<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


/**
 * Home Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 6, 2018
 */

class Home extends CI_Controller {

    public function index() {
        $this->renderDashboard('pages/index');
    }

    public function login() {
        $this->renderDashboard('pages/login');
    }

    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function renderDashboard($page) {
        $this->load->view('components/header');
        $this->load->view($page);
        $this->load->view('components/footer');
    }
}
