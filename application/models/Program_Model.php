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
        $this->db->select('*');
        $this->db->from('program');
        $this->db->join('program_price', 'program_price.program_id = program.id');
        $query = $this->db->get();

        return $query->result();
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
}