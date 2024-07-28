<?

// ----------------------------------------------
// Class Ecommerce Services Rates for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_services_rates extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table     = "kms_ecom_services_rates";
$key       = "id";

$fields = array("service", "from_value", "to_value", "unit", "price", "category");


if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];

$title = "Serveis";

$orderby = "service";

$this->exclude = array("dr_folder");

/*=[ PERMISOS ]===========================================================*/

$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = true;
$export = true;

/*=[ MISC OPTIONS ]==========================================================*/

// default number of rows to show per page
// page_rows = integer;
$this->page_rows = 200;

// default number of page links to display per page
// page_links = integer;
$this->page_links = 20;

// timestamp format
// ts_format = "string"
$this->ts_format  = "m/d/Y h:i A";

// SHOW_KEY allows us to view/edit the primary key.
// This is normally set to false.
//$this->show_key = true;

// Text label for add new record button (defaults to 'Insert Record'):
//$this->insert_label = _MB_NEWFILE;
$this->insert_label = "Nova entrada";

/*=[ REGLES  ]========================================================*/

// Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
//$this->setComponent("cipher","Password","MD5");
//$this->setComponent("cipher","CardNum","MD5");

// La regla XREF referencia un camp en un altre camp dins d'una altra taula
// (a la mateixa bd) i presenta un combobox.
$this->setComponent("xref","service",array("id","name_ca","kms_services"));
$this->setComponent("multiselect","Colors");

$this->setComponent("uniselect","unit");
$this->setComponent("uniselect","category");

// CHECKBOX
//$this->setComponent("checklist","Decoration",array("E"=>"Embroiderable","I"=>"Inscribeable"));

// uploads
//$this->setComponent("file","fitxer",array("/var/www/vhosts/tvlata.org/httpdocs/mediabase/files/videos","files"));
//$this->setComponent("file","imatge",array("/var/www/vhosts/tvlata.org/httpdocs/mediabase/files/images","files"));

// editor wysiwyg
//$this->setComponent("wysiwyg","notes");

/*=[ FI CONFIGURACIO ]=====================================================*/

//$this->dbi->debug = true;

// print results (required)

?>


