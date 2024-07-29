<?

// ----------------------------------------------
// Class Planner Events for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_events extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table	= "kms_events";
$key	= "id";	


$fields = array("id", "related",  "status", "description", "organizedby", "place", "start_date", "end_date","file");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->dr_folder = $_GET['dr_folder'];

$orderby = "start_date";

$this->defvalue("status","working");
$this->defvalue("priority","normal");
//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);

$this->default_content_type = "events";
/*=[ PERMISOS ]===========================================================*/

$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = false;
$export = false;
$search = true;


/*=[ MISC OPTIONS ]==========================================================*/

$this->page_rows = 200;
$this->page_links = 200;
$this->ts_format  = "m/d/Y h:i A";
$this->insert_label = _NEW_EVENT;

/*=[ REGLES  ]========================================================*/
$this->setComponent("uniselect","related");


?>

