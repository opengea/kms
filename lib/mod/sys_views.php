<?

// ----------------------------------------------
// Class System Views for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_views extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_views";
	var $key	= "id";	
	var $fields = array("id", "sort_order", "creation_date", "name", "type", "module", "group", "fields", "orderby", "where");
	var $hidden = array("sort_order");
	var $orderby = "creation_date";
	var $sortdir = "desc";

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $import = false;
	var $export = false;
	var $search = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_views($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                // set draggable
                $this->uid=$this-key;
                $this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
                $this->orderby="sort_order";

		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->insert_label = _NEW_PICTURE;
		$this->setComponent("uniselect","module");
		$this->setComponent("uniselect","app");
                $this->setComponent("select","type",array("left"=>"left menu","top"=>"top bar"));
		$this->setComponent("select","sort",array("asc"=>"asc","desc"=>"desc"));
		$this->setComponent("xcombo","group",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select * from kms_sys_groups where type='sys_users'"));
		$this->addComment("sort_order","Ordre d'aparici&oacute; de les vistes en el men&uacute;");
		$this->setStyle("sort_order","width:100px");
	}

}
?>
