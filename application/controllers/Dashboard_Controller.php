<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Home Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 6, 2018
 */

class Dashboard_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url(''));
        }

        // Load models
        $this->load->model('Member_Model');
    }

    public function index() {
        $data['page'] = 'Home: Quickstart';
        $data['isDashboard'] = true;
        // $data['membersCount'] = $this->Member_Model->count_all_members();
        // $data['programsCount'] = $this->Member_Model->count_all_programs();

        $this->render('pages/dashboard', $data);
    }

    /**
     * Displays the register page
     */
    public function register() {
        $data['isDashboard'] = true;
        $data['page'] = 'Members: Register';

        $this->render('pages/dashboard/register', $data);
    }


    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     * @param [array] $data
     */
    public function render($page, $data) {
        $data['user_type'] = $this->session->userdata('mode');
        $this->load->view('components/header', $data);
        $this->load->view($page, $data);
        $this->load->view('components/footer', $data);
    }

    /**
     * Logs you out of the system
     */
    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('mode');
        redirect(base_url(''));
    }
}
