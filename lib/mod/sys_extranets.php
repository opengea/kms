<?

// ----------------------------------------------
// Class System Extranets for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_extranets extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

if ($_SESSION['client_name']!="Intergrid SL") die('not authorized module for this client');


$table	= "kms_client_accounts";
$key	= "id";	

$fields = array("id", "status", "client_name", "domain", "dbhost", "modules", "creation_date");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];

$title = "KMS Client accounts";

$orderby = "creation_date";
$sortdir = "DESC";
// no mostra a la fitxa
//problema: si no el mostrem l'assigna si en creem un de nou!
//$this->exclude = array("content_type");


//compte: si es marca readonly no s'inserta
//$readonly = array("content_type");

//$this->safedel("Display","N","Disable");

//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

$this->humanize("dr_folder","Carpeta");

$this->defvalue("status","online");
$this->defvalue("dbhost","cp.intergridnetwork.net");
$this->defvalue("dbtype","mysql");
$this->defvalue("dbport","3306");
$this->defvalue("default_lang","ct");

$this->defvalue("username","admin");

//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("upload_date",$uploadDate);
$this->defvalue("creation_date",$uploadDate);

$this->default_content_type = "extranets";
$this->default_php = "documents.php";

//$this->validate("Email");
//$this->validate("WWW");

/*=[ PERMISOS ]===========================================================*/

$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = false;
$export = true;
$search = true;
$can_duplicate = true;

/*=[ MISC OPTIONS ]==========================================================*/

// default number of rows to show per page
// page_rows = integer;
$this->page_rows = 200;

// default number of page links to display per page
// page_links = integer;
$this->page_links = 200;

// timestamp format
// ts_format = "string"
$this->ts_format  = "d/m/Y h:i A";

// SHOW_KEY allows us to view/edit the primary key.
// This is normally set to false.
//$this->show_key = true;

// Text label for add new record button (defaults to 'Insert Record'):
//$this->insert_label = _MB_NEWFILE;
$this->insert_label = "Nova extranet";

/*=[ REGLES  ]========================================================*/

// Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
//$this->setComponent("cipher","Password","MD5");
//$this->setComponent("cipher","CardNum","MD5");

// La regla XREF referencia un camp en un altre camp dins d'una altra taula
// (a la mateixa bd) i presenta un combobox.
//$this->setComponent("xref","Type_Rid",array("Rid","Type","business_types"));

// Combobox

//$this->setComponent("select","status",array("pendiente"=>"<font color='#cc0000'><b>pendiente</b></font>", "confirmada"=>"<font color='#00aa00'><b>confirmada</b></font>", "rechazada"=>"<font color='#999999'><b>rechazada</b></font>"));

$this->setComponent("select","status",array("online"=>"<span style='color:#090;font-weight:bold'>online</span>","offline"=>"<span style='color:#900;font-weight:noral'>offline</span>"));




//$this->setComponent("select","oferta",array("CTP"=>"Conexi&oacute;n Total Profesional","MiniHP"=>"Mini Port&aacute;til HP Compaq 705C"));

// SELECT permet seleccionar multiples valors d'una llista de valors unics
// si la llista es fize, posar el segon parametre a true
$this->setComponent("uniselect","default_lang");
$this->setComponent("multiselect","modules");
//array("select distinct modules from kms_client_accounts","modules","modules"));

$this->customOptions = Array();
$this->customOptions[0] = Array ("label"=>"Instal&middot;lar client","url"=>"/kms/lib/isp/install/install_kms_client.php?","ico"=>"on.gif","params"=>"","target"=>"_self");

// CHECKBOX
//$this->setComponent("checklist","Decoration",array("E"=>"Embroiderable","I"=>"Inscribeable"));

// uploads
// El tercer parametre booleà indica si ha de mostrar les imatges o no 
//$this->setComponent("file","file",array("/var/www/vhosts/intergrid.cat/subdomains/kms/httpdocs/clients/dedicated/encuentrorespuestaempresarios.com/files/papers","files/papers",false));
//$this->setComponent("file","imatge",array("/var/www/vhosts/tvlata.org/httpdocs/mediabase/files/images","files"));

// editor wysiwyg
//$this->setComponent("wysiwyg","notes");

/*=[ FI CONFIGURACIO ]=====================================================*/

//$this->dbi->debug = true;

// print results (required)

?>
