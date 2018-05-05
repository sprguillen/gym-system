<?php

/**
 * @author Simon Guillen (sprguillen@gmail.com)
 * Fingerprint registration, verification done here
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fingerprint_Model extends CI_Model {
	public function __construct() {
        $this->load->database();
    }

    
}