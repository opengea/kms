<?

// ----------------------------------------------
// Class ISP Clients for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_offers extends mod {

        /*=[ CONFIGURATION ]=====================================================*/
	var $table	= "kms_isp_offers";
	var $key	= "id";	
	var $fields = array("id","creation_date","end_date","status","title_ct");
	var $readonly = array("sr_client","sr_user");
	var $orderby = "creation_date";
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_gohome = true;
	var $can_edit  = true;
	var $can_delete = true;
	var $can_duplicate = true;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_offers($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->onInsert = "onInsert";
		$this->onUpdate = "onUpdate";
	}

	function onInsert($post,$id) {
                include "shared/db_links.php";
		$data=array();
                foreach ($post as $i=>$var) {
                        if ($i!="return_mod"&&$i!="from"&&$i!="panelmod"&&$i!="xid"&&$i!="id"&&$i!="mod"&&$i!="app") $data[$i]=$var;
                }
		$id_client=$this->dbi->insert_record("kms_isp_offers",$data,$dblink_cp);
	}
	function onUpdate($post,$id) {
                include "shared/db_links.php";
                $data=array();
                foreach ($post as $i=>$var) {
                        if ($i!="creation_date"&&$i!="end_date"&&$i!="return_mod"&&$i!="from"&&$i!="panelmod"&&$i!="xid"&&$i!="id"&&$i!="mod"&&$i!="app") $data[$i]=$var;
                }

		$this->dbi->update_record("kms_isp_offers",$data,"id=".$id,$dblink_cp);
	}
}
?>
