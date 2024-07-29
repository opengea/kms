<?

// ----------------------------------------------
// Class Ecommerce Services for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_services extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table     = "kms_ecom_services";
	var $key       = "id";
	var $fields = array("id","checked","status","family", "subfamily", "name", "name_ca","setupPrice", "monthlyPrice", "anualPrice","cost_price","price_type");
	var $orderby = "subfamily";
	var $hidden = array();
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_services ($client_account,$user_account,$dm) {
                if ($_GET['view']=="") $this->where="kms_ecom_services.status='active'";
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->defvalue("status","active");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "catalog";
		$this->default_php = "services";
		$this->insert_label = _NEW_ECOM_SERVICE;
		$this->humanize("price_type","Tipus");
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("select","default_billing_period",array("1M"=>"Mensual","3M"=>"Trimestral","6M"=>"Semestral","1Y"=>"Anual","2Y"=>"2 anys","3Y"=>"3 anys","4Y"=>"4 anys","5Y"=>"5 anys","6Y"=>"6 anys","7Y"=>"7 anys","8Y"=>"8 anys","9Y"=>"9 anys","10Y"=>"10 anys"));

		$this->setComponent("checklist","highlight",array(1=>""));
		$this->setComponent("wysiwyg","description");
		$this->setComponent("xcombo","family",array("xtable"=>"kms_ecom_families","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","subfamily",array("xtable"=>"kms_ecom_subfamilies","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>220,"resize_max_height"=>165,"thumb_max_width"=>125,"thumb_max_height"=>125,"scaleType"=>"w"));
		$this->setComponent("xcombo","sr_vat",array("xtable"=>"kms_ecom_vat","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));

		$this->tabs=array();
                $tab=array("title"=>_KMS_GL_SERVEI,"mod"=>"ecom_services"); array_push($this->tabs,$tab);
                $tab=array("title"=>"Limits del pla de serveis","mod"=>"isp_hostings_plans","xkey1"=>"id","xkey2"=>"sr_service"); array_push($this->tabs,$tab);
                $this->editorTabs($this->tabs);
		$this->setComponent("select","price_type",array("0"=>"Fix","1"=>"Variable"));

                $this->styleRow=array("field"=>"checked","styles"=>array(""=>"font-family:arial;font-weight:bold","0"=>"font-family:arial;font-weight:bold", "1"=>"font-family:arial;font-weight:normal"));
                $this->setStyle("checked","width:25px","be");
                $this->abbreviate("checked","&nbsp; V");
                $this->setComponent("status_icon", "checked", array("script"=>"checked","show_label"=>true));


                $this->styleRow=array("field"=>"featured","styles"=>array(""=>"font-family:arial;font-weight:bold","0"=>"font-family:arial;font-weight:bold", "1"=>"font-family:arial;font-weight:normal"));
                $this->setComponent("status_icon", "featured", array("script"=>"featured","show_label"=>true));



                if ($_GET['_']=="e") { $this->setComponent("checklist","checked",array("1"=>""));
					$this->setComponent("checklist","featured",array(1=>""));
		}
					

		$this->onInsert = "onInsert";
		$this->onUpdate = "onUpdate";
		$this->onDelete = "onDelete";

		if ($_GET['_']=="e") {
			   include "shared/db_links.php";
			  $servei=$this->dbi->get_record("SELECT family FROM kms_ecom_services where id=".$_GET['id']);
			  if ($servei['family']=="1") { //dominis
							 $this->humanize("quarterPrice","Preu de trasnferència");
							 $this->humanize("anualPrice","Preu de renovació anual");
							 array_push($this->hidden,"monthlyPrice");
							 }
		}

	}

	function onInsert($post,$id) {
		$service=$this->dbi->get_record("select * from kms_ecom_services where id=$id");
		$dblink_isp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$this->dbi->insert_record("kms_ecom_services",$service,$dblink_isp);	
	}

	function onUpdate($post,$id) {
                $service=$this->dbi->get_record("select * from kms_ecom_services where id=$id");
                $dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $this->dbi->update_record("kms_ecom_services",$service,"id=$id",$dblink_cp);
        }

	function onDelete($post,$id) {
                $dblink_isp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
                $this->dbi->delete_record("kms_ecom_services","id=$id",$dblink_isp);
        }


}
?>

