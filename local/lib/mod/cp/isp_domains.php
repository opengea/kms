<?

// ----------------------------------------------
// Class ISP Domains for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

/*require '/usr/local/kms/mod/isp/domains/openprovider/app/Config/cfg.inc.php';
require '/usr/local/kms/mod/isp/domains/openprovider/vendor/autoload.php';

use App\Modules\Customer;
use App\Modules\Domain;
use App\Modules\Email;
use App\Modules\EmailTemplates;
use App\Modules\Nameserver;
*/
class isp_domains extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_domains";
	var $key	= "id";	
	var $fields = array("creation_date","expiration_date","status","auto_renew","dns_zone_id","sr_client","hosting_id");
	var $fields_search = array("creation_date","name");
//	var $excludeBrowser = array("name");
	var $readonly = array("sr_ownerc","sr_adminc","sr_techc","sr_zonec","hosting_id","expiration_date","sr_entity","sr_client","name","creation_date","updated_date","authcode");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $hidden=array("zonec_fullname","zonec_organization","zonec_address","zonec_postalcode","zonec_city","zonec_country","zonec_state","zonec_phone","ownerc_fax","adminc_fax","techc_fax","zonec_fax","zonec_email","sr_ownerc","sr_adminc","sr_techc","sr_zonec","vr_limits","vr_services","comments","active_date","renewal_date","registrar_id","registrar_owner_handle","registrar_billing_handle","registrar_admin_handle","registrar_tech_handle");
	var $notedit=array("zonec_fullname","zonec_organization","zonec_address","zonec_postalcode","zonec_city","zonec_country","zonec_state","zonec_phone","zonec_fax","zonec_email","sr_ownerc","sr_adminc","sr_techc","sr_zonec","authcode","hosting_id","expiration_date","dr_folder","client_id","sr_entity","sr_client","creation_date","updated_date","dns_zone_id","sr_contract","comments","vr_limits","vr_services");
	var $mandatory=array("ownerc_fullname","ownerc_address","ownerc_postalcode","ownerc_city","ownerc_phone","ownerc_fax","ownerc_email","ownerc_country","adminc_fullname","adminc_address","adminc_postalcode","adminc_city","adminc_phone","adminc_email","adminc_country");
        /*=[ PERMISSIONS ]===========================================================*/

	var $can_gohome = true;
	var $can_view = false;
	var $can_edit = true;
	var $can_delete = false;
	var $can_add   = false;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function isp_domains($client_account,$user_account,$dm) { //,$silent) {

		if (!$silent) {
                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysql_query($select);
                if (!$result) die(mysql_error($result));
                $client=mysql_fetch_array($result);
		$this->setComponent("domain_name","name");

                if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat")  {
			$this->can_edit=true;
			$this->notedit=array("hosting_id","_folder","client_id","sr_entity","creation_date","updated_date","dns_zone_id","sr_contract");
			$this->readonly=array("name","creation_date","updated_date","hosting_id","sr_entity");
			$this->fields = array("creation_date","status","expiration_date","registrar", "auto_renew","dns_zone_id","sr_client","hosting_id");
			$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_isp_clients","xkey"=>"sr_client","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"orderby"=>"name","sql"=>"select sr_client,name from kms_isp_clients"));
                } else if ($this->_group_permissions(3,$user_account['groups'])) { //reseller
                        $this->can_edit=true;
			$this->fields = array("creation_date","status","expiration_date","auto_renew","sr_client","dns_zone_id","hosting_id");
                        $this->readonly = array("sr_ownerc","sr_adminc","sr_techc","sr_zonec","hosting_id","expiration_date","sr_entity","name","creation_date","updated_date","authcode");
                        $this->notedit=array("zonec_fullname","zonec_organization","zonec_address","zonec_postalcode","zonec_city","zonec_country","zonec_state","zonec_phone","zonec_fax","zonec_email","sr_ownerc","sr_adminc","sr_techc","sr_zonec","authcode","hosting_id","expiration_date","dr_folder","client_id","sr_entity","creation_date","updated_date","dns_zone_id","sr_contract","comments");
		//$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_isp_clients","xkey"=>"sr_client","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select sr_client,name from kms_isp_clients where sr_provider=".$client['sr_client']));
			 $this->setComponent("xcombo","sr_client",array("xtable"=>"kms_isp_clients","xkey"=>"sr_client","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"orderby"=>"name","sql"=>"select sr_client,name from kms_isp_clients where sr_provider=".$client['sr_client']));
			$this->where = "kms_isp_domains.sr_client in (select kms_isp_clients.sr_client from kms_isp_clients where kms_isp_clients.sr_provider=".$client['sr_client'].")";
			array_push($this->notedit,"registrar");
                } else  {
			if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");

			$this->fields = array("creation_date", "status", "expiration_date", "auto_renew","dns_zone_id","hosting_id");
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                        $this->where = "sr_client=".$client['sr_client'];
			array_push($this->notedit,"registrar");
                }
		}
		if ($_GET['debug']==1) echo $this->where;
		$this->setGroup("_KMS_ISP_DOMAINS_RENEW_OPTIONS",false,array("status","expiration_date","auto_renew","renew_years","authcode"));
                $this->setGroup("_KMS_ISP_DOMAINS_NAMESERVERS",true,array("nameserver1","nameserver2","nameserver3","nameserver4"));
		$this->setGroup("_KMS_ISP_DOMAINS_OWNERC",true,array("ownerc_fullname","ownerc_organization","ownerc_address","ownerc_postalcode","ownerc_city","ownerc_country","ownerc_state","ownerc_fax","ownerc_email","ownerc_phone"));
		$this->setGroup("_KMS_ISP_DOMAINS_ADMINC",true,array("adminc_fullname","adminc_organization","adminc_address","adminc_postalcode","adminc_city","adminc_country","adminc_state","adminc_fax","adminc_email","adminc_phone"));
		$this->setGroup("_KMS_ISP_DOMAINS_TECHC",true,array("techc_fullname","techc_organization","techc_address","techc_postalcode","techc_city","techc_country","techc_state","techc_fax","techc_email","techc_phone"));

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		include "/usr/local/kms/tpl/panels/isp_domains.php";
		$this->page_rows = 100;

		$isp_client=$this->dbi->get_record("select * from kms_isp_clients where sr_user=".$user_account['id'],$dblink_cp);
                $this->setComponent("domain_name","name");
		//dades per defecte
		$this->defvalue("ownerc_fullname",$isp_client['contacts']);
		$this->defvalue("ownerc_organization",$isp_client['name']);
		$this->defvalue("ownerc_address",$isp_client['address']);
		$this->defvalue("ownerc_postalcode",$isp_client['zipcode']);
		$this->defvalue("ownerc_city",$isp_client['location']);
		$this->defvalue("ownerc_country",$isp_client['country']);
		$this->defvalue("ownerc_state",$isp_client['']);
		$this->defvalue("ownerc_phone",$isp_client['phone']);
		$this->defvalue("ownerc_fax",$isp_client['fax']);
		$this->defvalue("ownerc_email",$isp_client['email']);
	
		//dades per defecte
                $this->defvalue("adminc_fullname",$isp_client['contacts']);
                $this->defvalue("adminc_organization",$isp_client['name']);
                $this->defvalue("adminc_address",$isp_client['address']);
                $this->defvalue("adminc_postalcode",$isp_client['zipcode']);
                $this->defvalue("adminc_city",$isp_client['location']);
                $this->defvalue("adminc_country",$isp_client['country']);
                $this->defvalue("adminc_state",$isp_client['']);
                $this->defvalue("adminc_phone",$isp_client['phone']);
                $this->defvalue("adminc_fax",$isp_client['fax']);
                $this->defvalue("adminc_email",$isp_client['email']);

                if ($isp_client['status']!="blocked") {
			$this->customButtons=Array();
			$this->customButtons[0] = Array ("label"=>_KMS_ISP_DOMAINS_ADD,"url"=>"","ico"=>"pdf.gif","params"=>"action=add_domain","target"=>"_self","checkFunction"=>"","class"=>"highlight");
			$this->action("add_domain","/usr/local/kms/mod/isp/domains/index.php");
		} else {
                        $this->can_delete=false;
                }

                $this->action("enable_services","/usr/local/kms/mod/isp/domains/enable_services.php");
		// ------------

		$this->humanize("hosting_id",_KMS_ISP_DOMAINS_SERVICES);
		$this->addComment("intended_use",_KMS_ISP_DOMAINS_MUSTCAT);	
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {  $this->humanize("sr_contract","# Contracte (domini)"); }
		
		$this->setstyle("hosting_id","width:50px");
		if ($_GET['_']=="b") $this->humanize("status",_KMS_ISP_DOMAINS_NAME);	
		if ($_GET['_']=="e"&&$_GET['id']!="") {
			$domain=$this->dbi->get_record("SELECT status FROM kms_isp_domains where id=".$_GET['id']);
			if ($domain['status']=="ACTIVE"||$domain['status']=="LOCK") {
				$this->setComponent("select","status",array("LOCK"=>"<font color='#090'><b>"._KMS_ISP_DOMAINS_STATUS_LOCK."</b></font>","ACTIVE"=>"<font color='#090'><b>"._KMS_ISP_DOMAINS_STATUS_ACTIVE."</b></font>"));	
				if ($this->_group_permissions(1,$user_account['groups']))  {
					$this->setComponent("uniselect","status");
				}
			} else {	
				if ($_GET['app']!="cp-admin"&&$_GET['app']!="sysadmin") array_push($this->readonly,"status"); else $this->setComponent("uniselect","status",true);
			}
		}
		$this->setComponent("uniselect","registrar");

		$this->defvalue("autorenew","1");
//		$this->defvalue("private_whois","1");
		$this->defvalue("nameserver1","ns3.intergridnetwork.net");
		$this->defvalue("nameserver2","ns4.intergridnetwork.net");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		include "/usr/local/kms/lib/include/countries.php";
		$this->setComponent("select","ownerc_country",$countries);
		$this->setComponent("select","adminc_country",$countries);
		$this->setComponent("select","techc_country",$countries);
		$this->setComponent("select","zonec_country",$countries);
		//($xcombo_field,$xcombo_sql,$show,$value,$open)
                if ($_GET['app']!="cp"||$this->_group_permissions(3,$user_account['groups'])) {
//                $this->setComponent("xcombo","sr_client",array("xtable"=>"kms_isp_clients","xkey"=>"sr_client","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
                }
		if ($this->_group_permissions(1,$user_account['groups'])) $this->can_delete=true;
		$this->humanize("dns_zone_id","DNS");
		$this->insert_label = _KMS_ISP_DOMAINS_ADD;
		$this->setComponent("checklist","auto_renew",array("1"=>""));
		$this->setComponent("checklist","private_whois",array("1"=>""));

        $xsql=array("xv_xtable"=>"kms_isp_hostings", "xv_field"=>"hosting_id", "xv_xkey"=>"id", "xv_xfield"=>"max_space");
        $this->xvField("vr_limits",array("sql"=>$xsql));
        $xsql=array("xv_xtable"=>"kms_isp_hostings", "xv_field"=>"hosting_id", "xv_xkey"=>"id", "xv_xfield"=>"max_space");
        $this->xvField("vr_services",array("sql"=>$xsql));

	if ($_GET['_']!="e") $this->setComponent("status_icon", "status", array("script"=>"isp_domains_status","orderby"=>"name"));
	$this->setComponent("status_icon", "hosting_id", array("script"=>"isp_domains_services","show_label"=>false));
 	if ($_GET['_']!="e") $this->setComponent("status_icon", "auto_renew",  array("script"=>"isp_domains_autorenew","show_label"=>true));
	$this->setComponent("status_icon", "dns_zone_id", array("script"=>"isp_domains_dns","show_label"=>false));
	$this->alerts['delete']['msg']="Elimineu aquest domini nom&eacute;s en cas que ja no estigui registrat a Intergrid<br><br>Esteu segurs que voleu eliminar aquest domini?";
        $this->nowrap("number");
        $this->nowrap("creation_date");
	$this->humanize("creation_date",_KMS_DOMAINS_CR_DATE);
        //$this->action("email_invoice","/usr/local/kms/mod/erp/reports/report.php");
        $this->onInsert = "onInsert";
        $this->onUpdate ="onUpdate";
	$this->onPreUpdate="onPreUpdate";
	$this->onDelete ="onDelete";
	}

	function getServiceID($tld) {
		//segons families
                if ($tld=='cat') $service_id=1;
                else if ($tld=='com') $service_id=2;
                else if ($tld=='es') $service_id=3;
                else if ($tld=='tv') $service_id=12;
                else if ($tld=='net') $service_id=48;
                else if ($tld=='org') $service_id=49;
                else if ($tld=='biz') $service_id=50;
                else if ($tld=='info') $service_id=51;
                else if ($tld=='ch') $service_id=52;
                else if ($tld=='eu') $service_id=53;
		return $service_id;
	}

        function checkExists ($domini,$sr_client) {
                $domini=$this->dbi->get_record("select * from kms_isp_domains where name='".$domini."'");
                if ($domini['id']!="") {
                        if ($domini['sr_client']==$sr_client) return 1; else return 2;
                }
                return 0;
        }

	function onInsert ($post,$id) {
		// see /usr/local/kms/mod/isp/domains/add_domain.php
	}

	function onPreUpdate ($post,$id) {
                include "shared/db_links.php";
		$old_values=$this->dbi->get_record("select * from kms_isp_domains where id='".$post['id']."'");
		if ($old_values['status']=="PENDING"&&($post['status']=="ACTIVE"||$post['status']=="LOCK")) {
	                //Client notification on CHANGE from PENDING TO ACTIVE
			//idioma de client
			$isp_client=$this->dbi->get_record("select * from kms_isp_clients where sr_client=".$post['sr_client'],$dblink_erp);
			$case=true;
			require_once( '/usr/local/kms/lang/'.$isp_client['language'].".php");
	
	                $body=_KMS_MAIL_SENDCONFIG_SALUTATION."<br><br>".str_replace("DOMAIN.TLD","<b>".$post['name']."</b>",_KMS_ISP_DOMAINS_NOTIFY_REGISTER)."<br><br>"._KMS_ISP_DOMAINS_RENEW_YEARS.": ".$post['renew_years']."<br>"._KMS_ISP_DOMAINS_AUTO_RENEW.": ";
	                if ($post['auto_renew']) $body.=_KMS_GL_YES; else $body.=_KMS_GL_NO;
	                $body.="<br>"._KMS_ISP_DOMAINS_PRIVATE_WHOIS.": ";
	                if ($post['private_whois']) $body.=_KMS_GL_YES; else $body.=_KMS_GL_NO;
	                $body.="<br><br><b>"._KMS_ISP_DOMAINS_OWNERC."</b>:<br><br>"._KMS_GL_ORGANIZATION.": ".$this->u2h($post['ownerc_organization'])."<br>"._KMS_GL_FULLNAME.": ".$this->u2h($post['ownerc_fullname'])."<br>"._KMS_GL_ADDRESS.": ".$this->u2h($post['ownerc_address'])."<br>"._KMS_GL_LOCATION.": ".$this->u2h($post['ownerc_city'])."<br>"._KMS_GL_ZIPCODE.": ".$this->u2h($post['ownerc_postalcode'])."<br>"._KMS_GL_COUNTRY.": ".$this->u2h($post['ownerc_country'])."<br>"._KMS_GL_PHONE.": ".$post['ownerc_phone']."<br>"._KMS_GL_FAX.": ".$post['ownerc_fax']."<br>"._KMS_GL_EMAIL.": ".$post['ownerc_email']."<br><br><b>"._KMS_ISP_DOMAINS_NAMESERVERS."</b>:<br><br>"._KMS_DOMAIN_NAMES_NAMESERVER1.": ".$post['nameserver1']."<br>"._KMS_DOMAIN_NAMES_NAMESERVER2.": ".$post['nameserver2']."<br><br>"._KMS_INTERGRID_SUPPORT_SIGNATURE;
	                $from="registres@intergrid.cat";$to=$post['ownerc_email'];
	                $subject=str_replace("DOMAIN.TLD",$post['name'],_KMS_ISP_DOMAINS_NOTIFY_REGISTER_SUBJECT);
	         	$email = new Email($from,$to,$subject,$body,1);
	                $goodemail = $email->send();
		}

		$modificat=false;
		$camps_modificats=array();
		$exclude=array("creation_date","updated_date","expiration_date","sr_client","sr_contract","hosting_id","registrar","dns_zone_id","sr_ownerc","sr_adminc","sr_techc","sr_zonec");
		foreach ($old_values as $old_name => $old_val) {
			if (!is_numeric($old_name)&&!in_array($old_name,$exclude)) {
			if ($_POST[$old_name]!=$old_val) { $modificat=true;array_push($camps_modificats,$old_name); }
			}
		}

		// notificacio a registres modificacio domini
		if ($modificat) {
			$body="S'ha modificat el domini <b>".$post['name']."</b> des del panell de control.<br><br>Si us plau, actualitzeu les següents dades al Registrador tant aviat com sigui possible:<br><br>";
			foreach ($camps_modificats as $camp) {
		                $body.="{$camp} : <b>".$_POST[$camp]."</b> (antic valor: ".mysql_escape_string($old_values[$camp]).")<br>";
			}
	                $from="kms@intergrid.cat";$to="registres@intergrid.cat";
	                $subject="Domini ".$post['name']." modificat";
			if ($_POST['auto_renew']!=$old_values['auto_renew']) $subject.=" AUTORENEW CHANGED";	
	                $email = new Email($from,$to,$subject,$body,1);
	                $goodemail = $email->send();
	                if (!$goodemail) echo "failed sending email notification to admin.";
	                if ($post['sr_contract']==0) {
	                 //       $email = new Email($from,$to,"Domini sense contracte associat","Reviseu el domini <b>".$post['name']."</b>, no hi ha contracte associat.",1);
	                 //       $goodemail = $email->send();
			 //	  $update="update kms_isp_domains
	                } 
	                // afegir tasca 
	         /*       $task=array("start_date"=>date('Y-m-d H:i:s'),"creation_date"=>date('Y-m-d H:i:s'),"priority"=>2,"category"=>"3-domains","assigned"=>"3","sr_client"=>$post['sr_client'],"description"=>"MODIFICAR DOMINI ".$post['name'],"notes"=>$body,"origin"=>"control","status"=>"pendent");
	                $this->dbi->insert_record("kms_planner_tasks",$task,$dblink_erp);*/
			$tld=substr($post['name'],strrpos($post['name'],".")+1);
                        $domain_name=trim(substr($post['name'],0,strrpos($post['name'],".")));
			$post['nameserver1']=trim($post['nameserver1']);
			$post['nameserver2']=trim($post['nameserver2']);
                        $post['nameserver3']=trim($post['nameserver3']);
                        $post['nameserver4']=trim($post['nameserver4']);

        		$curlOb = curl_init();
		        curl_setopt($curlOb, CURLOPT_URL,"https://control.intergridnetwork.net/kms/lib/isp/domains/update_domain.php");
		        curl_setopt($curlOb, CURLOPT_POST, 1); 
		        curl_setopt($curlOb, CURLOPT_POSTFIELDS, array("domain_name"=>$domain_name,"tld"=>$tld,"nameserver1"=>$post['nameserver1'],"nameserver2"=>$post['nameserver2'],"nameserver3"=>$post['nameserver3'],"nameserver4"=>$post['nameserver4'],"auto_renew"=>$_POST['auto_renew'],"private_whois"=>$post['private_whois']));
		        curl_exec ($curlOb);
		        curl_close ($curlOb);
		//	if ($response['status']!="ACT") { $post['status']="PENDING"; die('<br><b>&nbsp;&nbsp;Error. No se ha podido cambiar el estado del dominio. Póngase en contacto con nostros.'); }
			return $post;
	}
	}

	function onUpdate ($post,$id) {
		include "shared/db_links.php";
		$post=$this->dbi->get_record("select * from kms_isp_domains where id={$id}");
		//replicate
		//$post=$this->filter_fields($post);
		$post['updated_date']=date('Y-m-d H:i:s');
		$this->dbi->update_record("kms_isp_domains",$post,"name='".$post['name']."'",$dblink_cp,'',true);
                $this->dbi->update_record("kms_isp_domains",$post,"name='".$post['name']."'",$dblink_erp);
		//update contract
		$contract=array("auto_renov"=>$post['auto_renew'],"billing_period"=>$post['renew_years']."Y");
		if ($this->_group_permissions(3,$user_account['groups'])) { //reseller
			$contract=array("auto_renov"=>$post['auto_renew'],"billing_period"=>$post['renew_years']."Y","sr_client"=>$post['sr_client']);
		}
		//echo "id=".$post['sr_contract'];exit;	
		$this->dbi->update_record("kms_erp_contracts",$contract,"id=".$post['sr_contract'],$dblink_erp);
		$this->dbi->update_record("kms_erp_contracts",$contract,"id=".$post['sr_contract'],$dblink_cp);


	}

	function onDelete ($post,$id) {
		include "shared/db_links.php";
		if ($_GET['app']=="sysadmin") $this->dbi->delete_record("kms_isp_domains","id={$id}",$dblink_cp);	
		else if ($this->_group_permissions(1,$user_account['groups'])) $this->dbi->delete_record("kms_isp_domains","id={$id}",$dblink_erp);

	}

}
?>
