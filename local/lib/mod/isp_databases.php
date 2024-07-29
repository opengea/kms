<?

// ----------------------------------------------
// Class ISP DNS Zones for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_databases extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_databases";
	var $key	= "id";	
//	var $fields = array("name","type","db_server","login","password");
	 var $fields = array("name","type","db_server","login");
//	var $readonly = array("expiration_date","registrar","status","sr_entity","name","creation_date","updated_date","authcode");
	var $orderby = "id";
	var $notedit=array("vhost_id", "password_type","db_server","hosting_id","creation_date");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_databases($client_account,$user_account,$dm,$silent) {
		if (!$silent) {
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
                if ($vhost['id']=="") { die("[isp_databases] error. Record not found."); }


		if ($_GET['xid']=="") die("'xid' param missing.");
		$this->where = "vhost_id=".$vhost['id']; 
		}
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                $hide_databrowser=false;
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";
		$this->humanize("name",_KMS_ISP_DATABASE_NAME);
		$this->humanize("login",_KMS_GL_SR_USER);
		$this->maxlength("login","16");
		$this->maxlength("password","16");

		$uploadDate = date('Y-m-d H:i:s');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "host";
		$this->default_php = "hosts.php";
		$this->humanize("dr_folder","carpeta");
                $this->humanize("real_size","Espai total");
                $this->humanize("plesk_space_limit","Espai Plesk");
                $this->humanize("real_traffic","Trafic total");
                $this->humanize("contract_space_limit","Espai contr.");
                $this->setComponent("bytes","real_size");
                $this->setComponent("bytes","plesk_space_limit");
                $this->setComponent("bytes","contract_space_limit");
                $this->setComponent("bytes","plesk_traffic_limit");
                $this->setComponent("bytes","contract_traffic_limit");
                $this->setComponent("bytes","real_traffic");
                $this->setComponent("bytes","httpdocs");
                $this->setComponent("bytes","httpsdocs");
                $this->setComponent("bytes","web_users");
                $this->setComponent("bytes","anonftp");
                $this->setComponent("bytes","logs");
                $this->setComponent("bytes","dbases");
                $this->setComponent("bytes","mailboxes");
		$this->setComponent("input","name");
		$this->setComponent("input","login");
		$this->setComponent("status_icon", "postbox", array("script"=>"isp_databases_postbox","show_label"=>false));
		$this->setComponent("status_icon", "redirect", array("script"=>"isp_databases_redirect","show_label"=>false));
		$this->setComponent("status_icon", "autoresponder", array("script"=>"isp_databases_autoresponder","show_label"=>false));
		//($xcombo_field,$xcombo_sql,$show,$value,$open)
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("select","type",array("mysql"=>"mysql"));
		$this->defvalue("password_type","plain");
		$this->setComponent("checklist","autorenew",array("1"=>""));
		$this->setComponent("checklist","hide_whois_info",array("1"=>""));

		$vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'");
		$this->customOptions = Array();
        	$this->customOptions[0] = Array ("label"=>"phpMyAdmin","url"=>"/kms/mod/isp/dbadmin/?dom=".$vhost['name']."&lang=".$_SESSION['lang']."-utf-8&pma_username=","ico"=>"addon.gif","params"=>"action=xview_pdf","target"=>"_self","checkFunction"=>"");
                $this->action("view_pdf","/usr/local/kms/mod/erp/reports/report.php");

		$this->onInsert="onInsert";
		$this->onUpdate="onUpdate";
		$this->onDelete="onDelete";
	}
	function onInsert($post,$id) {
		$this->trace("Creating database...");

		if ($_GET['xid']=="") {
			// estem cridant des d'un altre modul
			$vhost_id=$post['vhost_id'];	
		} else {
			$vhost_id=$_GET['xid'];
		}
                $vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$vhost_id."'");
