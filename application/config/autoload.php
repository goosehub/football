<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// CodeIgniter Features
$autoload['packages'] = array();
$autoload['libraries'] = array('session', 'form_validation');
$autoload['drivers'] = array();
$autoload['helper'] = array('url', 'form');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array();

// Set timezone
date_default_timezone_set('America/New_York');

// 
// General Purpose Functions
// 

// Return if this is dev
function site_name() {
    return 'gooseigniter';
}

// Return if this is dev
function is_dev() {
    if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'dev.foobar.com') {
        return true;
    }
    return false;
}

// Get Application Auth Information
function auth() {
    $auth = json_decode(file_get_contents('auth.php'));
    return $auth;
}

// Force HTTPS for non dev
function force_ssl() {
    if (!is_dev()) {
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
            $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            redirect($url);
            exit;
        }
    }
}

// Get JSON POST
function get_json_post($required) {
    $raw_post = file_get_contents('php://input');
    if ($required && !$raw_post) {
        echo api_error_response('no_post', 'POST received was empty.');
        exit();
    }
    $json_post = json_decode($raw_post);
    if ($required && !$json_post) {
        echo api_error_response('post_is_not_json', 'POST must be formatted as JSON.');
        exit();
    }
    return $json_post;
}

// API Error JSON Response
function api_error_response($error_code, $error_message) {
    log_message('error', $error_code . ' - ' . $error_message);
    $data['error'] = true;
    $data['error_code'] = $error_code;
    $data['error_message'] = $error_message;
    return json_encode($data);
}

// API Data JSON Response
function api_response($data) {
    $data['error'] = false;
    $data['success'] = true;
    // Encode and send data
    function filter(&$value) {
        if (is_string($value)) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $value = nl2br($value);
        }
    }
    array_walk_recursive($data, "filter");
    return json_encode($data);
}

// For turning slugs back into human friendly format
function deslug($string) {
    return ucwords(str_replace('_', ' ', $string));
}

// Returns true for ints or strings that are ints
function validate_int($input)
{
    $input = filter_var($input, FILTER_VALIDATE_INT);
    return is_int($input);
}

// http://stackoverflow.com/a/5727346/3774582
// Parse CRON frequency
// Break it down like James Brown
function parse_crontab($time, $crontab) {
    // Get current minute, hour, day, month, weekday
    $time = explode(' ', date('i G j n w', strtotime($time)));
    // Split crontab by space
    $crontab = explode(' ', $crontab);
    // Foreach part of crontab
    foreach ($crontab as $k => &$v) {
        // Remove leading zeros to prevent octal comparison, but not if number is already 1 digit
        $time[$k] = preg_replace('/^0+(?=\d)/', '', $time[$k]);
        // 5,10,15 each treated as seperate parts
        $v = explode(',', $v);
        // Foreach part we now have
        foreach ($v as &$v1) {
            // Do preg_replace with regular expression to create evaluations from crontab
            $v1 = preg_replace(
                // Regex
                array(
                    // *
                    '/^\*$/',
                    // 5
                    '/^\d+$/',
                    // 5-10
                    '/^(\d+)\-(\d+)$/',
                    // */5
                    '/^\*\/(\d+)$/'
                ),
                // Evaluations
                // trim leading 0 to prevent octal comparison
                array(
                    // * is always true
                    'true',
                    // Check if it is currently that time, 
                    $time[$k] . '===\0',
                    // Find if more than or equal lowest and lower or equal than highest
                    '(\1<=' . $time[$k] . ' and ' . $time[$k] . '<=\2)',
                    // Use modulus to find if true
                    $time[$k] . '%\1===0'
                ),
                // Subject we are working with
                $v1
            );
        }
        // Join 5,10,15 with `or` conditional
        $v = '(' . implode(' or ', $v) . ')';
    }
    // Require each part is true with `and` conditional
    $crontab = implode(' and ', $crontab);
    // Evaluate total condition to find if true
    return eval('return ' . $crontab . ';');
}

// For human readable spans of time
// http://stackoverflow.com/questions/2915864/php-how-to-find-the-time-elapsed-since-a-date-time
function get_time_ago($time_stamp) {
    $time_difference = strtotime('now') - $time_stamp;
    if ($time_difference >= 60 * 60 * 24 * 365.242199) {
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'year');
    }
    else if ($time_difference >= 60 * 60 * 24 * 30.4368499) {
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'month');
    }
    else if ($time_difference >= 60 * 60 * 24 * 7) {
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'week');
    }
    else if ($time_difference >= 60 * 60 * 24) {
        return get_time_ago_string($time_stamp, 60 * 60 * 24, 'day');
    }
    else if ($time_difference >= 60 * 60) {
        return get_time_ago_string($time_stamp, 60 * 60, 'hour');
    }
    else {
        return get_time_ago_string($time_stamp, 60, 'minute');
    }
}
function get_time_ago_string($time_stamp, $divisor, $time_unit) {
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = floor($time_difference / $divisor);
    settype($time_units, 'string');
    if ($time_units === '0') {
        return 'less than 1 ' . $time_unit . ' ago';
    }
    else if ($time_units === '1') {
        return '1 ' . $time_unit . ' ago';
    }
    else {
        return $time_units . ' ' . $time_unit . 's ago';
    }
}

// Flash Message
// http://www.phpdevtips.com/2013/05/simple-session-based-flash-messages/
function flash($name = '', $message = '', $class = 'success') {
    // We can only do something if the name isn't empty
    if (!empty( $name )) {
        // No message, create it
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name.'_class'])) {
                unset($_SESSION[$name.'_class']);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }
        // Message exists, display it
        else if (!empty($_SESSION[$name]) && empty($message)) {
            $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
            echo '<div class="alert alert-' . $class . '" role="alert">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}
