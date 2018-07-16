<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 6, 2018
 */

class Home_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        // Load session library
        $this->load->library('session');

        // Load URL helper
        $this->load->helper('url');

        // Load database
        $this->load->model('User_Model');

    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            $this->render('pages/index');
        } else {
            redirect(base_url('dashboard'));
        }
    }

    /**
     * Process page login
     */
    public function login_user_process() {
        $this->form_validation->set_rules('user_input', 'Username', 'trim|required');
		$this->form_validation->set_rules('pass_input', 'Password', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $data = array(
                'message' => 'Please enter your username and/or password.'
            );

            $this->session->set_flashdata('error', $data);
            redirect(base_url(''));
        } else {
            $data = array(
				'username' => $this->input->post('user_input'),
				'password' => sha1($this->input->post('pass_input'))
			);

            $userAccountData = $this->user_model->login($data);

            if($userAccountData !== false) {
                $userProfileData = $this->user_model->get_user_profile(
                    $userAccountData['0']->user_profile_id);
                
                if($userProfileData !== false) {
                    $sessionData = array(
                        'username' => $userAccountData[0]->username,
                        'email' => $userProfileData[0]->email,
                        'firstname' => $userProfileData[0]->fname,
                        'lastname' => $userProfileData[0]->lname,
                        'img' => $userProfileData[0]->img,
                        'account_type' => $userAccountData[0]->user_account_type_id 
                    );


                    $mode = ($userProfileData[0]->user_account_type_id === '1')? 'admin': 'staff';
                    $this->session->set_userdata('mode', $mode);
                    
                    $this->session->set_userdata('logged_in', $sessionData);
                    redirect(base_url('dashboard'));
                }
            } else {
                $data = array(
                    'message' => 'The username and/or password you entered is incorrect.'
                );

                $this->session->set_flashdata('error', $data);
    			redirect(base_url(''));
            }

        }

    }

    /**
     * Displays the register page
     */
    public function register() {
        $this->render('pages/register');
    }


    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $isDashboard = false) {
        $data['isDashboard'] = $isDashboard;
        $data['user_type'] = $this->session->userdata('mode');

        $this->load->view('components/header', $data);
        $this->load->view($page);
        $this->load->view('components/footer', $data);
    }
}
