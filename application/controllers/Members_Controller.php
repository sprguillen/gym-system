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
		$this->load->model('Program_Model');

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
				$programs_enrolled = $this->Member_Model->get_memberships_by_id_status($member->id, 'active');

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
					'isPaid' => $paid,
					'programs_enrolled' => $programs_enrolled
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
				'duration' => $member->date_started,
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
		$data['api_ver_url'] = FINGERPRINT_API_URL . "?action=verification&member_id=";
		$data['total_count'] = count($this->get_members($this->type));

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
		$header_title = 'Today - ' . date('F d, Y');

		switch ($view_type) {
			case 'weekly':
				$week_start = date("F d, Y",strtotime('monday this week'));
        		$week_end = date("F d, Y ",strtotime("next monday"));
        		$header_title = $week_start . '-' .$week_end;
			break;
			case 'monthly':
				$header_title = date("F");
			break;

		}

		return $header_title;
	}

	/**
	 * Get attendance of individual member
	 */
	public function ajax_get_member_attendance() {
		$member_id = $this->input->get('member_id');
		$attendance = $this->Member_Model->get_attendance_by_member_id($member_id);

		echo json_encode($attendance);
	}

	/**
	 * Get list of memberships enrolled by user 
	 */
	public function ajax_get_membership_logs() {
		$member_id = $this->input->get('member_id');
		$logs = $this->Member_Model->get_memberships_by_member_id($member_id);

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
		$program_price_id = $_POST['program_price_id'];
		$old_member_date_started = $_POST['date_started'];
		$program_price = $this->Program_Model->get_program_price_by_id($program_price_id);

		if ($program_price) {
			$duration = '+' . $program_price[0]->duration;

			$daily = ['Daily', 'daily'];

			if (in_array($program_price[0]->duration, $daily)) {
				$duration = "now";
			}
			
			if ($old_member_date_started) {
				$date_started = date(MYSQL_DATE_FORMAT, strtotime($old_member_date_started));
				$date_expired = date(MYSQL_DATE_FORMAT, strtotime($duration, strtotime($old_member_date_started)));
			} else {
				$date_started = date(MYSQL_DATE_FORMAT, strtotime("now"));
				$date_expired = date(MYSQL_DATE_FORMAT, strtotime($duration));
			}

			$data = [
				'member_id' => $member_id,
				'program_id' => $program_id,
				'date_started' => $date_started,
				'date_expired' => $date_expired,
				'status' => 'Active'
			];

			$result = $this->Member_Model->insert($data, 'membership');
			if ($result) {
				$current_date_time = date(MYSQL_DATE_TIME_FORMAT, strtotime("now"));
				$data = array(
					'payment_date_time' => $current_date_time,
					'membership_id' => $result,
					'program_price_id' => $program_price_id
				);

				$result = $this->Member_Model->insert($data, 'membership_payment');

				if ($result) {
					$response = [
						'status' => true,
						'message' => 'Member successfully enrolled..'
					];
				} else {
					$response = [
						'status' => false,
						'message' => 'Member enrollment error! Contact admin now!'
					];
				}
			} else {
				$response = [
					'status' => false,
					'message' => 'Member enrollment error! Contact admin now!'
				];
			}
		} else {
			$response = [
				'status' => false,
				'message' => 'Error getting price list from server! Contact admin now!'
			];
		}
		echo json_encode($response);
	}

	public function process_renewal() {
		$member_id 	= $_POST['member_id'];
		$membership_id = $_POST['membership_id'];
		$program_price_id = $_POST['program_price_id'];

		$program_price = $this->Program_Model->get_program_price_by_id($program_price_id);

		if ($program_price) {
			$duration = '+' . $program_price[0]->duration;

			$date_started = date(MYSQL_DATE_FORMAT, strtotime("now"));
			$date_expired = date(MYSQL_DATE_FORMAT, strtotime($duration));

			$data = array(
				'id' => $membership_id,
				'date_started' => $date_started,
				'date_expired' => $date_expired,
				'status' => 'Active'
			);

			$this->Member_Model->update_membership($data);

			$data = array(
				'payment_date_time' => $date_started,
				'membership_id' => $membership_id,
				'program_price_id' => $program_price_id
			);

			$status = $this->Member_Model->insert($data, 'membership_payment');

			if ($status) {
				$result['status'] = true;
				$result['message'] = 'Successfully renewed membership!';
			} else {
				$result['status'] = true;
	    		$result['message'] = 'Member renewed but error on recording payment! Please contact admin now!';
			}
		} else {
			$result['status'] = false;
			$result['message'] = 'Error on renewing membership! Please contact admin now!';
		}

		echo json_encode($result);
	}

	public function ajax_update_membership_expiry() {
		$membership_id = $this->input->post('membershipId');
		$program_price_id = $this->input->post('programPriceId');
		$program_price = $this->Program_Model->get_program_price_by_id($program_price_id);
		$membership = $this->Member_Model->get_memberships_by_id($membership_id);

		if ($program_price && $membership) {
			$duration = '+' . $program_price[0]->duration;
			$new_date_expired = date(MYSQL_DATE_FORMAT, strtotime($membership[0]->date_expired . $duration));
			$data = [
	    		'id' => $membership_id,
	    		'date_expired' => $new_date_expired
	    	];

	    	$this->Member_Model->update_membership($data);
	    	$current_date_time = date(MYSQL_DATE_TIME_FORMAT, strtotime("now"));
			$data = array(
				'payment_date_time' => $current_date_time,
				'membership_id' => $membership_id,
				'program_price_id' => $program_price_id
			);

			$status = $this->Member_Model->insert($data, 'membership_payment');

			if ($status) {
				$result['status'] = true;
	    		$result['message'] = 'Successfully updated membership!';
			} else {
				$result['status'] = true;
	    		$result['message'] = 'Member updated but error on recording payment! Please contact admin now!';
			}
		} else {
			$result['status'] = false;
			$result['message'] = 'Error on updating membership! Please contact admin now!';
		}

		echo json_encode($result);
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
	 * Ajax call to check if email exists on the database
	 * @return json
	 */
	public function check_email() {
		$email = urldecode($_GET['email']);

		$result = $this->Member_Model->check_email_if_exists($email);

		if ($result > 0) {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}
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

			$freeze_data['date_frozen'] = date(MYSQL_DATE_FORMAT);
			$this->Member_Model->freeze_membership($member_id, $freeze_data);

			$result = $this->Program_Model->get_freeze_program_price();

			if ($result) {
				$data = array(
					'payment_date_time' => date(MYSQL_DATE_FORMAT),
					'program_price_id' => $result
				);

				$result2 = $this->Member_Model->insert($data, 'membership_payment');

				if ($result2) {
					$response = [
						'code' => 200,
						'message' => 'Membership successfully frozen.'
					];
				} else {
					$response = [
						'code' => 200,
						'message' => 'Membership successfully frozen yet failed to record payment. Contact admin now!'
					];
				}
			}
			
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
		$data['user_type'] = $this->session->userdata('mode');
		
		$page = 'pages/members/' . $page;

		$this->load->view('components/header', $data);

		$this->load->view($page, $data);

		$this->load->view('components/footer', $data);
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

    public function verify_fingerprint() {
    	$status = $_GET['status'];
    	$member_id = (int)$_GET['member_id'];
    	$membership_id = (int)$_GET['membership_id'];
    	$time = $_GET['time'];

    	$membership = $this->Member_Model->get_memberships_by_id($membership_id);
    	$member = $this->Member_Model->get_member_data_by_id($member_id);

    	$data['login_time'] = date('Y-m-d H:i:s', strtotime($time));
    	$data['login_time_display'] = date('M d,Y h:i:s a', strtotime($time));
    	$data['first_name'] = $member[0]->fname;
    	$data['middle_name'] = $member[0]->mname;
    	$data['last_name'] = $member[0]->lname;

		if ($membership[0]->status === 'Inactive' || $membership[0]->status === 'Frozen') {
    			$membership_arry = array(
    				'program' => $membership[0]->type,
    				'status' => $membership[0]->status,
    				'expiration' => $membership[0]->date_expired
    			);

    			if ($membership[0]->status === 'Frozen') {
    				$membership_arry['frozen'] = true;
    			}

    			$data['membership'] = $membership_arry;
		} else {
    		if ($membership[0]->date_expired < date('Y-m-d', strtotime($time))) {
				$update_data = array(
					'id' => $membership[0]->id,
					'status' => 'Inactive'
				);
    			$this->Member_Model->update_membership($update_data);
				$data['membership'] = array(
    				'program' => $membership[0]->type,
    				'inactive' => true,
    				'status' => 'Inactive',
    				'expiration' => $membership[0]->date_expired
    			);
    		} else {
    			$insert_data = array(
    				'attendance' => $data['login_time'],
    				'membership_id' => $membership[0]->id
    			);

    			$this->Member_Model->insert($insert_data, 'membership_attendance');
    			$data['membership'] = array(
    				'program' => $membership[0]->type,
    				'inactive' => false,
    				'status' => $membership[0]->status
    			);
    		}
    	}

    	$data['member_img_url'] = $member[0]->img;

    	$this->render('login_biometric', $data);
    }

    /**
     * Cancels the membership of the user
     */
    public function cancel_membership() {
    	$membership_id = $this->uri->segment(3);

    	$data = [
    		'id' => $membership_id,
    		'status' => 'Cancelled'
    	];

    	$this->Member_Model->update_membership($data);

    	redirect('members/list/active');
    }


    public function get_verification_data() {
    	$verification_result = $this->session->userdata('verification_result');
    	if ($verification_result) {
    		$this->session->unset_userdata('verification_result');
    		echo json_encode($verification_result);
    	}
    }

    public function get_specific_date_attendance_by_ajax() {
    	$date = $_GET['date'];
    	$result = $this->Member_Model->get_daily_attendance($date);

    	echo json_encode($result);
    }

    public function register_as_guest () {
    	$this->render('register_guest');
    }

    public function guest_registration() {
    	$this->form_validation->set_rules('fname', 'First Name', 'trim|required');
    	$this->form_validation->set_rules('mname', 'Middle Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('program_price_id', 'Program Price', 'required');

        if ($this->form_validation->run() === FALSE) {
        	$data['status'] = false;
        	$data['message'] = validation_errors(); 
        } else {
        	$member_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'gender' => $this->input->post('gender')
            );

            $result = $this->Member_Model->insert($member_data, 'member');

            if ($result) {
            	$current_date = date(MYSQL_DATE_FORMAT);
            	$current_date_time = date(MYSQL_DATE_TIME_FORMAT);
            	$status = GUEST_STATUS;
            	$program_price_id = $this->input->post('program_price_id');
            	$member_id = $result;

            	$program_price = $this->Program_Model->get_program_price_by_id($program_price_id);
            	$membership_data = array(
            		'date_started' => $current_date,
            		'date_expired' => $current_date,
            		'status' => $status,
            		'member_id' => $member_id,
            		'program_id' => $program_price[0]->program_id
            	);



            	$result2 = $this->Member_Model->insert($membership_data, 'membership');
            	if ($result2) {
            		$membership_payment_data = array(
	            		'payment_date_time' => $current_date_time,
	            		'membership_id' => $result2,
	            		'program_price_id' => $program_price_id
	            	);

	            	$result3 = $this->Member_Model->insert($membership_payment_data, 'membership_payment');

	            	if ($result3) {
	            		$data['status'] = true;
            			$data['message'] = 'Successfully registered guest member.';
	            	} else {
	            		$data['status'] = true;
	            		$data['message'] = 'Successfully registered guest member yet error on recording payment. Please contact admin!';
	            	}
            	} else {
            		$data['status'] = false;
            		$data['message'] = 'Error creating guest member. Please contact admin!';

            	}
            } else {
            	$data['status'] = false;
        		$data['message'] = 'Error creating guest member. Please contact admin!';
            }
        }
        echo json_encode($data);
    }

    public function get_member_by_name() {
    	$paid_arry = [];
		$return_data = [];
    	$name = $_GET['name'];
    	$status = $_GET['status'];

   		if ($status === 'active' || $status === 'frozen') {
   			$members = $this->Member_Model->get_member_by_name($name, $status);

   			if ($members) {
   				$data['status'] = true;

				foreach ($members as $member) {
					$programs_enrolled = $this->Member_Model->get_memberships_by_id_status($member->id, 'active');

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
						'isPaid' => $paid,
						'programs_enrolled' => $programs_enrolled
					];

					array_push($return_data, $pushed_data);
				}

				$data['members'] = $return_data;
				$data['mode'] = $this->session->userdata('mode');
   			} else {
   				$data['status'] = false;
   				$data['message'] = 'No members found with that name.';
   			}
   		} else if ($status === 'inactive') {
   			$members_without_membership = $this->Member_Model->get_no_membership_member_by_name($name);

			if ($members_without_membership) {
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
			}

			$members_with_expired_membership = $this->Member_Model->get_member_by_name($name, $status);

			if ($members_with_expired_membership) {
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

			if ($members_without_membership || $members_with_expired_membership) {
				$data['status'] = true;
				$data['members'] = $return_data;
				$data['mode'] = $this->session->userdata('mode');
			} else {
				$data['status'] = false;
   				$data['message'] = 'No members found with that name.';
			}
   		} else if ($status === 'guest') {
   			$guests = $this->Member_Model->get_member_by_name($name, 'Not Applicable');

			if ($guests) {
				$data['status'] = true;
				foreach ($guests as $guest) {
					$pushed_data = [
						'id' => $guest->id,
						'name' => $guest->fname . ' ' . $guest->mname . ' ' . $guest->lname,
						'duration' => $guest->duration,
						'classes' => $guest->programs_type
					];
					array_push($return_data, $pushed_data);
				}

				$data['members'] = $return_data;
				$data['mode'] = $this->session->userdata('mode');
			} else {
				$data['status'] = false;
   				$data['message'] = 'No guests found with that name.';
			}
   		}

    	echo json_encode($data);
    }

    public function get_members_list_by_program() {
    	$programs_list = array();
    	$program_obj = $this->Program_Model->get_all_programs_type();

    	foreach ($program_obj as $program) {
    		$programs_list[$program->id] = $program->type;
    	}

    	$first_id = $this->Program_Model->get_program_first_id();
  		if (!$this->type) {
  			redirect(base_url('members/programs/' . $first_id));
  		}

  		$data['type'] = $programs_list[$this->type];
    	$data['members'] = $this->Program_Model->get_members_by_program($this->type);
    	$data['programs_list'] = $programs_list;
    	$this->breadcrumbs->set([ucfirst($data['type']) => 'members/list/' . $data['type']]);
    	$this->render('programs', $data);
    }
}

