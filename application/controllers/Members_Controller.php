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
		$this->load->model('member_model');

		$this->breadcrumbs->set(['Dashboard' => '/', 'Members' => 'members']);
		$this->type = $this->uri->segment(3);

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('/'));
		}
	}

	/**
	 * Sample data only - call the db methdo here
	 * @return {array} $membersgwapo akong
	 */
	public function get_members($status) {
		$return_data = [];
		$members = $this->member_model->get_all_membership_by_status($status);
		
		foreach ($members as $member) {
			$date_started = date('d M Y', strtotime($member->date_started));
			$date_expired = date('d M Y', strtotime($member->date_expired));

			if (time() - (60*60*24) <= strtotime($member->date_expired)) {
				$paid = true;
			} else {
				$paid = false;
			}

			$pushed_data = [
				'id' => $member->id,
				'name' => $member->fname . ' ' . $member->mname . ' ' . $member->lname,
				'duration' => $date_started . '-' . $date_expired,
				'classes' => $member->type,
				'isPaid' => $paid
			];
			array_push($return_data, $pushed_data);
		}

		

		return $return_data;
	}

	/**
	 * Sample data only - call the db methdo here
	 * @return {array} $members
	 */
	public function get_guests() {
		$return_data = [];
		$members = $this->member_model->get_all_membership_by_status('Not Applicable');

		foreach ($members as $member) {
			$pushed_data = [
				'id' => $member->id,
				'name' => $member->fname . ' ' . $member->mname . ' ' . $member->lname,
				'duration' => $member->date_expired,
				'classes' => $member->type
			];
			array_push($return_data, $pushed_data);
		}

		return $return_data;
	}

	/**
	 * (Called by AJAX) Get member details and return the member JSON
	 * @return {str} 
	 */
	public function get_member_details() {
		$member_id = $_GET['id'];

		$result = $this->member_model->get_member_data_by_id($member_id);
		if (array_key_exists('type', $_GET)) {
			if ($_GET['type'] === 'guest') {
				$this->session->set_flashdata('guest_data', $result[0]);
				echo true;
			}
		} else {
			echo json_encode($result[0]);
		}
		
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
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '2',
				'date' => 'April 23, 2018',
				'logged_in' => '8:27 AM',
				'name' => 'Arnel Pablo',
				'staff' => 'John Torralba',
				'notes' => 'New guest'
			],
			[
				'id' => '3',
				'date' => 'April 24, 2018',
				'logged_in' => '9:03 AM',
				'name' => 'Charles Malata',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '4',
				'date' => 'April 25, 2018',
				'logged_in' => '11:44 AM',
				'name' => 'Jay Cruz',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '5',
				'date' => 'April 25, 2018',
				'logged_in' => '12:01 PM',
				'name' => 'Bong George',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '6',
				'date' => 'April 26, 2018',
				'logged_in' => '3:28 PM',
				'name' => 'Sigrid Angkang',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '7',
				'date' => 'April 26, 2018',
				'logged_in' => '4:59 PM',
				'name' => 'Leon Prudencio',
				'staff' => 'John Torralba',
				'notes' => ''
			],
			[
				'id' => '8',
				'date' => 'April 27, 2018',
				'logged_in' => '6:10 PM',
				'name' => 'Richard Tamala',
				'staff' => 'John Torralba',
				'notes' => ''
			],

		];


		$this->breadcrumbs->set(['Members Attendance' => 'members/attendance']);

		$this->render('attendance', $data);
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
