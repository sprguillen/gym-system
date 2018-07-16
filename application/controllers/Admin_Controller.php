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

        if ($this->form_validation->run() === FALSE) {
            $data['isDashboard'] = TRUE;
            $this->breadcrumbs->set(['Add New Staff' => 'admin/add']);
            $this->render('add_admin', $data);
        } else {
            $data = array(
                'fname' => $this->input->post('first_name'),
                'lname' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => sha1($this->input->post('password'))
            );

            $result = $this->User_Model->register_user($data);

            if ($result['status']) {
                $result_data = array('message' => $result['message']);
                $this->session->set_flashdata('success', $result_data);
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
}