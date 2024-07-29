<?

// ----------------------------------------------
// Class ERP Contracts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

include "/usr/local/kms/lib/mod/isp_domains.php";
if ($_GET['mod']!="isp_hostings") include "/usr/local/kms/lib/mod/isp_hostings.php";
include "/usr/local/kms/lib/mod/isp_servers.php";
include_once "/usr/local/kms/lib/mod/erp_contracts_providers.php";

class erp_contracts extends mod {

	/*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_contracts";
	var $key	= "id";	
	var $fields 	= array("id", "status", "auto_renov", "sr_client", "sr_ecom_service","description","price","price_discount_pc", "initial_date","end_date","billing_period","payment_method");
	var $sum 	= array("price");
	var $title 	= "Contractes";
	var $orderby 	= "initial_date";
	var $sortdir 	= "desc";
	var $notedit 	= array("initial_date","end_date");
	var $default_content_type = "contracts";
        var $ts_format  = "XXm/d/Y h:i A";
	var $page_rows = 50;
        var $insert_label = _KMS_ERP_NEW_CONTRACT;
        var $customOptions = Array();
        var $iam = "erp_contracts";

	/*=[ PERMISSIONS ]===========================================================*/

	var $can_view 	= false;
	var $can_edit 	= true;
	var $can_delete = true;
	var $can_add   	= true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;
        var $can_print  = true;
	var $can_duplicate = true;
       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_contracts($client_account,$user_account,$dm) {
        	parent::mod($client_account,$user_account,$extranet);
	}

	function setup($client_account,$user_account,$dm) {
	if ($_GET['_']=="e")  {  $this->notedit=array();  $this->hidden=array("hosting_id","alta","new_hosting","new_vhost","authcode");  }
	if ($_GET['app']=="accounting") { $this->hidden=array("alta","new_hosting","new_vhost","authcode");  }
	if ($_GET['_']=="i") {
	        $this->onDocumentReady("$('#tr_hosting_id').hide();$('#tr_domain').hide();$('#tr_authcode').hide(); $('#tr_new_hosting').hide(); $('#tr_new_vhost').hide(); if ($('#redir_addr').val()!='') $('#tr_redir_addr').toggle();if ($('#autoresponder_subject').val()!='') $('#tr_autoresponder_subject').toggle();$('#tr_paypal_subscr_id').hide();");

	} else {
		$this->onDocumentReady("if (this.value=='16') $('#tr_paypal_subscr_id').show(); else $('#tr_paypal_subscr_id').hide();");
	}
	$this->setComponent("wysiwyg","notes",array("type"=>"richtext"));

	$this->addComment("alta"," <a href='#' style='color:#999;text-decoration:none' title='Si ho deixeu en blanc pren el valor per defecte segons el tipus de servei'>(opcional)</a>");
	$this->addComment("price"," <a href='#' style='color:#999;text-decoration:none' title='Si ho deixeu en blanc pren el valor per defecte segons el tipus de servei'>(opcional)</a>");
	$this->addComment("authcode"," <a href='#' style='color:#999;text-decoration:none' title='Nom&eacute;s si el domini esta registrat en un registrador extern'>(opcional)</a>");
	$this->addComment("payment_method"," <a href='#' style='color:#999;text-decoration:none' title='Si ho deixeu en blanc pren el valor de la fitxa de client'>(opcional)</a>");

        $this->folder     = $_GET['dr_folder'];
	$this->humanize("price_discount_pc","Descompte (%)");
	$this->humanize("paypal_subscr_id","ID Subscripci&oacute; Paypal");
	$this->abbreviate("price_discount_pc","-%");
	$this->abbreviate("payment_method","M.Pagament");
	$this->defvalue("price_discount_pc","0");
	$this->abbreviate("auto_renov","Ren");
	$this->defvalue("status","active");
	$this->defvalue("content_type","contracts");
	$this->defvalue("venciment","10");
	$this->defvalue("billing_period","");
	$this->defvalue("auto_renov","1");
	$this->defvalue("invoice_pending",1);
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("initial_date",$uploadDate);
	$this->defvalue("end_date",$uploadDate);
	$this->defvalue("payment_method",'');
	//Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
	//setComponent("cipher","Password","MD5");
	//setComponent("cipher","CardNum","MD5");
	// $this->customOptions[0] = Array ("label"=>"_KMS_ERP_CONTRACTS_MAKE_INVOICE","url"=>"","ico"=>"arrowbright.gif","params"=>"action=make_invoice","target"=>"new","checkFunction"=>"checkFacturar");
        // $this->action("make_invoice","/usr/local/kms/mod/erp/contracts/make_invoice.php");
	$this->setComponent("xref","Type_Rid",array("Rid","Type","business_types"));
        $this->setComponent("select","status",array("active"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_ACTIVE."</b></font>","terminator"=>"<b><font color=#ff0000><b>"._KMS_GL_STATUS_TERMINATOR."</b>","finalitzat"=>"<font color=#666>"._KMS_GL_STATUS_FINISHED."</font>","anulat"=>"<font color=#999999>"._KMS_GL_STATUS_ANULAT."</b>"));
	$this->setComponent("file","attachment",array('/var/www/vhosts/intergrid.cat/subdomains/data/httpdocs/files/contracts/','http://data.intergrid.cat/files/contracts'));
//	$this->setComponent("uniselect","billing_period");
	$this->setComponent("select","billing_period",array(""=>"Per defecte","1M"=>"Mensual","3M"=>"Trimestral","6M"=>"Semestral","1Y"=>"Anual","2Y"=>"2 anys","3Y"=>"3 anys","4Y"=>"4 anys","5Y"=>"5 anys","6Y"=>"6 anys","7Y"=>"7 anys","8Y"=>"8 anys","9Y"=>"9 anys","10Y"=>"10 anys"));
	$this->setComponent("select","hosting_type",array("CH"=>"simple","CH"=>"standard/cms","KH"=>"kms"));
	$this->setComponent("uniselect","bill_period_temp");
	$this->setComponent("select","auto_renov",array("1"=>"<font color=#00AA00>SI</font>","0"=>"<font color=#ff0000>NO</font>"));
	$this->dbi->debug = false;
	$this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));

	$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	//if ($_GET['_']=="b") $this->setComponent("status_icon", "sr_client", array("path"=>"","script"=>"client_check"));

