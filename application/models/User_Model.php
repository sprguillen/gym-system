<?php

/**
 * @author Simon Guillen (sprguillen@gmail.com)
 * User model (handles login, new members, logout, get user details)
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model {

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
        $this->db->join('user_account', 'user_account.user_profile_id = user_profile.id');
		$this->db->where('user_profile.id', $userProfileId);
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
            'email' => $data['email'],
            'img'   => $data['user_img']
        );

        $result = $this->insert($user_profile_data, 'user_profile');

        if ($result) {
            $user_account_data = array(
                'id' => $data['finger_data']['id'],
                'username' => $data['username'],
                'password' => $data['password'],
                'email' => $data['email'],
                'user_account_type_id' => 2,
                'user_profile_id' => $result
            );

            $result2 = $this->insert($user_account_data, 'user_account');
            $result3 = $this->insert($data['finger_data'], 'user_account_finger');

            if ($result2 && $result3) {
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

    public function get_complete_user_details() {
        $sql = "SELECT
                ua.id,
                ua.username,
                up.fname,
                up.lname,
                up.email
                FROM user_account ua JOIN user_profile up
                ON ua.user_profile_id = up.id";

        return $this->db->query($sql)->result();
    }

    public function get_max_id() {
        $sql = "SELECT MAX(id) as uid FROM user_account";

        return $this->db->query($sql)->result()[0]->uid;
    }

    public function check_if_username_exists($username) {
        $sql = "SELECT id FROM user_account WHERE username = '$username'";

        return $this->db->query($sql)->result();
    }

    public function get_user_profile_by_account_id($user_account_id) {
        $this->db->select('*');
        $this->db->from('user_profile');
        $this->db->join('user_account', 'user_account.user_profile_id = user_profile.id');
        $this->db->where('user_account.id', $user_account_id);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_user_account_attendance($user_account_id) {
        $sql = "SELECT * FROM user_account_attendance WHERE user_account_id = $user_account_id";

        return $this->db->query($sql)->result();
    }
}
