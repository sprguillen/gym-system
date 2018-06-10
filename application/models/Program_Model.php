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
        $sql = "SELECT p.id, p.type, pp.duration, pp.price FROM program p JOIN program_price pp ON p.id = pp.program_id";

        return $this->db->query($sql)->result();
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

    public function add_program($data) {
        
        $program_id = $this->insert('program', ['type' => $data['program_name']]);

        $status = true;
        
        if ($program_id) {
            foreach ($data['rates'] as $key => $value) {
                $price_data = [
                    'duration' => $key,
                    'price' => $value,
                    'program_id' => $program_id
                ];

                $status = $this->insert('program_price', $price_data);
            }
        }

        return $status;
    }

    public function get_all_programs_type() {
        $sql = "SELECT * FROM program";

        return $this->db->query($sql)->result();
    }

    public function get_all_programs_member($member_id) {
        $sql = "SELECT 
                p.id,
                p.type
            FROM program p WHERE p.id NOT IN (SELECT m.program_id FROM membership m WHERE m.member_id = ?)";

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
}