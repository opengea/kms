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
	var $fields = array("id", "status", "fromemail", "to_group", "subject", "report_total_emails", "send_date");
	var $notedit = array("dr_folder","report_total_contacts","report_total_emails","report_total_opened","report_total_delivered","report_total_bounced","report_total_pending","report_total_bounced_invalid","report_total_bounced_spam","report_total_bounced_fullbox","report_total_bounced_others","send_date");
	var $title = TY_MAILINGS;
	var $orderby = "id";
	var $sortdir = "desc";
	var $readonly = array("report_total_contacts","report_total_opened","serial","dr_folder","creation_date","send_date","status");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function imark_mailings ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		//date_default_timezone_set('UTC');
		$uploadDate = date('D j M Y');
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("send_date",$uploadDate);
		//$this->defvalue("topmenu","");
		$this->defvalue("logo","logo.png");
		$this->defvalue("robots","all");
		$this->defvalue("status","pending");
		$this->defvalue("language",$_SESSION['lang']);
		$this->defvalue("to_location","");
		$this->defvalue("unsubscribe_link",1);
		$this->defvalue("show_intergrid_label",1);
		$this->setComponent("checklist","unsubscribe_link",array("1"=>""));
		$this->setComponent("checklist","show_intergrid_label",array("1"=>""));
		$this->insert_label = _NEW_MAILING;
		$this->setComponent("select","status",array("pending"=>"<font color='#BB0000'>"._KMS_MAILING_PENDING."</font>", "sending"=>"<font color='#009900'>"._KMS_MAILING_SENDING."</font>","sent_and_processing"=>"<font color='#009900'>"._KMS_MAILING_SENT_AND_PROCESSING."</font>", "sent"=>"<font color='#009900'>"._KMS_MAILING_SENT."</font>","aborted"=>"<font color='#777777'>"._KMS_MAILING_ABORTED."</font>"));
		$this->setComponent("select","language",array("ct"=>_KMS_LANG_CT,"es"=>_KMS_LANG_ES,"en"=>_KMS_LANG_EN,"pt"=>_KMS_LANG_PT));
		$this->defvalue("template","_KMS_TEMPLATES_DEFAULT");
		$this->setComponent("multiselect","to_group",array("select * from kms_groups where type='contacts' order by name","name","id"));
		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>_KMS_BUT_MAILINGPREVIEW,"url"=>"/kms/mod/emailing/xidailing.php","ico"=>"massmail.gif","params"=>"&preview");
//$this->customOptions[1] = Array ("label"=>_KMS_BUT_SENDMAILING,"url"=>"/kms/mod/emailing/xidailing.php?","ico"=>"massmail.gif");
		$this->customOptions[1] = Array ("label"=>_KMS_BUT_MAILINGREPORT,"url"=>"/kms/mod/emailing/mod/reports/report.php","ico"=>"stats.gif","target"=>"stats");
		$this->setComponent("wysiwyg","body");
                $this->setComponent("xcombo","template",array("xtable"=>"kms_sys_templates","xkey"=>"name","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select * from kms_sys_templates"));
		$this->setComponent("xcombo","to_location",array("xtable"=>"kms_contacts","xkey"=>"location","xfield"=>"location","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct location from kms_contacts where location!=''"));
		$this->setComponent("xcombo","to_country",array("xtable"=>"kms_contacts","xkey"=>"country","xfield"=>"country","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct country from kms_contacts where country!=''"));
                $this->setComponent("xcombo","to_language",array("xtable"=>"kms_contacts","xkey"=>"language","xfield"=>"language","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct language from kms_contacts where language!=''"));
                $this->setComponent("xcombo","to_zipcode",array("xtable"=>"kms_contacts","xkey"=>"zipcode","xfield"=>"zipcode","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select distinct zipcode from kms_contacts where zipcode!=''"));
		$this->sum = array("report_total_emails");
	}
}
?>
