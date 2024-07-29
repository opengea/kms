<?

// ----------------------------------------------
// Class Entities > Clients for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ent_staff extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table		= "kms_ent_staff";
	var $key		= "id";	
	var $fields	 	= array("id","creation_date", "contact_id", "cif", "department","salary","quota_ss");
	var $notedit 		= array("dr_folder","sr_user");
//	var $readonly		= array("sr_user");
	var $title		= "Clients";
	var $orderby		= "creation_date";
	var $sortdir		= "desc";
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit 		= true;
        var $can_delete 	= true;
        var $can_add   		= true;
        var $can_import 	= false;
        var $can_export 	= true;
        var $can_search 	= true;
	var $can_print		= true;
	var $can_duplicate	= false; //no activar, dona problemes.

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ent_staff($client_account,$user_account,$dm) {
                // Edit Tabs
                /*$sel="select * from kms_ent_staff where id=".$_GET['id'];
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
		$this->setComponent("checklist","is_administrator",array("1"=>""));
		$this->setComponent("xcombo","contact_id",array("xtable"=>"kms_ent_contacts","xkey"=>"id", "xfield"=>"name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
		$this->setComponent("xcombo","user_id",array("xtable"=>"kms_sys_users","xkey"=>"id", "xfield"=>"username","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));	
		$this->addComment("quota_ss"," (p.e. quota mensual aut&ograve;noms, en cas que no la pagui l'empresa)");
		$this->defvalue("status","active");
		$this->defvalue("type","empresa");
		$this->defvalue("sr_payment_method","3");
		$this->defvalue("default_payment_day",20);
		$this->defvalue("force_payment_day","renewals");
		$this->humanize("sr_provider","Prove&iuml;dor");
		$this->humanize("retencio_aplicable","Retenci&oacute; aplicable % (<a href='https://www2.agenciatributaria.gob.es/wcl/PRET-RW00/index.zul'>calcular</a>)");
		$this->humanize("salary","Sou (&euro;)");
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

                $this->setValidator("email","email");
		$this->setValidator("username","alphanumeric");
		$this->setValidator("bank_accountNumber","ccc");
		$this->setStyle("quota_ss","width:100px","be");	
		$this->setComponent("select","regim",array("1"=>"General","2"=>"Aut&ograve;noms"));
		$this->humanize("regim","R&egrave;gim");
		$this->humanize("quota_ss","Quota Mensual S.S. (&euro;)");
		$this->setComponent("ckeditor_standard","comments");
	}


}
?>
