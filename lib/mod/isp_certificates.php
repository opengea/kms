<?

// ----------------------------------------------
// Class ISP DNS Zones for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_certificates extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_certificates";
	var $key	= "id";	
	var $fields = array("creation_date","status","name", "vhost_id", "contract_id");
//	var $readonly = array("expiration_date","registrar","status","sr_entity","name","creation_date","updated_date","authcode");
	var $orderby = "id";
	var $sortdir = "desc";
//	var $notedit=array("expiration_date","dr_folder","client_id","registrar","status","sr_entity","creation_date","updated_date","databases_zone_id","sr_contract","comments");
	var $hidden = array("ca_cert","cert","pvt_key","csr","ca_file","cert_file");
        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_certificates($client_account,$user_account,$dm,$dblinks) { //,$silent
		$this->defvalue("vhost_id",$_GET['xid']);
		$this->humanize("name","Domini");
		$this->humanize("vhost_id","Vhost");
		$this->humanize("contract_id","Contracte");
                parent::mod($client_account,$user_account,$extranet);
  }

        function setup($client_account,$user_account,$dm) {
                $this->onInsert="onInsert";
                $this->onUpdate="onUpdate";
                $this->onDelete="onDelete";

		$this->setComponent("select","status",array("active"=>"<font color='#009900'>"._KMS_GL_STATUS_ACTIVE."</font>", "pending"=>"<font color='#990000'>"._KMS_GL_STATUS_PENDING."</font>"));
		 $this->setComponent("xcombo","contract_id",array("xtable"=>"kms_erp_contracts","xkey"=>"id","xfield"=>"CONCAT(id,' : ',description)","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		 $this->setComponent("xcombo","vhost_id",array("xtable"=>"kms_isp_hostings_vhosts","xkey"=>"id","xfield"=>"CONCAT(id,' : ',name)","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	}

	function onInsert($post,$id) {
		//replicate cp or intranet
                include "shared/db_links.php";
                //select mail host
		$cert=array("creation_date"=>date('Y-m-d H:i:s'),"vhost_id"=>$post['vhost_id'],"name"=>$post['name'],"csr"=>$post['csr'],"pvt_key"=>$post['pvt_key'],"ca_cert"=>$post['ca_cert'],"id"=>$post['id']);
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $r=$this->dbi->insert_record("kms_isp_certificates",$cert,$dblink_cp);
			if (!$r) {echo $dblink_cp; echo mysqli_error();exit; }
                } else {
                        $this->dbi->insert_record("kms_isp_certificates",$cert,$dblink_erp);
                }
	}

	function onUpdate($post,$id) {
		include "shared/db_links.php";
                $cert=$this->dbi->get_record("select * from kms_isp_certificates where id=".$id);
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
			$r=$this->dbi->update_record("kms_isp_certificates",$cert,"id=".$id,$dblink_cp);
                } else {
			$this->dbi->update_record("kms_isp_certificates",$cert,"id=".$id,$dblink_erp);
       		}
	} 

	function onDelete($post,$id) {
		include "shared/db_links.php";
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->query("delete from kms_isp_certificates where id=$id",$dblink_cp);
                } else {
                        $this->dbi->query("delete from kms_isp_certificates where id=$id",$dblink_erp);
                }
        }
}
?>
