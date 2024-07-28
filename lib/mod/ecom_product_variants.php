<?

// ----------------------------------------------
// Class Ecommerce Product Variants for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_product_variants extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

$table	= "kms_product_variants";
$key	= "id";	

$fields = array("id", "status", "sr_product", "details_color", "details_talla", "details_weight", "units","pvp");


$title = "Variantes de producto";

$orderby = "id";

// no mostra a la fitxa
//problema: si no el mostrem l'assigna si en creem un de nou!
//$this->exclude = array("content_type");


//compte: si es marca readonly no s'inserta
//$readonly = array("content_type");

//$this->safedel("Display","N","Disable");

//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

$this->humanize("dr_folder","Carpeta");
$this->humanize("presentacion","Presentaci&oacute;n");
$this->humanize("content-type","Tipus");
$this->humanize("notes","Notes");
$this->humanize("status","Estado");
$this->humanize("composicion","Composici&oacute;n");
$this->humanize("pvpclub","PVP Club");
$this->humanize("pvponline","PVP Tienda Online");
$this->humanize("creation_date","Fecha de alta");
$this->humanize("sr_product","Producto");

$this->defvalue("status","active");

//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);

$this->default_content_type = "variants";
$this->default_php = "variants";

//$this->validate("Email");
//$this->validate("WWW");

/*=[ PERMISOS ]===========================================================*/

$can_edit = true;
$can_delete = true;
$can_add	= true;
$import = true;
$export = true;
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

// SHOW_KEY allows us to view/edit the primary key.
// This is normally set to false.
//$this->show_key = true;

// Text label for add new record button (defaults to 'Insert Record'):
//$this->insert_label = _MB_NEWFILE;
$this->insert_label = "Nueva variante";

/*=[ REGLES  ]========================================================*/

// Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
//$this->setComponent("cipher","Password","MD5");
//$this->setComponent("cipher","CardNum","MD5");

// La regla XREF referencia un camp en un altre camp dins d'una altra taula
// (a la mateixa bd) i presenta un combobox.

// Combobox

$this->setComponent("select","status",array("active"=>"<font color=#009900>activo</font>","inactive"=>"<font color=#ff0000>inactivo</font>"));

$this->setComponent("select","family",array("dominis"=>"dominis","allotjament"=>"allotjament","aplicacions"=>"aplicacions","certificats"=>"certificats","posicionament"=>"posicionament"));


$this->multixref("sr_product", "id", "name", "kms_catalog");
$this->xcombo("sr_product", "kms_catalog", "id", "name", false, "");
//$this->xcombo("sr_product", "kms_catalog", "name", "name", false, "");
//$this->xcombosql("sr_product", "select kms_products.name from kms_products");

// SELECT permet seleccionar multiples valors d'una llista de valors unics
// si la llista es fize, posar el segon parametre a true
$this->setComponent("uniselect","presentacion");
$this->setComponent("uniselect","details_color");
$this->setComponent("uniselect","medidas");
$this->setComponent("uniselect","composicion");
// CHECKBOX
//$this->setComponent("checklist","Decoration",array("E"=>"Embroiderable","I"=>"Inscribeable"));

// uploads
//$this->setComponent("file","fitxer",array("/var/www/vhosts/tvlata.org/httpdocs/mediabase/files/videos","files"));
//$this->setComponent("file","imatge",array("/var/www/vhosts/tvlata.org/httpdocs/mediabase/files/images","files"));

// editor wysiwyg
//$this->setComponent("wysiwyg","notes");

/*=[ FI CONFIGURACIO ]=====================================================*/

//$this->dbi->debug = true;

?>
