<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';

// View for testing htaccess URL rewrite
$route['create_team'] = 'team/create';
$route['game/(:any)'] = 'game/index/$1';

// Cron
$route['cron/(:any)'] = "cron/index/$1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;