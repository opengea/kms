<?

// ----------------------------------------------
// Class Ecommerce TPV for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_tpv extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_tpv";
	var $key	= "id";	
	var $fields = array("id", "status", "tpv_description", "tpv_merchantname", "tpv_urlMerchant");
	var $orderby = "id";
	var $readonly = array("dr_folder");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_tpv ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->defvalue("status","1");
                $this->setComponent("select","status",array("1"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","0"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
 
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "ecom_tpv";
		$this->insert_label = _NEW_TPV;
		$this->setComponent("checklist","highlight",array("SI"=>"Si"));
	}
}
?>
