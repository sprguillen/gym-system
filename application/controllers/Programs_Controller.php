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

        $this->load->model('Program_Model');
        
        // Load libraries
        $this->load->library('session');
        $this->load->library('Breadcrumbs');

        $this->breadcrumbs->set(['Dashboard' => '/', 'Programs' => 'programs']);

        // Load database
        $this->duration_types = ['Daily', '1 Month', '3 Months', '6 Months', '1 Year'];

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
        $data['duration'] = $this->duration_types;
        
        $this->breadcrumbs->set(['List' => 'programs']);
     
        $this->render('list', $data);
    }

    /**
     * Displays the add program page
     */
    public function add_program() {
        $data['programs'] = $this->Program_Model->get_all_programs();
        $data['duration'] = $this->duration_types;
        
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
     * Ajax call to add pricing for a program
     */
    public function add_program_rate () {
        $amount = $this->input->post('amount');
        $duration = $this->input->post('duration');
        $program_id = $this->input->post('program_id');

        $data = [$duration => $amount];

        $status = $this->Program_Model->add_program_rate($data, $program_id);

        echo json_encode($status);
    }

    /**
     * Get program information by id
     * @return JSON
     */
    public function ajax_get_program_by_id () {
        $program_id = $this->uri->segment(3);

        $data['program_info'] = $this->Program_Model->get_program_info($program_id);
        $data['duration'] = $this->duration_types;

        echo json_encode($data);
    }

    /**
     * Ajax call to update the program name AND the pricing
     * NOTE: Does NOT add new pricing/rate
     * @return [type] [description]
     */
    public function ajax_update_program () {
        $rates = json_decode($this->input->post('rates'));
        $program_name = $this->input->post('program_name');
        $program_id = $this->input->post('program_id');


        $data = [
            'rates' => $rates,
            'program_name' => $program_name,
            'program_id' => $program_id
        ];

        $this->Program_Model->update_program(['type' => $program_name], $program_id);
        $status = $this->Program_Model->update_program_pricing($rates, $program_id);

        echo json_encode($status);
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