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

}