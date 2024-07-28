<?

// ----------------------------------------------
// Class Sites Texts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_texts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table	= "kms_variables";
$key	= "id";	

$fields = array("id",  "name", "value");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];

$title = "Textos";

$orderby = "name";

// no mostra a la fitxa
//problema: si no el mostrem l'assigna si en creem un de nou!
//$this->exclude = array("content_type");


//compte: si es marca readonly no s'inserta
//$readonly = array("content_type");

//$this->safedel("Display","N","Disable");

//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

$this->humanize("dr_folder","Carpeta");
$this->humanize("file","Imatge");

$this->humanize("image","Frame");
//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);

$this->default_content_type = "variables";
$this->default_php = "variables.php";

//$this->validate("Email");
//$this->validate("WWW");

/*=[ PERMISOS ]===========================================================*/
$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = false;
$export = false;
$search = false;


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

// SHOW_KEY allows us to view/edit the primary key.
// This is normally set to false.
//$this->show_key = true;

// Text label for add new record button (defaults to 'Insert Record'):
//$this->insert_label = _MB_NEWFILE;
$this->insert_label = "Nou text";

/*=[ REGLES  ]========================================================*/

// Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
//$this->setComponent("cipher","Password","MD5");
//$this->setComponent("cipher","CardNum","MD5");

// La regla XREF referencia un camp en un altre camp dins d'una altra taula
// (a la mateixa bd) i presenta un combobox.
//$this->setComponent("xref","Type_Rid",array("Rid","Type","business_types"));

// Combobox
//$this->setComponent("select","category",array("simple text"=>"simple text", "image"=>"image", "sound"=>"sound", "video"=>"video", "html file"=>"html file", "pdf"=>"pdf", "office document"=>"office document", "freehand"=>"freehand", "interactive"=>"interactive", "source code"=>"source code"));

// SELECT permet seleccionar multiples valors d'una llista de valors unics
// si la llista es fize, posar el segon parametre a true

?>

