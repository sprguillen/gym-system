<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coaches Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 16, 2018
 */

class Admin_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Breadcrumbs');
        $this->breadcrumbs->set(['Admin' => 'admin']);

        // Load libraries
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->load->library('form_validation');

        // Load models
        $this->load->model('User_Model');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('/'));
        } 

        redirect(base_url('dashboard/home'));
    }

    /**
     * Unlocks admin mode -- STATIC
     * Modify this to fetch the necessary data from the database
     */
    public function unlock() {
        $data = array(
            'username' => $this->input->post('username'),
            'password' => sha1($this->input->post('password'))
        );

        $userAccountData = $this->User_Model->login($data);

        if ($userAccountData) {
            $this->session->set_userdata('mode', 'admin');
            $data['status'] = true;
        } else {
            $data['status'] = false;
            $data['message'] = 'Invalid username and/or password!';
        }

        echo json_encode($data);
    }

    /**
     * Locks admin mode and changes into STAFF -- STATIC
     * Modify this to fetch the necessary data from the database
     */
    public function lock() {
        $this->session->set_userdata('mode', 'staff');
  
        $refer =  $this->agent->referrer();

        redirect($refer);
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {
        
        $data['isDashboard'] = TRUE;
        $data['user_type'] = $this->session->userdata('mode');
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);

        $page = 'pages/admin/' . $page;

        $this->load->view($page, $data);
        
        $this->load->view('components/footer', $data);
    }


    public function add_admin() {
        $data['isDashboard'] = TRUE;
        $this->breadcrumbs->set(['Add New Staff' => 'admin/add']);
        $next_user_id = $this->User_Model->get_max_id() + 1;

        $data['api_reg_url'] = base64_encode(FINGERPRINT_API_URL . "?action=register&user_id=$next_user_id");

        if ($this->session->userdata('current_user_finger_data')) {
            $this->session->unset_userdata('current_user_finger_data');
        }

        $this->render('add_admin', $data);
    }

    public function add_user() {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user_account.email]');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user_account.username]');
        $this->form_validation->set_message('is_unique', '%s is already taken.');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('user_img', 'Profile Picture', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['isDashboard'] = TRUE;
            $this->breadcrumbs->set(['Add New Staff' => 'admin/add']);
            $this->add_admin();
        } else {
            $finger_data = $this->session->userdata('current_user_finger_data');

            $data = array(
                'fname' => $this->input->post('first_name'),
                'lname' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => sha1($this->input->post('password')),
                'user_img' => $this->input->post('user_img'),
                'finger_data' => $finger_data
            );

            $result = $this->User_Model->register_user($data);

            if ($result['status']) {
                redirect(base_url(''));
            } else {
                $this->session->set_flashdata('error', $result['message']);
                redirect(base_url('admin/add'));
            }
        }
    }

    public function user_list() {
        $data['users'] = $this->User_Model->get_complete_user_details();
        $this->render('list', $data);
    }

    public function save_fingerprint() {
        $status = $_GET['status'];
        
        if ($status === 'success') {
            $finger_data = array(
                'finger_id' => $_GET['finger_id'],
                'finger_data' => $_GET['finger_data'],
                'user_account_id' => (int)$_GET['user_account_id']
            );

            $this->session->set_userdata('current_user_finger_data', $finger_data);
        }

        echo "<script>window.close();</script>";
    }

    /**
     * API Call to verify if fingerdata has been stored before
     * registration form submit
     * @return bool
     */
    public function get_fingerprint_data() {
        if ($this->session->userdata('current_user_finger_data')) {
            echo true;
        } else {
            echo false;
        }
    }

    public function get_user_attendance() {
        $user_account_id = $_GET['user_account_id'];
        $data['attendance'] = $this->User_Model->get_user_account_attendance($user_account_id);
        $this->render('attendance', $data);
    }

    public function login_for_attendance() {
        $this->render('login');
    }

    public function get_username_for_attendance() {
        $username = $_POST['username'];
        $result = $this->User_Model->check_if_username_exists($username);
        if ($result) {
            $fingerprint_url = FINGERPRINT_API_URL . "?action=verification&user_id=" . $result[0]->id;
            echo json_encode(array('status' => true, 'fingerprint_url' => $fingerprint_url));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Employee username not found.'));
        }
    }

    public function verify_fingerprint() {
        $user_id = $_GET['user_id'];
        $user_profile = $this->User_Model->get_user_profile_by_account_id($user_id);

        $current_date_time = date(MYSQL_DATE_TIME_FORMAT);

        $insert_data = array(
            'attendance' => $current_date_time,
            'user_account_id' => $user_id
        );

        $this->User_Model->insert($insert_data, 'user_account_attendance');

        $data['user_profile'] = $user_profile[0];
        $data['current_logged_in_time'] = $current_date_time;

        $this->session->set_userdata('done_verification', true);

        $this->render('verification', $data);
    }

    public function ajax_done_verification() {
        $result = $this->session->userdata('done_verification');
        echo json_encode($result);
    }

    public function clear_done_verification() {
        $this->session->unset_userdata('done_verification');
        echo json_encode(true);
    }
}