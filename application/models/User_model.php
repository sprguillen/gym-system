<?php

/**
 * @author Simon Guillen (sprguillen@gmail.com)
 * User model (handles login, new members, logout, get user details)
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

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

    public function login($data) {
        $sql = "SELECT
                ua.id as id,
                ua.username as username,
                ua.email as email,
                ua.password as password,
                ua.user_profile_id as user_profile_id,
                uat.account_type as account_type
            FROM user_account ua JOIN user_account_type uat
            ON ua.user_account_type_id = uat.id
            WHERE ua.username = ? AND ua.password = ?";

        $query = $this->db->query($sql, array($data['username'], $data['password']));
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

    public function register_user($data) {
        $user_profile_data = array(
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email']
        );

        $result = $this->insert($user_profile_data, 'user_profile');

        if ($result) {
            $user_account_data = array(
                'username' => $data['username'],
                'password' => $data['password'],
                'email' => $data['email'],
                'user_account_type_id' => 2,
                'user_profile_id' => $result
            );

            $final_result = $this->insert($user_account_data, 'user_account');

            if ($final_result) {
                $data = array(
                    'status' => true,
                    'message' => 'Successfully created new user!'
                );
            } else {
                $data = array(
                    'status' => false,
                    'message' => 'Error inserting account, please contact admin!'
                );
            }
        } else {
            $data = array(
                'status' => false,
                'message' => 'Error inserting to profile, please contact admin!'
            );
        }

        return $data;
    }
}
