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
$route['members/list'] = 'Members_Controller/members_list';
$route['members/list/active'] = 'Members_Controller/members_list';
$route['members/list/inactive'] = 'Members_Controller/members_list';
$route['members/list/frozen'] = 'Members_Controller/members_list';
$route['members/list/guest'] = 'Members_Controller/members_list';
$route['members/list/get_member_details'] = 'Members_Controller/get_member_details';
$route['members/list/register'] = 'Members_Controller/register';
$route['members/register'] = 'Members_Controller/register';
$route['members/edit/(:any)'] = 'Members_Controller/edit';
$route['members/process_member_register'] = 'Members_Controller/process_member_register';

/**
 * Admin Mode
 */
$route['admin/unlock/(:any)'] = 'Admin_Controller/unlock';
$route['admin/lock/(:any)'] = 'Admin_Controller/lock';


/**
 * Coaches
 */
$route['coaches'] = 'Coaches_Controller/getList';
