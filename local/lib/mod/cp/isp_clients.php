<?

// ----------------------------------------------
// Class ISP Clients for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_clients extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_clients";
	var $key	= "id";	
	var $fields = array("sr_client","status","name","contacts");
	var $readonly = array("sr_client","sr_user","creation_date");
	var $orderby = "creation_date";
	var $notedit=array("comments","sr_provider","status","sr_client","dr_folder","sr_user","creation_date","bank_name","default_payment_day");
	var $notedit_insert=array("sr_provider","status","sr_client","dr_folder","sr_user","creation_date","bank_name","sr_user");
	var $hidden = array("credit_card","credit_card_name","credit_card_expiration_date","credit_card_vcs","username","password","terms_and_cond","rgpd","fax");
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_gohome = true;
	var $can_edit  = true;
	var $can_delete = true;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_clients($client_account,$user_account,$dm) {
		$select="SELECT * FROM kms_isp_clients WHERE sr_user=".$user_account['id'];
		$result=mysql_query($select);
		$client=mysql_fetch_array($result);
                if ($this->_group_permissions(1,$user_account['groups'])) { //admin  ($this->_group_permissions(1,$user_account['groups']))  {
			$_GET['app']="cp-admin";
                        $this->notedit=array();
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) { //reseller
			$_GET['app']="cp-reseller";
			$this->notedit=array("comments","sr_provider","sr_client","dr_folder","bank_name","default_payment_day");
                        
			if ($_GET['action']=='edit_client') {
							$this->where = "sr_client=".$client['sr_client']; 
						$this->can_delete=false;
						$_GET['_']="e"; $_GET['id']=$client['id']; 
			} else { 
				$this->where = "sr_client in (select sr_client from kms_isp_clients where status='active' and sr_provider=".$client['sr_client'].")";
//						array_push($this->notedit,"billing_email"); 
				$this->fields = array("sr_client","status","name","email", "billing_email","billing_client");			
			}
                } else if ($this->_group_permissions(2,$user_account['groups'])) { // client 
			$this->can_delete=false;
			array_push($this->notedit,"billing_client");
			if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");
			//always edit
			$_GET['app']="cp";
			$_GET['_']="e"; $_GET['id']=$client['id'];
                        $this->fields = array("status","name","contacts","creation_date");
                        $this->where = "sr_client=".$client['sr_client'];
                } else if ($this->_group_permissions(4,$user_account['groups'])) { //user(client without invoices)
			array_push($this->notedit,"billing_client");
                        if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");
                        //always edit
                        $_GET['app']=$user_account['autorun_app'];
                        $_GET['_']="e"; $_GET['id']=$client['id'];
                        $this->fields = array("status","name","contacts","creation_date");
                        $this->where = "sr_client=".$client['sr_client'];

		}
		if ($_GET['action']=="accept_sepa")  $_GET['_']="f";
		parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->user_account=$user_account;
		if ($_GET['action']=="edit_client") $this->title=_KMS_TY_ISP_CLIENT_DATA; else $this->title=_KMS_TY_ISP_CLIENTS;
		include "/usr/local/kms/tpl/panels/isp_clients.php";
//		$this->action("update_domains","/usr/local/kms/mod/isp/update_domains.php");
		$this->setComponent("select","billing_client",array("1"=>_KMS_ISP_BILLING_CLIENT_1,"2"=>_KMS_ISP_BILLING_CLIENT_2));
		$this->setComponent("select","status",array("active"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_ALTA."</b></font>","migracio"=>"<font color=#ff0000>"._KMS_GL_STATUS_MIGRACIO."</font>","aturat"=>"<font color=#ff0000>"._KMS_GL_STATUS_ATURAT."</a>","baixa"=>"<font color=#ff0000>"._KMS_GL_STATUS_BAIXA."</font>"));
                $this->setComponent("select","payment_status",array("al corrent"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_AL_CORRENT."</b></font>","impagats"=>"<font color=#ff0000>"._KMS_GL_STATUS_IMPAGATS."</font>"));
		if ($this->_group_permissions(1,$user_account['groups']))  { $this->setComponent("uniselect","sector"); } 

		$this->setComponent("checklist","newsletter",array("1"=>""));
		$this->setComponent("select","language",array("ct"=>"Catal&agrave;","es"=>"Espa&ntilde;ol","eu"=>"Euskara","en"=>"English"));
		include "/usr/local/kms/lib/include/countries.php";
		$this->setComponent("select","country",$countries);
		$this->setComponent("select","sr_payment_method",array("3"=>_KMS_ERP_PAYMENTM_DOMICILIACIO,"11"=>_KMS_ERP_PAYMENTM_CREDITCARD,"1"=>_KMS_ERP_PAYMENTM_TRANSFER,"16"=>"PayPal"));
                $this->onInsert = "onInsert";
		$this->onUpdate = "onUpdate";
		$this->humanize("name",_KMS_ISP_CLIENTS_NAME);
		$this->humanize("sr_user",_KMS_ISP_CP_USER);
		$this->setValidator("email","email");
                $this->setValidator("username","alphanumeric");
                $this->setValidator("bank_accountNumber","ccc");
                $this->maxlength("bank_accountNumber","30");
		$this->setComponent("xcombo","sr_user",array("xtable"=>"kms_sys_users","xkey"=>"id","xfield"=>"username","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));

		$this->onFieldChange("sr_payment_method","if ($('#sr_payment_method').val()==11) { $('#default_payment_day').attr('readonly',''); $('#tr_bank_accountNumber').hide();$('#tr_credit_card').show();$('#tr_credit_card_name').show(); $('#tr_credit_card_vcs').show();$('#tr_credit_card_expiration_date').show(); refreshUI(); } else if ($('#sr_payment_method').val()==1) {  $('#tr_bank_accountNumber').hide(); $('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); } else if ($('#sr_payment_method').val()==16) { $('#tr_bank_accountNumber').hide();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_expiration_date').hide(); $('#tr_credit_card_vcs').hide();	 } else { $('#default_payment_day').val(20);$('#default_payment_day').attr('readonly','readonly'); $('#tr_bank_accountNumber').show();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); refreshUI(); }");
		$this->onDocumentReady("if ($('#sr_payment_method').val()==11) { $('#default_payment_day').attr('readonly',''); $('#tr_bank_accountNumber').hide();$('#tr_credit_card').show();$('#tr_credit_card_name').show(); $('#tr_credit_card_vcs').show();$('#tr_credit_card_expiration_date').show(); refreshUI(); } else if ($('#sr_payment_method').val()==1) {  $('#tr_bank_accountNumber').hide(); $('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide();  } else if ($('#sr_payment_method').val()==16) { $('#tr_bank_accountNumber').hide();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_expiration_date').hide(); $('#tr_credit_card_vcs').hide(); } else { $('#default_payment_day').val(20);$('#default_payment_day').attr('readonly','readonly'); $('#tr_bank_accountNumber').show();$('#tr_credit_card').hide();$('#tr_credit_card_name').hide(); $('#tr_credit_card_vcs').hide();$('#tr_credit_card_expiration_date').hide(); refreshUI(); }");
		if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
		if ($_GET['action']!="edit_client") $this->hidden=array("credit_card","credit_card_name","credit_card_expiration_date","credit_card_vcs");
		}
	
		if ($this->_group_permissions(3,$user_account['groups'])) { //reseller
		if ($_GET['action']!="edit_client") $this->hidden=array("credit_card","credit_card_name","credit_card_expiration_date","credit_card_vcs");
          //      $this->tabs=array();
        //        $tab=array("title"=>"Ficha de cliente","mod"=>"isp_clients"); 
      //          array_push($this->tabs,$tab);
//                $tab=array("title"=>"Password Panel de control","mod"=>"sys_users","xfield1"=>"sr_user","xfield2"=>"id"); 
  //              array_push($this->tabs,$tab);
    //            $this->editorTabs($this->tabs);
                }

               if ($user_account['username']=="demo") {
                        $this->readonly=array("name","cif","sector","contacts","email","billing_email","web","phone","alt_phone","address","location","zipcode","province","country","newsletter","bank_accountNumber");
                        $this->hidden=array("sr_payment_method","newsletter","bank_accountNumber","username","password"); 
                }
	
                // block edit name and cif only if editing (on insert is allowed)
                if ($_GET['_']=="e") {
                array_push($this->readonly,"name");
                array_push($this->readonly,"cif");
                }

		 $this->action("accept_sepa","/usr/local/kms/mod/isp/stripe/accept_sepa.php");



	}

	function onInsert($post,$id) {
		include "shared/db_links.php";
                //insert contact & client to ERP
		$post['creation_date']=date('Y-m-d H:i:s');
		unset($post['return_mod']);unset($post['from']);unset($post['mod']);
		unset($post['panelmod']);unset($post['xid']);unset($post['id']);unset($post['dr_folder']);
		$tmp=array();
		$tmp['billing_client']=$post['billing_client'];unset($post['billing_client']);
		$tmp['billing_email']=$post['billing_email'];unset($post['billing_email']);
		$tmp['sr_payment_method']=$post['sr_payment_method'];unset($post['sr_payment_method']);
		$tmp['bank_name']=$post['bank_name'];unset($post['bank_name']);
		$tmp['bank_accountNumber']=$post['bank_accountNumber'];unset($post['bank_accountNumber']);
		$tmp['credit_card']=$post['credit_card'];unset($post['credit_card']);
		$tmp['credit_card_name']=$post['credit_card_name'];unset($post['credit_card_name']);
		$tmp['credit_card_expiration_date']=$post['credit_card_expiration_date'];unset($post['credit_card_expiration_date']);
		$tmp['credit_card_vcs']=$post['credit_card_vcs'];unset($post['credit_card_vcs']);
		$tmp['default_payment_day']=$post['default_payment_day'];unset($post['default_payment_day']);
		$tmp['cif']=$post['cif'];unset($post['cif']);
                $post['status']="active";
		$post['comesFrom']="reseller  ".$post['name'];
		$contact=$post;
		unset($contact['username']);
		unset($contact['password']);
//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125')  {  print_r($contact);exit;}
		$id_contact=$this->dbi->insert_record("kms_ent_contacts",$contact,$dblink_isp);
		$id_contact=$this->dbi->insert_record("kms_ent_contacts",$contact,$dblink_erp);
		$post['sr_client']=$id_contact;
		unset($post['name']);unset($post['comes_from']);unset($post['sector']);unset($post['contacts']);
		unset($post['language']); unset($post['web']);unset($post['alt_phone']);unset($post['address']);
		unset($post['location']);unset($post['zipcode']);unset($post['country']);unset($post['province']);
		unset($post['newsletter']);
		$post['cif']=$tmp['cif'];
		$post['status']='active';
		$post['payment_status']="al corrent";
		$post['type']="empresa";
		$post['billing_client']=$tmp['billing_client'];
		$post['billing_email']=$tmp['billing_email'];
		$post['sr_payment_method']=$tmp['sr_payment_method'];
		$post['bank_name']=$tmp['bank_name'];
		$post['bank_accountNumber']=$tmp['bank_accountNumber'];
		$post['credit_card']=$tmp['credit_card'];
		$post['credit_card_name']=$tmp['credit_card_name'];
		$post['credit_card_expiration_date']=$tmp['credit_card_expiration_date'];
		$post['credit_card_vcs']=$tmp['credit_card_vcs'];
		$post['default_payment_day']=$tmp['default_payment_day'];
		$id_client=$this->dbi->insert_record("kms_ent_clients",$post,$dblink_erp);
		//update and enable client
		$select="SELECT * FROM kms_isp_clients WHERE sr_user=".$this->user_account['id'];
                $result=mysql_query($select,$dblink_cp);
                $client=mysql_fetch_array($result);
		unset($post['payment_status']);unset($post['comesFrom']);unset($post['empresa']);unset($post['type']);
		unset($post['billing_client']);
		$post['sr_client']=$id_contact;
		$post['sr_provider']=$client['sr_client'];
		

                // create username
                if ($post['username']=="") {
                        //check if username exists
                        $post['username']=substr(strtolower(str_replace(" ","",$post['name'])),0,10);
			$post['password']=rand(10000000,99999999);
			$u=$this->dbi->get_record("select username from kms_sys_users where username='".$post['username']."'",$dblink_cp);
                        if ($u['username']==$post['username']) {
//                                $this->trace("username already exists, renaming...");
                                $post['username']=$post['username'].$isp_client_id;
                        }
		}

                if ($post['type']=="reseller") $client_group=3; else $client_group=2;  //client or reseller
		if ($post['type']=="reseller"&&$post['billing_client']=="1") $client_group=2; //user (no invoices)
                $user=array("creation_date"=>date('Y-m-d H:i:s'),"username"=>$post['username'],"upassword"=>$post['password'],"password_type"=>"plain","groups"=>$client_group,"status"=>"active","language"=>$entity['language'],"email"=>$post['email']);
		$sr_user=$this->dbi->insert_record("kms_sys_users",$user,$dblink_cp);
                // sets sr_user field
		$post['sr_user']=$sr_user;
		$this->dbi->update_record("kms_isp_clients",$post,"id=".$id,$dblink);
		$this->dbi->update_record("kms_ent_clients",$post,"id=".$id_client,$dblink_erp);
		//replicate isp client to ERP
                $dblink=$this->dbi->db_connect("erp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $id=$this->dbi->insert_record("kms_isp_clients",$dblink);
	}

	function onUpdate($post,$id) {
		include "shared/db_links.php";
		$client_extended=$this->dbi->get_record("SELECT * from kms_isp_clients WHERE id=$id",$dblink_cp);
		//update user language
		if ($client_extended['sr_user']!="")  {
			if ($this->_group_permissions(3,$user_account['groups'])) $client_group=3; else $client_group=2;  //reseller(3) or client(2)
	//		if ($client_group==3&&$post['billing_client']=="1") $client_group=4; //user (no invoices)
			$update="UPDATE kms_sys_users SET groups='{$client_group}',language='".$post['language']."',email='".$post['email']."' WHERE id=".$client_extended['sr_user'];
	                $this->dbi->query($update);
		} else {
			$this->_error("","El client #$id no disposa d'usuari en el panell de control");
//			$id_contact=$this->dbi->insert_record("kms_sys_users",$post,$dblink_erp)
		}
		$_SESSION['user_lang']=$_SESSION['lang']=$post['language'];
		$this->user_account['language']=$post['language'];

		//replicate to ERP
		$dblink=$this->dbi->db_connect("erp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$isp_client=array();
		foreach ($post as $i=>$var) { 
			if ($i!="return_mod"&&$i!="from"&&$i!="panelmod"&&$i!="xid"&&$i!="id"&&$i!="mod"&&$i!="app") $isp_client[$i]=$var;
		}	
		$this->dbi->update_record("kms_isp_clients",$isp_client,"id=".$id,$dblink_cp);
		$this->dbi->update_record("kms_isp_clients",$isp_client,"sr_client=".$client_extended['sr_client'],$dblink_erp);
		//backup client data and send to admin email
		$select="select * from kms_ent_clients WHERE sr_client=".$client_extended['sr_client'];
		$result=$this->dbi->query($select,$dblink);
		$original_client=mysql_fetch_array($result);	
		$select="select * from kms_ent_contacts WHERE id=".$client_extended['sr_client'];
                $result=$this->dbi->query($select,$dblink);
                $original_entity=mysql_fetch_array($result);		
		foreach ($original_client as $field => $value) if (!is_numeric($field)) $data_client.="<tr><td>".$field."</td><td>".$value."</td></tr>";
		$body="El client #".$original_client['id']." ha actualitzat les seves dades des del panell de control.<br>A continuaci&oacute; segueix una c&ograve;pia de seguretat de les dades originals (abans de fer els canvis).<br><br><b>kms_ent_clients:<br></b><br><table border=1 style='border-collapse:collapse'>".$data_client."</table>";
		foreach ($original_entity as $field => $value) if (!is_numeric($field)) $data_entity.="<tr><td>".$field."</td><td>".$value."</td></tr>";
		$body.="<b><br>ORIGINAL DATA<br>kms_ent_contacts:</b><br><br><table border=1 style='border-collapse:collapse'>".$data_entity."</table>";
		$link="http://intranet.intergrid.cat/index.php?app=contacts&mod=contacts_clients&_=e&id=".$original_client['id'];
		$body.="<br><br>Per accedir a la fitxa actualitzada: <a href='$link'>$link</a><br><br><br>";
		$body.="--<br>INTERGRID KMS";
		$from="kms@intergrid.cat";$to="j.berenguer@intergrid.cat";
		$subject="Dades de client #".$original_client['id']." actualitzades";
		$email = new Email($from,$to,$subject,$body,1);
		$goodemail = $email->send();
		if (!$goodemail) echo "failed sending email notification to admin.";
		//update ERP contacts_clients
		$fields_to_update=array("sr_client","dr_folder","creation_date","status","sr_provider","phone","email","billing_email","sr_payment_method","default_payment_day","bank_name","bank_accountNumber","credit_card","credit_card_name","credit_card_expiration_date","credit_card_vcs","sr_user");
		$merge=array_merge($client_extended,$post);
		$update=$this->dbi->make_update($merge,"kms_ent_clients","sr_client=".$client_extended['sr_client'],$fields_to_update);
		$this->dbi->query($update,$dblink);
		//update erp_contracts 
		$fields_to_update=array("payment_method");
		$post_=array();
		$post_['payment_method']=$post['sr_payment_method'];
		$update=$this->dbi->make_update($post_,"kms_erp_contracts","sr_client=".$client_extended['sr_client'],$fields_to_update);
		$this->dbi->query($update,$dblink_erp);
		$this->dbi->query($update,$dblink);
        }
}
?>
