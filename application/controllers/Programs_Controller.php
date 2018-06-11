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

    /**
     * Displays the add program page
     */
    public function add_program() {
        $data['programs'] = $this->Program_Model->get_all_programs();
        $data['duration'] = ['1 Month', '3 Months', '6 Months', '1 Year'];
        
        $this->breadcrumbs->set(['New' => 'programs/add']);
        
        $this->render('add', $data);
    }

    /**
     * Ajax call to check if the name already exists in `program` table
     * @return [Boolean] $result
     */
    public function ajax_check_if_program_exists() {
        $name = $this->input->post('program_name');
        $result = $this->Program_Model->program_exists($name);

        echo json_encode($result);
    }

    /**
     * AJAX call to insert program and prices into their respective tables
     */
    public function ajax_add_program() {
        $rates = json_decode($this->input->post('rates'));
        $program_name = $this->input->post('program_name');

        $data = [
            'rates' => $rates,
            'program_name' => $program_name
        ];

        $result = $this->Program_Model->add_program($data);

        echo json_encode($result);
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

    /**
     * Get list of all programs (called by AJAX)
     * @return JSON
     */
    public function get_program_list() {
        $program_list = $this->Program_Model->get_all_programs_type();

        echo json_encode($program_list);
    }

    /**
     * Get list of all programs per member (called by AJAX)
     * @return JSON
     */
    public function get_program_list_per_member() {
        $member_id = $_GET['member_id'];
        $program_list = $this->Program_Model->get_all_programs_member($member_id);

        echo json_encode($program_list);
    }

    /**
     * Get program payment scheme (called by AJAX)
     * @return JSON
     */
    public function get_program_payment_by_program_id() {
        $program_id = $_GET['program_id'];
        $program_scheme = $this->Program_Model->get_program_price_by_program_id($program_id);

        echo json_encode($program_scheme);
    }

    public function get_expired_program_list_per_member() {
        $member_id = $_GET['member_id'];
        $program_list = $this->Program_Model->get_all_inactive_programs_member($member_id);

        echo json_encode($program_list);
    }
}