//		$hosting=$this->dbi->get_record("SELECT * from kms_isp_hostings WHERE id='".$vhost["hosting_id"]."'");
                //per defecte utilitzem com a dbserver el webserver del vhost, no del hosting mare
                $server=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$vhost["webserver_id"]);
		if ($server['id']=="") { die("[isp_databases] error: webserver #".$vhost["webserver_id"]." not found (check kms_isp_servers table)"); }

                //configure 
		$db=$this->dbi->get_record("select * from kms_isp_databases where id=$id");
                $db['db_server']=$server['hostname'];//"sql.".$vhost["name"];
                $db['vhost_id']=$vhost['id'];
                $db['creation_date']=date('Y-m-d H:i:s');
		$db['password_type']="plain";
                include "shared/db_links.php";
		//replicate and update
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
			$this->dbi->update_record("kms_isp_databases",$db,"id=".$id,$dblink_erp);
			$this->dbi->insert_record("kms_isp_databases",$db,$dblink_cp);
		} else {
			$this->dbi->update_record("kms_isp_databases",$db,"id=".$id,$dblink_cp);
			$this->dbi->insert_record("kms_isp_databases",$db,$dblink_erp);
		}

		//creacio de la base de dades fisica
		$this->trace("Create Phisical database and user on database server...");
                $dblink=$this->dbi->db_connect(str_replace(".intergridnetwork.net","",$server['hostname']),$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$result=$this->dbi->query("CREATE SCHEMA `".$post['name']."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;",$dblink);
		//creacio d'usuari i assignacio de privilegis
		$this->dbi->query("CREATE USER '".$post['login']."'@'localhost' IDENTIFIED BY '".$post['password']."';",$dblink);
		$this->dbi->query("CREATE USER '".$post['login']."'@'cp.intergridnetwork.net' IDENTIFIED BY '".$post['password']."';",$dblink);
		$this->dbi->query("GRANT ALL PRIVILEGES ON ".$post['name'].".* TO ".$post['login']."@'localhost' IDENTIFIED BY '".$post['password']."';",$dblink);
		$this->dbi->query("GRANT ALL PRIVILEGES ON ".$post['name'].".* TO ".$post['login']."@'cp.intergridnetwork.net' IDENTIFIED BY '".$post['password']."';",$dblink);
		$this->dbi->query("FLUSH PRIVILEGES;",$dblink);
		$this->trace("Database and user created...");
	}

        function onUpdate($post,$id) {

		$vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'");
                //$hosting=$this->dbi->get_record("SELECT * from kms_isp_hostings WHERE id='".$vhost["hosting_id"]."'");
		$server=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$vhost["webserver_id"]);
		$db=$this->dbi->get_record("SELECT * from kms_isp_databases WHERE id=$id");
		include "shared/db_links.php";
                //replicate and update
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->update_record("kms_isp_databases",$db,"id=".$id,$dblink_cp);
                } else {
                        $this->dbi->update_record("kms_isp_databases",$db,"id=".$id,$dblink_erp);
                }

		//possible password change
		$dblink=$this->dbi->db_connect(str_replace(".intergridnetwork.net","",$server['hostname']),$this->dbi,"JADF7320cSJdcj3750492x42dj244");

		$update_user="GRANT ALL PRIVILEGES ON ".$post['name'].".* TO ".$post['login']."@'cp.intergridnetwork.net' IDENTIFIED BY '".$post['password']."';";
		$this->dbi->query($update_user,$dblink);
                $update_user="GRANT ALL PRIVILEGES ON ".$post['name'].".* TO ".$post['login']."@'localhost' IDENTIFIED BY '".$post['password']."';";
		$this->dbi->query($update_user,$dblink);
                $this->dbi->query("FLUSH PRIVILEGES;",$dblink);


        }
        function onDelete($post,$id) {
		//remove db i user
		include "shared/db_links.php";
                //replicate and update
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->delete_record("kms_isp_databases","id=".$id,$dblink_cp);
                } else {
			$this->dbi->delete_record("kms_isp_databases","id=".$id,$dblink_erp);
                }
		//drop database and user on database server
                $vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'");
//                $hosting=$this->dbi->get_record("SELECT * from kms_isp_hostings WHERE id='".$vhost["hosting_id"]."'");
                $server=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$vhost["webserver_id"]);

                $dblink=$this->dbi->db_connect(str_replace(".intergridnetwork.net","",$server['hostname']),$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$query="DROP USER ".$post['login']."@localhost";
                $this->dbi->query($query,$dblink);
		$query="DROP USER '".$post['login']."'@'cp.intergridnetwork.net'";
                $this->dbi->query($query,$dblink);
		$query="DROP SCHEMA ".$post['name'];
		$this->dbi->query($query,$dblink);
        }

}
?>
