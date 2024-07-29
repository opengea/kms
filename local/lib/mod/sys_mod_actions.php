<?

// ----------------------------------------------
// KMS System Mod Actions Class
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_mod_actions extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_mod_actions";
	var $key	= "id";	
	var $fields = array("mod_id", "name", "type", "order_num", "value");
	var $orderby    = "id";
	var $sortdir    = "asc";
	var $readonly = array("");
	var $notedit= array("");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_mod_actions ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->setComponent("select","status",array("inactive"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "active"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("type","kms");
		$this->defvalue("target","_self");

//		$this->insert_label = _NEW_PRODUCT_FAMILY;
		//$linkfield = "title";
		$this->setComponent("checklist","readonly",array("1"=>""));
		$this->setComponent("checklist","hidden",array("1"=>""));	
		$this->setComponent("checklist","required",array("1"=>""));
		
		$this->setComponent("xcombo","mod_id",array("xtable"=>"kms_sys_mod","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));

		$this->setComponent("select","type",array("kms"=>"kms","url"=>"url"));

		$this->setComponent("file","zipfile",array($this->kms_datapath."files/catalog/download","files/catalog/download",true,"75","100"));
                $this->onInsert = "onInsert";
                $this->onDelete = "onDelete";
        }
        function onInsert($post,$id) {
        }

        function onDelete($post,$id) {
        }


}
?>
