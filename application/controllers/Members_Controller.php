<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Members Class
 *
 * @author Nikki <monique.dingding@gmail.com>
 * Created on March 16, 2018
 */

class Members_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->membership_types = ['active', 'inactive', 'frozen', 'guest'];
		// Load helpers
		$this->load->helper('form');
		$this->load->helper('url');

		// Load libraries
		$this->load->library('form_validation');
		$this->load->library('session');

		// Load models
		$this->load->model('Member_Model');
		$this->load->model('Fingerprint_Model');

		$this->breadcrumbs->set(['Dashboard' => '/', 'Members' => 'members']);
		$this->type = $this->uri->segment(3);

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('/'));
		}

	}

	/**
	 * Sample data only - call the db method here
	 * @return {array} $members
	 */
	public function get_members($status) {
		$paid_arry = [];
		$return_data = [];
		if ($status === 'active' || $status === 'frozen') {
			$members_with_membership = $this->Member_Model->get_all_membership_by_status($status);

			foreach ($members_with_membership as $member) {

				$paid_arry = [];

				if (strpos($member->programs_status, ',') !== false) {
					$status_arry = explode(",", $member->programs_status);
					foreach ($status_arry as $sa) {
						if ($sa === 'Active' || $sa === 'Frozen') {
							$paid = "Yes";
						} else {
							$paid = "No";
						}
						array_push($paid_arry, $paid);
					}
					$paid = implode(",", $paid_arry);
				} else {
					if ($member->programs_status === 'Active' || 
						$member->programs_status === 'Frozen') {
						$paid = 'Yes';
					} else {
						$paid = 'No';
					}
				}

				$pushed_data = [
					'id' => $member->id,
					'name' => $member->fname . ' ' . $member->mname . ' ' . $member->lname,
					'duration' => $member->duration,
					'classes' => $member->programs_type,
					'isPaid' => $paid
				];

				array_push($return_data, $pushed_data);
			}

		} else if ($status === 'inactive') {
			$members_without_membership = $this->Member_Model->get_no_membership_member();

			foreach ($members_without_membership as $member) {
				$pushed_data = [
					'id' => $member->id,
					'name' => $member->fname . ' ' . $member->mname . ' ' . $member->lname,
					'duration' => "-",
					'classes' => "Member has not enrolled yet",
					'isPaid' => "Not yet"
				];

				array_push($return_data, $pushed_data);
			}

			$members_with_expired_membership = $this->Member_Model->get_all_membership_by_status($status);

			foreach ($members_with_expired_membership as $member) {
				if (strpos($member->programs_status, ',') !== false) {
					$status_arry = explode(",", $member->programs_status);
					foreach ($status_arry as $sa) {
						if ($sa === 'Inactive') {
							$paid = "No";
						} else {
							$paid = "Yes";
						}
						array_push($paid_arry, $paid);
					}
					$paid = implode(",", $paid_arry);
				} else {
					if ($member->programs_status === 'Inactive') {
						$paid = 'No';
					}
				}

				$pushed_data = [
					'id' => $member->id,
					'name' => $member->fname . ' ' . $member->mname . ' ' . $member->lname,
					'duration' => $member->duration,
					'classes' => $member->programs_type,
					'isPaid' => $paid,
					'displayRenewButton' => true
				];

				array_push($return_data, $pushed_data);
			}
		}

		return $return_data;
	}

	/**
	 * Sample data only - call the db method here
	 * @return {array} $members
	 */
	public function get_guests() {
		$return_data = [];
		$members = $this->Member_Model->get_all_membership_by_status('Not Applicable');

		foreach ($members as $member) {
			$pushed_data = [
				'id' => $member->id,
				'name' => $member->fname . ' ' . $member->mname . ' ' . $member->lname,
				'duration' => $member->duration,
				'classes' => $member->programs_type
			];
			array_push($return_data, $pushed_data);
		}

		return $return_data;
	}

	/**
	 * (Called by AJAX) Get member details and return the member JSON
	 * @return {bool} 
	 */
	public function get_details_via_ajax() {
		$member_id = $_GET['id'];

		$result = $this->Member_Model->get_member_data_by_id($member_id);
		
		$this->session->set_flashdata('guest_data', $result[0]);
		echo true;
	}

	/**
	 * Get member details to be used by the information page
	 * @return {array}
	 */
	public function get_member_details($member_id) {
		$result = $this->Member_Model->get_member_data_with_emergency_contact_by_id($member_id);
		
		return $result;
	}

	/**
	 * Displays a list of members
	 */
	public function members_list() {
		if (!in_array($this->type, $this->membership_types)) {
			redirect(base_url('members/list/active'));
		}

		$data['type'] = ($this->type === NULL)? 'active': $this->type;
		$data['user_mode'] = $this->session->userdata('mode');
		$data['members'] = $this->get_members($this->type);

		$this->breadcrumbs->set([ucfirst($data['type']) => 'members/list/' . $data['type']]);

		if ($this->type === 'guest') {
			$data['guests'] = $this->get_guests();
		}

		$this->render('list', $data);
	}



	/**
	 * Displays the edit page (same as register)
	 */
	public function edit() {
		$userId = $this->uri->segment(3);
		$name = 'Juan Saluminag';

		$this->breadcrumbs->set(['Edit: ' . $name => 'members/edit/' . $userId]);

		$this->render('register');
	}

	/**
	 * Displays the register page
	 */
	public function register() {
		$result = $this->Member_Model->get_max_id();
		$current_next_id = $result + 1;

		$this->breadcrumbs->set(['Register' => 'members/register']);
		$data['api_reg_url'] = base64_encode(FINGERPRINT_API_URL . "?action=register&member_id=$current_next_id");

		if ($this->session->userdata('current_finger_data')) {
			$this->session->unset_userdata('current_finger_data');
		}

		$this->render('register', $data);
	}

	public function process_member_register() {
		$response = array();
		$this->load->helper('url');
		$member_id = (int)$this->Member_Model->get_max_id() + 1;

		$member_data = array(
				'id'			=> $member_id,
				'fname' 	 	=> $_POST['fname'],
				'mname' 	 	=> $_POST['mname'],
				'lname' 	 	=> $_POST['lname'],
				'address'	 	=> $_POST['address'],
				'date_of_birth' => $_POST['birthdate'],
				'gender' 	 	=> $_POST['gender'],
				'weight' 	 	=> $_POST['weight'],
				'height' 	 	=> $_POST['height'],
				'contact' 		=> $_POST['cellnumber'],
				'email' 	 	=> $_POST['email'],
				'img' 	 	 	=> $_POST['img']
		);

		$contact_data = array(
			'full_name'    => $_POST['ename'],
			'relationship' => $_POST['relationship'],
			'contact'      => $_POST['econtact'],
			'member_id'	   => $member_id
		);

		$finger_data = $this->session->userdata('current_finger_data');

		$result1 = $this->Member_Model->insert($member_data, 'member');
		$result2 = $this->Member_Model->insert($contact_data, 'emergency_contact');
		$result3 = $this->Member_Model->insert($finger_data, 'member_finger');

		if ($result1 && $result2 && $result3) {
			$response['status'] = true;
			$response['message'] = 'Member successfully registered!';
			$response['redirect'] = base_url() . 'members/list/inactive';
		} else {
			$response['error'] = array();
			$response['status'] = false;
			$response['redirect'] = base_url() . 'members/register';
			if (!$result1) {
				array_push($response['error'], "Error inserting member data, please consult admin!");
			}

			if (!$result2) {
				array_push($response['error'], "Error inserting emergency contact data, please consult admin!");
			}

			if (!$result3) {
				array_push($response['error'], "Error inserting fingerprint data, please consult admin!");
			}
		}

		echo json_encode($response);
	}

	/**
	 * Temporary method to display the header for the attendance table
	 * Please change to dynamic data
	 * @param  [string] $view_type
	 * @return [string]           
	 */
	public function get_sched_header($view_type) {
		$header_title = 'Today - ' . date('M d, Y');

		switch ($view_type) {
			case 'weekly':
				$header_title = 'April 23-28, 2018';
			break;
			case 'monthly':
				$header_title = 'April 2018';
			break;

		}

		return $header_title;
	}

	/**
	 * Get attendance of individual member
	 */
	public function ajax_get_member_attendance() {
		$member_id = $this->input->post('member_id');
		$attendance = $this->Member_Model->get_attendance_by_member_id($member_id);

		echo json_encode($attendance);
	}

	/**
	 * Get list of memberships enrolled by user 
	 */
	public function ajax_get_membership_logs() {
		$member_id = $this->input->post('member_id');
		$logs = $this->Member_Model->get_memberships_by_id($member_id);

		echo json_encode($logs);
	}

	/**
	 * Get member attendance of a specific date 
	 */
	public function get_attendance() {
		$view_type = ($this->uri->segment(3) === NULL)? 'daily': $this->uri->segment(3);

		$data['view_header'] = $this->get_sched_header($view_type);
		$data['view_type'] = $view_type;
		$data['type'] = ($this->type === NULL)? 'active': $this->type;

		$result = $this->Member_Model->get_attendance($view_type);
		$data['members'] = $result;

		$this->breadcrumbs->set(['Members Attendance' => 'members/attendance']);

		$this->render('attendance', $data);
	}

	/**
	 * Get member details by id
	 */
	public function get_details() {
		$member_id = $this->uri->segment(3);
		$member_details = $this->get_member_details($member_id);
		
		$data['type'] = ($this->type === NULL)? 'active': $this->type;
		$data['user_mode'] = $this->session->userdata('mode');
		$data['member'] = (isset($member_details[0]))? $member_details[0]: NULL;
		
		$full_name = $member_details[0]->fname . ' ' . 
			$member_details[0]->mname . ' ' . 
			$member_details[0]->lname;

		$this->breadcrumbs->set(['Member Information: ' . $full_name => 'members/info/' . $member_id]);
		$this->render('information', $data);
	}

	/**
	 * Get list of all programs (called by AJAX)
	 * @return JSON
	 */
	public function get_program_list() {
		$program_list = $this->Member_Model->get_all_programs();

		echo json_encode($program_list);
	}

	/**
	 * Update member (called by AJAX)
	 */
	public function update_member_details() {
		$data = $_POST; 

		$this->Member_Model->update_member($data);
	}

	/**
	 * Count all members
	 * @return string (total member count)
	 */
	public function get_member_count() {
		$result = $this->Member_Model->count_all_members();

		$total_member_count = $result + 1;
		echo $total_member_count;
	}

	/**
	 * Store fingerprint data to session
	 */
	public function register_fingerprint() {
		$status = $_GET['status'];

		if ($status === 'success') {
			$finger_data = array(
				'finger_id' => $_GET['finger_id'],
				'finger_data' => $_GET['finger_data'],
				'member_id' => (int)$_GET['member_id']
			);
			$this->session->set_userdata('current_finger_data', $finger_data);
		}

		echo "<script>window.close();</script>";
	}

	/**
	 * API Call to verify if fingerdata has been stored before
	 * registration form submit
	 * @return bool
	 */
	public function get_fingerprint_data() {
		if ($this->session->userdata('current_finger_data')) {
			echo true;
		} else {
			echo false;
		}
	}

	/**
	 * Process membership enrollment (called by AJAX)
	 * @return JSON
	 */
	public function process_enrollment() {
		$member_id 	= $_POST['member_id'];
		$program_id = $_POST['program_id'];

		$date_started = date(MYSQL_DATE_TIME_FORMAT, strtotime("now"));
		$date_expired = date(MYSQL_DATE_TIME_FORMAT, strtotime($_POST['payment_length']));

		$data = [
			'member_id' => $member_id,
			'program_id' => $program_id,
			'date_started' => $date_started,
			'date_expired' => $date_expired,
			'status' => 'Active'
		];

		$result = $this->Member_Model->insert($data, 'membership');
		if ($result) {
			$response = [
				'status' => true,
				'message' => 'Member successfully enrolled..'
			];
		} else {
			$response = [
				'status' => false,
				'message' => 'Member insert error! Contact admin now!'
			];
		}

		echo json_encode($response);
	}

	/**
	 * Ajax call to unfreeze the member and update the status of membership
	 */
	public function ajax_unfreeze_member() {
		$member_id = $this->input->post('member_id');

		$result = $this->Member_Model->unfreeze_membership($member_id);

		if ($result) {
			$return_data = [
				'code' => 200,
				'message' => 'Successfully unfrozen member'
			];
		} else {
			$return_data = [
				'code' => 400,
				'message' => 'Failure to unfreeze member'
			];
		}

		echo json_encode($return_data);
	}

	/**
	 * Ajax call to freeze the member and insert data to membership_frozen table
	 */
	public function ajax_freeze_member() {
		$member_id = $this->input->post('member_id');
		$freeze_data = $this->input->post('freeze_data');
		
		$results = $this->Member_Model->get_memberships_by_id_status($member_id, 'Active');
		$isValidDate = true;

		foreach ($results as $row) {
			if ($isValidDate) {
				$date_expired = strtotime($row['date_expired']);

				$isValidDate = ($date_expired >= time());
			}
		}

		if (!$isValidDate) {
			$response = [
				'code' => 400,
				'message' => 'Invalid date.'
			];
		} else {

			$freeze_data['date_frozen'] = date("Y-m-d");
			$this->Member_Model->freeze_membership($member_id, $freeze_data);

			$response = [
				'code' => 200,
				'message' => 'Membership successfully frozen.'
			];
		}

		echo json_encode($response);
	}

	/**
	 * Method to render template (header - body - footer)
	 * @param  [string] $page
	 */
	public function render($page, $data = []) {

		$data['isDashboard'] = TRUE;
		$data['breadcrumbs'] = $this->breadcrumbs->get();
		$page = 'pages/members/' . $page;

		$this->load->view('components/header', $data);

		$this->load->view($page, $data);

		$this->load->view('components/footer');
	}

	/**
	 * Custom date check validator
	 * @param  [string] date
	 */
	public function check_date_format($date) {
		$matched = preg_match("/[0-12]{2}/[0-31]{2}/[0-9]{4}/", $date);

		if ($matched) {
			return checkdate(substr($date, 0, 2), substr($date, 3, 2), substr($date, 6, 4)); 
		}

		return $matched;
	}

	/**
     * Display login page of members - biometrics 
     */
    public function biometric_login() {
    	$member_id = $_GET['member_id'];
    	$data['login_done'] = false;
    	$data['api_ver_url'] = base64_encode(FINGERPRINT_API_URL . "?action=verification&member_id=$member_id");

        $this->render('login_biometric', $data);
    }

    public function verify_fingerprint() {
    	$status = $_GET['status'];
    	$member_id = (int)$_GET['member_id'];
    	$time = $_GET['time'];

    	$memberships = $this->Member_Model->get_memberships_by_id($member_id);
    	$member = $this->Member_Model->get_member_data_by_id($member_id);

    	$data['login_done'] = true;
    	$data['verification_status'] = $status;
    	$data['login_time'] = date('Y-m-d H:i:s', strtotime($time));
    	$data['first_name'] = $member[0]->fname;
    	$data['middle_name'] = $member[0]->mname;
    	$data['middle_name'] = $member[0]->lname;
    	$data['memberships'] = array();

    	foreach($memberships as $membership) {
    		if ($membership->status === 'Inactive' || $membership->status === 'Frozen') {
    			$pushArray = array(
    				'program' => $this->Member_Model->get_program_type_by_id($membership->program_id),
    				'inactive' => true,
    				'status' => $membership->status,
    				'expiration' => $membership->date_expired
    			);

    			if ($membership->status === 'Frozen') {
    				$pushArray['frozen'] = true;
    			}

    			array_push($data['memberships'], $pushArray);
    		} else {
    			if ($membership->date_expired < date('Y-m-d', strtotime($time))) {
    				$update_data = array(
    					'id' => $membership->id,
    					'status' => 'Inactive'
    				);
    				$this->Member_Model->update_membership($update_data);
    				array_push($data['memberships'], array(
	    				'program' => $this->Member_Model->get_program_type_by_id($membership->program_id),
	    				'inactive' => true,
	    				'status' => 'Inactive',
	    				'expiration' => $membership->date_expired
	    			));
    			} else {
	    			$insert_data = array(
	    				'attendance' => $data['login_time'],
	    				'membership_id' => $membership->id
	    			);

	    			$this->Member_Model->insert($insert_data, 'membership_attendance');
	    			array_push($data['memberships'], array(
	    				'program' => $this->Member_Model->get_program_type_by_id($membership->program_id),
	    				'inactive' => false,
	    				'status' => $membership->status
	    			));
    			}
    			
    		}
    	}

    	$this->session->set_userdata('verification_result', $data, 300);
    	echo "<script>window.close();</script>";
    }

    public function get_verification_data() {
    	$verification_result = $this->session->userdata('verification_result');
    	if ($verification_result) {
    		$this->session->unset_userdata('verification_result');
    		echo json_encode($verification_result);
    	}
    }
}
