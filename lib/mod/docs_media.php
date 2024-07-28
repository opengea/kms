<?

// ----------------------------------------------
// Class Docs Media for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_media extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table	= "kms_media";
$key	= "id";	

$fields = array("creation_date", "status", "category", "title");

$notedit = array('dr_folder',"external_url", "size");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];

$orderby = "creation_date";

// no mostra a la fitxa
//problema: si no el mostrem l'assigna si en creem un de nou!
//$this->exclude = array("content_type");


//compte: si es marca readonly no s'inserta
//$readonly = array("content_type");

//$this->safedel("Display","N","Disable");

//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));


$this->defvalue("status","active");
$this->defvalue("priority","normal");
$uploadDate = date('y-m-d');
$this->defvalue("creation_date",$uploadDate);
$this->default_content_type = "files";

/*=[ PERMISOS ]===========================================================*/

$can_view = true;
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
$this->insert_label = _NEW_FILE;

//$this->setComponent("select","category",array("simple text"=>"simple text", "image"=>"image", "sound"=>"sound", "video"=>"video", "html file"=>"html file", "pdf"=>"pdf", "office document"=>"office document", "freehand"=>"freehand", "interactive"=>"interactive", "source code"=>"source code"));

$this->setComponent("file","file",array($this->kms_datapath."files/media","files/media"));


?>
