<?

// ----------------------------------------------
// Class System Extranet Preferences for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_extranet extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_extranet";
	var $key	= "id";	
	var $fields = array("id", "status", "domain");
	var $title = "KMS Client accounts";
	var $orderby = "creation_date";
	var $sortdir = "DESC";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_extranet ($client_account,$user_account,$dm) {
		$_GET['_']='e';
                $_GET['id']=1;

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

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

		$this->insert_label = "Nova extranet";

		$this->setComponent("select","status",array("1"=>"<span style='color:#090;font-weight:bold'>online</span>","0"=>"<span style='color:#900;font-weight:noral'>offline</span>"));
		$this->setComponent("select","header_style",array("classic"=>"classic","quick_menu"=>"quick_menu","cp"=>"control panel"));
		$this->setComponent("select","bg_image",array("default"=>"default","clear"=>"clear","green"=>"green","pattern"=>"pattern","grey_wood"=>"grey_wood","wood"=>"wood","aurora"=>"aurora","blue"=>"blue","rhombuses"=>"rhombuses","tiger"=>"tiger","leopard"=>"leopard","pixelverse"=>"pixelverse","sunset"=>"sunset","calmity"=>"calmity","branches"=>"branches","leman"=>"leman","pyramids"=>"pyramids","lights"=>"lights","trees"=>"trees","view"=>"view"));

		$this->setComponent("uniselect","default_lang");
		$this->setComponent("multiselect","modules");
                $this->setComponent("xcombo","autorun_app",array("xtable"=>"kms_sys_apps","xfield"=>"keyname","xselectionfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));

	}
}
?>

