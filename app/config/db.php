<?php
// header('Content-Type: text/html; charset=utf8');
// date_default_timezone_set('Europe/Istanbul');
// //error_reporting(E_ALL);
// //ini_set("display_errors", 1);
// error_reporting(0);
// include_once "ez_sql_core.php";
// include_once "ez_sql_mysql.php";
// $host = 'localhost';
// $user = 'sungate_vbu';
// $pass = 'Cqy1#c48';
// $dbname = 'sungate_vb';


// $db = new ezSQL_mysql($user,$pass,$dbname,$host);
// define('DILADI', 'utf8');
// define('DILKARSILASTIRMASI','utf8_general_ci');
// $db->query("SET NAMES '". DILADI. "'");
// $db->query("SET CHARACTER SET " . DILADI);
// $db->query("SET COLLATION_CONNECTION = '". DILKARSILASTIRMASI ."'");

header('Content-Type: text/html; charset=utf8');
date_default_timezone_set('Europe/Istanbul');
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
error_reporting(0);

// MySQLi connection details
$host = 'localhost';
$user = 'sungate_vbu';
$pass = 'Cqy1#c48';
$dbname = 'sungate_vb';

// Create connection
$con = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Set the character set and collation for the connection
$con->set_charset('utf8');
$con->query("SET COLLATION_CONNECTION = 'utf8_general_ci'");

define('DILADI', 'utf8');
define('DILKARSILASTIRMASI', 'utf8_general_ci');

// Optionally, you can set other options here as needed

// Use this $con object to interact with the database
?>