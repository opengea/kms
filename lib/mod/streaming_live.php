<?

// ----------------------------------------------
// Class Streaming Live for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class streaming_live extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table	= "kms_streaming_live";
$key	= "id";	

$fields = array("creation_date", "channel_id", "title","mountpoint");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];

$orderby = "creation_date";

$notedit = array("dr_folder");
$this->setComponent("uniselect","category");
// no mostra a la fitxa
//problema: si no el mostrem l'assigna si en creem un de nou!
//$this->exclude = array("content_type");


//compte: si es marca readonly no s'inserta
//$readonly = array("content_type");

//$this->safedel("Display","N","Disable");

//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

$this->defvalue("status","active");
$this->defvalue("priority","normal");
//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);
$this->insert_label = _NEW_VIDEO;
$this->default_content_type = "videos";
$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = false;
$export = false;
$search = true;


/*=[ MISC OPTIONS ]==========================================================*/

// default number of rows to show per page
// page_rows = integer;
$this->page_rows = 200;

// default number of page links to display per page
// page_links = integer;
$this->page_links = 200;

// timestamp format
// ts_format = "string"
$this->ts_format  = "m/d/Y h:i A";
$this->setComponent("file","file",array($this->kms_datapath."files/videos","files/videos"));

$this->setComponent("picture","thumbnail",array("path"=>"/var/www/vhosts/".$current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$current_domain."/files/pictures","resize_max_width"=>360,"resize_max_height"=>230,"thumb_max_width"=>120,"thumb_max_height"=>90));
?>

