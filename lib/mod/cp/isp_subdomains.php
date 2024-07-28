<?

// ----------------------------------------------
// Class ISP Subdomains for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_subdomains extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_subdomains";
	var $key	= "id";	
	var $fields = array("name","vr_login","vr_services");
	var $readonly = array("vr_login","ftp_id");
	var $orderby = "name";
	var $notedit=array("domain_id","ftp_id","php","perl","python","fastcgi","ssl","vhost_id","ftp_main","ftp_id","vr_services");
	var $hidden=array("ftp_id","vr_services");
	
        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_subdomains($client_account,$user_account,$dm,$dblinks) {

                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysql_query($select);
                if (!$result) die("[isp_subdomains] error #1 ".$select." ".mysql_error($result));
                $client=mysql_fetch_array($result);
	
		if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
                } else {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE sr_client=".$client['sr_client']." AND id='".$_GET['xid']."'";
                }

                if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat")  {
                        $this->notedit=array("ftp_id");
                        $this->readonly=array("ftp_id","vhost_id","name");
			$this->where = "kms_isp_ftps.vhost_id=".$_GET['xid'];
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['xid']." AND sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
                } else  {
//                        $this->fields = array("postbox","mailname","status","name","hosting_id");
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                }

		$result=mysql_query($sel);
		if (!$result) die("[isp_subdomains] error #2 ".$sel." ".mysql_error($result));
                $vhost=mysql_fetch_array($result);

                if ($vhost['id']==""&&$_GET['app']!='sysadmin'&&$_GET['app']!='cp-admin') {
                        die("[isp_subdomains] error. Record not found.");
                }

