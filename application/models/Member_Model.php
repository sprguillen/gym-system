<?php

/**
 * @author Simon Guillen (sprguillen@gmail.com)
 * Member model (member registration, getting member details, get member status)
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_Model extends CI_Model {

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

    public function freeze_membership($member_id, $freeze_data) {
        $sql = "SELECT membership.id AS membership_id FROM membership JOIN member ON membership.member_id = member.id
        WHERE member.id = '" . $member_id . "' AND membership.status = 'Active'"; 

        $memberships = $this->db->query($sql)->result();
        $this->db->trans_start();

        foreach ($memberships as $row) {

            $freeze_data['membership_id'] = $row->membership_id;
            $this->insert($freeze_data, 'membership_frozen');
            
            $membership_data = [
                'id' => $row->membership_id,
                'status' => 'Frozen'
            ];

            $this->update_membership($membership_data);
        }

        $this->db->trans_complete();
    }

    public function unfreeze_membership_frozen($member_id) {
        $this->db->trans_start();

        $sql = "UPDATE membership_frozen AS mf SET mf.status = 'Done' WHERE status = 'Ongoing'
                AND membership_id IN (SELECT id FROM membership WHERE status = 'Active' AND member_id = " . $member_id . ")"; 

        $result = $this->db->query($sql);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_new_date_expired($date_expired, $date_frozen) {

        if (date("Y-m-d") === $date_frozen) {
            return $date_expired;
        }

        $days_frozen = round((time() - strtotime($date_frozen)) / (60 * 60 * 24));
        
        $new_date = strtotime($date_expired . " + " . $days_frozen . " days");

        return date("Y-m-d", $new_date);
    }

    public function unfreeze_membership_table($member_id) {
        $this->db->trans_start();

        $frozen_memberships = $this->get_membership_frozen_by_member_id($member_id);

        foreach ($frozen_memberships as $row) {

            $new_date_expired = $this->get_new_date_expired($row['date_expired'], $row['date_frozen']);
            
            $sql = "UPDATE membership AS m
                    SET m.status = 'Active', m.date_expired = '" . $new_date_expired . "'
                    WHERE id = " . $row['membership_id'];
            
            $this->db->query($sql);

            $sql = "UPDATE membership_frozen
                    SET status = 'Done' 
                    WHERE status = 'Ongoing' AND membership_id = " . $row['membership_id'];

            $this->db->query($sql);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_membership_frozen_by_member_id($member_id) {
        $sql = "SELECT * FROM membership_frozen AS mf
                JOIN membership AS m
                ON mf.membership_id = m.id
                WHERE mf.status = 'Ongoing'
                AND m.member_id = " . $member_id;

        return $this->db->query($sql)->result_array();
    }


    public function unfreeze_membership($member_id) {
        return ($this->unfreeze_membership_frozen($member_id) && $this->unfreeze_membership_table($member_id));
    }
        

    public function get_memberships_by_id_status($member_id, $status) {
        $query = $this->db->get_where('membership', ['member_id' => $member_id, 'status' => $status]);

        return $query->result_array();
    }

    public function get_memberships_by_id($member_id) {
        $query = $this->db->get_where('membership', ['member_id' => $member_id]);

        return $query->result_array();
    }

    public function get_program_type_by_id($program_id) {
        $query = $this->db->get_where('program', ['id' => $program_id]);

        return $query->row()->type;
    }

    public function update_membership_frozen_where_membership_id($data) {
        $this->db->trans_start();
        
        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        $this->db->where('membership_id', $membership_id);
        $this->db->update('membership_frozen');

        $this->db->trans_complete();
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

    public function count_all_members() {
        return $this->db->count_all_results('member', FALSE);
    }

    public function get_max_id() {
        $sql = "SELECT MAX(id) as mid FROM member";

        return $this->db->query($sql)->result()[0]->mid;
    }
}
