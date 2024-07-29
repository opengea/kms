<?

// ----------------------------------------------
// Class Docs Materials for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_materials extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table	= "kms_materials";
$key	= "id";	

$fields = array("id", "status", "type", "description", "creation_date");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];
$orderby = "creation_date";
$this->setComponent("select","status",array("noconfirmat"=>"<font color=#ff0000>no confirmat</font>", "confirmat"=>"<font color=#00DD00><b>confirmat</b></font>"));
$this->setComponent("uniselect","type");

//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);
$this->default_content_type = "documents";
$this->insert_label = _NEW_MATERIAL;
$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = false;
$export = false;
$search = true;


$this->page_rows = 200;
$this->page_links = 200;
$this->ts_format  = "d/m/Y h:i A";
//$this->show_key = true;


?>

