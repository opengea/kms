<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "dbConnect.php";
require "/usr/share/kms/mod/isp/dashboard/classes/KMSData.php";

$db->where ("name = 'servers_groups'");
$results = $db->get("sys_conf");

die($results);