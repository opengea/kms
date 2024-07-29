<?

// ----------------------------------------------
// Class Mailings for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class imark_mailings extends mod {

        /*=[ CONFIGURATION ]=====================================================*/
	var $table	= "kms_imark_mailings";
	var $key	= "id";	
	var $fields = array("id", "status", "fromemail", "to_group", "subject", "report_total_emails", "send_datetime");
	var $notedit = array("dr_folder","report_total_contacts","report_total_emails","report_total_opened","report_total_delivered","report_total_bounced","report_total_pending","report_total_bounced_invalid","report_total_bounced_spam","report_total_bounced_fullbox","report_total_bounced_others");
	var $title = _KMS_TY_MAILINGS;
	var $orderby = "id";
	var $sortdir = "desc";
	var $readonly = array("report_total_contacts","report_total_opened","serial","dr_folder","creation_date");
	var $hidden = array("url_body","creation_date","to_location","to_from_creation_date","to_zipcode","show_brandname","unsubscribe_label","to_sector","to_state","to_province","to_country","to_language");
	
	var $can_duplicate = true;
       //*=[ CONSTRUCTOR ]===========================================================*/

        function imark_mailings ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		//date_default_timezone_set('UTC');
		$this->addComment("show_brandname",_KMS_MAILING_BRANDNAME5PC); //"Si es desmarca aquesta opci&oacute; s'aplicar&agrave; un increment d'un 5% a la tarifa.");
		$this->addComment("from_email",_KMS_IMARK_FROM_EMAIL_NOTE);
		$this->addComment("preview_text",_KMS_IMARK_PREVIEW_TEXT_EXPLAIN);
                $uploadDate = date('Y-m-d H:i:s');
                $this->defvalue("creation_date",$uploadDate);
                $this->defvalue("send_datetime",$uploadDate);
                $this->defvalue("auto_send",0);
                $this->setComponent("checklist","auto_send",array("1"=>""));
                $this->onFieldChange("auto_send","if ($('#auto_send').val()=='1') $('#tr_send_datetime').show(); else $('#tr_send_datetime').hide()");
                $this->onDocumentReady("if ($('#auto_send').val()=='1') $('#tr_send_datetime').show(); else $('#tr_send_datetime').hide()");

		//$this->defvalue("topmenu","");
		$this->defvalue("logo","logo.png");
		$this->defvalue("robots","all");
		$this->defvalue("status","pending");
		$this->defvalue("language",$_SESSION['lang']);
		$this->defvalue("to_location","");
		$this->defvalue("show_unsubscribe","1");
		$this->defvalue("show_brandname","1");
//		$this->defvalue("show_intergrid_label",1);
		$this->setComponent("checklist","show_unsubscribe",array("1"=>""));
		$this->setComponent("checklist","show_brandname",array("1"=>""));
		$this->insert_label = _NEW_MAILING;
		$this->setComponent("select","status",array("pending"=>"<font color='#BB0000'>"._KMS_MAILING_PENDING."</font>", "sending"=>"<font color='#009900'>"._KMS_MAILING_SENDING."</font>","sent_and_processing"=>"<font color='#009900'>"._KMS_MAILING_SENT_AND_PROCESSING."</font>", "sent"=>"<font color='#009900'>"._KMS_MAILING_SENT."</font>","aborted"=>"<font color='#777777'>"._KMS_MAILING_ABORTED."</font>"));
		$this->setComponent("select","language",array("ca"=>_KMS_LANG_CT,"es"=>_KMS_LANG_ES,"en"=>_KMS_LANG_EN,"pt"=>_KMS_LANG_PT));
		$this->defvalue("template","1");
//		$this->setComponent("multiselect","to_group",array("sql"=>"select * from kms_sys_groups where type='ent_contacts' order by name","xfield"=>"name","xkey"=>"id","xtable"=>"kms_sys_groups"));
		$this->setComponent("multixref","to_group",array("sql"=>"select * from kms_sys_groups where type='ent_contacts' order by name","xfield"=>"name","xkey"=>"id","xtable"=>"kms_sys_groups"));

		$this->can_view=false;
		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>_KMS_BUT_MAILINGPREVIEW,"url"=>"","ico"=>"massmail.png","params"=>"action=domailing&preview","target"=>"_self","checkFunction"=>"","class"=>"highlight");
