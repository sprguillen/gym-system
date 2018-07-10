<?php

/**
 * @author Nikki <monique.dingding@gmail.com>
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_Model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_membership_payments($select_date = NULL, $between = NULL) {

        $sql = "SELECT * FROM membership_payment AS mp
                JOIN membership AS ms ON ms.id = mp.membership_id
                JOIN member AS m ON m.id = ms.member_id
                JOIN program_price AS pp ON pp.id = mp.program_price_id
                JOIN program AS p ON p.id = pp.program_id ";

        if (isset($between)) {
            $sql .= "WHERE mp.payment_date_time BETWEEN '" . $between['sun'] . "' AND '" . $between['sat'] . "'";
        } else {
            if (!isset($select_date)) {
                $select_date = date('Y-m') . "-%";
            }

            $sql .= "WHERE mp.payment_date_time LIKE '" . $select_date . "' ";
        }

        $sql .= "ORDER BY mp.payment_date_time DESC";

        return $this->db->query($sql)->result();
    }
}