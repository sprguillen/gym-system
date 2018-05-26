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

        // Load session library
        $this->load->library('session');
        $this->load->library('user_agent');

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

        $refer =  $this->agent->referrer();

        redirect($refer);
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
        
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);

        $page = 'pages/admin/' . $page;

        $this->load->view($page, $data);
        
        $this->load->view('components/footer');
    }


    public function add_admin() {
        $data['isDashboard'] = TRUE;
        $this->breadcrumbs->set(['Add New Staff' => 'admin/add']);

        $this->render('add_admin', $data);
    }

    public function add_user() {
        
        
    }

}