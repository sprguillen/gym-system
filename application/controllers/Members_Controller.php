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
        $this->type = $this->uri->segment(3);

        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('/'));
        }
    }

    /**
     * Displays a list of members
     */
    public function members_list() {

        $data['type'] = ($this->type === NULL)? 'active': $this->type;

        $data['sampleUsers'] = [
            [
                'id' => 1,
                'name' => 'Gab del Rosario',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 14 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => TRUE
            ],
            [
                'id' => 2,
                'name' => 'John Lloyd Cruz',
                'scheme' => '1 month',
                'duration' => '14 March 2018 - 14 Apr 2018',
                'classes' => 'Boxing',
                'isPaid' => TRUE
            ],
            [
                'id' => 3,
                'name' => 'Nikki Gil',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 18 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => FALSE
            ],
            [
                'id' => 3,
                'name' => 'Dianne Molina',
                'scheme' => '1 year',
                'duration' => '14 Feb 2018 - 18 Feb 2019',
                'classes' => 'Yoga',
                'isPaid' => TRUE
            ],
            [
                'id' => 4,
                'name' => 'Marianne Seremesa',
                'scheme' => '1 month',
                'duration' => '23 Apr 2018 - 23 May 2018',
                'classes' => 'Wushu',
                'isPaid' => TRUE
            ],
            [
                'id' => 5,
                'name' => 'Gab del Rosario',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 14 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => FALSE
            ],
            [
                'id' => 6,
                'name' => 'John Lloyd Cruz',
                'scheme' => '1 month',
                'duration' => '14 March 2018 - 14 Apr 2018',
                'classes' => 'Boxing',
                'isPaid' => TRUE
            ],
            [
                'id' => 7,
                'name' => 'Nikki Gil',
                'scheme' => '6 months',
                'duration' => '14 Jan 2018 - 18 Aug 2018',
                'classes' => 'Weight Training',
                'isPaid' => TRUE
            ],
            [
                'id' => 8,
                'name' => 'Dianne Molina',
                'scheme' => '1 year',
                'duration' => '14 Feb 2018 - 18 Feb 2019',
                'classes' => 'Yoga',
                'isPaid' => TRUE
            ],
            [
                'id' => 9,
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
     * Displays the edit page (same as register)
     */
    public function edit() {
        $userId = $this->uri->segment(3);

        $this->breadcrumbs->set(['Register' => 'members/register']);

        $this->render('register');
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

        print_r($_POST);
        $data = array(
            'fname' => $_POST['fname'],
            'mname' => $_POST['mname'],
            'lname' => $_POST['lname'],
            'address' => $_POST['address'],
            'birthdate' => $_POST['birthdate'],
            'gender' => $_POST['gender'],
            'weight' => $_POST['weight'],
            'height' => $_POST['height'],
            'cellnumber' => $_POST['cellnumber'],
            'email' => $_POST['email'],
            'ename' => $_POST['ename'],
            'relationship' => $_POST['relationship'],
            'econtact' => $_POST['econtact']
        );

        echo json_encode($data);
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $data = []) {

        $data['isDashboard'] = TRUE;
        $data['breadcrumbs'] = $this->breadcrumbs->get();
        $page = 'pages/members/' . $page;

        $this->load->view('components/header', $data);

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
