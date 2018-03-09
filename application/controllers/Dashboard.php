<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Home Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 6, 2018
 */

class Dashboard extends CI_Controller {

    public function index() {
        $data['page'] = 'Home: Quickstart';

        $this->render('pages/dashboard/home', $data);
    }  


    /**
     * Displays the register page
     */
    public function register() {
        $data['page'] = 'Members: Register';

        $this->render('pages/dashboard/register', $data);
    }


    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     * @param [array] $data
     */
    public function render($page, $data) {
        $data['isDashboard'] = true;


        $this->load->view('components/header', $data);
        $this->load->view($page, $data);
        $this->load->view('components/footer');
    }
}
