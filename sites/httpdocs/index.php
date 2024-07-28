<?php
if ($_GET['s']=="index.php") $_GET['s']="";
ini_set("zlib.output_compression", 1);
ob_start();
session_start();
include "config/kms.init.php";
include "config/setup.php";
//if ($conf['debug_mode']) include "lib/debug.php";
include "lib/meta.loader.php";
include "tpl/partials/header.php";
if ($showhead) include "tpl/partials/head.php";
include "tpl/partials/page.php";
include "tpl/partials/footer.php";
?>
