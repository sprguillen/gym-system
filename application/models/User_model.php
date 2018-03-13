<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function login($data) {
        $this->db->select('*');
		$this->db->where('username',$data['username']);
        $this->db->where('password',$data['password']);
        $this->db->limit(1);
        $query = $this->db->get("user_account");

        if ($query->num_rows() === 1) {
			return $query->result();
		} else {
			return false;
		}
    }

    public function get_user_profile($userProfileId) {
        $this->db->select('*');
		$this->db->from('user_profile');
		$this->db->where('id', $userProfileId);
        $this->db->limit(1);
		$query = $this->db->get();

        if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
    }
}
