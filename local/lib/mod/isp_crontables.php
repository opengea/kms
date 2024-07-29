<?

// ----------------------------------------------
// Class ISP Cron Jobs for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_crontables extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_crontables";
	var $key	= "id";	
	var $fields = array("status","user","minute","hour","dayofmonth","dayofweek","command");
//	var $readonly = array("expiration_date","registrar","status","sr_entity","name","creation_date","updated_date","authcode");
	var $orderby = "id";
	var $notedit=array("vhost_id");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_crontables($client_account,$user_account,$dm) {


                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysqli_query($this->dblinks['client'],$select);
                if (!$result) die(mysqli_error($result));
                $client=mysqli_fetch_array($result);
		
		if ($_GET['app']=='sysadmin'||$_GET['app']=='cp-admin') {
			$sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
		} else { 
			$sel ="SELECT * from kms_isp_hostings_vhosts WHERE sr_client=".$client['sr_client']." AND id='".$_GET['xid']."'";
		}

//		$this->where = "sr_client=".$client['sr_client']." and id=".$_GET['xid'];
                if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat")  {
                        $this->notedit=array();
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['xid']." AND sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
                } else  {
			if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");
//                        $this->fields = array("postbox","mailname","status","name","hosting_id");
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                }

		$result=mysqli_query($this->dblinks['client'],$sel);
                if (!$result) die(mysqli_error($result));
                $vhost=mysqli_fetch_array($result);
                if ($vhost['id']==""&&$_GET['app']!='sysadmin'&&$_GET['app']!='cp-admin') {
                        die("[isp_crontables] error. Record not found.");
                }
                if ($vhost['id']!="") $this->where = "kms_isp_crontables.vhost_id=".$vhost['id'];

		if ($_GET['xid']=="") die("'xid' param missing.");

                parent::mod($client_account,$user_account,$extranet);

                $this->onInsert="onInsert";
                $this->onUpdate="onUpdate";
                $this->onDelete="onDelete";
        }

        function setup($client_account,$user_account,$dm) {
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";

		$sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
                $result=mysqli_query($this->dblinks['client'],$sel);
                if (!$result) die(mysqli_error($result));
                $vhost=mysqli_fetch_array($result);

		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("status",1);
		if ($_GET['_']=="b") $this->setComponent("checklist","status",array("1"=>"<span style='color:#090'>"._KMS_GL_STATUS_ACTIVE."</span>")); 
   		else $this->setComponent("checklist","status",array("1"=>""));
		$this->addComment("minute"," (0 - 59) *="._KMS_GROUPS_ALL);
		$this->addComment("hour"," (0 - 23) *="._KMS_GROUPS_ALL);
		$this->addComment("dayofmonth"," (1 - 31) *="._KMS_GROUPS_ALL);
		$this->addComment("month"," (1 - 12) *="._KMS_GROUPS_ALL);
		$this->addComment("dayofweek"," (0 - 6) "._KMS_GL_SUNDAY."=0");
		$this->setComponent("xcombo","user",array("xtable"=>"kms_isp_ftps","xkey"=>"login","xfield"=>"login","notnull"=>true,"readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select login,login,id from kms_isp_ftps where vhost_id=".$vhost['id']." order by login,id"));
	}

	function onInsert ($post,$id) {
                include "shared/db_links.php";
		if (substr($post['command'],0,4)=="echo"||$post['command']=="passwd") return false;
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");

		$this->dbi->update_record("kms_isp_crontables",array("vhost_id"=>$_GET['xid']),"id=$id");

                $cron=$this->dbi->get_record("SELECT * FROM kms_isp_crontables where id=$id");
                if ($_GET['app']=="sysadmin") $this->dbi->insert_record("kms_isp_crontables",$cron,$dblink_cp);
                else $this->dbi->insert_record("kms_isp_crontables",$cron,$dblink_erp);

		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                $server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'mkdir -p /var/spool/cron/'  >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
//		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'echo \"".$post['minute']."\t".$post['hour']."\t".$post['dayofmonth']."\t".$post['month']."\t".$post['dayofweek']."\t".$post['command']."\" >> /var/spool/cron/".$post['user']."'  >> /var/log/kms/kms.log";
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'echo \"".$post['minute']."\t".$post['hour']."\t".$post['dayofmonth']."\t".$post['month']."\t".$post['dayofweek']."\t. /var/www/vhosts/".$vhost['name']."/.profile; ".$post['command']."\" >> /var/spool/cron/".$post['user']."'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'chown ".$post['user']." /var/spool/cron/".$post['user']."'";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

        }

        function onUpdate ($post,$id) {
                include "shared/db_links.php";
		if (substr($post['command'],0,4)=="echo"||$post['command']=="passwd") return false;
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");
	
		$cron=$this->dbi->get_record("SELECT * FROM kms_isp_crontables where id=$id");
		if ($_GET['app']=="sysadmin") $this->dbi->update_record("kms_isp_crontables",$cron,"id=$id",$dblink_cp);
		else $this->dbi->update_record("kms_isp_crontables",$cron,"id=$id",$dblink_erp);

		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                $server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
		$this->rebuild($post['user'],$server['hostname']);
        }

	function onDelete ($post,$id) {
		include "shared/db_links.php";
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");
                $cron=$this->dbi->get_record("SELECT * FROM kms_isp_crontables where id=$id");
                if ($_GET['app']=="sysadmin") $this->dbi->delete_record("kms_isp_crontables","id=$id",$dblink_cp);
                else $this->dbi->delete_record("kms_isp_crontables","id=$id",$dblink_erp);
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                $server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
                $this->rebuild($post['user'],$server['hostname']);

	}

	function rebuild($user,$hostname) {
		include_once "shared/db_links.php";
		$select="select * from kms_isp_crontables where user='$user' and status=1";
		$result=mysqli_query($this->dblinks['client'],$select);
		$command = "ssh -i /root/.ssh/id_rsa root@".$hostname." 'rm /var/spool/cron/".$user." >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$op=">";
		while ($cron=mysqli_fetch_array($result)) {
			$command = "ssh -i /root/.ssh/id_rsa root@".$hostname." 'echo \"".$cron['minute']."\t".$cron['hour']."\t".$cron['dayofmonth']."\t".$cron['month']."\t".$cron['dayofweek']."\t".$cron['command']."\" ".$op." /var/spool/cron/".$user."' >> /var/log/kms/kms.log";
                	$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");	
			$op=">>";
		}
		$command = "ssh -i /root/.ssh/id_rsa root@".$hostname." ' chmod 0644 /var/spool/cron/".$user." >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	}

}
?>
