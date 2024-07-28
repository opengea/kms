<?

// ----------------------------------------------
// Class Docs Documents for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_documents extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        $table  = "kms_documents";
	$key	= "id";	
	$fields = array("id", "type", "name", "file", "creation_date");
	$orderby = "creation_date";

        /*=[ PERMISSIONS ]===========================================================*/

        $can_view = true;
        $can_edit = true;
        $can_delete = true;
        $can_add   = true;
        $import = false;
        $export = false;
        $search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function docs_documents($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

	$uploadDate = date('y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->default_content_type = "documents";
	$this->insert_label = _NEW_DOCUMENT;
	$this->page_rows = 200;
	$this->page_links = 200;
	$this->ts_format  = "d/m/Y h:i A";
	//$this->show_key = true;

	$this->setComponent("file","file",array("/var/www/vhosts/".$current_domain."/subdomains/data/httpdocs/files/documents","files/documents"));

	}
}
?>

