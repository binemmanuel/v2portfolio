<?php
/**
 * System configurations.
 * 
 * @package Bin Emmanuel
 * @author  Bin Emmanuel https://github.com/binemmanuel
 * @license GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/
 * @link    https://github.com/
 *
 * @version	1.0
 */
session_start();

use portfolio\SiteInfo;

/**
 * For developers: Bin Emmanuel debugging mode.
 *
 * Configure error reporting options
 * Change this to false to enable the display of notices during development.
 */
define('IS_ENV_PRODUCTION', false);

// Turn on error reporting
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', !IS_ENV_PRODUCTION);

// Set error log.
ini_set('error_log', 'log/php-error.txt');

// ** Set time zone to use date/time functions without warnings ** //
date_default_timezone_set('Africa/Lagos'); //http://www.php.net/manual/en/timezones.php

// Include our autoloader
require "vendor/autoload.php";

// Include our functions.
require 'functions.php';

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database */
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_SERVER', 'localhost');

/** Set character set */
define('CHARSET', 'utf8mb4');

// Initialize a Site Info Object.
$site_info = new SiteInfo;
$site_info = (object) $site_info->fetch();

// Set web root based on enviroment.
if (IS_ENV_PRODUCTION) {
    define('WEB_ROOT', $site_info->site_address . DIRECTORY_SEPARATOR);
} else {
    define('WEB_ROOT', 'http://localhost/portfolio/');
}
define('CSS_PATH', WEB_ROOT ."views/$site_info->template/assets/css/");
define('JS_PATH', WEB_ROOT ."views/$site_info->template/assets/js/");
define('IMG_PATH', WEB_ROOT ."views/$site_info->template/assets/img/");

/**
 * Upload Directory.
 */
define('UPLOAD_DIR', 'uploads' . DIRECTORY_SEPARATOR);
define('IMAGE_PATH', UPLOAD_DIR .'images'. DIRECTORY_SEPARATOR);
define('VIDEO_PATH', UPLOAD_DIR .'videos'. DIRECTORY_SEPARATOR);
define('AUDIO_PATH', UPLOAD_DIR .'audios'. DIRECTORY_SEPARATOR);
define('ZIP_PATH', UPLOAD_DIR .'zips'. DIRECTORY_SEPARATOR);
define('OTHER_FILES_PATH', UPLOAD_DIR .'other-files'. DIRECTORY_SEPARATOR);

/** Mail configurations */
define('SMTP_HOST', '');
define('SMTP_DEBUG', false);
define('SMTP_PORT', 26);
define('REPLY_TO', '');
define('MAIL_USER', '');
define('MAIL_USERS_NAME', '');
define('MAIL_PASSWORD', '');
