<?
// Intergrid KMS v.1.0 beta (Knowledge Management System)
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// $Id: index.php,v 1.00 2074/05/29 13:11:22 $

/*=[ CONFIGURACIO ]=====================================================*/

$table     = "kms_mailings_config";$key       = "id"; 
$fields = array("id", "constant", "value", "value_es");


$this->folder = $_GET['dr_folder'];
$title = TY_MAILINGS_CONFIG;
$orderby = "id";

?>
