<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Members Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 16, 2018
 */

class Members_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->breadcrumbs->set(['Members' => 'members']);
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('/'));
        } 

        redirect(base_url('dashboard/home'));
    }

    /**
     * Displays the register page
     */
    public function register() {
        $this->breadcrumbs->set(['Register' => 'members/register']);

        $this->render('register');
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {
        
        $data['isDashboard'] = TRUE;
        
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);
        $page = 'pages/dashboard/members/' . $page;
        $this->load->view($page, $data);
        
        $this->load->view('components/footer');
    }

}