//$this->customOptions[1] = Array ("label"=>_KMS_BUT_SENDMAILING,"url"=>"/kms/mod/emailing/domailing.php?","ico"=>"massmail.gif");
		$this->action("domailing", "/usr/share/kms/mod/emailing/domailing.php");
		$this->action("start", "/usr/share/kms/mod/emailing/domailing.php");
		$this->customOptions[1] = Array ("label"=>_KMS_BUT_MAILINGREPORT,"url"=>"","ico"=>"stats.png","params"=>"action=mailing_report","target"=>"stats");
//		if ($_SESSION['user_name']=="root") $this->customOptions[2] = Array ("label"=>_KMS_BUT_MAILINGRESUME,"url"=>"/kms/mod/emailing/domailing.php?","ico"=>"mailingresume.gif","params"=>"&preview&resume=1");
		if ($_SESSION['user_name']=="root") $this->customOptions[2] = Array ("label"=>_KMS_BUT_MAILINGRESUME,"url"=>"","ico"=>"mailingresume.gif","params"=>"action=domailing&preview&resume=1","target"=>"_self","checkFunction"=>"","class"=>"highlight");

		$this->action("mailing_report","/usr/share/kms/mod/emailing/mod/reports/report.php");
		$this->action("download_xls","/usr/share/kms/mod/emailing/mod/reports/download_xls.php");
		$this->action("get_report","/usr/share/kms/mod/emailing/mod/reports/get_report.php");

//		$this->setComponent("wysiwyg","body");
		$this->setComponent("ckeditor_standard","body",array("type"=>"html"));

                $this->setComponent("xcombo","template",array("xtable"=>"kms_imark_templates","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select id,name from kms_imark_templates"));
		//$this->setComponent("xcombo","to_location",array("xtable"=>"kms_ent_contacts","xkey"=>"location","xfield"=>"location","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct location from kms_ent_contacts where location is not null"));
		$this->setComponent("multiselect","to_location",array("sql"=>"select distinct location from kms_ent_contacts order by location","xfield"=>"location","xkey"=>"location","xtable"=>"kms_ent_contacts"));
//		$this->setComponent("multiselect","to_province",array("sql"=>"select distinct province from kms_ent_contacts order by province","xkey"=>"province","xkey"=>"province","xtable"=>"kms_ent_contacts"));

		$this->setComponent("xcombo","to_country",array("xtable"=>"kms_ent_contacts","xkey"=>"country","xfield"=>"country","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct country from kms_ent_contacts where country!=''"));
                $this->setComponent("xcombo","to_language",array("xtable"=>"kms_ent_contacts","xkey"=>"language","xfield"=>"language","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct language from kms_ent_contacts where language!=''"));
                $this->setComponent("xcombo","to_zipcode",array("xtable"=>"kms_ent_contacts","xkey"=>"zipcode","xfield"=>"zipcode","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct zipcode from kms_ent_contacts where zipcode!=''"));
		$this->sum = array("report_total_emails");

		$this->setGroup("_KMS_IMARK_MAILINGS_FROM_SELECT",false,array("fromemail","fromname","replyto"));
		$this->setGroup("_KMS_IMARK_MAILINGS_RECIPIENT_SELECT",false,array("to_group","to_sector","to_state","to_province","to_location","to_country","to_language", "to_zipcode", "to_email", "to_from_creation_date"));
		$this->setGroup("_KMS_IMARK_MAILINGS_MAIL_CONTENT",false,array("subject","preview_text","template","language","body","url_body"));
		$this->setGroup("_KMS_IMARK_MAILINGS_OPTIONS",false,array("auto_send","send_datetime","show_unsubscribe","show_brandname"));
		$this->onPreDelete = "onPreDelete";
		$this->onDuplicate= "onDuplicate";
	}

	function onPreDelete($post,$id) {
		$mailing=$this->dbi->get_record("select report_total_emails from kms_imark_mailings where id=".$id);	
		if ($mailing['report_total_emails']>10)  $this->_error("",_KMS_IMARK_MAILINGS_ERROR1,"fatal");
	}
	
	function onDuplicate($post,$id) {
                $update=array("status"=>"pending","auto_send"=>"0","send_datetime"=>"","report_total_emails"=>0);
                $this->dbi->update_record("kms_imark_mailings",$update,"id=".$id);
        }

}

?>
