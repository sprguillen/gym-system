<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coaches Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 16, 2018
 */

class Programs_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load libraries
        $this->load->library('session');
        $this->load->library('Breadcrumbs');

        $this->breadcrumbs->set(['Dashboard' => '/', 'Programs' => 'programs']);

        // Load database
        $this->load->model('Program_Model');

        if ($this->session->userdata('mode') !== 'admin') {
            redirect(base_url('/'));
        }
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('/'));
        } 

        redirect(base_url('dashboard/home'));
    }

    /**
     * Displays the programs page
     */
    public function programs_list() {
        $data['programs'] = $this->Program_Model->get_all_programs();
        $this->breadcrumbs->set(['List' => 'programs']);
     
        $this->render('list', $data);
    }

    public function add_program() {
        $data['programs'] = $this->Program_Model->get_all_programs();
        $data['duration'] = ['1 Month', '3 Months', '6 Months', '1 Year'];
        
        $this->breadcrumbs->set(['New' => 'programs/add']);
        
        $this->render('add', $data);
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {
        
        $data['isDashboard'] = TRUE;
        
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);
        $page = 'pages/programs/' . $page;
        $this->load->view($page, $data);
        
        $this->load->view('components/footer');
    }

}