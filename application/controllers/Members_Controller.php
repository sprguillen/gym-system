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

}
