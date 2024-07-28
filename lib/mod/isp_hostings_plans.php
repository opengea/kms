<?

// ----------------------------------------------
// Class ISP Hostings Plans for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_hostings_plans extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_hostings_plans";
	var $key	= "id";	
	var $fields = array("id","sr_service","sr_client","name","max_space","max_transfer","max_mailboxes","max_vhosts");
	var $orderby = "id";
	var $sortdir = "desc";
//	var $notedit=array("name");
	//var $readonly=array("sr_service");
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_gohome = true;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;
	var $can_view = false;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_hostings_plans($client_account,$user_account,$dm) {

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->defvalue("sr_client",1);
//		$this->defvalue("sr_service","1");
		$this->setComponent("xcombo","sr_service",array("xtable"=>"kms_ecom_services","xkey"=>"id","xfield"=>"name_ca","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setcomponent("bytes","max_space");
		$this->setcomponent("bytes","max_transfer");
                $this->onInsert = "onInsert";
                $this->onUpdate = "onUpdate";
                $this->onDelete = "onDelete";
	}
	
        function onUpdate($post,$id) {
                $plan=$this->dbi->get_record("select * from kms_isp_hostings_plans where id=$id");
                $dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $this->dbi->update_record("kms_isp_hostings_plans",$plan,"id=$id",$dblink_cp);
        }

        function onInsert($post,$id) {
                $plan=$this->dbi->get_record("select * from kms_isp_hostings_plans where id=$id");
                $dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $this->dbi->insert_record("kms_isp_hostings_plans",$plan,$dblink_cp);
        }

        function onDelete($post,$id) {
                $dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $this->dbi->delete_record("kms_isp_hostings_plans","id=$id",$dblink_cp);
        }

}

?>
