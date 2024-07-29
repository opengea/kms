<?
// Intergrid KMS v.1.0 beta (Knowledge Management System)
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// $Id: index.php,v 1.00 2074/05/29 13:11:22 $


/*=[ CONFIGURACIO ]=====================================================*/

$table	= "kms_sites_guestbook";
$key	= "id";	

$fields = array("creation_date", "comment", "name", "email");

if (isset($_GET["dr_folder"])) {
        $where = "dr_folder = ".$_GET['dr_folder'];
}

$this->folder = $_GET['dr_folder'];
$orderby = "creation_date";
// no mostra a la fitxa
//problema: si no el mostrem l'assigna si en creem un de nou!
//$this->exclude = array("content_type");

//compte: si es marca readonly no s'inserta
$readonly = array("lectures","dr_folder","karma");

//$this->safedel("Display","N","Disable");
//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

$this->humanize("dr_folder","Carpeta");
$this->humanize("file","Imatge");

$this->humanize("image","Frame");
//date_default_timezone_set('UTC');
//$uploadDate = date('D j M Y');
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);
$this->default_content_type = "web_guestbook";

//$this->validate("Email");
//$this->validate("WWW");

/*=[ PERMISOS ]===========================================================*/
$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add = false;
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

// SHOW_KEY allows us to view/edit the primary key.
// This is normally set to false.
//$this->show_key = true;

// Text label for add new record button (defaults to 'Insert Record'):
//$this->insert_label = _MB_NEWFILE;
$this->insert_label = _NEW_WEB_BLOG_COMMENT;

/*=[ REGLES  ]========================================================*/

// Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
//$this->setComponent("cipher","Password","MD5");
//$this->setComponent("cipher","CardNum","MD5");

// La regla XREF referencia un camp en un altre camp dins d'una altra taula
// (a la mateixa bd) i presenta un combobox.
//$this->setComponent("xref","Type_Rid",array("Rid","Type","business_types"));
$this->setComponent("uniselect","category");
$this->setComponent("wysiwyg","body");
$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
$this->multixref("id_post", "id", "title", "kms_docs_articles");
$this->xcombo("id_post", "kms_docs_articles", "id", "title", false, "");
?>
