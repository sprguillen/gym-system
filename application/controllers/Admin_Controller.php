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
        $this->breadcrumbs->set(['Coaches' => 'coaches']);

        // Load session library
        $this->load->library('session');
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
        $this->session->set_userdata('mode', 'admin');

        redirect($this->uri->segment(3));
    }

    /**
     * Locks admin mode and changes into STAFF -- STATIC
     * Modify this to fetch the necessary data from the database
     */
    public function lock() {
        $this->session->set_userdata('mode', 'staff');
        
        redirect($this->uri->segment(3));
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {
        
        $data['isDashboard'] = TRUE;
        
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);
        $page = 'pages/coaches/' . $page;
        $this->load->view($page, $data);
        
        $this->load->view('components/footer');
    }

}