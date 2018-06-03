<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home_Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/**
 * CUSTOM ROUTES
 */
//
// $route['login'] = 'Home_Controller/login';
$route['register'] = 'Home_Controller/register';


/**
 * Dashboard Routes
 */

$route['dashboard'] = 'Dashboard_Controller/index';
$route['dashboard/logout'] = 'Dashboard_Controller/logout';

/**
 * Members
 */
$route['members'] = 'Members_Controller/members_list';
$route['members/get_member_count'] = 'Members_Controller/get_member_count';
$route['members/test_session'] = 'Members_Controller/test_session';
$route['members/list'] = 'Members_Controller/members_list';
$route['members/list/active'] = 'Members_Controller/members_list';
$route['members/list/inactive'] = 'Members_Controller/members_list';
$route['members/list/frozen'] = 'Members_Controller/members_list';
$route['members/list/guest'] = 'Members_Controller/members_list';
$route['members/list/get_details_via_ajax'] = 'Members_Controller/get_details_via_ajax';
$route['members/list/register'] = 'Members_Controller/register';
$route['members/register'] = 'Members_Controller/register';
$route['members/register/register_fingerprint'] = 'Members_Controller/register_fingerprint';
$route['members/verify_fingerprint'] = 'Members_Controller/verify_fingerprint';
$route['members/edit/(:any)'] = 'Members_Controller/edit';
$route['members/get_fingerprint_data'] = 'Members_Controller/get_fingerprint_data';
$route['members/process_member_register'] = 'Members_Controller/process_member_register';
$route['members/attendance'] = 'Members_Controller/get_attendance';
$route['members/attendance/get_specific_date_attendance_by_ajax'] = 'Members_Controller/get_specific_date_attendance_by_ajax';
$route['members/attendance/(:any)'] = 'Members_Controller/get_attendance';
$route['members/info/update_member_details'] = 'Members_Controller/update_member_details';
$route['members/list/get_program_list'] = 'Members_Controller/get_program_list';
$route['members/list/get_program_list_per_member'] = 'Members_Controller/get_program_list_per_member';
$route['members/list/process_enrollment'] = 'Members_Controller/process_enrollment';
$route['members/process_fingerprint'] = 'Members_Controller/process_fingerprint';
$route['members/get_device_account'] = 'Members_Controller/get_device_account';
$route['members/biometric-login'] = 'Members_Controller/biometric_login';
$route['members/get_verification_data'] = 'Members_Controller/get_verification_data';
$route['members/info/(:num)'] = 'Members_Controller/get_details';
$route['members/cancel-membership/(:any)'] = 'Members_Controller/cancel_membership';

/**
 * Guests 
 */
$route['guests/register'] = 'Members_Controller/register_as_guest';
$route['guests/registration'] = 'Members_Controller/guest_registration';
$route['guests/get_program_list'] = 'Members_Controller/get_program_list';


/**
 * Admin Mode
 */
$route['admin/unlock/(:any)'] = 'Admin_Controller/unlock';
$route['admin/lock/(:any)'] = 'Admin_Controller/lock';
$route['admin/add'] = 'Admin_Controller/add_admin';
$route['admin/add_user'] = 'Admin_Controller/add_user';

/**
 * Coaches
 */
$route['coaches'] = 'Coaches_Controller/getList';

/**
 * Programs
 */
$route['programs'] = 'Programs_Controller/programs_list';
$route['programs/add'] = 'Programs_Controller/add_program';

