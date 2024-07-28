<?
$sr_user_id=$this->dm->user_account['id'];
if ($sr_user_id=="") die('add_domain : invalid user');

include "/usr/local/kms/lib/mod/shared/db_links.php";

include "/usr/local/kms/lib/mod/erp_contracts_providers.php";
if ($_GET['domain']!="") {
		$_GET['domain']=str_replace("www.","",strtolower($_GET['domain']));
		//PROCEDIM A REGISTRAR EL DOMINI DES DEL PANELL DE CONTROL
		$domain=new isp_domains($this->client_account,$this->user_account,$this->dm,1);
		$isp_client=$this->dbi->get_record("SELECT * FROM kms_isp_clients where sr_user=".$this->dm->user_account['id']);

                //2. Creem contracte a erp_contracts
		$service_id=$domain->getServiceID($_REQUEST['tld']);
		if ($_POST['period']=="") $_POST['period']="1Y";
		//busquem tarifa a aplicar
//		$count_domains=$this->dbi->get_record("SELECT COUNT(*) FROM kms_isp_domains WHERE sr_client='".$isp_client['sr_client']."' AND name LIKE '%.".$_REQUEST['tld']."'");
		$count_domains=$this->dbi->get_record("SELECT COUNT(*) FROM kms_isp_domains WHERE sr_client='".$isp_client['sr_client']."' AND (status='LOCK' OR status='ACTIVE')");
		$service_limit=$this->dbi->get_record("SELECT * FROM kms_ecom_services_limits WHERE unit='dominis' AND service=".$service_id." AND from_value<=".$count_domains[0]." AND to_value>=".$count_domains[0]);
		$price=$service_limit['price'];

		$contract=array("creation_date"=>date('Y-m-d'),"status"=>"active","sr_client"=>$isp_client['sr_client'],"sr_ecom_service"=>$service_id,"initial_date"=>date('Y-m-d H:i:s'),"end_date"=>date('Y-m-d H:i:s'),"billing_period"=>$_POST['period'],"auto_renov"=>"1","domain"=>$_GET['domain'].".".$_REQUEST['tld'],"description"=>$_GET['domain'].".".$_REQUEST['tld'],"price"=>$price,"payment_method"=>3,"invoice_pending"=>1);
                $id=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_erp);
                //1. De moment enviem peticio manual per registrar domini
		$subject="[KMS ISP | Domains] Sol.licitud de registre de domini ".$_GET['domain'];$op="registrar";
		
                if ($_REQUEST['authcode']!="") { $subject." : Transfer IN"; $op="transferir"; $subject="Sol.licitud de transferencia a Intergrid de domini ".$_GET['domain'].".".$_REQUEST['tld']; }
                $body="Cal $op el domini <b>".$_GET['domain'].".".$_REQUEST['tld']."</b><br>No us oblideu de posar el domini a status a 'actiu'  a la intranet<br><br>Contracte Num.: <b>".$id."</b><br>";
		$body.="<br><br>Hide whois info : ".$_POST['hide_whois_info']."<br>";
		if ($_POST['intented_use']!="") $body.="Intended use : ".$_POST['intented_use']."<br><br>";
		//contactes
		$body.="<br><b>CONTACTES:</b><br>";
		$body.="<table border=1 style='padding:5px;border-collapse:collapse'>";
		$body.= "<tr><td colspan=2><b>"._KMS_ISP_DOMAINS_OWNERC."</b> :<br><br></td></tr>";
		$body.= "<tr><td width='200'>"._KMS_GL_FULLNAME."</td><td>".$_POST['ownerc_fullname']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_ORGANIZATION."</td><td>".$_POST['ownerc_organization']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_ADDRESS."</td><td>".$_POST['ownerc_address']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_POSTALCODE."</td><td>".$_POST['ownerc_zipcode']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_LOCATION."</td><td>".$_POST['ownerc_city']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_COUNTRY."</td><td>".$_POST['adminc_country']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_PHONE."</td><td>".$_POST['ownerc_phone']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_FAX."</td><td>".$_POST['ownerc_fax']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_EMAIL."</td><td>".$_POST['ownerc_email']."</td></tr>";
		if ($_POST['custom_contacts']=="on") {	
		$body.= "<tr><td colspan=2><hr><b>"._KMS_ISP_DOMAINS_ADMINC."</b> :<br><br></td></tr>";
		$body.= "<tr><td>"._KMS_GL_FULLNAME."</td><td>".$_POST['adminc_fullname']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_ORGANIZATION."</td><td>".$_POST['adminc_organization']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_ADDRESS."</td><td>".$_POST['ownerc_address']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_POSTALCODE."</td><td>".$_POST['adminc_zipcode']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_LOCATION."</td><td>".$_POST['adminc_city']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_COUNTRY."</td><td>".$_POST['adminc_country']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_PHONE."</td><td>".$_POST['adminc_phone']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_FAX."</td><td>".$_POST['adminc_fax']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_EMAIL."</td><td>".$_POST['adminc_email']."</td></tr>";
		$body.= "<tr><td colspan=2><hr><b>"._KMS_ISP_DOMAINS_TECHC."</b> :<br><br> </td></tr>";
		$body.= "<tr><td>"._KMS_GL_FULLNAME."</td><td>".$_POST['techc_fullname']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_ORGANIZATION."</td><td>".$_POST['techc_organization']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_POSTALCODE."</td><td>".$_POST['techc_zipcode']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_LOCATION."</td><td>".$_POST['techc_city']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_COUNTRY."</td><td>".$_POST['adminc_country']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_PHONE."</td><td>".$_POST['techc_phone']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_FAX."</td><td>".$_POST['techc_fax']."</td></tr>";
		$body.= "<tr><td>"._KMS_GL_EMAIL."</td><td>".$_POST['techc_email']."</td></tr>";
		}
		$body.= "</table>";

                if ($_REQUEST['authcode']!="") $body.="<br>AuthCode : <b>".htmlentities($_REQUEST['authcode'])."</b><br><br>";
                $this->emailNotify($subject,$body,"kms@intergrid.cat","registres@intergrid.cat");
                //3. Creem contracte proveidor a erp_contracts_providers 
		$contract_provider=new erp_contracts_providers($this->client_account,$this->user_account,$this->dm, 1);
		$contract_id=$contract_provider->add(array("creation_date"=>$contract['creation_date'],"description"=>$_GET['domain'],"family"=>"DOMINI","billing_period"=>$_POST['period']));

                //4. Creem domini a isp_domains
		$this->existeix=$domain->checkExists($_GET['domain'],$contract['sr_client']);
                if (!$this->existeix) {
		                switch ($_POST['period']) {
	                        case "1Y"   :  $add_time = '+1 year';break;
	                        case "2Y"   :  $add_time = "+2 years";break;
	                        case "3Y"   :  $add_time = "+3 years";break;
	                        case "4Y"   :  $add_time = "+4 years";break;
	                        case "5Y"   :  $add_time = "+5 years";break;
	                        case "6Y"   :  $add_time = "+6 years";break;
	                        case "7Y"   :  $add_time = "+7 years";break;
	                        case "8Y"   :  $add_time = "+8 years";break;
	                        case "9Y"   :  $add_time = "+9 years";break;
                	        case "10Y"  :  $add_time = "+10 years";break;
		                }

                                $domini=array("creation_date"=>$contract['creation_date'],"updated_date"=>date('Y-m-d H:i:s'),"expiration_date"=>date('Y-m-d'),"sr_client"=>$contract['sr_client'],"sr_contract"=>$id,"status"=>"PENDING","registrar"=>"INTERGRID.OP","name"=>$_GET['domain'].".".$_REQUEST['tld'],"nameserver1"=>"ns3.intergridnetwork.net","nameserver2"=>"ns4.intergridnetwork.net","sr_ownerc"=>$contract['sr_client'],"sr_adminc"=>$contract['sr_client'],"sr_techc"=>1,"sr_zonec"=>1,"auto_renew"=>1,"authcode"=>mysql_escape_string(urldecode($_REQUEST['authcode'])));
				                //owner
		                $domini["ownerc_fullname"]=$isp_client['contacts'];
		                $domini["ownerc_organization"]=$isp_client['name'];
		                $domini["ownerc_address"]=$isp_client['address'];
		                $domini["ownerc_postalcode"]=$isp_client['zipcode'];
		                $domini["ownerc_city"]=$isp_client['location'];
		                $domini["ownerc_country"]=$isp_client['country'];
		                $domini["ownerc_state"]=$isp_client[''];
		                $domini["ownerc_phone"]=$isp_client['phone'];
		                $domini["ownerc_fax"]=$isp_client['fax'];
		                $domini["ownerc_email"]=$isp_client['email'];
		                //admin
		                $domini["adminc_fullname"]=$isp_client['contacts'];
		                $domini["adminc_organization"]=$isp_client['name'];
		                $domini["adminc_address"]=$isp_client['address'];
		                $domini["adminc_postalcode"]=$isp_client['zipcode'];
		                $domini["adminc_city"]=$isp_client['location'];
		                $domini["adminc_country"]=$isp_client['country'];
		                $domini["adminc_state"]=$isp_client[''];
		                $domini["adminc_phone"]=$isp_client['phone'];
		                $domini["adminc_fax"]=$isp_client['fax'];
		                $domini["adminc_email"]=$isp_client["registres@intergrid.cat"];
		                //tech
		                $domini["techc_fullname"]=$isp_client["Intergrid SL"];
		                $domini["techc_organization"]=$isp_client["Intergrid SL"];
		                $domini["techc_address"]=$isp_client["Carrer d'En Roig, 15 local"];
		                $domini["techc_postalcode"]=$isp_client["08001"];
		                $domini["techc_city"]=$isp_client["Barcelona"];
		                $domini["techc_country"]=$isp_client["ES"];
		                $domini["techc_state"]=$isp_client["Catalunya"];
		                $domini["techc_phone"]=$isp_client["+34-934426787"];
		                $domini["techc_fax"]=$isp_client["+34-934439639"];
		                $domini["techc_email"]=$isp_client["registres@intergrid.cat"];

                                $this->dbi->insert_record("kms_isp_domains",$domini,$dblink_cp,$dblink_erp);
                } else {
/*                                $domini=array("updated_date"=>$contract['creation_date'],"expiration_date"=>date('Y-m-d', strtotime("+1 year")),"sr_client"=>$contract['sr_client'],"sr_contract"=>$id,"status"=>"LOCK","registrar"=>"INTERGRID.INTERNETX","name"=>$_GET['domain'],"nameserver1"=>"ns3.intergridnetwork.net","nameserver2"=>"ns4.intergridnetwork.net","sr_ownerc"=>$contract['sr_client'],"sr_adminc"=>$contract['sr_client'],"sr_techc"=>1,"sr_zonec"=>1,"auto_renew"=>1);
                                $this->dbi->update_record("kms_isp_domains",$domini,"name='".$domain['domain']."'");*/
                }

	//return back
	echo "<script>document.location='/?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b';</script>";

} else {

// APPLICATION FORM

if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
	//include "domains/new.php";
	include "domains/index.php";
} else {
	include "domains/index.php";
}

}?>
