<?php

/**
 * @author Simon Guillen (sprguillen@gmail.com)
 * Fingerprint registration, verification done here
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fingerprint_Model extends CI_Model {
	public function __construct() {
        $this->load->database();
    }

    public function insert($data, $table = 'member_finger') {
    	$this->db->trans_start();

    	$this->db->insert($table, $data);
    	$id = $this->db->insert_id();

    	$this->db->trans_complete();
    	return (string)$id;
    }

    public function get_device_by_serial($sn) {
    	$sql = "SELECT * FROM device WHERE serial_number = ?";
    	return $this->db->query($sql, $sn)->row();
    }

    public function get_fingerprint_by_member($member_id) {
    	$sql = "SELECT MAX(finger_id) as fid FROM member_finger WHERE member_id = ?";

    	return $this->db->query($sql, $member_id)->row()->fid;
    }

    public function get_device_by_verification($vc) {
    	$sql = "SELECT * FROM device WHERE verification_code = ?";
    	return $this->db->query($sql, $vc)->row();
    }

    public function count_fingerprint_by_member($member_id) {
    	$sql = "SELECT COUNT(finger_id) as ct FROM member_finger WHERE member_id = ?";

    	return $this->db->query($sql, $member_id)->row()->ct;
    }
}