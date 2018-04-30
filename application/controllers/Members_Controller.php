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

		// Load libraries
		$this->load->library('form_validation');
		$this->load->library('session');

		// Load models
		$this->load->model('Member_Model');

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
		$result = $this->Member_Model->get_member_data_by_id($member_id);
		
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
		$this->breadcrumbs->set(['Register' => 'members/register']);

		$this->render('register');
	}

	public function process_member_register() {
		$this->load->helper('url');

		print_r($_POST);
		$data = array(
				'fname' => $_POST['fname'],
				'mname' => $_POST['mname'],
				'lname' => $_POST['lname'],
				'address' => $_POST['address'],
				'birthdate' => $_POST['birthdate'],
				'gender' => $_POST['gender'],
				'weight' => $_POST['weight'],
				'height' => $_POST['height'],
				'cellnumber' => $_POST['cellnumber'],
				'email' => $_POST['email'],
				'ename' => $_POST['ename'],
				'relationship' => $_POST['relationship'],
				'econtact' => $_POST['econtact']
		);

		echo json_encode($data);
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
	 * Get member attendance of a specific date 
	 */
	public function get_attendance() {
		$view_type = ($this->uri->segment(3) === NULL)? 'daily': $this->uri->segment(3);

		$data['view_header'] = $this->get_sched_header($view_type);
		$data['view_type'] = $view_type;
		$data['type'] = ($this->type === NULL)? 'active': $this->type;

		$data['members'] = [
			[

				'id' => '1',
				'date' => 'April 23, 2018',
				'logged_in' => '6:47 AM',
				'name' => 'Resa Embutin',
				'type' => 'Guest',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '2',
				'date' => 'April 23, 2018',
				'logged_in' => '8:27 AM',
				'name' => 'Arnel Pablo',
				'type' => 'Guest',
				'staff' => 'John Torralba',
				'notes' => 'New guest'
			],
			[
				'id' => '3',
				'date' => 'April 24, 2018',
				'logged_in' => '9:03 AM',
				'name' => 'Charles Malata',
				'type' => 'Guest',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '4',
				'date' => 'April 25, 2018',
				'logged_in' => '11:44 AM',
				'name' => 'Jay Cruz',
				'type' => 'Guest',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '5',
				'date' => 'April 25, 2018',
				'logged_in' => '12:01 PM',
				'name' => 'Bong George',
				'type' => 'Member',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '6',
				'date' => 'April 26, 2018',
				'logged_in' => '3:28 PM',
				'name' => 'Sigrid Angkang',
				'type' => 'Member',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '7',
				'date' => 'April 26, 2018',
				'logged_in' => '4:59 PM',
				'name' => 'Leon Prudencio',
				'type' => 'Member',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '8',
				'date' => 'April 27, 2018',
				'logged_in' => '6:10 PM',
				'name' => 'Richard Tamala',
				'type' => 'Member',
				'staff' => 'John Torralba',
				'notes' => ''
			],

		];


		$this->breadcrumbs->set(['Members Attendance' => 'members/attendance']);

		$this->render('attendance', $data);
	}

	/**
	 * Get member details by id
	 * @return [type] [description]
	 */
	public function get_details() {
		$member_id = $this->uri->segment(3);
		$member_details = $this->get_member_details($member_id);
		
		$data['type'] = ($this->type === NULL)? 'active': $this->type;
		$data['user_mode'] = $this->session->userdata('mode');
		$data['member'] = (isset($member_details[0]))? $member_details[0]: NULL;
		
		$this->breadcrumbs->set(['Member Information: Leon Tamala' => 'members/info/' . $member_id]);
		$this->render('information', $data);
	}

	public function get_program_list() {
		$program_list = $this->Member_Model->get_all_programs();

		echo json_encode($program_list);
	}

	public function process_enrollment() {
		$member_id = $_POST['member_id'];
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

		$result = $this->Member_Model->insert_to_membership($data);
		if ($result == 1) {
			$return_data = [
				'status' => 'Success',
				'message' => 'Successfully enrolled user to a new program'
			];
		} else {
			$return_data = [
				'status' => 'Failure',
				'message' => 'Failure to enroll user to a new program'
			];
		}

		echo json_encode($return_data);
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
}
