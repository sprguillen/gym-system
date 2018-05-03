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
    	$sql = "SELECT m.id, m.fname, m.mname, m.lname, m.date_created, 
            GROUP_CONCAT(CONCAT(DATE_FORMAT(ms.date_started, '%M %d %Y'), 
            ' - ', DATE_FORMAT(ms.date_expired, '%M %d %Y')) SEPARATOR ', ') as duration, 
            GROUP_CONCAT(status) as programs_status, GROUP_CONCAT(p.type) as programs_type
            FROM member m JOIN membership ms on m.id = ms.member_id JOIN program p
    		on ms.program_id = p.id WHERE ms.status = ? GROUP BY m.id
            ORDER BY m.date_created DESC"; 

    	return $this->db->query($sql, $status)->result();
    }

    public function get_no_membership_member() {
        $sql = "SELECT id, fname, mname, lname, date_created
            FROM member WHERE id NOT IN (SELECT member_id FROM membership)";

        return $this->db->query($sql)->result();
    }

    public function get_member_data_by_id($id) {
    	$sql = "SELECT * FROM member WHERE id = ?";

    	return $this->db->query($sql, $id)->result();
    }

    public function get_all_programs() {
        $sql = "SELECT * FROM program";

        return $this->db->query($sql)->result();
    }

    public function insert_to_membership($data) {
        $this->db->insert('membership', $data);
        return ($this->db->affected_rows() === 1) ? true : false;
    }

    public function update_member($data) {
        $member_id = $data['id'];
        foreach($data as $key => $value) {
            $this->db->set($key, $value);
        }
        $this->db->where('id', $member_id);
        $this->db->update('member');
    }
}