//                if ($vhost['id']!=""&&$_GET['_']=="b") $this->where = "kms_isp_ftps.vhost_id=".$_GET['xid']; 
		if ($vhost['id']!=""&&$_GET['_']!="e") $this->where = "kms_isp_ftps.vhost_id=".$vhost['id'];
		if ($_GET['_']=="e"||$_GET['_']=="i") $this->where = "";
		if ($_GET['xid']=="") die("'xid' param missing.");

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";
		//$this->setComponent("cipher","vr_password","plain");
		if ($_GET['_']=="e") array_push($this->readonly,"vr_login");
		if ($_GET['_']=="i") $this->setComponent("cipher","vr_password","plain"); //amb edit no, perque aixi la podem consultar
		$this->defvalue("ftp_main",1);
		$this->defvalue("php",1);
		$this->setComponent("checklist","ftp_main",array("1"=>""));
		$this->setComponent("checklist","php",array("1"=>""));
		$this->setComponent("checklist","perl",array("1"=>""));
                $this->setComponent("checklist","python",array("1"=>""));
                $this->setComponent("checklist","fastcgi",array("1"=>""));
                $this->setComponent("checklist","ssl",array("1"=>""));
		$this->onInsert="onInsert";
                $this->onDelete="onDelete";
                $this->onPreInsert="onPreInsert";
                $this->onUpdate="onUpdate";
		$this->onPreDelete="onPreDelete";
		if ($_GET['_']=="i") {
			$this->xvField("vr_login",array("content_function"=>"vr_login_rule"));
			$this->defvalue("vr_login",$this->vr_login_rule());
		} else {
        	 $xsql=array("xv_xtable"=>"kms_isp_ftps", "xv_field"=>"ftp_id", "xv_xfield"=>"id", "xv_xselectionfield"=>"login");
            	 $this->xvField("vr_login",array("sql"=>$xsql));
		}
                $this->maxlength("vr_login","20");

		$xsql=array("xv_xtable"=>"kms_isp_ftps", "xv_field"=>"ftp_id", "xv_xfield"=>"id", "xv_xselectionfield"=>"password");
                $this->xvField("vr_password",array("sql"=>$xsql));
		$this->addComment("name",".".$vhost['name']);
		$this->inputSize("name",20);
	//	if ($_GET['_']=="b") {
		$this->humanize("vr_services", str_replace("FTP","Web FTP",_KMS_SERVICES_FTP));
		$this->setstyle("vr_services","width:175px");
		//$xsql=array("xv_xtable"=>"kms_isp_hostings", "xv_field"=>"hosting_id", "xv_xfield"=>"id", "xv_xselectionfield"=>"max_space");
                //$this->xvField("vr_services",array("sql"=>$xsql));

		$this->setComponent("status_icon", "vr_services", array("script"=>"file_manager","orderby"=>"id"));
	//	}

        }

        function onPreInsert($post) {
		include "shared/db_links.php";
		$this->trace("Creating subdomain, please wait....");
		if (preg_match('/^[a-zA-Z0-9_]+$/',$post['vr_login'])) { // validate login name

		//check if ftp and subdomain already exists
                $ftp=$this->dbi->get_record("select login from kms_isp_ftps where login='".$post['vr_login']."'");
		$subdomain=$this->dbi->get_record("select name from kms_isp_subdomains where name='".$post['name']."' AND vhost_id=".$_GET['xid']);
                if ($ftp['login']==$post['vr_login']&&$ftp['login']!=NULL) $this->_error("",_KMS_ERR_FTP2,"fatal");
		if ($subdomain['name']==$post['name']&&$subdomain['name']!=NULL) $this->_error("",_KMS_ERR_SUBDOMAIN1,"fatal");

                } else $this->_error("","[isp_subdomains] "._KMS_ERR_FTP3,"fatal");

		$this->trace("Creating ftp account for this subdomain...");
                // create FTP for this subdomain 
        //      if ($post['ftp_main']==0) {
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                $isp_ftps=new isp_ftps($this->client_account,$this->user_account,$this->dm,$this->dblinks);
                $ftp=array("vhost_id"=>$_GET['xid'],"login"=>$post['vr_login'],"password"=>$post['vr_password'],"home"=>"/var/www/vhosts/".$vhost['name']."/subdomains/".$post['name'],"shell"=>"/bin/false","type"=>"subdomains");
                $id_ftp=$this->dbi->insert_record("kms_isp_ftps",$ftp); // no s'ha de replicar, ja ho fara el onInsert
                $ftp['name']=$post['name']; // need subdomain name
		//no s'ha de fer insert ni preinsert del ftp perque el subdomini ja crea l'ftp fisic
                //}

		//setup
//		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
		$post_=Array();
		$post_=$post;
		$post_['vhost_id']=$_GET['xid'];
		$post_['ftp_id']=$id_ftp;
		$post_['ftp_main']=0;
		$post_['perl']='false';$post_['python']='false';$post_['fastcgi']='false';$post_['ssl']='false';$post_['php']='false';
		$post_['name']=$post['name'];
		return $post_;	
        }

        function onInsert($post,$id) {
		//replicate
		include "shared/db_links.php";
		if ($_GET['xid']=="") $this->_error("","'xid' param missing.","fatal");
		$subdomain=$this->dbi->get_record("select * from kms_isp_subdomains where id={$id} AND vhost_id=".$_GET['xid']);
                if ($subdomain['name']=="") $this->_error("","subdomain id={$id} not found for vhost_id=".$_GET['xid'],"fatal");

        	$this->trace("Replicating...");
	        if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->insert_record("kms_isp_subdomains",$subdomain,$dblink_cp);
                } else {
                        $this->dbi->insert_record("kms_isp_subdomains",$subdomain,$dblink_erp);
                }
		// create phisical subdomain (directory and ftp system user)
		$this->trace("Creating physical subdomain ".$post['name']."...");
                $vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
		$server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']); // ns4
                $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." '/usr/local/kms/mod/isp/setup/create_subdomain.sh ".$vhost['name']." ".$post['name']." ".$post['vr_login']." ".$post['vr_password']." ".$server['ip']."' >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		// insert subdomain in DNS zones
		$this->trace("Updating DNS zones ...");
		$dns_record=array("dns_zone_id"=>$vhost['dns_zone_id'],"type"=>"CNAME","host"=>$subdomain['name'].".".$vhost['name'].".","val"=>$server['hostname'].".","opt"=>"");
		//insertem nomes en un lloc perque el onInsert ja replicara l'altre:
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
		$id_dns=$this->dbi->insert_record("kms_isp_dns_recs",$dns_record,$dblink_erp);
		} else {
		$id_dns=$this->dbi->insert_record("kms_isp_dns_recs",$dns_record,$dblink_cp);
		}
		$dns=new isp_dns($this->client_account,$this->user_account,$this->dm,$this->dblinks);//$this->dblinks);
		$dns->onInsert($dns_record,$id_dns);
        }

        function onPreDelete($post,$id) {
                //delete FTP
                $subdomain=$this->dbi->get_record("select * from kms_isp_subdomains where id={$id}");// AND vhost_id=".$_GET['xid']);
                if ($subdomain['ftp_id']=="") { echo "select * from kms_isp_subdomains where id={$id}"; print_r($subdomain); die ('ftp_id empty'); $this->trace("WARNING ftp_id is empty, can't remove FTP account"); }
                if ($subdomain['ftp_id']!="") {
                $this->trace("Deleting ftp id=".$subdomain['ftp_id']."...");
                if (!isset($this->dbi)) $this->dbi = new dataDBI();
                $this->dbi->delete_record("kms_isp_ftps","id=".$subdomain['ftp_id'],$dblink_cp);
                $this->dbi->delete_record("kms_isp_ftps","id=".$subdomain['ftp_id'],$dblink_erp);
                }
		return $post;
	}

        function onDelete($post,$id) {

                if (!isset($this->dbi)) $this->dbi = new dataDBI();
		include "shared/db_links.php";

		$dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");

//print_r($dblink_cp);
//exit;
		$this->trace("Deleting subdomain ".$post['name']." id={$id}, please wait....");
		if ($_GET['xid']=="") $this->_error("","'xid' param missing.","fatal");
	
		// delete replicate
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                	$this->dbi->delete_record("kms_isp_subdomains","id=".$id,$dblink_cp);
                	$this->dbi->delete_record("kms_isp_subdomains","id=".$id,$dblink_erp);
                }
                // remove directory
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                $server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." '/usr/local/kms/mod/isp/setup/delete_subdomain.sh ".$vhost['name']." ".$post['name']." ".$post['vr_login']."' >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		//delete dns record
               // $dns_zone=$this->dbi->get_record("SELECT * FROM kms_isp_dns_zones where id=".$vhost['dns_zone_id']);
		$rec=$this->dbi->get_record("SELECT id FROM kms_isp_dns_recs where host='".$post['name'].".".$vhost['name'].".' and dns_zone_id='".$vhost['dns_zone_id']."'");
                $this->dbi->delete_record("kms_isp_dns_recs","id=".$rec['id'],$dblink_erp);
                $this->dbi->delete_record("kms_isp_dns_recs","id=".$rec['id'],$dblink_cp);
                //update DNS records
                $this->trace("Configuring DNS zone...");
                $dns=new isp_dns($this->client_account,$this->user_account,$this->dm,$this->dblinks);
		$servers=$dns->getServers($vhost,"vhost");
                $dns->setupDNSzone($vhost['name'],$dns_zone['email'],$servers,"DNS,WEB,DB,MAIL,MAILING,CP,FTP,KMS",$dblink_cp,$dblink_erp,true);

        }

        function onUpdate ($post,$id) {
		$this->trace("Updating subdomain, please wait...");
                include "shared/db_links.php";
                //replicate
                $ftp=array("login"=>$post['vr_login'],"password"=>$post['vr_password']);
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                //        $this->dbi->update_record("kms_isp_subdomains",$subdomain,"id={$id}",$dblink_cp);
			$this->dbi->update_record("kms_isp_ftps",$ftp,"login='{$ftp['login']}'",$dblink_cp);
                } else {
//                        $this->dbi->update_record("kms_isp_subdomains",$ftp,"id={$id}",$dblink_erp);
			$this->dbi->update_record("kms_isp_ftps",$ftp,"login='{$ftp['login']}'",$dblink_cp);
                }
                //change password
                $vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                $server=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=".$vhost['webserver_id']);
                $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'echo  ".$post['login'].":".$post['password']." | /usr/sbin/chpasswd' >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");


        }

        function vr_login_rule($id) {
		$u=1;
		while (1==1) {
			$login="v".$_GET['xid']."_u".$u;
			$q="select login from kms_isp_ftps where vhost_id=".$_GET['xid']." and login='".$login."'";
			$res=$this->dbi->query($q);
			$row=mysql_fetch_assoc($res);
			if ($row['login']=="") break; else $u++;
		}
                return $login;
        }

}
?>
