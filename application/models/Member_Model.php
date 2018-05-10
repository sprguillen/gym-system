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
        $this->db->trans_start();
        
        $this->db->insert($table, $data);
	    $id = $this->db->insert_id();

        $this->db->trans_complete();
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
        $this->db->trans_start();

        $this->db->insert('membership', $data);

        $this->db->trans_complete();
    
        return ($this->db->affected_rows() === 1) ? true: false;
    }

    public function freeze_membership($member_id, $freeze_data) {
        $sql = "SELECT membership.id AS membership_id FROM membership JOIN member ON membership.member_id = member.id
        WHERE member.id = '" . $member_id . "' AND membership.status = 'Active'"; 

        $memberships = $this->db->query($sql)->result();
        
        $this->db->trans_start();

        foreach ($memberships as $row) {

            $freeze_data['membership_id'] = $row->membership_id;
            $this->insert_frozen_membership($freeze_data);
            
            $membership_data = [
                'id' => $row->membership_id,
                'status' => 'Frozen'
            ];

            $this->update_membership($membership_data);
        }

        $this->db->trans_complete();
    }

    public function unfreeze_membership($member_id) {
        $sql = "UPDATE membership_frozen AS mf SET mf.status = 'Done' WHERE status = 'Ongoing'
                AND membership_id IN (SELECT id FROM membership WHERE status = 'Active' AND member_id = " . $member_id . ")"; 

        $memberships = $this->db->query($sql)->result();
    }

    public function get_memberships_by_id($member_id, $status) {
        $query = $this->db->get_where('membership', ['member_id' => $member_id, 'status' => $status]);

        return $query->result_array();
    }

    public function insert_frozen_membership($data) {
        $this->db->trans_start();
        
        $this->db->insert('membership_frozen', $data);

        $this->db->trans_complete();

        return ($this->db->affected_rows() === 1) ? true: false;
    }

    public function update_membership($data) {
        $this->db->trans_start();

        $membership_id = $data['id'];
        
        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->where('id', $membership_id);
        $this->db->update('membership');

        $this->db->trans_complete();
    }

    public function update_member($data) {
        $this->db->trans_start();
        
        $member_id = $data['id'];
        
        foreach($data as $key => $value) {
            $this->db->set($key, $value);
        }
        
        $this->db->where('id', $member_id);
        $this->db->update('member');

        $this->db->trans_complete();
    }
}
