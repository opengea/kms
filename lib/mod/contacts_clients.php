<?

// ----------------------------------------------
// Class Contacts Clients for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class contacts_clients extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table		= "kms_contacts_clients";
	var $key		= "id";	
	var $fields	 	= array("id","creation_date", "status", "payment_status", "type", "vr_cif", "sr_client", "sr_provider");
	var $notedit 		= array("dr_folder","sr_user");
//	var $readonly		= array("sr_user");
	var $title		= "Clients";
	var $orderby		= "creation_date";
	var $sortdir		= "desc";
	var $linkField		= "sr_client";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit 		= true;
        var $can_delete 	= true;
        var $can_add   		= true;
        var $can_import 	= false;
        var $can_export 	= true;
        var $can_search 	= true;
	var $can_print		= true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function contacts_clients($client_account,$user_account,$dm) {
                // Edit Tabs
                /*$sel="select * from kms_contacts_clients where id=".$_GET['id'];
                $res=mysqli_query($this->dblinks['client'],$sel);
                $client=mysqli_fetch_array($res);
                if ($client['type']=="reseller"||$client['type']=="franchise") {
                $tabs=array();
                $tab=array("title"=>"Reseller/Franchise Details","mod"=>"isp_wholesale"); array_push($tabs,$tab);
                $this->editorTabs($tabs);
                }*/
                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]=================================================*/ 
        // This is needed to declare member functions outside the class. Just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

	function __call($name, $args) {
        	call_user_func_array(sprintf('%s__%s', get_class($this), $name), array_merge(array($this), $args));
 	}	

        /*=[ METHODS ]===========================================================*/

        function setup($client_account,$user_account,$dm) {
		$obj=$this;
		global $obj;
		$this->setComponent("xcombo","sr_provider",array("xtable"=>"kms_contacts_entities","xkey"=>"id", "xfield"=>"shortname", "readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_contacts_entities","xkey"=>"id", "xfield"=>"name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
		$this->setComponent("xcombo","sr_payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id", "xfield"=>"payment_name","readonly"=>false,"linkcreate"=>true, "linkedit"=>true, "sql"=>""));
		$this->setComponent("select","force_payment_day",array("all"=>"tot for&ccedil;at (altes,tasques,contractes)","renewals"=>"nom&eacute;s renovaci&oacute; de contractes","none"=>"no for&ccedil;at (segons venciment)"));
		$this->xlist("Contractes","SELECT kms_erp_contracts.id, kms_erp_contracts.status, kms_ecom_services.name, kms_erp_contracts.description, kms_erp_contracts.billing_period FROM kms_erp_contracts,kms_ecom_services WHERE kms_erp_contracts.sr_client='".$_GET['id']."' and kms_ecom_services.id = kms_erp_contracts.sr_ecom_service","contacts_clients");
		$xsql=array("xv_xtable"=>"kms_contacts_entities", "xv_field"=>"sr_client", "xv_xkey"=>"id", "xv_xfield"=>"cif");
        	$this->xvField("vr_cif",array("sql"=>$xsql));

		$this->defvalue("status","active");
		$this->defvalue("type","empresa");
		$this->defvalue("sr_payment_method","3");
		$this->defvalue("default_payment_day",20);
		$this->defvalue("force_payment_day","renewals");
		$this->humanize("vr_cif","CIF");
		$this->humanize("sr_provider","Prove&iuml;dor");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("satisfaction","no avaluat");
		$this->defvalue("sr_provider",1);
		$this->default_content_type = "client";
		$this->insert_label = "Nova fitxa";
		$this->edit_rfile = "Editar fitxa de client";
		$this->custom_button1 = "Contractes";
		$this->custom_button2 = "Factures";
		$this->custom_button3 = "Estad&iacute;stiques";
		$this->custom_action1 = "?app=accounting&mod=erp_contracts&queryfield=sr_client";
		$this->custom_action2 = "?app=accounting&mod=erp_invoices&queryfield=sr_client";
		$this->custom_action3 = "";
		$this->setComponent("select","status",array("active"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_ALTA."</b></font>","migracio"=>"<font color=#ff0000>"._KMS_GL_STATUS_MIGRACIO."</font>","aturat"=>"<font color=#ff0000>"._KMS_GL_STATUS_ATURAT."</a>","baixa"=>"<font color=#ff0000>"._KMS_GL_STATUS_BAIXA."</font>"));
		$this->setComponent("select","payment_status",array("al corrent"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_AL_CORRENT."</b></font>","impagats"=>"<font color=#ff0000>"._KMS_GL_STATUS_IMPAGATS."</font>"));
		$this->setComponent("select","type",array("particular"=>_KMS_CLIENTS_PARTICULAR,"empresa"=>_KMS_CLIENTS_ENTITY,"reseller"=>_KMS_CLIENTS_RESELLER));
		if ($_GET['id']!="") {
		$result=$this->dbi->query("select sr_client from kms_contacts_clients where id=".$_GET['id']);
		$row = $this->dbi->fetch_row($result);
		$entity_id = $row[0];
                $this->xlist("Contractes","SELECT * FROM kms_erp_contracts WHERE kms_erp_contracts.sr_client='".$entity_id."'","erp_contracts");
                $this->xlist("Factures","SELECT * FROM kms_erp_invoices WHERE kms_erp_invoices.sr_client='".$entity_id."'","erp_invoices");
		}
		$this->setComponent("random","password");//$this->setComponent("cipher","password","plain");
                $this->onInsert = "onInsert";
                $this->onDelete = "onDelete";
                $this->onUpdate = "onUpdate";

                // Extra Client Setup
		$extra_include="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/".$_GET['mod'].".php";
		if (file_exists($extra_include)) include $extra_include;

		// Edit Tabs
		$sel="select * from kms_contacts_clients where id=".$_GET['id'];
		$res=mysqli_query($this->dblinks['client'],$sel);
		$client=mysqli_fetch_array($res);
		if ($client['type']=="reseller"||$client['type']=="franchise"||$_GET['tab']>0) {
		$this->tabs=array();
		$tab=array("title"=>$this->title,"mod"=>"contacts_clients"); array_push($this->tabs,$tab);
		$tab=array("title"=>"Reseller/Franchise Details","mod"=>"isp_wholesale","xkey"=>"sr_client"); array_push($this->tabs,$tab);
		$this->editorTabs($this->tabs);
		}

                $this->setValidator("email","email");
		$this->setValidator("username","alphanumeric");
		$this->setValidator("bank_accountNumber","ccc");
		$this->maxlength("bank_accountNumber","24");
//		$this->onFieldChange("sr_payment_method","if ($('#sr_payment_method').val()==11) { $('#default_payment_day').attr('readonly',''); $('#tr_bank_accountNumber').hide();$('#tr_credit_card').show();$('#tr_credit_card_name').show(); $('#tr_credit_card_vcs').show();$('#tr_credit_card_expiration_date').show(); refreshUI(); } else { $('#default_payment_day').val(20);$('#default_payment_day').attr('readonly','readonly'); $('#tr_bank_accountNumber').show();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); refreshUI(); }");
  //              $this->onDocumentReady("if ($('#sr_payment_method').val()==11) { $('#default_payment_day').attr('readonly',''); $('#tr_bank_accountNumber').hide();$('#tr_credit_card').show();$('#tr_credit_card_name').show(); $('#tr_credit_card_vcs').show();$('#tr_credit_card_expiration_date').show(); refreshUI(); } else { $('#default_payment_day').val(20);$('#default_payment_day').attr('readonly','readonly'); $('#tr_bank_accountNumber').show();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); refreshUI(); }");

                $this->onFieldChange("sr_payment_method","if ($('#sr_payment_method').val()==11) { $('#default_payment_day').attr('readonly',''); $('#tr_bank_accountNumber').hide();$('#tr_bank_name').hide();$('#tr_credit_card').show();$('#tr_credit_card_name').show(); $('#tr_credit_card_vcs').show();$('#tr_credit_card_expiration_date').show(); refreshUI(); } else if ($('#sr_payment_method').val()==1) {  $('#tr_bank_accountNumber').hide(); $('#tr_bank_name').hide();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); } else { $('#default_payment_day').val(20);$('#default_payment_day').attr('readonly','readonly'); $('#tr_bank_accountNumber').show();$('#tr_bank_name').show();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); refreshUI(); }");
                $this->onDocumentReady("if ($('#sr_payment_method').val()==11) { $('#default_payment_day').attr('readonly',''); $('#tr_bank_accountNumber').hide();$('#tr_bank_name').hide();$('#tr_credit_card').show();$('#tr_credit_card_name').show(); $('#tr_credit_card_vcs').show();$('#tr_credit_card_expiration_date').show(); refreshUI(); } else if ($('#sr_payment_method').val()==1) {  $('#tr_bank_accountNumber').hide();$('#tr_bank_name').hide(); $('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide();  } else { $('#default_payment_day').val(20);$('#default_payment_day').attr('readonly','readonly'); $('#tr_bank_accountNumber').show();$('#tr_bank_name').show();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); refreshUI(); }");

	}

        function onInsert($post,$id) {
                $dblink_erp=$this->dbi->db_connect("erp-localhost",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		//debug info
                $info=$this->table." onInsert";
                //get entity data
		$entity=$this->dbi->get_record("select * from kms_contacts_entities where id='".$post['sr_client']."'");
                //compile and create isp_client
                $isp_client=array("sr_client","creation_date","status","sr_provider","phone","email","billing_email","sr_payment_method","default_payment_day","bank_name","bank_accountNumber","credit_card","credit_card_name","credit_card_expiration_date","credit_card_vcs","sr_user","name","sector","cif","contacts","alt_phone","web","address","location","province","zipcode","country","language","newsletter");
		$post['newsletter']=1;
                $values=array_merge($entity,$post);
                $insert=$this->dbi->make_insert($values,"kms_isp_clients",$isp_client,$dblink_erp);
                $this->dbi->query($insert,$dblink_erp,$info);
		$this->dbi->query($insert,$dblink_cp,$info);
                $isp_client_id=mysqli_insert_id();
                //insert username & password of control panel
                if ($post['username']!="") {
			//check if username exists
			$u=$this->dbi->get_record("select username from kms_sys_users where username='".$post['username']."'",$dblink_cp);
			if ($u['username']==$post['username']) {
				$this->trace("username already exists, renaming...");
				$post['username']=$post['username'].$isp_client_id;
			}
			if ($post['type']=="reseller") $client_group=3; else $client_group=2;  //client or reseller
			$user=array("creation_date"=>date('Y-m-d H:i:s'),"username"=>$post['username'],"upassword"=>$post['password'],"password_type"=>"plain","groups"=>$client_group,"status"=>"active","language"=>$entity['language'],"email"=>$post['email']);
                        $sr_user=$this->dbi->insert_record("kms_sys_users",$user,$dblink_cp);
                }
                // sets sr_user field
		$client_=array("sr_user"=>$sr_user);
		$this->dbi->update_record("kms_isp_clients",$client_,"id=$isp_client_id",$dblink_erp);
		$this->dbi->update_record("kms_isp_clients",$client_,"id=$isp_client_id",$dblink_cp);
		// update sr_user on clients database
		$this->dbi->update_record("kms_contacts_clients",$client_,"id=".$id,$dblink_erp);
        }

        function onUpdate($post,$id) {
		include "/usr/local/kms/lib/mod/shared/db_links.php";
		$info=$this->table." onUpdate";
		//get entity data
                $entity=$this->dbi->get_record("select * from kms_contacts_entities where id='".$post['sr_client']."'");
		$fields_to_update=array("sr_client","creation_date","status","sr_provider","phone","email","billing_email","sr_payment_method","default_payment_day","bank_name","bank_accountNumber","credit_card","credit_card_name","credit_card_expiration_date","credit_card_vcs");
		$values=array_merge($entity,$post);
		$dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		if ($post['payment_status']=="impagats") $values['status']="blocked";
		$update=$this->dbi->make_update($values,"kms_isp_clients","sr_client=".$values['sr_client'],$fields_to_update,$dblink_cp);
		$this->dbi->query($update,$dblink_cp,$info);
		//comprovem si ja existeix...
                $user_check=$this->dbi->get_record("select * from kms_sys_users where username='".$post['username']."'",$dblink_cp);
		$contact_client=$this->dbi->get_record("select * from kms_contacts_clients where id=".$id,$dblink_erp);
		$user_db=$this->dbi->get_record("select * from kms_sys_users where id=".$contact_client['sr_user'],$dblink_cp);
//		if ($post['username']!=$user_db['username']) {
			//hem canviat el username...
			//comprovem que no existeixi
			//if ($user_check['username']==$post['username']) $this->_error("","Error: Ja existeix un usuari amb aquest nom.","fatal");
///		}
                if ($user_check['username']==""||($post['username']!=$user_db['username'])) {
			// l'usuari no existeix o be hem canviat el nom d'usuari i per tant hem d'insertar-lo
                	if ($post['type']=="reseller") $client_group=3; else $client_group=2;  //client or reseller
	                $user=array("creation_date"=>date('Y-m-d H:i:s'),"username"=>$post['username'],"upassword"=>$post['password'],"password_type"=>"plain","groups"=>$client_group,"status"=>"active","language"=>$entity['language'],"email"=>$post['email']);
			// si no existeix l'insertem
	                if ($post['username']!=$user_check['username']) {
				 $this->trace("no existeix, insertem");
				$sr_user=$this->dbi->insert_record("kms_sys_users",$user,$dblink_cp);
			} else {
				$this->trace("ja existeix, no cal insertar");
				 $sr_user=$user_check['id'];
			}
			// modifiquem nou sr_user de contacts_clients
			$this->dbi->update_record("kms_contacts_clients",array("sr_user"=>$sr_user),"id=$id",$dblink_erp);
			$this->dbi->update_record("kms_isp_clients",array("sr_user"=>$sr_user),"sr_client=".$contact_client['sr_client'],$dblink_cp);
			$this->dbi->update_record("kms_isp_clients",array("sr_user"=>$sr_user),"sr_client=".$contact_client['sr_client'],$dblink_erp);
			$contact_client['sr_user']=$sr_user;
		} else { 
			//update username & password of control panel
			if ($post['type']=="reseller") $client_group=3; else $client_group=2;  //client or reseller
			$user=array("username"=>$post['username'],"upassword"=>$post['password'],"groups"=>$client_group);
			$this->dbi->update_record("kms_sys_users",$user,"id=".$user_db['id'],$dblink_cp);
			$sr_user=$user_db['id'];
		} 
		if ($post['sr_provider']!=$user_db['sr_provider']) {
			$this->dbi->update_record("kms_isp_clients",array("sr_provider"=>$post['sr_provider']),"sr_client=".$contact_client['sr_client'],$dblink_cp);
                        $this->dbi->update_record("kms_isp_clients",array("sr_provider"=>$post['sr_provider']),"sr_client=".$contact_client['sr_client'],$dblink_erp);	
		} 
	}

        function onDelete($post,$id) {
		$info=$this->table." onDelete";
		$dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $delete="DELETE FROM kms_isp_clients WHERE sr_client=".$post['sr_client'];
		$this->dbi->query($delete,$dblink_cp,$info);
		if ($post['sr_user']!="") {
			$delete="DELETE FROM kms_sys_users WHERE id=".$post['sr_user'];
			$this->dbi->query($delete,$dblink_cp,$info);
		}
        }

}
?>
