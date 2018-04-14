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

    public function insert($data, $table) {
        $this->db->insert($table, $data);
	    $id = $this->db->insert_id();
	    return (string)$id;
    }

    public function get_all_membership_by_status($status) {
    	$sql = "SELECT m.id, m.fname, m.mname, m.lname, ms.date_started, ms.date_expired, status,
    		p.type FROM member m JOIN membership ms on m.id = ms.member_id JOIN program p
    		on ms.program_id = p.id WHERE ms.status = ?"; 

    	return $this->db->query($sql, $status)->result();
    }

    public function get_member_data_by_id($id) {
    	$sql = "SELECT * FROM member WHERE id = ?";

    	return $this->db->query($sql, $id)->result();
    }
}
