<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Reports Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on June 19, 2018
 */

class Reports_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Breadcrumbs');
        $this->breadcrumbs->set(['Dashboard' => '/', 'Reports' => 'reports']);

        $this->load->model('Report_Model');
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('/'));
        } 

        redirect(base_url('dashboard/home'));
    }

    /**
     * Displays the reports generation page
     */
    public function get_reports() {
        $data['results'] = $this->Report_Model->get_membership_payments();
        $this->render('list', $data);
    }

    /**
     * Ajax call to get membership reports by month
     * @return JSON result
     */
    public function ajax_get_reports_by_month() {
        $month = $this->input->post('month');
        $month = (!empty($month))? $month: date('Y-m');

        $data['month'] = (!empty($month))? date('F', strtotime($month)): date('F');
        $data['month_digit'] = (!empty($month))? date('Y-m', strtotime($month)): date('Y-m');

        $data['result'] = $this->Report_Model->get_membership_payments($month . '-%');

        echo json_encode($data);
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {
        
        $data['isDashboard'] = TRUE;
        
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);
        $page = 'pages/reports/' . $page;
        $this->load->view($page, $data);
        
        $this->load->view('components/footer');
    }

}