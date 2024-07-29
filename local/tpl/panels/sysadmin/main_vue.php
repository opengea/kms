<?php

require "classes/Widget.php";
require "classes/ApiData.php";
require "classes/KMSData.php";
require "vendor/autoload.php";

$api_data = new ApiData();
ob_start();

?>
<script src="/kms/mod/isp/dashboard/dist/main.js"></script>
<div id="app">{{ message }}</div>
<?
$content_html = ob_get_clean();
$panel = array(
    "title" => _KMS_SERVICES_CP,
    "buttons" => "",
    "content" => $content_html,
    "defaultMod" => "",
    "infotable" => "",
    "hide_databrowser" => true
);
$this->setPanel($panel);
?>
