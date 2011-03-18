<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/library/Settings.class.php');
$settings = new Settings();

// use this pathes and/or define the pathes for the "standard" pages
//define("CLASS_PATH", dirname($_SERVER['PHP_SELF'])."/"); // the location where the class is executed
//$sec_path = "/library/user/"; // a second location where the scripts should be
//define("APPLICATION_PATH", $sec_path);


// modify these constants to fit your environment
/*
define("BITEY_DB_SERVER", $settings->get('db.server'));
define("BITEY_DB_NAME", $settings->get('db.database'));
define ("BITEY_DB_USER", $settings->get('db.username'));
define ("BITEY_DB_PASSWORD", $settings->get('db.password'));
*/

// Important! use this setting to store the session data in your Mysql database
// disable this feature if your host doesn't support this session handler.
/*
define("USE_MYSQL_SESSIONS", true); // "false" to disable this setting
define ('COOKIE_SECRET_WORD', '');
*/

// these are the names for the standard table names
// !!! Important
// It's possible that your server doesn't allow the database name inside a query
// if this forms a problem don't use them here and unescape the mysql_select_db() function
// inside the connect_db() method.
//define("USER_TABLE", "user");
//define("PROFILE_TABLE", "users_profile");
//define("SESSION_TABLE", "sessions");

// variables (locations) standard pages (combine the pathes from the top or use your own)
define("LOGIN_PAGE", APPLICATION_PATH."login.php");
define("LOGOUT_PAGE", APPLICATION_PATH."logout.php");
define("FORGOT_PASSWORD_PAGE", APPLICATION_PATH."forgot_password.php");
define("REGISTER_PAGE", APPLICATION_PATH."register.php");
define("START_PAGE", "/"); //define("START_PAGE", "/classes/access_user/example.php");
define("ACTIVE_PASS_PAGE", APPLICATION_PATH."activate_password.php");
define("RESEND_ACTIVATION_PAGE", APPLICATION_PATH."resend_activation.php");
define("DENY_ACCESS_PAGE", APPLICATION_PATH."deny_access.php");
define("ADMIN_PAGE", APPLICATION_PATH."admin_user.php");
//define("LOGOUT_PAGE", APPLICATION_PATH."logout.php"); // if you use the setting "USE_MYSQL_SESSIONS" you need a logout page without class object to clear the old session data from the database
define("UPDATE_ACCOUNT", APPLICATION_PATH."update_account.php");
define("UPDATE_PROFILE", APPLICATION_PATH."update_user_profile.php"); // if the update profile extension is used and the profile record doesn't exists a required redirect to this page is possible

// your path must be related to the site root.

// change this vars if you need...
define('PW_LENGTH', 4);
define('LOGIN_LENGTH', 2);
define('LOGIN_MAX_LENGTH', 35);

define("COOKIE_NAME", "user");
define("COOKIE_PATH", "/");
define("MIN_ACCESS_LEVEL", 1);
define("MAX_ACCESS_LEVEL", 20);
define("DEFAULT_ACCESS_LEVEL", 2);
define("DEFAULT_ADMIN_LEVEL", 20);

