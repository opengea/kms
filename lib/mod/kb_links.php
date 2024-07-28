<?

// ----------------------------------------------
// Class Docs Files for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_files extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	$table	= "kms_docs_links";
	$key	= "id";	
	$fields = array("status", "name", "url","count","creation_date");

$this->folder = $_GET['dr_folder'];
$orderby = "creation_date";
$this->defvalue("status","published");
$uploadDate = date('Y-m-d');
$this->defvalue("creation_date",$uploadDate);
$this->default_content_type = "links";
$this->default_php = "links.php";

/*=[ PERMISOS ]===========================================================*/
$notedit = array("dr_folder");
$can_view = false;
$can_edit = true;
$can_delete = true;
$can_add   = true;
$import = false;
$export = false;
$search = true;
$this->page_rows = 20;
$this->page_links = 20;
$this->ts_format  = "m/d/Y h:i A";
$this->insert_label = _NEW_LINK;
$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
$this->setComponent("select","target",array("blank"=>_KMS_WEB_LINKS_BLANKPAGE, "self"=>_KMS_WEB_LINKS_SAMEPAGE));
$readonly = array("count","creation_date");
//$this->setComponent("file","img",array("/var/www/vhosts/".$KMS[current_domain]."/subdomains/data/httpdocs/files/pictures","files/pictures",true,180,180));
//$this->setComponent("file","navico",array("/var/www/vhosts/".$KMS[current_domain]."/subdomains/data/httpdocs/files/documents","files/documents"));

?>