//        $this->setComponent("xcombo","sr_ecom_service",array("xtable"=>"kms_ecom_services","xkey"=>"id","xfield"=>"name_ca","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,name_ca from kms_ecom_services where status='active' order by family,subfamily,name"));
        $this->setComponent("xcombo","sr_ecom_service",array("xtable"=>"kms_ecom_services","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,name,name_ca from kms_ecom_services where status='active' order by family,subfamily,name"));

//	$this->setComponent("xcombo","sr_ecom_service",array("xtable"=>"kms_ecom_services","xkey"=>"id","xfield"=>"name_ca","readonly"=>false,"linkcreate"=>true,"linkedit"=>true));
	$this->setComponent("xcombo","hosting_id",array("xtable"=>"kms_isp_hostings","xkey"=>"id","xfield"=>"CONCAT(id,':',description)","readonly"=>false,"linkcreate"=>false,"linkedit"=>true,"sql"=>"select id,CONCAT(sr_contract,':',description) from kms_isp_hostings where status='active' order by sr_contract desc"));
	$this->setComponent("checklist","invoice_pending",array(1=>""));
	$this->setComponent("checklist","new_hosting",array(1=>""));
	$this->setComponent("checklist","new_vhost",array(1=>""));
	$this->defvalue("new_hosting","1");
	$sel="select id from kms_ecom_services where family=1"; //dominis 
//	$res=$this->dbi->query($sel);
	$res=mysqli_query($this->dblinks['client'],$sel);	
	if (!$res) die(mysqli_error($res));
	$list_domains="";
	while ($row=mysqli_fetch_array($res)) {
		$list_domains.="s==".$row['id']."||";
	}	
	$list_domains=substr($list_domains,0,strlen($list_domains)-2);
	$sel="select id from kms_ecom_services where family=2 or family=3 or family=7"; //hostings, aplicacions i altres
        $res=mysqli_query($this->dblinks['client'],$sel);
        if (!$res) die(mysqli_error($res));
        $list_other="";
        while ($row=mysqli_fetch_array($res)) {
                $list_other.="s==".$row['id']."||";
        }
        $list_other=substr($list_other,0,strlen($list_other)-2);
	$sel="select id from kms_ecom_services where family=3"; //aplicacions
        $res=mysqli_query($this->dblinks['client'],$sel);
        if (!$res) die(mysqli_error($res));
        $list_app="";
        while ($row=mysqli_fetch_array($res)) {
                $list_app.="s==".$row['id']."||";
        }
        $list_app=substr($list_app,0,strlen($list_app)-2);

        $this->onFieldChange("new_hosting","$('#tr_hosting_id').toggle()");
//        $this->onFieldChange("new_vhost","$('#tr_domain').toggle();");//$('#tr_authcode').toggle();");
	$this->onFieldChange("sr_ecom_service","s=$('#sr_ecom_service').val();if ({$list_domains}) { $('#tr_domain').show();$('#tr_authcode').show();$('#tr_new_hosting').hide();$('#tr_new_hosting').hide();} else if ({$list_other}) { $('#tr_domain').hide();$('#tr_authcode').hide();$('#tr_new_hosting').show(); $('#tr_hosting_id').hide(); } else if (s==19||s==30||s==33) { $('#tr_domain').hide();$('#tr_authcode').hide();$('#tr_new_hosting').hide();$('input#new_hosting_1').attr('checked',true); $('#tr_new_hosting').show(); $('#tr_hosting_id').hide(); } if ({$list_app}) { $('#hosting_type').val('KH');  $('#tr_domain').show();  $('#tr_description').hide(); }");
//	$this->onFieldChange("sr_client","o=getObject($('#sr_client').val(),'".$_GET['mod']."');timer=setTimeout(alert(o['payment_method']),2000);alert('si');clearTimeout(timer);setTimeout($('#sr_payment_method').val(o['payment_method']),2000);");
	 $this->onFieldChange("sr_client","getObject($('#sr_client').val(),'".$_GET['mod']."');if(obj['payment_method']==undefined) obj['payment_method']=0; $('#payment_method').val(obj['payment_method'])");
	$this->onFieldChange("payment_method","if (this.value=='16') $('#tr_paypal_subscr_id').show(); else $('#tr_paypal_subscr_id').hide()");
	// $this->onDocumentReady("function callback_pm(o) { alert(o['payment_method']); }");
	

