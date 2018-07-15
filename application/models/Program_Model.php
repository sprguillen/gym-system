<?php

/**
 * Program Model
 * @author  nikki <monique.dingding@gmail.com>
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_Model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_all_programs() {

        $programs = $this->get_all_programs_type();

        foreach ($programs as $p) {
            $sql = "SELECT * FROM program_price WHERE program_id = " . $p->id;
            $p->price = $this->db->query($sql)->result();
        }

        return $programs;
    }

    public function get_program_info($program_id) {
        $query = $this->db->get_where('program', ['id' => $program_id]);

        $result = $query->result(); 

        if ($result > 0) {            
            foreach ($result as $row) {
                $sql = "SELECT * FROM program_price WHERE program_id = " . $program_id;
                $row->price = $this->db->query($sql)->result();   
            }

            return $result;
        }
    }

    public function program_exists($type) {
        $query = $this->db->get_where('program', ['type' => $type]);
        return ($query->num_rows() > 0);
    }

    public function insert($table, $data) {
        $this->db->trans_start();
        
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();

        $this->db->trans_complete();

        return ($this->db->trans_status())? $id: false;
    }

    public function add_program_rate($rates, $program_id) {

        foreach ($rates as $key => $value) {
            $this->db->trans_start();

            $price_data = [
                'duration' => $key,
                'price' => $value,
                'program_id' => $program_id
            ];

            $this->insert('program_price', $price_data);

            $this->db->trans_complete();
        }

        return $this->db->trans_status();    
    }

    public function add_program($data) {
        
        $program_id = $this->insert('program', ['type' => $data['program_name']]);

        $status = true;
        
        if ($program_id) {
            $status = $this->add_program_rate($data['rates'], $program_id);
        }

        return $status;
    }

    public function update_program($data, $id) {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('program', $data);

        $this->db->trans_complete();
    }

    public function update_program_pricing($data, $id) {

        $program_prices = $this->get_program_price_by_program_id($id);

        foreach ($data as $index => $rate) {
            foreach ($rate as $key => $value) {
                $this->db->trans_start();

                $this->db->where('program_id', $id);
                $this->db->where('duration', $key);
                $this->db->update('program_price', ['price' => $value]);

                $this->db->trans_complete();
            }
        }

        return $this->db->trans_status();

    }

    public function get_all_programs_type() {
        $sql = "SELECT * FROM program WHERE type <> 'Freeze Program'";

        return $this->db->query($sql)->result();
    }

    public function get_all_programs_member($member_id) {
        $sql = "SELECT 
                p.id,
                p.type
            FROM program p WHERE p.id NOT IN (SELECT m.program_id FROM membership m WHERE m.member_id = ?)";

        return $this->db->query($sql, $member_id)->result();
    }

    public function get_all_inactive_programs_member($member_id) {
        $sql = "SELECT
                ms.id as membership_id,
                p.id as program_id,
                p.type as type
            FROM membership ms JOIN program p ON ms.program_id = p.id WHERE ms.member_id = ? AND ms.status = 'Inactive'";

        return $this->db->query($sql, $member_id)->result();
    }

    public function get_program_price_by_program_id($program_id) {
        $sql = "SELECT * FROM program_price WHERE program_id = ?";

        return $this->db->query($sql, $program_id)->result();
    }

    public function get_program_price_by_id($id) {
        $sql = "SELECT * FROM program_price WHERE id = ?";
        return $this->db->query($sql, $id)->result();
    }

    public function get_members_by_program($program_id) {
        $sql = "SELECT DISTINCT
                m.id, 
                m.fname, 
                m.mname, 
                m.lname, 
                m.email,
                ms.date_started,
                ms.date_expired
            FROM member m JOIN membership ms ON ms.member_id = m.id
            WHERE ms.program_id = ?";

        return $this->db->query($sql, $program_id)->result();
    }

    public function get_program_first_id() {
        $sql = "SELECT min(id) AS first_id FROM program";

        return $this->db->query($sql)->result()[0]->first_id;
    }
}