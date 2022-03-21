<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//user dashboard
$route['dashboard'] = 'welcome';
$route['logout'] = 'welcome/logout';

//Admin dashboard
$route['admin/dashboard'] = 'admin';
$route['admin/logout'] = 'admin/logout';

$route['default_controller'] = 'user';
$route['register'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