/*        $client=$this->dbi->get_record("SELECT sr_payment_method FROM kms_ent_clients WHERE sr_client=".$post['sr_client'],$dblink_erp);


        $this->defvalue("payment_method",$client['sr_payment_method']);
*/

 	$this->customButtons=Array();
        $this->customButtons[0] = Array ("label"=>_KMS_TY_ISP_CLIENT_CONFIG,"url"=>"","ico"=>"","params"=>"action=isp_client_config","target"=>"new","checkFunction"=>"");
        $this->action("isp_client_config","/usr/local/kms/mod/isp/client_config/index.php");

        $this->onInsert = "onInsert";
	$this->onUpdate ="onUpdate";
	$this->onPreUpdate="onPreUpdate";
	$this->onPreInsert = "onPreInsert";
	}

	function checkFacturar($id) {
		if ($id=="") echo  ("ERROR: no id!"); else {
		//  $select = "SELECT * from kms_erp_contracts WHERE id=".$id." and status='active' and invoice_pending=1";
  		$select = "SELECT id from kms_erp_contracts WHERE id=".$id." and status='active' and invoice_pending=1";// and initial_date";
		  $result = mysqli_query($this->dblinks['client'],$select);
		  if (!$result) echo mysqli_error()."<br>SQL:".$select;;
		  $row = mysqli_fetch_array($result);
		  // cal accedir al objecte
		  if ($row['id']==$id) return true; else return false;
		}
	}

	function onPreInsert ($post,$id) {
		// recuperem familia de producte per saber que fer
		$this->trace("Creating new contract...");
                $service=$this->dbi->get_record("SELECT * from kms_ecom_services where id=".$post['sr_ecom_service']);

		$domini=new isp_domains($this->client_account,$this->user_account,$this->dm,$this->dblinks);
		if ($service['family']==1) {
                    // -- DOMINI ---------------------		
			//0. Comprovem que el domini no existeixi
			if ($post['domain']=="")  $this->_error("",_KMS_ISP_DOMAINS_ERROR4,"fatal");
			$exists=$domini->checkExists($post['domain'],$post['sr_client']);
			if ($exists==1) $this->_error("",_KMS_ISP_DOMAINS_ERROR2,"fatal"); else if ($exists==2) $this->_error("",_KMS_ISP_DOMAINS_ERROR3,"fatal"); 
		} else if ($service['family']==2&&$post['domain']!="") { //&&$service['subfamily']==1) {
			// CLOUD HOSTING -----------------------------------------
                        //0. Comprovem que no hi ha cap altre hosting actiu per aquest domini a Intergrid
                        $hosting=$this->dbi->get_record("select * from kms_isp_hostings where description='".$post['domain']."'");
                        if ($hosting['id']!=""&&$hosting['sr_client']==$post['sr_client']) $this->_error("","Ja disposeu d'un hosting (#".$hosting['id'].") per aquest domini amb el contracte #{$hosting['sr_contract']}. Si voleu realitzar algun canvi en el tipus de hosting, actualitzeu el contracte.","fatal");
                        if ($hosting['id']!=""&&$hosting['sr_client']!=$post['sr_client']) $this->_error("","Ja existeix un pla de hosting per aquest domini a Intergrid a nom d'un altre client. Si voleu realitzar una migraci&oacute; utilitzeu el gestor de migracions.","fatal");
		} else if ($service['family']==3) {
			if ($post['hosting_type']=="CH") { 
			    $post['hosting_type']="KH"; 
			    //$this->_error("","Aquest servei requereix que seleccioneu tipus de hosting KMS", "fatal"); 	
			}
		}
		return $post; 
	}

        function onInsert ($post,$id) {
		ob_start();
		$post['id']=$id;
		include "shared/dns.php";
		include "shared/db_links.php";
		$client=$this->dbi->get_record("SELECT * FROM kms_ent_clients WHERE sr_client=".$post['sr_client'],$dblink_erp);
		if ($client=="") die('[erp_contracts] No such client '.$post['sr_client']);
		$service=$this->dbi->get_record("SELECT * from kms_ecom_services where id=".$post['sr_ecom_service']);
		$isp_servers=new isp_servers($this->client_account,$this->user_account,$this->dm);
		$add="";
		if ($post['billing_period']=="") $post['billing_period']=$service['default_billing_period']; //periode per defecte
		if ($post['price']=="") { // si no espefiquem preu posem el per defecte segons el tipus de servei i periodicitat
			if ($post['billing_period']=="1Y") $post['price']=$service['anualPrice'];
			else if ($post['billing_period']=="1M") $post['price']=$service['monthlyPrice'];
			else if ($post['billing_period']=="3M") $post['price']=$service['quarterPrice'];
			else $post['price']=$service[$post['billing_period']];	
			if ($post['setupPrice']=="") { $post['setupPrice']=$service['setupPrice']; $add.=",alta='".$post['setupPrice']."'"; }

			//preu personalitzat per volum (dominis)
			if ($service['family']==1) {
			$num=$this->dbi->get_record("SELECT COUNT(*) FROM kms_isp_domains WHERE sr_client=".$post['sr_client']." AND (status='LOCK' OR status='ACTIVE')");
			$services_limits=$this->dbi->get_record("SELECT * FROM kms_ecom_services_limits WHERE service=".$post['sr_ecom_service']." AND from_value<={$num[0]} AND to_value>={$num[0]}");
			$post['price']=$services_limits['price'];
			}
			$add.=",price='".$post['price']."',billing_period='".$post['billing_period']."'";
		}
		// posem metode de pagament i descompte segons fitxa de client
		if ($service['family']!=1) $discount=$client['discount_pc']; else $discount=0;
		if ($post['payment_method']=="") $post['payment_method']=$client['sr_payment_method'];
                $this->dbi->query("UPDATE kms_erp_contracts SET initial_date='".date('Y-m-d')."',end_date='".date('Y-m-d')."',price_discount_pc=\"{$discount}\",payment_method=\"".$post['payment_method']."\"$add WHERE id={$id}",$dblink_erp);
		$this->dbi->query("UPDATE kms_erp_contracts SET initial_date='".date('Y-m-d')."',end_date='".date('Y-m-d')."',price_discount_pc=\"{$discount}\",payment_method=\"".$post['payment_method']."\"$add WHERE id={$id}",$dblink_cp);
		ob_flush();
		if ($service['family']==1) {
		// -- DOMINI ------------------------------------------------------------------------------------------------------------------
			$this->trace("Setup domain...");
			$servers=$isp_servers->getInstallServers("domain");
			$domini=new isp_domains($this->client_account,$this->user_account,$this->dm,$this->dblinks);

			// Creem domini o l'actualitzem si ja existeix
			$this->existeix=$domain->checkExists($post['domain'],$post['sr_client']);
			if (!$this->existeix) {
				 $expire=date('Y-m-d', strtotime("+1 year")); // no perque ho fara la renovacio de contracte?
//				 $expire=date('Y-m-d');
				$domini=array("creation_date"=>date('Y-m-d H:i:s'),"updated_date"=>date('Y-m-d H:i:s'),"expiration_date"=>$expire,"sr_client"=>$post['sr_client'],"sr_contract"=>$id,"status"=>"LOCK","registrar"=>"INTERGRID.OP","name"=>$post['domain'],"nameserver1"=>$servers['nameserver1']['hostname'],"nameserver2"=>$servers['nameserver2']['hostname'],"sr_ownerc"=>$post['sr_client'],"sr_adminc"=>$post['sr_client'],"sr_techc"=>1,"sr_zonec"=>1,"auto_renew"=>$post['auto_renov']);
				$this->dbi->insert_record("kms_isp_domains",$domini,$dblink_erp,$dblink_cp); 
			} else {
				$domini=array("updated_date"=>date('Y-m-d H:i:s'),"expiration_date"=>$expire,"sr_client"=>$post['sr_client'],"sr_contract"=>$id,"status"=>"LOCK","registrar"=>"INTERGRID.OP)","name"=>$post['domain'],"nameserver1"=>$servers['nameserver1']['hostname'],"nameserver2"=>$servers['nameserver2']['hostname'],"sr_ownerc"=>$post['sr_client'],"sr_adminc"=>$post['sr_client'],"sr_techc"=>1,"sr_zonec"=>1,"auto_renew"=>$post['auto_renov']);
				$this->dbi->update_record("kms_isp_domains",$domini,"name='".$post['domain']."'",$dblink_erp,$dblink_cp);

				//update domain
			$tld=substr($post['domain'],strrpos($post['domain'],".")+1);
                        $domain_name=trim(substr($post['domain'],0,strrpos($post['domain'],".")));
			$post_=array();
                        $post_['nameserver1']=trim($servers['nameserver1']['hostname']);
                        $post_['nameserver2']=trim($servers['nameserver2']['hostname']);
                        $post_['nameserver3']=trim($servers['nameserver3']['hostname']);
                        $post_['nameserver4']=trim($servers['nameserver4']['hostname']);

			$curlOb = curl_init();
                        curl_setopt($curlOb, CURLOPT_URL,"https://control.intergridnetwork.net/kms/lib/isp/domains/update_domain.php");
                        curl_setopt($curlOb, CURLOPT_POST, 1);
                        curl_setopt($curlOb, CURLOPT_POSTFIELDS, array("domain_name"=>$domain_name,"tld"=>$tld,"nameserver1"=>$post_['nameserver1'],"nameserver2"=>$post_['nameserver2'],"nameserver3"=>$post_['nameserver3'],"nameserver4"=>$post_['nameserver4'],"auto_renew"=>$post['auto_renov'],"private_whois"=>$post['private_whois']));
                        curl_exec ($curlOb);
                        curl_close ($curlOb);


			}
			ob_flush();
			// Creem contracte de proveidor a erp_contracts_providers
			$contract_provider=new erp_contracts_providers($this->client_account,$this->user_account,$this->dm);
			$contract_id=$contract_provider->add(array("creation_date"=>$contract['creation_date'],"description"=>$post['domain'],"family"=>"DOMINI","billing_period"=>"1Y"));

			// Enviem peticio manual per registrar domini
                        $subject="Peticio de registre de Domini";
                        $op="registrar"; if ($post['authcode']!="") { $subject.=" : Transfer IN"; $op="transferir"; }
                        $body="Cal $op el domini <b>".$post['domain']."</b><br>ID Contracte: <b>".$id."</b><br>ID Client:".$post['sr_client'];
                        if ($post['authcode']!="") $body.="<br>AuthCode : <b>".$post['authcode']."</b><br><br>";
                        $subject.=" ".$post['domain'];
			
		} else if ($service['family']==2) {
		// --- HOSTING ------------------------------------------------------------------------------------------------------
			$this->trace("Setup hosting...");
//			if ($post['domain']=="") $this->_error("","Cal que especifiqueu el nom del domini a descripcio.","fatal");
			// si descripcio = nom de domini, pasem a configurar vhost
                        $post['domain']=strtolower($post['domain']);
			if ($service['subfamily']==1) {
			// CLOUD HOSTING ---------------------------
				$servers=$isp_servers->getInstallServers("vhost");
				$post['type']="Cloud Hosting";
				$subject="[KMS ISP] Nou Hosting creat";
				if ($post['domain']=="") $body="ID Contracte: <b>".$id."</b><br>De moment sense vhosts<br>Client: ".$post['sr_client']; else $body="ID Contracte: <b>".$id."</b><br>Descripci&oacute;: <b>".$post['domain']."</b><br>Client: ".$post['sr_client'];
			} else if ($service['subfamily']==10) {
			// MULTIDOMAIN CLOUD HOSTING ---------------
				$servers=$isp_servers->getInstallServers("vhost");
				$post['type']="Multidomain Cloud Hosting";
                        	$subject="Nou Multidomain Cloud Hosting creat";
	                        $body="ID Contracte: <b>".$id."</b><br>Descripci&oacute;: <b>".$post['domain']."</b><br>Client: ".$post['sr_client'];
			} else if ($service['subfamily']==3) {
	                // VIRTUAL HOSTING -------------------------
				$servers=$isp_servers->getInstallServers("vps");
                        	//1. Creem servidor
	                        //2. Notificacio manual per crear VPS-
				$post['type']="Virtual Private Server (VPS)";
	                        $subject="Peticio de SERVIDOR PRIVAT VIRTUAL";
	                        $body="Cal crear un VPS.<br><br><b>Tipus: <b>".$post['sr_ecom_service']."</b><br>Descripcio: <b>".$post['domain']."</b><br>ID Contracte: <b>".$id."</b><br>Client #:".$post['sr_client'];
				//posem contacte a 1M (mensual)
                                $this->dbi->update_record("kms_erp_contracts",array("billing_period"=>'1M'),"id='".$post['id']."'",$dblink_erp);
				$this->dbi->update_record("kms_erp_contracts",array("billing_period"=>'1M'),"id='".$post['id']."'",$dblink_cp);

	                } else if ($service['subfamily']==4) {
                        // DEDICATED HOSTING -----------------------
				$servers=$isp_servers->getInstallServers("dedicated");
                        	//1. Creem servidor
                        	//2. Creem contract proveidor
                        	//3. Notificacio manual per demanar servidor al DC
				// Creem contracte de proveidor a erp_contracts_providers (per controlar despesa hetzner)
        	                $contract_provider=new erp_contracts_providers($this->client_account,$this->user_account,$this->dm);
	                        $contract_id=$contract_provider->add(array("creation_date"=>$contract['creation_date'],"description"=>$_GET['domain'],"family"=>"DEDICATED","billing_period"=>"1M"));
				$post['id']=$contract_id;
				$post['type']="Dedicated Server";	
				$post['domain']=$_GET['domain'];
                        	$subject="Peticio de SERVIDOR DEDICAT";
                        	$body="Cal demanar un nou SERVIDOR.<br><br><b>Tipus: <b>".$post['sr_ecom_service']."</b><br>Descripcio: <b>".$post['domain']."</b><br>ID Contracte: <b>".$id."</b><br>Client #:".$post['sr_client'];
				//posem contacte a 1M (mensual)
				$this->dbi->update_record("kms_erp_contracts",array("billing_period"=>'1M'),"id='".$post['id']."'",$dblink_erp);
				$this->dbi->update_record("kms_erp_contracts",array("billing_period"=>'1M'),"id='".$post['id']."'",$dblink_cp);
			} 
			ob_flush();		
			//if ($post['domain']!="") {
			// Common setup for all (administrated) hostings
			$hosting=new isp_hostings($this->client_account,$this->user_account,$this->dm,$this->dblinks);
			$hosting->setupHosting($post,$client,$servers,"DNS,WEB,DB,MAIL,CP,FTP");
			//}

			ob_flush();
		} else if ($service['family']==3) {
                    	// KMS -----------------------------------------------------------------------------------------------------
			$this->trace("Setup KMS...");
                        if ($post['domain']=="") $this->_error("","Cal que especifiqueu el nom del domini a descripcio.","fatal");
			$post['domain']=trim(strtolower($post['domain']));

			$servers=$isp_servers->getInstallServers("kms");
			$subject="Nou KMS Hosting creat";
			if ($post['domain']=="") $body="ID Contracte: <b>".$id."</b><br>De moment sense vhosts<br>Client: ".$post['sr_client']; else $body="ID Contracte: <b>".$id."</b><br>Descripci&oacute;: <b>".$post['domain']."</b><br>Client: ".$post['sr_client'];
			if ($post['new_hosting']==1) { // crear hosting ara
			$post['type']="Cloud Hosting"; 

			//1. Creem hosting
			// cal un contracte apart (util per si despres es vol ampliar o reduir)
				if ($post['sr_ecom_service']) { // KMS Mailing
					$host_service=13; // Cloud Hosting Start (FREE)
					if ($post['price']=="") $host_price=0; else $host_price=$post['price'];
	                        } else if ($post['sr_ecom_service']=="78") { // KMS Sites Basic
					$host_service=13; // Cloud Hosting Start
					if ($post['price']=="") $host_price=62; else $host_price=$post['price'];
	                        } else if ($post['sr_ecom_service']=="30") { // KMS Sites Business
					$host_service=14; // Cloud Hosting Standard
                                        if ($post['price']=="") $host_price=92; else $host_price=$post['price'];
	                        } else if ($post['sr_ecom_service']=="79") { // KMS Sites Ecommerce
					$host_service=14; // Cloud Hosting Standard
                                        if ($post['price']=="") $host_price=119; else $host_price=$post['price'];
				}
			$contract=array("creation_date"=>date('Y-m-d'),"status"=>"active","sr_client"=>$post['sr_client'],"sr_ecom_service"=>$host_service,"initial_date"=>date('Y-m-d'),"end_date"=>date('Y-m-d H:i:s'),"billing_period"=>"1Y","auto_renov"=>"1","domain"=>$post['domain'],"price"=>$host_price,"payment_method"=>$client['sr_payment_method'],"invoice_pending"=>1);
			$id=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_cp);
			$id=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_erp);

			$this->trace("Setup hosting...");
			$hosting=new isp_hostings($this->client_account,$this->user_account,$this->dm,1);
			$isp_client=$this->dbi->get_record("select * from kms_isp_clients where sr_client=".$post['sr_client'],$dblink_erp);
			$post['sr_ecom_service']=$service['id'];
                        $vhost_id=$hosting->setupHosting($post,$client,$servers,"DNS,WEB,DB,MAIL,MAILING,CP,FTP,KMS");
			ob_flush();

			} else { // end crear hosting ara 
			    	//creacio del vhost
		                $isp_vhost=new isp_hostings_vhosts($this->client_account,$this->user_account,$this->dm,1);
				$hosting=$this->dbi->get_record("select * from kms_isp_hostings where id=".$post['hosting_id']);
				$contract=$this->dbi->get_record("select * from kms_erp_contracts where id=".$hosting['sr_contract']); 
				if ($contract['id']=="") die ('[erp_contracts] Fatal error: contract not found ');
				$vhost=array();$vhost["webserver_id"]=$hosting['webserver_id'];$vhost["mailserver_id"]=$hosting['mailserver_id'];
				$servers=$isp_servers->getInstallServers("",$hosting); //$vhost?
		                $vhost_id=$isp_vhost->setupVhost($contract,$post['hosting_id'],$servers,"DNS,WEB,DB,MAIL,MAILING,CP,FTP,KMS");	
			}

			//2. Creem base de dades per aquest domini (si no existeix ja)
			include "/usr/local/kms/lib/components/random.php";
                        $random=new random();
			include "/usr/local/kms/lib/mod/isp_databases.php";	
			$db=new isp_databases($this->client_account,$this->user_account,$this->dm,1);
			$dblogin=$dbname=substr(str_replace("-","",str_replace(".","_",$post['domain'])),0,12)."_kms";
			$dbpasswd=$random->createRandomPassword(7);
			$post_db=array("creation_date"=>date('Y-m-d'),"vhost_id"=>$vhost_id,"name"=>$dbname,"type"=>"mysql","db_server"=>$servers['webserver']['hostname'],"login"=>$dblogin,"password"=>$dbpasswd,"password_type"=>"plain");
			$this->dbi->insert_record("kms_isp_databases",$post_db,$dblink_erp,$dblink_cp);
			$db->onInsert($post_db,$id);
			//3. Creem extranet
			$this->trace("Setup extranet...");
			$modules="sys,lib,ent,docs";
			if ($service['subfamily']==6) $modules.=",sites,imark";
			if ($service['subfamily']==5) $modules.=",imark";
			if ($service['subfamily']==7) $modules.=",erp,planner";
			if ($service['subfamily']==11) $modules.=",ecom,cat";
			ob_flush();	
			$isp_client=$this->dbi->get_record("select * from kms_isp_clients where sr_client=".$post['sr_client'],$dblink_erp);
			$ent_client=$this->dbi->get_record("select * from kms_ent_clients where sr_client=".$post['sr_client'],$dblink_erp);
			$extranet=array("status"=>"online","creation_date"=>date('Y-m-d'),"client_id"=>$ent_client['id'],"hosting_id"=>$vhost['hosting_id'],"contract_id"=>$id,"client_name"=>$isp_client['name'],"subdomain"=>"extranet","default_lang"=>$isp_client['language'],"domain"=>$post['domain'],"username"=>"admin","password"=>$random->createRandomPassword(7),"dbhost"=>$servers['webserver']['hostname'],"dbname"=>$dbname,"dbuser"=>$dblogin,"dbpasswd"=>$dbpasswd,"dbtype"=>"mysql","dbport"=>"3306","modules"=>$modules,"max_users"=>10,"mailing_discount_pc"=>0);
			$this->dbi->insert_record("kms_isp_extranets",$extranet,$dblink_erp);
			$this->dbi->insert_record("kms_isp_extranets",$extranet,$dblink_cp);
			//3. Instal.lem extranet de client
			ob_flush();
			//4. Notificacio
                        $subject="Nou Client KMS creat";
                        $body="ID Contracte: <b>".$id."</b><br>Client #:".$post['sr_client']."<br><b>Tipus: <b>".$post['sr_ecom_service']."</b><br>Descripcio: <b>".$post['domain']."</b><br>";
                } else {
		    // SPECIAL REQUEST -------------------------------------------------------------------------------------------------------------
			$this->trace("Special request...");
			//1. Fem solicitud manual
                        $subject="[KMS Ecom] Peticio de producte especial";
                        $body="ID Contracte: <b>".$id."</b><br>Client #:".$post['sr_client']."<br><b>Tipus: <b>".$post['sr_ecom_service']."</b><br>Descripcio: <b>".$post['domain']."</b><br>";
		}
		$this->emailNotify($subject,$body);
        }

	function onPreUpdate($post,$id) {
		include "shared/db_links.php";
		// llegim contracte abans de modificarse

		$contract=$this->dbi->get_record("select * from kms_erp_contracts where id=$id");
		// client language
		$client=$this->dbi->get_record("select * from kms_isp_clients where sr_client=".$contract['sr_client']);
		 if ($client['language']=="ct") $client['language']="ca";
		if ($post['status']=="terminator"&&$contract['status']=="active") {
			// passem de active a terminator
			// fetch debt
			$sel="select total from kms_erp_invoices where (status='pendent' or status='impagada') and sr_client=".$post['sr_client'];
			$res=$this->dbi->query($sel);
			$debt=0;
			while ($invoice=mysqli_fetch_array($res)) {
				$debt+=$invoice['total'];
			}
			if ($client['language']=="ct") $client['language']="ca";
			$label=$this->dbi->get_record("select ".$client['language']." from kms_sys_lang where const='_KMS_ISP_TERMINATOR_CONTRACT_BLOQUED_SUBJECT'");
			$subject=$label[0];
			$label=$this->dbi->get_record("select ".$client['language']." from kms_sys_lang where const='_KMS_ISP_TERMINATOR_CONTRACT_BLOQUED_BODY'");
			$body=$label[0];
			$body=str_replace("[CONTRACT_ID]",$contract['id'],$body);
			$body=str_replace("[CONTRACT_DESCRIPTION]",$contract['domain'],$body);			
			$body=str_replace("[DEBT]",$debt,$body);
			if ($client['language']=="es") $from="gestion@intergrid.es"; else $from="gestio@intergrid.cat";
			if ($debt>0) {
			$this->emailNotify($subject,$body,$from,$client['email']);
			$this->trace('Notificacio de desconnexio de serveis...'); 
			} else {
			$body="ATENCIO: S'ha bloquejat el contracte ".$contract['id']." (".$contract['domain'].") pero no hi ha cap factura pendent de pagament.<br><br>Sistema de notificacions del KMS";
			$this->emailNotify($subject,$body);
			}
		} else if ($post['status']=="active"&&$contract['status']=="terminator") {
			// pasem de terminator a active
			$label=$this->dbi->get_record("select ".$client['language']." from kms_sys_lang where const='_KMS_ISP_TERMINATOR_CONTRACT_UNBLOQUED_SUBJECT'");
                        $subject=$label[0];
                        $label=$this->dbi->get_record("select ".$client['language']." from kms_sys_lang where const='_KMS_ISP_TERMINATOR_CONTRACT_UNBLOQUED_BODY'");
                        $body=$label[0];
			$body=str_replace("[CONTRACT_ID]",$contract['id'],$body);
                        $body=str_replace("[CONTRACT_DESCRIPTION]",$contract['domain'],$body);
			if ($client['language']=="es") $from="gestion@intergrid.es"; else $from="gestio@intergrid.cat";
                        $this->emailNotify($subject,$body,$from,$client['email']);
			$this->trace('Notificacio de reactivacio de serveis...');

			//activem DNS
			$service=$this->dbi->get_record("select * from kms_ecom_services where id=".$post['sr_ecom_service']);
			$this->dbi->update_record("kms_isp_dns_zones",array("status"=>1),"name='".$post['domain']."'",$dblink_erp,$dblink_cp);

		} else if (($post['status']=="finalitzat"||$post['status']=="anulat")&&($contract['status']=="active")) {
			// CONFIRMACIO DE BAIXA
			if ($_GET['confirm']!="1") {
			echo "<form name='dm' action='/?app=".$_GET['app']."&mod=".$_GET['mod']."&_=e&confirm=1' method='post'>";
			echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
			echo "<input type='hidden' name='status' value='".$_POST['status']."'>";
			echo "<input type='hidden' name='sr_ecom_service' value='".$_POST['sr_ecom_service']."'>";
			echo "<input type='hidden' name='sr_client' value='".$_POST['sr_client']."'>";
			echo "<input type='hidden' name='hosting_id' value='".$_POST['hosting_id']."'>";
			echo "<input type='hidden' name='domain' value='".$_POST['domain']."'>";
			echo "<input type='hidden' name='_action' value='".$_POST['_action']."'>";
			$service=$this->dbi->get_record("select * from kms_ecom_services where id=".$post['sr_ecom_service']);
			if ($service['family']==1) { //domini 
			$this->alerts['delete']['msg']=$service['name_ca'].":<br><br>".strtoupper($post['domain'])."<br><br>"._KMS_ISP_DOMAINS_DELETE_MSG;}
			else if ($service['family']==7) { //Altres (WP, Ips, certificats, suport, backups..
				//do nothing
				$this->alerts['delete']['msg']=$service['name_ca'].":<br><br>".strtoupper($post['domain'])."<br><br>";
			} else {
			$this->alerts['delete']['msg']=$service['name_ca'].":<br><br>".strtoupper($post['domain'])."<br><br>"._KMS_ERP_CONTRACTS_DELETE_MSG;
			}
			$this->alerts['delete']['ok_label']=_MB_CONFIRM_OFF;
			$this->alerts['delete']['ok_action']="document.dm.submit();";
			$this->draw_alert($this->alerts['delete']);
			echo "</form>";
			exit;	
			}
		}
		if ($post['sr_ecom_service']=="") die('Cal especificar un servei');
		$service=$this->dbi->get_record("select * from kms_ecom_services where id=".$post['sr_ecom_service']);

		if ($service['family']==1) {
		$sendmail=false;
               // -------- DOMAIN NAMES --------------------------------------------------------------------------
                        $this->dbi->update_record("kms_isp_domains",array("sr_client"=>$post['sr_client']),"name='".$post['domain']."'",$dblink_erp);//$dblink_cp);  
			$this->dbi->update_record("kms_isp_domains",array("sr_client"=>$post['sr_client']),"name='".$post['domain']."'",$dblink_cp);	
//			UPDATE kms_isp_domains SET `sr_client`="478" WHERE name'blingblingmdr.com'
			$domain=$this->dbi->get_record("select * from kms_isp_domains where name='{$post['domain']}'");

                        if (($contract['auto_renov']==1&&$post['auto_renov']==0)||($contract['status']=='active'&&$post['status']!="active")) {

                                $changes=array("auto_renew"=>0,"sr_client"=>$post['sr_client']);
                                if ($domain['expiration_date']<date('Y-m-d')) $changes['status']='EXPIRED';
                                $this->dbi->update_record("kms_isp_domains",$changes,"sr_contract=$id",$dblink_erp);
                                $this->dbi->update_record("kms_isp_domains",$changes,"sr_contract=$id",$dblink_cp);
				$subject="Baixa de domini ".$post['domain'];
                                $body="El domini ".$post['domain']." ha estat marcat per no renovar.<br><br>--<br>Intergrid KMS";
				$sendmail=true;

                        } else if (($contract['auto_renov']==0&&$post['auto_renov']==1)||($contract['status']!='active'&&$post['status']=="active")) {

				$changes=array("auto_renew"=>$post['auto_renov'],"sr_client"=>$post['sr_client']);
                                $this->dbi->update_record("kms_isp_domains",$changes,"name='{$post['domain']}'",$dblink_erp);
				$this->dbi->update_record("kms_isp_domains",$changes,"name='{$post['domain']}'",$dblink_cp);
                                $subject="Activació de renovació automàtica de domini ".$post['domain'];
                                $body="El domini ".$post['domain']." ha estat marcat per autorenovar-se automàticament.<br><br>--<br>Intergrid KMS";
				$sendmail=true;
                        }

			//update OP
                        $tld=substr($post['domain'],strrpos($post['domain'],".")+1);
                        $domain_name=trim(substr($post['domain'],0,strrpos($post['domain'],".")));
                        $domain['nameserver1']=trim($domain['nameserver1']);
                        $domain['nameserver2']=trim($domain['nameserver2']);
                        $domain['nameserver3']=trim($domain['nameserver3']);
                        $domain['nameserver4']=trim($domain['nameserver4']);

			$curlOb = curl_init();
                        curl_setopt($curlOb, CURLOPT_URL,"https://control.intergridnetwork.net/kms/lib/isp/domains/update_domain.php");
                        curl_setopt($curlOb, CURLOPT_POST, 1);
                        curl_setopt($curlOb, CURLOPT_POSTFIELDS, array("domain_name"=>$domain_name,"tld"=>$tld,"nameserver1"=>$domain['nameserver1'],"nameserver2"=>$domain['nameserver2'],"nameserver3"=>$domain['nameserver3'],"nameserver4"=>$domain['nameserver4'],"auto_renew"=>$_POST['auto_renov'],"private_whois"=>$domain['private_whois']));
                        $response = curl_exec ($curlOb);
                        curl_close ($curlOb);

			if ($response) { /* success */ }

			if ($sendmail) {
                        $from="kms@intergrid.cat";
                        $to="registres@intergrid.cat";
                        $this->emailNotify($subject,$body,$from,$to);
			}
                }

	}

	function onUpdate($post,$id) {
		include "shared/db_links.php";
		$service=$this->dbi->get_record("select * from kms_ecom_services where id=".$post['sr_ecom_service']);
		// autorenovacio off si contracte anulat/finalitzat
		if ($post['status']=="anulat"||$post['status']=="finalitzat"||$post['auto_renov']=="0") {
			$post['auto_renov']=0;
			$this->dbi->update_record("kms_erp_contracts",array("auto_renov"=>0),"id=$id",$dblink_erp);
			$this->dbi->update_record("kms_erp_contracts",array("auto_renov"=>0),"id=$id",$dblink_cp);
                }

		if ($post['sr_ecom_service' ]==2119||$post['sr_ecom_service' ]==573) { //WP protection
			$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where name like '%".$post['domain']."%'");
                	$server=$this->dbi->get_record("select * from kms_isp_servers where id=".$vhost['webserver_id']);
			if ($post['status']=="active") {
			$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'touch /var/www/vhosts/".$vhost['name']."/conf/wp-service' >> /var/log/kms/kms.log";
                       } else {
			$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'rm /var/www/vhosts/".$vhost['name']."/conf/wp-service' >> /var/log/kms/kms.log";
			}
		 //  echo $command;exit; 
			$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
		}

		if ($service['family']==1) { 
		// -------- DOMAIN NAMES --------------------------------------------------------------------------

			if ($post['status']=="terminator")  {
				// aturem les DNS
				$this->dbi->update_record("kms_isp_dns_zones",array("status"=>0),"name='".$post['domain']."'",$dblink_erp,$dblink_cp);
				// canviem les DNS del domini a ns0.intergridnetwork.net (potser amb aixòn'hi ha prou)
				// caldria tenir servidor preconfigurat 
				// aturem les DNS fisicament
				// ...falta
				// stop possible domain forwarding...
				$body="Canvieu les DNS del domini ".$post['domain']." a ns0.intergridnetwork.net (Servidor de bloqueig)";
			}

			// canvi a OP
                        $tld=substr($post['name'],strrpos($post['domain'],".")+1);
                        $domain_name=trim(substr($post['name'],0,strrpos($post['domain'],".")));




		} else if ($service['family']==2) { 
		// -------- HOSTING --------------------------------------------------------------------------------
			$status=$post['status'];
			$hosting=$this->dbi->get_record("select * from kms_isp_hostings where sr_contract=$id");
			if ($hosting['id']=="") $this->_error("","No hi ha cap hosting associat a aquest contracte. Busqueu el hosting i poseu-li en el camp sr_contract el valor $id","fatal");
                        $sel="select * from kms_isp_hostings_vhosts where hosting_id=".$hosting['id'];
                        $result=$this->dbi->query($sel);
			if ($post['status']=="terminator") {
				$status="blocked";
				//perform vhosts lock
				$server=$this->dbi->get_record("select * from kms_isp_servers where id=".$hosting['webserver_id']);
				while ($vhost=mysqli_fetch_array($result)) {
//					$server=$this->dbi->get_record("select * from kms_isp_servers where id=".$hosting['webserver_id']);
					$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." '/usr/local/kms/mod/isp/setup/block_vhost.sh ".$vhost['name']."' >> /var/log/kms/kms.log";
//echo $command;
				$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
					// disconnect email accounts
					$this->dbi->query("update kms_isp_mailboxes set postbox=0 where vhost_id=".$vhost['id'],$dblink_cp);
					$this->dbi->query("update kms_isp_mailboxes set postbox=0 where vhost_id=".$vhost['id'],$dblink_erp);
				}
				
			} else if ($post['status']=="active") {
				// check if blocked and reactive if necessary
				while ($vhost=mysqli_fetch_array($result)) {
                                        $server=$this->dbi->get_record("select * from kms_isp_servers where id=".$hosting['webserver_id']);
                                        $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." '/usr/local/kms/mod/isp/setup/unblock_vhost.sh ".$vhost['name']."' >> /var/log/kms/kms.log";
					// disconnect email accounts
                                        $this->dbi->query("update kms_isp_mailboxes set postbox=1 where vhost_id=".$vhost['id'],$dblink_cp);
                                        $this->dbi->query("update kms_isp_mailboxes set postbox=1 where vhost_id=".$vhost['id'],$dblink_erp);
                                        $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
                                }	
			} else if ($post['status']=="finalitzat"||$post['status']=="anulat") {
				// eliminar vhosts
				while ($vhost=mysqli_fetch_array($result)) {
					//dns
					$isp_dns=new isp_dns($this->client_account,$this->user_account,$this->dm,1);
					$isp_dns->removeDNS($vhost,array("dblink_cp"=>$dblink_cp,"dblink_erp"=>$dblink_erp));
					//vhost
					$webserver=$this->dbi->get_record("select * from kms_isp_servers where id=".$hosting['webserver_id']);
					$command = "ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_vhost.sh ".$vhost['name']."' >> /var/log/kms/kms.log";
					$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
					$this->dbi->delete_record("kms_isp_hostings_vhosts","id=".$vhost['id'],$dblink_cp,$dblink_erp);
					//ftps & subdomains & extranets
					$this->dbi->delete_record("kms_isp_ftps","vhost_id=".$vhost['id'],$dblink_cp,$dblink_erp);
					$this->dbi->delete_record("kms_isp_subdomains","vhost_id=".$vhost['id'],$dblink_cp,$dblink_erp);
					$this->dbi->delete_record("kms_isp_extranets","domain='".$vhost['name']."'",$dblink_cp,$dblink_erp);
					//webstats
					$command = "ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_webstats.sh ".$vhost['name']."' >> /var/log/kms/kms.log";
					$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
					//databases
					$sel="select * from kms_isp_databases where vhost_id=".$vhost['id'];
					$res_db=mysqli_query($this->dblinks['client'],$sel);
					while ($db=mysqli_fetch_array($res_db)) {
					$command = "ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_database.sh ".$db['name']." ".$db['login']."' >> /var/log/kms/kms.log";
                                        $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
					}
					$this->dbi->delete_record("kms_isp_databases","vhost_id=".$vhost['id'],$dblink_cp,$dblink_erp);
					//mailboxes
					$mailserver=$this->dbi->get_record("select * from kms_isp_servers where id=".$hosting['mailserver_id']);
					$command = "ssh -i /root/.ssh/id_rsa root@".$mailserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_all_mailboxes.sh ".$vhost['name']."' >> /var/log/kms/kms.log";
					$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
					$this->dbi->delete_record("kms_isp_mailboxes","vhost_id=".$vhost['id'],$dblink_cp,$dblink_erp);
					//cron jobs
					$this->dbi->delete_record("kms_isp_crontables","vhost_id=".$vhost['id'],$dblink_cp,$dblink_erp);
//					$command = "ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_";
//					$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
					//vhosts logs
					$this->dbi->delete_record("kms_isp_hostings_vhosts_log","domain='".$vhost['name']."'",$dblink_cp,$dblink_erp);
				}
				// hosting logs
				$this->dbi->delete_record("kms_isp_hostings_log","hosting_id=".$hosting['id'],$dblink_cp,$dblink_erp);
				$this->dbi->delete_record("kms_isp_hostings","id=".$hosting['id'],$dblink_cp,$dblink_erp);
			}
			if ($post['status']!="finalitzat"&&$post['status']!="anulat") {
			$changes=array("sr_ecom_service"=>$post['sr_ecom_service'],"status"=>$status,"sr_client"=>$post['sr_client']);
			$this->dbi->update_record("kms_isp_hostings",$changes,"sr_contract=$id",$dblink_cp,$dblink_erp);
			}

		} else if ($service['family']==3) {
		// ---------------- KMS ----------------------------------------------------------------
			if ($post['status']=="active") $status="online"; else $status="offline";

			if ($post['status']=="finalitzat"||$post['status']=="anulat") {
				$this->dbi->delete_record("kms_isp_extranets","contract_id=$id",$dblink_cp,$dblink_erp);
				// eliminar subdomini extranet i data
				//...
			} else {
				$changes=array("status"=>$status,"client_id"=>$post['sr_client']);
	                        $this->dbi->update_record("kms_isp_extranets",$changes,"contract_id=$id",$dblink_cp,$dblink_erp);
			}
		}

		//replicate everything
	unset($post['return_mod']);unset($post['from']);unset($post['mod']);unset($post['panelmod']);unset($post['xid']);
	$post['initial_date']=date('Y-m-d',strtotime($post['initial_date']));
	$post['end_date']=date('Y-m-d',strtotime($post['end_date']));
	$post['creation_date']=date('Y-m-d',strtotime($post['creation_date']));
	$id=$this->dbi->update_record("kms_erp_contracts",$post,"id={$id}",$dblink_cp);
	}


} // class
?>
