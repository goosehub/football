<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// User Auth
define('PASSWORD_OVERRIDE', false); // Dev and emergency use only
define('PASSWORD_OPTIONAL', false); // Useful for /r/webgames which requires no required password logins
define('REGISTER_IP_FREQUENCY_LIMIT_MINUTES', 30); // Minutes between registration from IP
define('LOGIN_LIMIT_WINDOW_MINUTES', 30); // Number of minutes during which an IP can login LOGIN_LIMIT_COUNT times
define('LOGIN_LIMIT_COUNT', 5); // Number of logins allowed in last LOGIN_LIMIT_WINDOW_MINUTES

// File and Directory Modes
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

// File Stream Modes
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

// Display Debug backtrace
define('SHOW_DEBUG_BACKTRACE', true);

// Exit Status Codes
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code