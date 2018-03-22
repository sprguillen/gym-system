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
    }

    public function index() {
        $data['page'] = 'Home: Quickstart';

        $this->render('pages/dashboard', $data);
    }


    /**
     * Displays the register page
     */
    public function register() {
        $data['page'] = 'Members: Register';

        $this->render('pages/dashboard/register', $data);
    }


    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     * @param [array] $data
     */
    public function render($page, $data) {
        $data['isDashboard'] = true;


        $this->load->view('components/header', $data);
        $this->load->view($page, $data);
        $this->load->view('components/footer');
    }

    /**
     * Logs you out of the system
     */
    public function logout() {
        $this->session->unset_userdata('logged_in');
        redirect(base_url(''));
    }
}
