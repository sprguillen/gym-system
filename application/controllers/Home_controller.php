<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 6, 2018
 */

class Home_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        // Load session library
        $this->load->library('session');

        // Load database
        $this->load->model('user_model');
    }

    public function index() {
        $this->render('pages/index');
    }

    /**
     * Displays the login page
     */
    public function login() {
        $this->render('pages/login');
    }

    /**
     * Process page login
     */
    public function login_user_process() {
        $this->load->helper('url');
        $this->form_validation->set_rules('user_input', 'Username', 'required');
		$this->form_validation->set_rules('pass_input', 'Password', 'required');

        echo 'here';
        if ($this->form_validation->run() === FALSE) {
            echo 'false';
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
                        'password' => $userAccountData[0]->password,
                        'email' => $userProfileData[0]->email,
                        'firstname' => $userProfileData[0]->fname,
                        'lastname' => $userProfileData[0]->lname,
                        'img' => $userProfileData[0]->img
                    );

                    // $this->session->set_userdata('logged_in', $sessionData);
                    echo $sessionData;
                }
            } else {
                $data = array(
                    'errorMessage' => 'Invalid Username and/or Password'
                );
            }

            // Add error data in session
			$this->session->set_flashdata('error', $data);
			redirect(base_url('login'));
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

        $this->load->view('components/header', $data);
        $this->load->view($page);
        $this->load->view('components/footer');
    }
}
