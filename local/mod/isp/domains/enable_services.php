<?
//Definiciio de conexions Mysql
include "/usr/local/kms/lib/mod/shared/db_links.php";


$sel="select * from kms_isp_domains where id=".$_GET['id'];
$res=mysql_query($sel,$dblink_cp);
$dom=mysql_fetch_array($res);

$sel="select * from kms_isp_clients where sr_client=".$dom['sr_client'];
$res=mysql_query($sel,$dblink_cp);
$client=mysql_fetch_array($res);


if ($_POST['activate']==1) {
// ACTIVATION
$this->trace("Enabling services, please wait....");
//$ins="INSERT INTO kms_isp_dns_zones"
//$ins="insert into kms_isp_hostings_vhosts (creation_date,hosting_id,isp_client_id,sr_client,status,name,type,webserver_id,mailserver_id,dns_zone_id,max_space,max_transfer) VALUES ()"

                        // Determine servers to install

			// Create DNS ZONE
			$dns=new isp_dns($this->client_account,$this->user_account,$this->dm,1);
			$servers=$dns->getInstallServers("vhost_forwarding");
                        $dns_zone_id=$dns->setupDNSzone($dom['name'],$client['email'],$servers,"DNS,WEB,CP",$dblink_cp,$dblink_erp);
                        // Create SERVICE (vhost) amb hosting_id=0 (sense hosting)
                        $vhost=array("creation_date"=>date('Y-m-d H:i:s'),"hosting_id"=>0,"sr_client"=>$client['sr_client'],"isp_client_id"=>$client['id'],"status"=>"active","name"=>$dom['name'],"type"=>"cloud","webserver_id"=>$servers['webserver']['id'],"mailserver_id"=>0,"dns_zone_id"=>$dns_zone_id,"max_space"=>0,"max_transfer"=>0);
                        $vhost_id=$this->dbi->insert_record("kms_isp_hostings_vhosts",$vhost,$dblink_cp,$dblink_erp);

                        //3. Creem el vhost fisic
 //                       $this->trace("Creant hosting f&iacute;sic...");
//			$this->trace("Creanting phisical vhost...");
//                        $command = "ssh -i /root/.ssh/id_rsa root@a1.intergridnetwork.net '/usr/local/kms/mod/isp/setup/create_vhost.sh ".$dom['name']." ".$server_ip." ".$this->user_account['username']." ".$ftp['password']."'";
//                        $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
                        // Reload de serveis httpd
                        //$this->reloadNamed("cp.intergridnetwork.net");
                        //$this->ssh_exec("localhost","ssh -i /root/.ssh/id_rsa root@a1.intergridnetwork.net service httpd reload","JADF7320cSJdcj3750492x42dj244");
			$post=array();
                        $post['tld']=substr($dom['name'],strrpos($dom['name'],".")+1);
                        $post['domain_name']=trim(substr($dom['name'],0,strrpos($dom['name'],".")));


                        $post['nameserver1']="ns3.intergridnetwork.net";
                        $post['nameserver2']="ns4.intergridnetwork.net";
                        $post['nameserver3']="";
                        $post['nameserver4']="";
			$post['auto_renew']=$dom['auto_renew'];
			$post['private_whois']=$dom['private_whois'];

                        $curlOb = curl_init();
                        curl_setopt($curlOb, CURLOPT_URL,"https://control.intergridnetwork.net/kms/lib/isp/domains/update_domain.php");
                        curl_setopt($curlOb, CURLOPT_POST, 1);
                        curl_setopt($curlOb, CURLOPT_POSTFIELDS, array("domain_name"=>$post['domain_name'],"tld"=>$post['tld'],"nameserver1"=>$post['nameserver1'],"nameserver2"=>$post['nameserver2'],"nameserver3"=>$post['nameserver3'],"nameserver4"=>$post['nameserver4'],"auto_renew"=>$post['auto_renew'],"private_whois"=>$post['private_whois']));
                        curl_exec ($curlOb);
                        curl_close ($curlOb);

                        //5. Notificacio
                        $subject="[KMS ISP ] Serveis activats per al domini ".$dom['name'];
                        $body="Domini <b>".$dom['name']."</b><br>Client: ".$dom['sr_client'];
                        $this->emailNotify($subject,$body);
?>
			<script>document.location="/?app=<?=$_GET['app']?>&mod=<?=$_GET['mod']?>&_=b&xid=<?=$_GET['xid']?>&from=<?=$_GET['from']?>&panelmod=<?=$_GET['panelmod']?>";</script>
<?

} else {
// FORM ?> 
<h2><?=_KMS_ISP_DOMAINS_SERVICES_TITLE?>: <?=$dom['name']?></h2>
<?=str_replace("[DOMAIN]",$dom['name'],_KMS_ISP_DOMAINS_SERVICES_EXPLAIN)?>
<br>
<? if (strpos($dom['nameserver1'],"intergridnetwork.net")==0) echo "<br><div class='warn'>"._KMS_ISP_DOMAINS_SERVICES_DNS_WARNING."</div>"; ?>
<br>
<br>

<form method="POST">
<input type="hidden" name="activate" value="1">
<input class="customButton highlight" type="submit" name="submit" value="<?=_KMS_ISP_DOMAINS_SERVICES_BUT?>" style="cursor:pointer;cursor:hand">
&nbsp;&nbsp;
<input class="customButton" type="button" value="<?=_404_RTS?>" style="cursor:pointer;cursor:hand" onclick="document.location='/?app=<?=$_GET['app']?>&mod=isp_domains'">
</form>
<? } ?>
