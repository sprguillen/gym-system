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
     * Gate sat and sun (first and last day of the week)
     * @param  $timestamp
     * @return [Array]      
     */
    public function get_sat_sun_dow($timestamp) {
        $timestamp = (isset($timestamp))? $timestamp: time();

        $day_of_week = date('w', $timestamp);
        $offset = ($day_of_week < 0)? 6: (int) $day_of_week;

        $days = [];

        $sunday_timestamp = $timestamp - $offset * 86400;
        $days['sun'] = date('Y-m-d', $sunday_timestamp);

        $saturday_timestamp = $sunday_timestamp + (86400 * 6);
        $days['sat'] = date('Y-m-d', $saturday_timestamp);

        return $days;
    }


    public function ajax_get_reports_by_week() {
        $selected_date = $this->input->post('selected_date');
        $selected_timestamp = strtotime($selected_date);

        $start_day = strtotime($selected_date . '-01');
        $last_day = strtotime(date('Y-m-t', $selected_timestamp));


        $data['last_day'] = $last_day;
        $data['start_day'] = $start_day;
        
        $timestamp = $start_day;
        $i = $timestamp;
        $week = [];
        $count = 0;

        do {
            $week[$count] = $this->get_sat_sun_dow($timestamp);
            $timestamp = strtotime('+7 days', $timestamp);
            
            $result[$count] = $this->Report_Model->get_membership_payments(NULL, $week[$count]);
            $count++;

        } while ($timestamp < $last_day);

        $data['week'] = $week;
        $data['selected_date'] = $selected_date;
        $data['result'] = $result;


        // $data['result'] = $this->Report_Model->get_membership_payments(NULL, $start_day);





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