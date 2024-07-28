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
	var $fields = array("status","name","creation_date");
	var $readonly = array("name");//"expiration_date","registrar","status","sr_entity","name","creation_date","updated_date","authcode");
	var $orderby = "id";
//	var $notedit=array("expiration_date","dr_folder","client_id","registrar","status","sr_entity","creation_date","updated_date","databases_zone_id","sr_contract","comments");
	var $hidden = array("contract_id","creation_date","status","ca_cert","cert","pvt_key","csr","cert_file","ca_file","vhost_id");
        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = false;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_certificates($client_account,$user_account,$dm) {
		$this->defvalue("vhost_id",$_GET['xid']);
		$this->humanize("name",_KMS_WEB_SITES_DOMAIN);
//$this->setComponent("xcombo","name",array("xtable"=>"kms_isp_hostings_vhosts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select name from kms_isp_hostings_vhosts where isp_client_id=".$user_account['id']));
//$this->setComponent("xcombo","name",array("xtable"=>"kms_isp_hostings_vhosts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select name from kms_isp_hostings_vhosts where id=".$_GET['xid']));
		$select="SELECT name FROM kms_isp_hostings_vhosts where id=".$_GET['xid'];
                $result=mysql_query($select);
                if (!$result) die("error".mysql_error($result));
                $domain=mysql_fetch_array($result);
		$this->defvalue("name",$domain['name']);
		$this->defvalue("status","pending");
		$this->setComponent("select","status",array("active"=>"<font color='#009900'><b>"._KMS_CLIENTS_STATUS_ACTIVE."</b></font>", "pending"=>"<font color='#995500'><b>"._KMS_CLIENTS_STATUS_PENDING."</b></font>"));

		$this->setComponent("wysiwyg","csr",array("type"=>"text"));
		$this->setComponent("wysiwyg","cert",array("type"=>"text"));
		$this->setComponent("wysiwyg","pvt_key",array("type"=>"text"));
		$this->setComponent("wysiwyg","ca_cert",array("type"=>"text"));
                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysql_query($select);
                if (!$result) die(mysql_error($result));
                $client=mysql_fetch_array($result);
		
		if ($_GET['app']=='sysadmin'||$_GET['app']=='cp-admin') {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
                } else {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE sr_client=".$client['sr_client']." AND id='".$_GET['xid']."'";
                }


                if ($this->_group_permissions(1,$user_account['groups']))  {
                        $this->notedit=array();
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['xid']." AND sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
                } else  {
//                        $this->fields = array("postbox","mailname","status","name","hosting_id");
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                }

		$result=mysql_query($sel);
                if (!$result) die(mysql_error($result));
                $vhost=mysql_fetch_array($result);
                if ($vhost['id']==""&&$_GET['app']!='sysadmin'&&$_GET['app']!='cp-admin') {
                        die("[isp_certificates] error. Record not found.");
                }

                if ($vhost['id']!="")  $this->where = "kms_isp_certificates.vhost_id=".$vhost['id'];

		if ($_GET['xid']=="") die("'xid' param missing.");
		$this->where = "kms_isp_certificates.vhost_id=".$vhost['id']; 

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                $this->onInsert="onInsert";
                $this->onUpdate="onUpdate";
                $this->onDelete="onDelete";
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";
		if ($_GET['_']=="i") $_SESSION["msgs"]=_KMS_ISP_CERTIFICATES_WARN;
	}

	function onInsert($post,$id) {
		//replicate cp or intranet
                include "shared/db_links.php";

                //add new contract
                include "/usr/local/kms/lib/mod/erp_contracts.php";
                $client=$this->dbi->get_record("SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'],$dblink_cp);
                $contract=array("creation_date"=>date('Y-m-d H:m:s'),"status"=>"pending","domain"=>$post['name'],"description"=>$post['name'],"status"=>"active","sr_client"=>$client['sr_client'],"sr_ecom_service"=>567,"initial_date"=>date('Y-m-d H:i:s'),"end_date"=>date('Y-m-d H:i:s'),"billing_period"=>"1Y","auto_renov"=>1,"alta"=>0,"price"=>'9.95',"payment_method"=>$client['sr_payment_method'],"invoice_pending"=>1);
                $contract['id']=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_erp);
                $contracts = new erp_contracts($this->client_account,$this->user_account,$this->dm);
                $contract['isp_client_id']=$client['id'];
                $contracts->onInsert($contract,$contract['id']);


                //select mail host
		$cert=array("contract_id"=>$contact['id'],"creation_date"=>date('Y-m-d H:i:s'),"status"=>"pending","vhost_id"=>$post['vhost_id'],"name"=>$post['name'],"csr"=>$post['csr'],"pvt_key"=>$post['pvt_key'],"ca_cert"=>$post['ca_cert'],"id"=>$post['id']);
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $r=$this->dbi->insert_record("kms_isp_certificates",$cert,$dblink_cp);
			if (!$r) {echo $dblink_cp; echo mysql_error();exit; }
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
