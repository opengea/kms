<?
// ----------------------------------------------
// Class ISP DNS Zones for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_dns extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_dns_recs";
	var $key	= "id";	
	var $fields	= array("host","type","opt","val");
	var $readonly	= array("dns_zone_id");
	var $orderby	= "type";
	var $sortdir    = "desc,host";
	var $notedit 	= array("time_stamp","dns_zone_id");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view   = false;
	var $can_edit   = true;
	var $can_delete = true;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_dns($client_account,$user_account,$dm,$dblinks) {

            include_once "shared/db_links.php";
                $dblink_cp=$dblinks['client'];

	if ($silent!=1) {

		if ($_GET['app']!="sysadmin") {
			if ($user_account['id']=="") die("[isp_dns] User account ID missing.");
	                $sel="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
	                $result=mysql_query($sel,$dblink_cp);
                	if (!$result) { echo "dblinks=";print_r($dblinks); echo "<br><br>this=";print_r($this);  echo "<br><br>dm=";print_r($dm);die("[isp_dns] error #1 ".$sel." ".mysql_error($result));}
                	$client=mysql_fetch_array($result);
			if ($client['id']=="") die("[isp_dns] Client not found.".$sel);
		}

		if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
                } else {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE sr_client=".$client['sr_client']." AND id='".$_GET['xid']."'";
                }

		if ($this->_group_permissions(1,$user_account['groups']))  {
                        $sel ="SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'";
                        $this->notedit=array();
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['xid']." AND sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
                } else  {
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                }
                if ($_GET['xid']=="") die("'xid' param missing.");


                $result=mysql_query($sel,$dblink_cp);
                if (!$result) die("[isp_dns] error #2 ".$sel." ".mysql_error($result));
                $vhost=mysql_fetch_array($result);
		if ($vhost['id']=="")  die('[isp_dns] error #3 '.$sel.' error:'.mysql_error($result));
/*		$sel ="SELECT * from kms_isp_domains WHERE name='".$vhost['name']."'";
                $result=mysql_query($sel);
                if (!$result) die(mysql_error($result));
                $domain=mysql_fetch_array($result);
		if ($domain['id']=="") die("[isp_dns] Domain not found.".$sel); */
		$sel ="SELECT * from kms_isp_dns_zones WHERE name='".$vhost['name']."'";
		$result=mysql_query($sel,$dblink_cp);
                if (!$result) die('[isp_dns] error with query '.$sel.' error:'.mysql_error($result));
                $dns=mysql_fetch_array($result);
		if ($dns['id']=="") { 
			//$this->trace("[isp_dns] DNS Zone not found. Creating...".$sel);
			$insert="INSERT INTO kms_isp_dns_zones SET name='".$vhost['name']."',status='1',type='master'";
			$result=mysql_query($insert);
			$result=mysql_query($sel);
			$dns=mysql_fetch_array($result);
		}

		$this->where = "dns_zone_id=".$dns['id'];
                parent::mod($client_account,$user_account,$extranet);
        }
	}

        function setup($client_account,$user_account,$dm) {
                $hide_databrowser=false;
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";
		if ($_GET['_']=="e"||$_GET['_']=="i") $this->setComponent("select","type",array("NS"=>"NS","A"=>"A","AAAA"=>"AAAA","CNAME"=>"CNAME","MX"=>"MX","PTR"=>"PTR","TXT"=>"TXT","SRV"=>"SRV"));
		                $this->customButtons=Array();
                $this->customButtons[0] = Array ("label"=>_KMS_ISP_DNS_REBUILD,"url"=>"","ico"=>"reload_icon.gif","params"=>"action=rebuildDNS","target"=>"_self","checkFunction"=>"","class"=>"");
		if ($_SERVER['REMOTE_ADDR']=='81.0.57.125') $this->customButtons[1] = Array ("label"=>"Restaurar DKIM","url"=>"","ico"=>"reload_icon.gif","params"=>"action=rebuildDKIM","target"=>"_self","checkFunction"=>"","class"=>"");

		$this->action("rebuildDNS","/usr/local/kms/mod/isp/dns/rebuildDNS.php");
		$this->action("rebuildDKIM","/usr/local/kms/mod/isp/dns/rebuildDKIM.php");
//		$this->onDocumentReady("function checkDNShostname() { if ($('#').val()==) }; 
//		$this->script("function updateF(t) { if (t=='NS')  $('#label_val').html(\""._KMS_ISP_DNS_RECS_NS_NAME."\"); }  else if (t=='A') { $('#label_val').html(\""._KMS_ISP_DNS_RECS_IP_ADDRESS."\"); } ");
		$this->script("function updateF(t) { $('textarea#val').css('height','25px');$('textarea#val').css('resize','none');if (t=='NS') { $('#label_host').html(\""._KMS_ISP_DNS_RECS_DOMAIN."\"); $('#label_val').html(\""._KMS_ISP_DNS_RECS_NS_NAME."\"); $('#comment_val').html('.'); $('#comment_host').html('.".$vhost['name'].".'); } else if (t=='A') { $('#label_host').html(\""._KMS_ISP_DNS_RECS_DOMAIN."\"); $('#label_val').html(\""._KMS_ISP_DNS_RECS_IP_ADDRESS."\"); $('#comment_val').html(''); $('#comment_host').html('.".$vhost['name'].".'); } else if (t=='CNAME') { $('#label_host').html(\""._KMS_ISP_DNS_RECS_DOMAIN."\"); $('#label_val').html(\""._KMS_ISP_DNS_RECS_CANONICAL_NAME."\"); $('#comment_val').html('.'); $('#comment_host').html('.".$vhost['name'].".'); } else if (t=='MX') { $('#label_opt').html(\""._KMS_ISP_DNS_RECS_PRIORITY."\"); $('#label_host').html(\""._KMS_ISP_DNS_RECS_DOMAIN."\"); $('#label_val').html(\""._KMS_ISP_DNS_RECS_MAIL_SERVER."\"); $('#comment_val').html('.'); $('#comment_host').html('.".$vhost['name'].".'); } else if (t=='PTR') { $('#label_host').html(\""._KMS_ISP_DNS_RECS_IP_ADDRESS."\");  $('#label_val').html(\""._KMS_ISP_DNS_RECS_DOMAIN."\"); $('#val').val('".$vhost['name']."'); $('#comment_val').html(''); i=$('#host').val().indexOf('/'); if (i>0) { $('#host').val($('#host').val().substr(0,i) ); }    $('#comment_host').html(' / <select name=PTR_mask id=PTR_mask><option value=8>8</option><option value=16>16</option><option value=24 selected>24</option></select>'); }  else if (t=='TXT') {  $('textarea#val').css('height','200px'); $('#label_host').html(\""._KMS_ISP_DNS_RECS_DOMAIN."\"); $('#comment_host').html('.".$vhost['name'].".'); $('#label_val').html(\""._KMS_ISP_DNS_RECS_TXT_REGISTER."\"); $('#comment_val').html(''); } else if (t=='SRV') { $('#label_host').html(\""._KMS_ISP_DNS_RECS_SERVICE_PROTO."\"); $('#comment_host').html('.".$vhost['name'].".'); $('#label_val').html(\""._KMS_ISP_DNS_RECS_TARGET."\"); $('#comment_val').html('.'); $('#label_opt').html(\"Weight Priority Port\"); } } ");
		$this->onFieldChange("type","updateF($('#type').val())");
		$vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'");
		$this->onDocumentReady("h=$('#host').val();$('#host').val(h.replace('.".$vhost['name'].".',''));h=$('#host').val(); $('#host').val(h.replace('".$vhost['name'].".',''));v=$('#val').val(); if (v.substr(v.length-1,1)=='.') v=$('#val').val(v.substr(0,v.length-1)); updateF($('#type').val())");
		$this->addComment("host",".".$vhost['name'].".");
		$this->addComment("val",".");
		$this->setstyle("host","width:200px");
		$this->setstyle("type","width:150px");
		$this->setstyle("val","width:auto;min-height:25px;height:auto");
		$this->setComponent("wysiwyg","val",array("type"=>"text"));
		
		$this->setstyle("opt","width:150px");
		$this->onPreInsert = "onPreInsert";
		$this->onPreUpdate = "onPreUpdate";
		$this->onInsert="onInsert";
		$this->onUpdate="onUpdate";
		$this->onDelete="onDelete";
	}

	function rebuildDNS($type) {
		$delete=true;
		if (!isset($this->dbi)) $this->dbi = new dataDBI();
                include "shared/db_links.php";
		$this->trace("Rebuilding DNS zones...");
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");
		$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid'],$dblink_cp);
                if ($vhost['dns_zone_id']=="") $this->_error("","DNS Zone not found for this domain!","fatal");
                $dns_zone=$this->dbi->get_record("SELECT * FROM kms_isp_dns_zones where id=".$vhost['dns_zone_id'],$dblink_cp);
                $servers=$this->getServers($vhost,$type);
		$services="DNS,CP,MAIL,DKIM,CLOUD,KMS,MAILING,FTP"; //default
		if ($type=="DKIM") $services="DKIM";
		if ($vhost['webserver_id']==0) $services="DNS,CP,MAIL,DKIM,CLOUD";
		if ($vhost['mailserver_id']==0) $services="DNS,CP,KMS,MAILING,FTP,CLOUD";
		if ($type=="DKIM") { $services="DKIM";$delete=false; }
		$dns_zone_id=$this->_rebuildDNSzone($delete,$vhost['name'],$dns_zone['email'],$servers,$services,$dblink_cp,$dblink_erp);
		return $dns_zone_id;
	}

       function _setupMasterNameserver($domain,$nameserver) {
		$this->trace("Setting up primary nameserver $nameserver for domain ".$domain."...");
		//copiem fitxer de zones
		$domain=trim($domain);
                $command = "scp -i /root/.ssh/id_rsa /tmp/".$domain." root@{$nameserver}:/var/named/master/";

                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		//elimina registre a named (si existeix)
		$command = "ssh -i /root/.ssh/id_rsa root@".$nameserver." \"sed '/".$domain."/,+8 d' /etc/named.conf > /tmp/named.conf\"  >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
                //copia registre 
                $command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} 'cp /tmp/named.conf /etc/named.conf' >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		//preparem registre de domini
                $command = "scp -i /root/.ssh/id_rsa /tmp/named_".$domain."* root@{$nameserver}:/tmp/";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		//afegeix registre a named
                $command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} 'cat /tmp/named_".$domain.".tmp >> /etc/named.conf' >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$this->_reloadNamed($nameserver);
        }

	function _setupSlaveNameserver($domain,$nameserver) {
		$this->trace("Setting up secondary nameserver $nameserver for domain ".$domain."...");
//               $command="ssh -i /root/.ssh/id_rsa root@$nameserver '/usr/local/kms/mod/isp/setup/create_dns_zone.sh ".$domain."'";

		//elimina registre a named (si existeix)
                $command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} \"sed '/".$domain."/,+0 d' /etc/named.conf > /tmp/named.conf\" >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		//copia registre 
                $command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} 'cp /tmp/named.conf /etc/named.conf' >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		// transferim nova zona al servidor 
                $command = "scp -i /root/.ssh/id_rsa /tmp/named2_".$domain."* root@{$nameserver}:/tmp/";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
                //afegeix registre a named.conf
                $command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} 'cat /tmp/named2_".$domain.".tmp >> /etc/named.conf'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		// copia slave zone
		$command = "scp -i /root/.ssh/id_rsa /tmp/".$domain." root@{$nameserver}:/var/named/slaves/";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		// chown named:named
		$command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} 'chown named:named /var/named/slaves/".$domain."'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		// named restart
                $this->_restartNamed($nameserver);
        }

	function _setupNameservers ($domain,$servers) {
		$this->trace("Setting up and reloading Nameservers...");
		$this->_setupMasterNameserver($domain,$servers['nameserver1']['hostname']);
		$this->_setupSlaveNameserver($domain,$servers['nameserver2']['hostname']);
	}

        function _reloadNamed($host) {
                        $this->ssh_exec("localhost","ssh -i /root/.ssh/id_rsa root@{$host} 'service named reload' >> /var/log/kms/kms.log","JADF7320cSJdcj3750492x42dj244");
        }

        function _restartNamed($host) {
                        $this->ssh_exec("localhost","ssh -i /root/.ssh/id_rsa root@{$host} 'service named restart'  >> /var/log/kms/kms.log","JADF7320cSJdcj3750492x42dj244");
        }

        function _setupPTR($domain,$nameserver) {
                //afegeix zona inversa/PTR (Aixo nomes te sentit en configuracio de servidors. En compartit amaguem els dominis.)
                //1. crea fitxer de zona inversa si no existeix IP INVERSA in-addr-arpa
                //2. afegeix registre PTR
                $file="205.47.78.in-addr.arpa";
                $command = "ssh -i /root/.ssh/id_rsa root@{$nameserver} 'cat /tmp/named_".$domain."_reverse.tmp >> /var/named/master/".$file."'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
        }

	function _rebuildDNSzone($delete,$domain,$admin_email,$servers,$services,$dblink1,$dblink2) {
			include "shared/db_links.php";  // include_once no serveix
			if ($domain=="") $this->_error("","[KMS] Rebuild DNS : Missing 'domain' parameter","fatal");
			if (!isset($this->dbi)) $this->dbi = new dataDBI();
			$dns_zone=$this->dbi->get_record("select * from kms_isp_dns_zones where name='".$domain."'",$dblink_cp);
			if ($delete) {
				$this->dbi->delete_record("kms_isp_dns_zones","name='".$domain."'",$dblink1);
				$this->dbi->delete_record("kms_isp_dns_zones","name='".$domain."'",$dblink2);
				if ($dns_zone['id']!=""&&$dns_zone['id']!=0) {
					$this->dbi->delete_record("kms_isp_dns_recs","dns_zone_id=".$dns_zone['id'],$dblink1);
					$this->dbi->delete_record("kms_isp_dns_recs","dns_zone_id=".$dns_zone['id'],$dblink2);
				}
				$this->dbi->query("ALTER TABLE kms_isp_dns_recs auto_increment=1",$dblink1);
				$this->dbi->query("ALTER TABLE kms_isp_dns_recs auto_increment=1",$dblink2);	
			}
			$dns_zone_id=$this->setupDNSzone($domain,$admin_email,$servers,$services,$dblink1,$dblink2,$delete);
			return $dns_zone_id;
	}

        function setupDNSzone($domain,$admin_email,$servers,$services,$dblink1,$dblink2,$delete) {
			
			if (!isset($this->dbi)) $this->dbi = new dataDBI();
			include "shared/db_links.php";

                        $this->trace("Configuring DNS zone for domain name ".$domain."...");
			$dns_zone=$this->dbi->get_record("select * from kms_isp_dns_zones where name='".$domain."'",$dblink_cp);
                        $dns_zone_id=$dns_zone['id'];

        //      	  if ($delete) {
                        //remove previous tmp files
                        unlink("/tmp/named_*");

			if ($dns_zone_id==""||!$delete) {
//die('rebuild....');
				//Ops! DNS zone doesn't exist, we must create it.
//				$this->trace("DNS zone is missing. Creating it...");
				$this->trace("Setting up DNS zone...");
                                if ($admin_email=="") $admin_email="registres@intergrid.cat";
                                $values=array("status"=>1,"name"=>$domain,"email"=>$admin_email,"type"=>"master","ttl"=>86400,"ttl_unit"=>86400,"refresh"=>10800,"refresh_unit"=>3600,"retry_unit"=>3600,"expire"=>1209600,"expire_unit"=>86400,"minimum"=>10800,"minimum_unit"=>3600,"serial_format"=>"UNIXTIMESTAMP","serial"=>date('Ymds'));
                                $dns_zone_id=$this->dbi->insert_record("kms_isp_dns_zones",$values,$dblink_cp,$dblink_erp);
				//update vhost dns_zone_id
				$this->dbi->update_record("kms_isp_hostings_vhosts",array("dns_zone_id"=>$dns_zone_id),"name='{$domain}'",$dblink_cp,$dblink_erp);
				$action="insert";
				$this->trace("Build DNS records...");
				if ($services=="") $services="DNS,WEB,DB,MAIL,MAILING,CP,FTP,CLOUD,KMS,DKIM";
				$where_services="service='".str_replace(",","' OR service='",$services)."'";
	                        $select="SELECT * FROM kms_isp_dns_recs_tpl WHERE ".$where_services;
	                        $result=mysql_query($select,$dblink_cp);
	                        while ($record=mysql_fetch_array($result)) {
					//host replacement
	                                $host=str_replace("<domain>",$domain,$record['host']);
	                                $host=str_replace("<webserver_ip>",$servers['webserver']['ip'],$host);
					$host=str_replace("<mailserver_ip>",$servers['mailserver']['ip'],$host);
					if ($servers['mailserver']['ipv6']=="") { //no ipv6
                                                $host=str_replace("ip6:<mailserver_ip6>","",$host);
                                        } else {
                                                $host=str_replace("<mailserver_ip6>",$servers['mailserver']['ipv6'],$host);
                                        }
					//val replacement
					$val=trim($record['val']);
					$val=str_replace("<nameserver1_name>",$servers['nameserver1']['hostname'],$val);
					$val=str_replace("<nameserver2_name>",$servers['nameserver2']['hostname'],$val);
	                                $val=str_replace("<domain>",$domain,$val);
	                                $val=str_replace("<webserver_ip>",$servers['webserver']['ip'],$val);
					$val=str_replace("<mailserver_ip>",$servers['mailserver']['ip'],$val);
					$val=str_replace("<mailserver_ip6>",$servers['mailserver']['ipv6'],$val);
					if ($servers['mailserver']['ipv6']=="") { //no ipv6
						$val=str_replace("ip6:<mailserver_ip6>","",$val);
					} else {
						$val=str_replace("<mailserver_ip6>",$servers['mailserver']['ipv6'],$val);
					}
					$val=str_replace("<mailserver_name>",$servers['mailserver']['hostname'],$val);
					$val=str_replace("<webserver_name>",$servers['webserver']['hostname'],$val);
					//DKIM
					if ($record['service']=="DKIM") {

					$url="https://".$servers['mailserver']['hostname'].":7475/api/v1/email/dkim/generate/".str_replace(".","-dot-",$domain);
					$arrContextOptions=array(
						    "ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false),
						);
                                        $result = file_get_contents($url,false,stream_context_create($arrContextOptions));
				        $json=json_decode($result);
				        $DKIM_KEY=substr($json->data->dns_txt_entry,strpos($json->data->dns_txt_entry,"p=")+2);
				        $DKIM_KEY=substr($DKIM_KEY,0,strpos($DKIM_KEY,"\""));
					$val=str_replace("<DKIM_KEY>",$DKIM_KEY,$val);
					}

	                                $dns_record=array("dns_zone_id"=>$dns_zone_id,"type"=>$record['type'],"host"=>$host,"val"=>$val,"opt"=>$record['opt'],"time_stamp"=>date('Y-m-d h:i:s'));

	                                if ($action=="insert") {
						$this->dbi->insert_record("kms_isp_dns_recs",$dns_record,$dblink_cp,$dblink_erp);

					}
                        	}

			if ($delete) {

			//Add subdomains
//                        include "shared/db_links.php";
                       		 $this->trace("Add subdomains ...");
                       		 $select="SELECT * FROM kms_isp_subdomains WHERE vhost_id=".$_GET['xid'];
                       		 $res2=mysql_query($select,$dblink_cp);
                                while ($subdomain=mysql_fetch_assoc($res2)) {

                                $dns_record=array("dns_zone_id"=>$dns_zone_id,"type"=>"CNAME","host"=>$subdomain['name'].".".$domain.".","val"=>$servers['webserver']['hostname'].".","opt"=>"");
                                //insertem nomes en un lloc perque el onInsert ja replicara l'altre:
                                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                                $id_dns=$this->dbi->insert_record("kms_isp_dns_recs",$dns_record,$dblink_erp);
                                } else {
                                $id_dns=$this->dbi->insert_record("kms_isp_dns_recs",$dns_record,$dblink_cp);
                                }
                       //         $dns=new isp_dns($this->client_account,$this->user_account,$this->dm,1);
                         //       $dns->onInsert($dns_record,$id_dns);
                       		}
			}


			} else {
				//update serial
				$this->trace("Update DNS zone...");
				$data=array("serial"=>date('Ymdh'));
				$this->dbi->update_record("kms_isp_dns_zones",$data,"id=$dns_zone_id",$dblink_cp,$dblink_erp);
			}
		  //  } //delete


                        $this->trace("Building DNS zone...");
                        $dnszone=$this->dbi->get_record("select * from kms_isp_dns_zones where id=$dns_zone_id",$dblink_cp);
                        $dnszone_file    ="; *** This file is automatically generated by Intergrid KMS ***\n";
                        $dnszone_file   .="\$TTL\t".$dnszone['ttl']."\n";
                        $dnszone_file   .="\n";
                        $admin_email=substr($dnszone['email'],0,strpos($dnszone['email'],"@")); // part abans de l'arroba
                        $admin_email= str_replace(".","\.",$admin_email).".".substr($dnszone['email'],strpos($dnszone['email'],"@")+1);
                        $dnszone_file   .="@\tIN\tSOA\tns3.intergridnetwork.net. ".$admin_email.". (\n";
                        $dnszone_file   .="\t\t\t".$dnszone['serial']."\t; Serial\n"; //we should generate a new serial here?
                        $dnszone_file   .="\t\t\t".$dnszone['refresh']."\t; Refresh\n";
                        $dnszone_file   .="\t\t\t".$dnszone['retry']."\t; Retry\n";
                        $dnszone_file   .="\t\t\t".$dnszone['expire']."\t; Expire\n";
                        $dnszone_file   .="\t\t\t".$dnszone['minimum']." )\t; Minimum\n";
                        $dnszone_file   .="\n";
			$select="select * from kms_isp_dns_recs where dns_zone_id={$dns_zone_id} order by type desc,host";
                        $result=mysql_query($select,$dblink_cp);
                        while ($rec=mysql_fetch_array($result)) {

                                if ($rec['type']=="PTR") { $ptr=$rec; } else {
                                if ($rec['type']=="TXT") $rec['val']='"'.trim($rec['val']).'"';
				if (strpos($rec['val'],"DKIM")&&strlen($rec['val'])>251) {
						$parts = str_split($rec['val'], 251);
						$new_val="(";
						foreach ($parts as $part) {
							$new_val.=$part."\"\n\"";
						}
						$new_val=substr($new_val,0,strlen($new_val)-3).")";
						$rec['val']=$new_val;
				}


				if ($rec['type']=="SRV") {
					if ($rec['opt']=="") $rec['opt']="10 60 5060";
                                        $dnszone_file   .=$rec['host']."\t\t 86400 IN\tSRV ".$rec['opt']."\t".$rec['val']."\n";
                                } else {
					$dnszone_file   .=$rec['host']."\t\t IN ".$rec['type']."\t".$rec['opt']." ".$rec['val']."\n";
				}

                                }
                        }
                        $fp=fopen("/tmp/".$domain,"w");
                        fwrite($fp,$dnszone_file);
                        fclose($fp);
                        $this->trace("Creating physical named configuration...");
                        $named = "\nzone \"".$domain."\" {\n";
                        $named.= "\ttype master;\n";
                        $named.= "\tfile \"".$domain."\";\n";
                        $named.= "\tallow-transfer {\n";
                        $named.= "\t\t".$servers['nameserver1']['ip'].";\n";
                        $named.= "\t\t".$servers['nameserver2']['ip'].";\n";
                        $named.= "\t\tcommon-allow-transfer;\n";
                        $named.= "\t};\n";
                        $named.= "};\n";
                        $fp=fopen("/tmp/named_".$domain.".tmp","w");
                        fwrite($fp,$named);
                        fclose($fp);
                        //$this->trace("Reverse zone...");
			if ($ptr['val']!="") {
	                        $ptr_tmp="217\t\t IN PTR\t ".trim($ptr['val'])."\n";
	                        $fp=fopen("/tmp/named_".$domain."_reverse.tmp","w");
	                        fwrite($fp,$ptr_tmp);
	                        fclose($fp);
			}
			// define secondary slave config file
			$fp=fopen("/tmp/named2_".$domain.".tmp","w");
			$named="zone \"".$domain."\" { type slave; file \"slaves/".$domain."\"; masters { ".$servers['nameserver1']['ip']."; }; };";
			fwrite($fp,$named);
                        fclose($fp);
			$this->_setupNameservers($domain,$servers);

                return $dns_zone_id;
        }

	function removeDNS($vhost,$dblinks) {
		include "shared/db_links.php";
//		if ($dblink_cp=="") include "shared/db_links.php";
		$servers=$this->getServers($vhost,"vhost");
		$command = "ssh -i /root/.ssh/id_rsa root@".$servers['nameserver1']." \"sed '/".$vhost['domain']."/,+8 d' /etc/named.conf > /tmp/named.conf\"  >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$command = "ssh -i /root/.ssh/id_rsa root@".$servers['nameserver1']." 'mv /tmp/named.conf /etc/named.conf'  >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$command = "ssh -i /root/.ssh/id_rsa root@".$servers['nameserver1']." 'rm /var/named/master/".$vhost['domain']."'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$this->_reloadNamed($servers['nameserver1']);	
		
		//secundari
		$command = "ssh -i /root/.ssh/id_rsa root@".$servers['nameserver2']." \"sed '/".$vhost['domain']."/$ d' /etc/named.conf > /tmp/named.conf\"  >> /var/log/kms/kms.log";
		$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$command = "ssh -i /root/.ssh/id_rsa root@".$servers['nameserver2']." 'mv /tmp/named.conf /etc/named.conf'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$command = "ssh -i /root/.ssh/id_rsa root@".$servers['nameserver2']." 'rm /var/named/slaves/".$vhost['domain']."'  >> /var/log/kms/kms.log";
                $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		$this->_reloadNamed($servers['nameserver2']);

		// database
		if ($vhost['dns_zone_id']!=0) {
			$this->dbi->delete_record("kms_isp_dns_zones","id='".$vhost['dns_zone_id']."'",$dblink_cp);
			$this->dbi->delete_record("kms_isp_dns_zones","id='".$vhost['dns_zone_id']."'",$dblink_erp);
			$this->dbi->delete_record("kms_isp_dns_recs","dns_zone_id='".$vhost['dns_zone_id']."'",$dblink_cp);
			$this->dbi->delete_record("kms_isp_dns_recs","dns_zone_id='".$vhost['dns_zone_id']."'",$dblink_erp);
		}
	}

	function getServers($vhost,$type) {
		if (!isset($this->dbi)) $this->dbi = new dataDBI();
		include_once "shared/db_links.php";
		if ($dblink_cp=="") include "shared/db_links.php";
		$servers=array();
                if ($type=="vhost") {
                        $servers["webserver"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=".$vhost['webserver_id'],$dblink_cp); 
                        $servers["mailserver"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=".$vhost['mailserver_id'],$dblink_cp); 
                        $servers["nameserver1"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=8",$dblink_cp); // ns4
                } else if ($type=="vhost_forwarding") {
                        $servers["webserver"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=".$vhost['webserver_id'],$dblink_cp);  
                        $servers["nameserver1"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=8",$dblink_cp); // ns4
                } else if ($type=="domain") {
                        $servers["nameserver1"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=8",$dblink_cp); // ns4
                } else if ($type=="full") {
                        $servers["webserver"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=".$vhost['webserver_id'],$dblink_cp); 
                        $servers["mailserver"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=".$vhost['mailserver_id'],$dblink_cp); 
                        $servers["nameserver1"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=8",$dblink_cp); // ns4
                } else if ($type=="dkim") {
			$servers["mailserver"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=".$vhost['mailserver_id'],$dblink_cp); 
                        $servers["nameserver1"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip,ipv6 from kms_isp_servers where id=8",$dblink_cp); // ns4

		}
                return $servers;

	}

        function getInstallServers($type) {

		if (!isset($this->dbi)) $this->dbi = new dataDBI();
		include "shared/db_links.php";
		// NOVA INSTALACIO
                // mes endavant podem comprovar taula _kms_isp_servers, espai i memoria disponible i 
                // determinar un servidor per instal.lar el client. De moment FIX.
                $servers=array();
                if ($type=="vhost") {
			$servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%CH%' and free='1'",$dblink_cp);
                        $servers["mailserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%MX%' and free='1'",$dblink_cp);
			$servers["nameserver1"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=8",$dblink_cp); // ns4
		} else if ($type=="vhost_forwarding") {
			$servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%CH%' and free='1'",$dblink_cp);
			$servers["nameserver1"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=8",$dblink_cp); // ns4
                } else if ($type=="domain") {
                        $servers["nameserver1"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=8",$dblink_cp); // ns4
                } else if ($type=="full"||$type=="kms") {
			$servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%CH%' and free='1'",$dblink_cp);
                        $servers["mailserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%MX%' and free='1'",$dblink_cp);
			$servers["nameserver1"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=1",$dblink_cp); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select hostname,ip from kms_isp_servers where id=8",$dblink_cp); // ns4
		}
                return $servers;
        }


	function onPreInsert ($post) {
		$vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'");
		//format
		if ($post['type']=="NS"||$post['type']=="A"||$post['type']=="AAAA"||$post['type']=="CNAME"||$post['type']=="MX"||$post['type']=="SRV") {
                        if ($post['host']!="") $post['host']=$post['host'].".".$vhost['name']."."; else $post['host']=$vhost['name'].".";
			if ($post['type']=="NS"||$post['type']=="CNAME"||$post['type']=="MX"||$post['type']=="SRV") {
                                $post['val']=trim($post['val']).".";
                        }
                }
                if ($post['type']=="PTR") {
                        $post['host']=$post['host']."/".$post['PTR_mask'];
                        $post['val']=trim($post['val']).".".$vhost['name'];

                }
                if ($post['type']=="TXT") {
                        if ($post['host']=="") $post['host']=$vhost['name']."."; else $post['host']=trim($post['host']).".".$vhost['name'].".";
                }
		return $post; // pass post to onInsert
	}

      function onPreUpdate ($post) {
                $vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts WHERE id='".$_GET['xid']."'");
                if ($post['type']=="NS"||$post['type']=="A"||$post['type']=="AAAA"||$post['type']=="CNAME"||$post['type']=="MX"||$post['type']=="SRV") {
                        if ($post['host']!="") $post['host']=$post['host'].".".$vhost['name']."."; else $post['host']=$vhost['name'].".";
                        if ($post['type']=="NS"||$post['type']=="CNAME"||$post['type']=="MX"||$post['type']=="SRV") {
                                $post['val']=trim($post['val']).".";
                        }
                }
                if ($post['type']=="PTR") {
                        $post['host']=$post['host']."/".$post['PTR_mask'];
                        $post['val']=trim($post['val']).".".$vhost['name'];

                }
		if ($post['type']=="TXT") {
			if ($post['host']=="") $post['host']=$vhost['name']."."; else $post['host']=trim($post['host']).".".$vhost['name'].".";
		}
                return $post; // pass post to onUpdate
        }


        function onInsert ($post,$id) {
		if (!isset($this->dbi)) { $this->dbi = new dataDBI(); include "shared/db_links.php"; }
                include_once "shared/db_links.php";
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");
                //set the dns_zone_id to the new record added
                $this->trace("Configuring DNS records...");
                $vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid'],$dblink_cp);
                if ($vhost['dns_zone_id']==0||$vhost['dns_zone_id']=="") $this->_error("","DNS Zone not found for this domain!","fatal");
		$this->dbi->update_record("kms_isp_dns_recs",array("dns_zone_id"=>$vhost['dns_zone_id']),"id=$id",$dblink_cp);
                $dns_zone=$this->dbi->get_record("SELECT * FROM kms_isp_dns_zones where id=".$vhost['dns_zone_id'],$dblink_cp);
		$dns_rec=$this->dbi->get_record("SELECT * FROM kms_isp_dns_recs where id=$id",$dblink_cp);
		//replicar
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") { $this->dbi->insert_record("kms_isp_dns_recs",$dns_rec,$dblink_cp);
		} else { $this->dbi->insert_record("kms_isp_dns_recs",$dns_rec,$dblink_erp); }
                //update DNS records
                $this->trace("Configuring DNS zone...");
		$servers=$this->getInstallServers("vhost");
                $this->setupDNSzone($vhost['name'],$dns_zone['email'],$servers,"DNS,WEB,DB,MAIL,MAILING,CP,FTP,KMS",$dblink_cp,$dblink_erp,true);
        }

        function onUpdate ($post,$id) {
                include_once "shared/db_links.php";
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");
                //set the dns_zone_id to the new record added
                $this->trace("Configuring new DNS records...");
                $vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                if ($vhost['dns_zone_id']=="") $this->_error("","DNS Zone not found for this domain!","fatal");
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") $link=$dblink_erp; else $link=$dblink_cp;
                $dns_zone=$this->dbi->get_record("SELECT * FROM kms_isp_dns_zones where id=".$vhost['dns_zone_id']);
		$dns_rec=$this->dbi->get_record("SELECT * FROM kms_isp_dns_recs  where id=$id",$link);
//		print_r($post);echo "<br><br>";print_r($dns_rec);exit;
		$this->dbi->update_record("kms_isp_dns_recs",$dns_rec,"id=$id",$dblink_erp);
		$this->dbi->update_record("kms_isp_dns_recs",$dns_rec,"id=$id",$dblink_cp);
                //update DNS records
                $this->trace("Configuring DNS zone...");
                $servers=$this->getServers($vhost,"vhost");
		$this->setupDNSzone($vhost['name'],$dns_zone['email'],$servers,"DNS,WEB,DB,MAIL,MAILING,CP,FTP,KMS",$dblink_cp,$dblink_erp,true);
        }

        function onDelete ($post,$id) {
                include_once "shared/db_links.php";
                if ($_GET['xid']=="") $this->_error("","xid parameter is missing.","fatal");
                //set the dns_zone_id to the new record added
                $vhost=$this->dbi->get_record("SELECT * from kms_isp_hostings_vhosts where id=".$_GET['xid']);
                if ($vhost['dns_zone_id']=="") $this->_error("","DNS Zone not found for this domain!","fatal");
                $dns_zone=$this->dbi->get_record("SELECT * FROM kms_isp_dns_zones where id=".$vhost['dns_zone_id']);
                $this->dbi->delete_record("kms_isp_dns_recs","id=$id",$dblink_erp);
                $this->dbi->delete_record("kms_isp_dns_recs","id=$id",$dblink_cp);
                //update DNS records
                $this->trace("Configuring DNS zone...");
                $servers=$this->getServers($vhost,"vhost");
                $this->setupDNSzone($vhost['name'],$dns_zone['email'],$servers,"DNS,WEB,DB,MAIL,MAILING,CP,FTP,KMS",$dblink_cp,$dblink_erp,true);
        }

}
?>
