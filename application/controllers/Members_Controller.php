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

        // Load helpers
        $this->load->helper('form');

        // Load libraries
        $this->load->library('form_validation');
        $this->load->library('session');

        // Load models
        $this->load->model('user_model');

        $this->breadcrumbs->set(['Members' => 'members']);

    }

    public function list() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('/'));
        }

        $data['sampleUsers'] = [
            [
                'name' => 'Gab del Rosario',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 14 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => TRUE
            ],
            [
                'name' => 'John Lloyd Cruz',
                'scheme' => '1 month',
                'duration' => '14 March 2018 - 14 Apr 2018',
                'classes' => 'Boxing',
                'isPaid' => TRUE
            ],
            [
                'name' => 'Nikki Gil',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 18 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => FALSE
            ],
            [
                'name' => 'Dianne Molina',
                'scheme' => '1 year',
                'duration' => '14 Feb 2018 - 18 Feb 2019',
                'classes' => 'Yoga',
                'isPaid' => TRUE
            ],
            [
                'name' => 'Marianne Seremesa',
                'scheme' => '1 month',
                'duration' => '23 Apr 2018 - 23 May 2018',
                'classes' => 'Wushu',
                'isPaid' => TRUE
            ],
            [
                'name' => 'Gab del Rosario',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 14 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => FALSE
            ],
            [
                'name' => 'John Lloyd Cruz',
                'scheme' => '1 month',
                'duration' => '14 March 2018 - 14 Apr 2018',
                'classes' => 'Boxing',
                'isPaid' => TRUE
            ],
            [
                'name' => 'Nikki Gil',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 18 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => TRUE
            ],
            [
                'name' => 'Dianne Molina',
                'scheme' => '1 year',
                'duration' => '14 Feb 2018 - 18 Feb 2019',
                'classes' => 'Yoga',
                'isPaid' => TRUE
            ],
            [
                'name' => 'Marianne Seremesa',
                'scheme' => '1 month',
                'duration' => '23 Apr 2018 - 23 May 2018',
                'classes' => 'Wushu',
                'isPaid' => TRUE
            ],

        ];

        $this->render('list', $data);
    }

    /**
     * Displays the register page
     */
    public function register() {
        $this->breadcrumbs->set(['Register' => 'members/register']);

        $this->render('register');
    }

    public function process_member_register() {
        $this->load->helper('url');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('mname', 'Middle Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Date of birth', 'trim|required|callback__check_date_format');
        $this->form_validation->set_message('callback__check_date_format','Date not valid (mm/dd/yyyy)');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('weight', 'Weight', 'required|decimal');
        $this->form_validation->set_rules('height', 'Height', 'required|decimal');
        $this->form_validation->set_rules('cellnumber', 'Mobile Number', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('ename', 'Contact Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('relationship', 'Relationship', 'trim|required');
        $this->form_validation->set_rules('econtact', 'Emergency Mobile Number', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {

        } else {

        }
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {

        $data['isDashboard'] = TRUE;

        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $this->load->view('components/header', $data);
        $page = 'pages/members/' . $page;
        $this->load->view($page, $data);

        $this->load->view('components/footer');
    }

    /**
     * Custom date check validator
     * @param  [string] date
     */
    public function check_date_format($date) {
        if (preg_match("/[0-12]{2}/[0-31]{2}/[0-9]{4}/", $date)) {
            if (checkdate(substr($date, 0, 2), substr($date, 3, 2), substr($date, 6, 4))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
