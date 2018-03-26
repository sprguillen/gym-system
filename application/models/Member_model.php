<?php

/**
 * @author Simon Guillen (sprguillen@gmail.com)
 * Member model (member registration, getting member details, get member status)
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function insert($data, $table = 'member') {
        $this->db->insert($table, $data);
	    $id = $this->db->insert_id();
	    return (string)$id;
    }
}
