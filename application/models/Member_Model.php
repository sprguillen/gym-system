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
            DATE_FORMAT(ms.date_started, '%M %d %Y') as date_started,
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

    public function get_member_data_with_emergency_contact_by_id($id) {
        $sql = "SELECT 
                m.id as id,
                m.fname as fname,
                m.mname as mname,
                m.lname as lname,
                m.address as address,
                m.date_of_birth as date_of_birth,
                m.gender as gender,
                m.weight as weight,
                m.height as height,
                m.email as email,
                m.contact as contact,
                m.img as img,
                m.date_created as date_created,
                ec.full_name as ec_fullname,
                ec.contact as ec_contact,
                ec.relationship as ec_relationship
            FROM member m JOIN emergency_contact ec ON m.id = ec.member_id WHERE m.id = ?";

        return $this->db->query($sql, $id)->result();
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
        $sql = "SELECT *, m.id as membership_id FROM membership AS m
                JOIN program ON program.id = m.program_id
                WHERE m.member_id = " . $member_id . " AND m.status = '" . $status . "'";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function get_memberships_by_member_id($member_id) {
        $sql = "SELECT 
                ms.id as id,
                ms.date_started as date_started,
                ms.date_expired as date_expired,
                ms.status as status,
                ms.member_id as member_id,
                p.type as type
            FROM membership ms
            JOIN program p ON p.id = ms.program_id
            WHERE ms.member_id = " . $member_id;

        return $this->db->query($sql)->result();
    }

    public function get_memberships_by_id($membership_id) {
        $sql = "SELECT 
                ms.id as id,
                ms.date_started as date_started,
                ms.date_expired as date_expired,
                ms.status as status,
                ms.member_id as member_id,
                p.type as type
            FROM membership ms
            JOIN program p ON p.id = ms.program_id
            WHERE ms.id = " . $membership_id;

        return $this->db->query($sql)->result();
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

    public function get_attendance_by_member_id($member_id) {
        $sql = "SELECT * FROM membership_attendance AS ma
                JOIN membership AS ms ON ms.id = ma.membership_id
                JOIN program ON program.id = ms.program_id
                WHERE ms.member_id = " . $member_id . "
                ORDER BY attendance DESC";

        return $this->db->query($sql)->result();
    }

    public function count_all_members() {
        return $this->db->count_all_results('member', FALSE);
    }

    public function count_all_programs() {
        $sql = "SELECT COUNT(*) as pc FROM program";
        
        return $this->db->query($sql)->result()[0]->pc;
    }

    public function get_max_id() {
        $sql = "SELECT MAX(id) as mid FROM member";

        return $this->db->query($sql)->result()[0]->mid;
    }

    public function get_daily_attendance($date = null) {

        if ($date) {
            $current_date = $date;
        } else {
            $current_date = date("Y-m-d");
        }
        
        
        $start_of_the_day = $current_date . " 00:00:00";
        $end_of_the_day = $current_date . " 23:59:59";

        $sql = "SELECT 
                ma.id AS attendance_id, 
                ma.attendance as logged_in, 
                p.type as program_type, 
                m.id AS id, 
                m.fname AS first_name, 
                m.mname AS middle_name, 
                m.lname AS last_name 
            FROM membership_attendance ma 
            JOIN membership ms ON ma.membership_id = ms.id
            JOIN program p ON ms.program_id = p.id
            JOIN member m ON ms.member_id = m.id
            WHERE attendance >= ? AND attendance <= ?
            ORDER BY attendance ASC";

        return $this->db->query($sql, array($start_of_the_day, $end_of_the_day))->result();
    }

    public function get_monthly_attendance() {
        $month = date("Y-m");
        $last_date = date("Y-m-t");
        $current_date = $month . '-01';
        $sql = "SELECT 
                ma.id AS attendance_id, 
                ma.attendance as logged_in, 
                p.type as program_type, 
                m.id AS id, 
                m.fname AS first_name, 
                m.mname AS middle_name, 
                m.lname AS last_name 
            FROM membership_attendance ma 
            JOIN membership ms ON ma.membership_id = ms.id
            JOIN program p ON ms.program_id = p.id
            JOIN member m ON ms.member_id = m.id
            WHERE attendance >= ? AND attendance <= ?
            ORDER BY attendance ASC";

        return $this->db->query($sql, array($current_date, $last_date))->result();
    }

    public function get_weekly_attendance() {
        $week_start = date("Y-m-d",strtotime('monday this week'));
        $week_end = date("Y-m-d",strtotime("next monday"));

        $sql = "SELECT 
                ma.id AS attendance_id, 
                ma.attendance as logged_in, 
                p.type as program_type, 
                m.id AS id, 
                m.fname AS first_name, 
                m.mname AS middle_name, 
                m.lname AS last_name 
            FROM membership_attendance ma 
            JOIN membership ms ON ma.membership_id = ms.id
            JOIN program p ON ms.program_id = p.id
            JOIN member m ON ms.member_id = m.id
            WHERE attendance >= ? AND attendance <= ?
            ORDER BY attendance ASC";

        return $this->db->query($sql, array($week_start, $week_end))->result();    
    }

    public function get_attendance($type) {
        if ($type === 'daily') {
            return $this->get_daily_attendance();
        } else if ($type === 'weekly') {
            return $this->get_weekly_attendance();
        } else if ($type === 'monthly') {
            return $this->get_monthly_attendance();
        }
    }

    public function get_member_by_name($name, $status) {
        $name = $name . '%';
        $sql = "SELECT m.id, m.fname, m.mname, m.lname, m.date_created,
            GROUP_CONCAT(CONCAT(DATE_FORMAT(ms.date_started, '%M %d %Y'), 
            ' - ', DATE_FORMAT(ms.date_expired, '%M %d %Y')) SEPARATOR ', ') as duration, 
            GROUP_CONCAT(status) as programs_status, GROUP_CONCAT(p.type) as programs_type
            FROM member m JOIN membership ms on m.id = ms.member_id JOIN program p
            on ms.program_id = p.id WHERE ms.status = ? AND
            CONCAT(m.fname, ' ', m.mname, ' ', m.lname) LIKE ? GROUP BY m.id
            ORDER BY m.date_created DESC"; 

        return $this->db->query($sql, array($status, $name))->result();
    }

    public function get_no_membership_member_by_name($name) {
        $name = $name . '%';
        $sql = "SELECT id, fname, mname, lname, date_created
            FROM member WHERE id NOT IN (SELECT member_id FROM membership)
            AND CONCAT(fname, ' ', mname, ' ', lname) LIKE ?";

        return $this->db->query($sql, $name)->result();
    }

    public function check_email_if_exists($email) {
        $sql = "SELECT id FROM member WHERE email = '$email'";
        return $this->db->query($sql)->num_rows();
    }
}
