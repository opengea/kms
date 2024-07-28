<?

// ----------------------------------------------
// Class ISP FTP for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_ftps extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_ftps";
	var $key	= "id";	
	var $fields = array("login","home","vr_public_url","vr_ftp_host");
	var $readonly = array("vhost_id","shell","quota","inici");
	var $orderby = "id";
	var $notedit=array("vhost_id","vhost_id","quota","shell","home","vr_public_url","vr_ftp_host","type");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_ftps($client_account,$user_account,$dm) {

                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysqli_query($this->dblinks['client'],$select);
                if (!$result) die(mysqli_error($result));
                $client=mysqli_fetch_array($result);

		if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
                } else {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE sr_client=".$client['sr_client']." AND id='".$_GET['xid']."'";
                }

                if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat")  {
                        $this->notedit=array();
                        $this->readonly=array("home","vr_public_url");
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['xid']." AND sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
                } else  {

                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                }
		$result=mysqli_query($this->dblinks['client'],$sel);
                if (!$result) die(mysqli_error($result));
                $vhost=mysqli_fetch_array($result);
                if ($vhost['id']==""&&$_GET['app']!='sysadmin'&&$_GET['app']!='cp-admin') {
                        die("[isp_ftps] error. Record not found.");
                }

       //         if ($vhost['id']!="") $this->where = "vhost_id=".$vhost['id'];
		if ($_GET['xid']=="") $this->_error("","'xid' param missing.","fatal");
		$this->where = "vhost_id=".$vhost['id']; //$_GET['xid'];
//echo $this->where;
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		if ($_GET['_']=="e") array_push($this->readonly,"login"); 
       //         if ($_GET['_']=="i") $this->setComponent("cipher","password","plain"); //amb edit no, perque aixi la podem consultar
                $hide_databrowser=false;
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";
		$this->humanize("login",_KMS_GL_USERNAME);
		$this->onPreDelete="onPreDelete";
		$this->onDelete="onDelete";
		$this->onPreInsert="onPreInsert";
                $this->onInsert="onInsert";
		$this->onUpdate="onUpdate";
		$this->xvField("vr_public_url",array("content_function"=>"vr_public_url_rule"));
		$this->xvField("vr_ftp_host",array("content_function"=>"vr_ftp_host_rule"));
		$this->setComponent("cipher","password","plain");
        }

	function vr_ftp_host_rule($id) {
		$row=$this->dbi->get_record("select home from kms_isp_ftps where id=$id");
                $home=$row['home'];
                $home=str_replace("/var/www/vhosts/","",$home);
		 if (strpos($home,"/")!=0) $domain=substr($home,0,strpos($home,"/")); else $domain=$home;
		return "ftp.".$domain;
	}

	function vr_public_url_rule($id) {
		$row=$this->dbi->get_record("select home from kms_isp_ftps where id=$id");
		$home=$row['home'];
		$home=str_replace("/var/www/vhosts/","",$home);
		if (strpos($home,"/")!=0) $domain=substr($home,0,strpos($home,"/")); else $domain=$home;
		if (strpos($home,"/")!=0) $home=substr($home,strpos($home,"/")+1);
		if (substr($home,0,10)=="web_users/") $public_url="http://".$domain."/~".substr($home,10)."/";
		else if ($home==$domain)  $public_url="http://www.".$domain."/";
		else if (substr($home,0,11)=="subdomains/") $public_url="http://".substr($home,11).".".$domain."/";
		return "<a href='{$public_url}' target='new'>{$public_url}</a>";
	}

	function onPreDelete($post,$id) {
		if ($post['home']=="/var/www/vhosts/".$post['login']) $this->_error("",_KMS_ERR_FTP1,"fatal");
	
	}

	function onPreInsert($post,$id) {
		//comprovem que aquest user no existeix i que el login es correcte
		if (preg_match('/^[a-zA-Z0-9_]+$/',$post['login'])) {
		$ftp=$this->dbi->get_record("select login from kms_isp_ftps where login='".$post['login']."'");
                if ($ftp['login']==$post['login']&&$ftp['login']!=NULL) $this->_error("",_KMS_ERR_FTP2,"fatal");
		} else $this->_error("",_KMS_ERR_FTP3,"fatal");
	}

        function onInsert ($post,$id) {
                if ($_GET['xid']=="")  $this->_error("","xid param missing","fatal");
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
		if ($post['type']!="") $type=$post['type']; else $type="web_users";
		if ($post['name']!="") $name=$post['name']; else $name=$post['login'];
                $update=array("vhost_id"=>$vhost['id'],"home"=>"/var/www/vhosts/".$vhost['name']."/{$type}/".$name,"shell"=>"/bin/false","quota"=>0);
                $this->dbi->update_record("kms_isp_ftps",$update,"id=$id");
		// replicate
		$ftp=$this->dbi->get_record("select * from kms_isp_ftps where id=$id");
		include "shared/db_links.php";
		//replicate
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
			$this->dbi->insert_record("kms_isp_ftps",$ftp,$dblink_cp);
		} else {
			$this->dbi->insert_record("kms_isp_ftps",$ftp,$dblink_erp);
		}
		// create phisical FTP (directory and system user)
		$server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']); // ns4

                $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." '/usr/local/kms/mod/isp/setup/create_ftp.sh ".$vhost['name']." ".$post['login']." ".$ftp['password']."' >> /var/log/kms.log";
//if ($_SERVER['REMOTE_ADDR']=='88.12.33.163') { echo $command;exit; }
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
        }

	function onDelete ($post,$id) {
		if ($_GET['xid']=="")  $this->_error("","xid param missing","fatal");
		// replicate
		include "shared/db_links.php";
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->delete_record("kms_isp_ftps","id={$id}",$dblink_cp);
                } else {
                        $this->dbi->delete_record("kms_isp_ftps","id={$id}",$dblink_erp);
                }
		// remove directory
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
		$server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
		if ($post['type']!="") $type=$post['type']; else $type="web_users";
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'rm -r /var/www/vhosts/".$vhost['name']."/{$type}/".$post['login']."' >> /var/log/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'userdel ".$post['login']."' >> /var/log/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	}

	function onUpdate ($post,$id) {
		include "shared/db_links.php";
		//replicate
		$ftp=array("login"=>$post['login'],"password"=>$post['password']);
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->update_record("kms_isp_ftps",$ftp,"id={$id}",$dblink_cp);
                } else {
                        $this->dbi->update_record("kms_isp_ftps",$ftp,"id={$id}",$dblink_erp);
                }
		//read work data
		$ftp=$this->dbi->get_record("select * from kms_isp_ftps where id=".$id);
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
		$server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
	
		//add user if not exists

		$command="ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'id -u ".$post['login']." &>/dev/null || useradd -p ".$post['password']." -s /bin/false -g intergrid -d ".$ftp['home']." -c \"KMS ftp user\" ".$post['login']."' >> /var/log/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
//useradd -M -p $pass -s /bin/false -g 2523 -d /var/www/vhosts/$1 -c 'KMS vhost user' $3		
//		$command="id -u ".$post['login']." &>/dev/null || useradd -p ".$pass." -s /bin/false -g 2523 -d /var/www/vhosts/".$1."/web_users/$2 -c 'KMS ftp user (webuser)' $2
//useradd -p $pass -s /bin/false -g 2523 -d /var/www/vhosts/$1/subdomains/$2 -c 'KMS subdomain user' $3	

		//change password
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'echo \"".$post['login'].":".$post['password']."\" | /usr/sbin/chpasswd ' >> /var/log/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	}

}
?>
