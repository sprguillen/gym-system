<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 6, 2018
 */

class Home extends CI_Controller {

    public function index() {
        $this->render('pages/index');
    }

    /**
     * Displays the login page
     */
    public function login() {
        $this->render('pages/login');
    }


    /**
     * Method to render template (header - body - footer)
     * @param  [string] $page
     */
    public function render($page, $isDashboard = false) {
        $data['isDashboard'] = $isDashboard;
        
        $this->load->view('components/header', $data);
        $this->load->view($page);
        $this->load->view('components/footer');
    }
}
