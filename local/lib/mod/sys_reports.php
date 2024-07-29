<?

// ----------------------------------------------
// Class System Reports for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_reports extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_reports";
	var $key	= "id";	
	var $fields = array("id", "report", "title", "group","params");
	var $orderby = "creation_date";
	var $insert_label = _NEW_USER;

	/*=[ PERMISOS ]===========================================================*/

	var $can_edit      = true;
	var $can_delete    = true;
	var $can_add       = true;
	var $can_duplicate = true;
	var $import = true;
	var $export = true;
	var $search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_reports($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->excludeBrowser = array("report");
		$this->notedit = array("dr_folder","creation_date");

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("location","Poblaci&oacute;");
		$this->humanize("creation_date","Data d'alta");
		$this->humanize("name","Nom");
		$this->humanize("comments","Notes");
		$this->humanize("mobile","M&ograve;bil");
		$this->humanize("address","Adre&ccedil;a");
		$this->humanize("zipcode","Codi Postal");
		$this->humanize("phone","Tel&egrave;fon");
		$this->humanize("type","Tipus");
		$this->humanize("contacts","Contactes");
	
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
	
		$this->defvalue("status","active");

		$this->setComponent("uniselect","module");
		$user_groups = explode ("|", $_SESSION['user_groups']);
		if (in_array("admin",$user_groups)||$_SESSION['user_name']=="root") {
		        // l'usuari amb grup admin ho veu tot
                	$this->setComponent("xcombo","group",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
        	} else {
        	        // l'usuari nomes pot crear carpetes dels grups al que pertany
	                for ($i=0;$i<count($user_groups);$i++) {
	                        $conditions.="id='".$user_groups[$i]."' OR ";
	                 }
	                $conditions  = substr($conditions,0,strlen($conditions)-4);
	//                $this->xcombosql("group","select * from kms_groups where  (".$conditions.")","name","id",false);
	                $this->setComponent("xcombo","group",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select * from kms_sys_groups where  (".$conditions.")"));
	        }
	
		$this->setComponent("select","sendreport",array("none"=>"none","weekly"=>"weekly","monthly"=>"monthly","year"=>"year"));

		$this->action('report',"/usr/share/kms/lib/reports/report.php");
		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>_KMS_BUT_VIEWREPORT,"url"=>"/?_=f&app=erp&mod=sys_reports&action=report","ico"=>"stats.gif","params"=>"&id=[id]&[params]");

	}

}

?>
