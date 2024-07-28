<?

// ----------------------------------------------
// Class Ecommerce Catalogs for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class db_catalogs extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_db_catalogs";
	var $key	= "id";	
	var $fields = array("id", "creation_date", "status", "type", "name");
	var $orderby = "type";
	var $notedit = array("dr_folder");
	var $readonly = array("dr_folder");

	/*=[ PERMISOS ]===========================================================*/

	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = true;
	var $can_export = true;
	var $can_duplicate = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_views($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","1");
		$this->defvalue("priority","normal");
		$this->defvalue("stock","-1");
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("highlight",0);

		$this->default_content_type = "catalog";
		$this->default_php = "catalog.php";
		$this->insert_label = _NEW_PRODUCT;
		$this->setComponent("select","status",array("1"=>"<font color='#009900'>"._KMS_GL_STATUS_ACTIVE."</font>", "0"=>"<font color='#990000'>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("select","type",array("products"=>_KMS_TY_ECOM_PRODUCTS, "services"=>_KMS_TY_ECOM_SERVICES));
		$this->setComponent("select","content_type",array("services"=>_KMS_TY_SERVICES, "products"=>_KMS_TY_PRODUCTS, "software"=>_KMS_TY_SOFTWARE,  "audio"=>_KMS_TY_AUDIOFILES, "music"=>_KMS_TY_MUSIC, "pictures"=>_KMS_TY_PICTURES, "reservations"=>_KMS_TY_RESERVATIONS));
		$this->setComponent("checklist","enable_request_form",array("1"=>""));
		$this->setComponent("checklist","enable_shopping_cart",array("1"=>""));
		$this->setComponent("checklist","enable_tpv",array("1"=>""));
		$this->setComponent("checklist","enable_facebook_ilikeit",array("1"=>""));
		$this->setComponent("checklist","enable_facebook",array("1"=>""));
		$this->setComponent("checklist","enable_twitter",array("1"=>""));
		$this->setComponent("checklist","show_menu_families",array("1"=>""));
		$this->setComponent("select","default_page_catalog",array("description"=>_KMS_ECOM_DEF_DESCRIPTION,"datagrid"=>_KMS_ECOM_DEF_FAMILY_DATAGRID,"datagrid"=>_KMS_ECOM_DEF_PRODUCT_DATAGRID,"list"=>_KMS_ECOM_DEF_LIST,"slide"=>_KMS_ECOM_DEF_SLIDESHOW));
		$this->setComponent("select","default_page_family",array("page"=>_KMS_ECOM_DEF_PAGE,"description"=>_KMS_ECOM_DEF_DESCRIPTION,"datagrid"=>_KMS_ECOM_DEF_DATAGRID,"list"=>_KMS_ECOM_DEF_LIST,"slide"=>_KMS_ECOM_DEF_SLIDESHOW));
		$this->setComponent("select","default_page_subfamily",array("page"=>_KMS_ECOM_DEF_PAGE,"description"=>_KMS_ECOM_DEF_DESCRIPTION,"datagrid"=>_KMS_ECOM_DEF_DATAGRID,"list"=>_KMS_ECOM_DEF_LIST,"slide"=>_KMS_ECOM_DEF_SLIDESHOW));
		$this->setComponent("wysiwyg","description");
                $this->onInsert = "onInsert";
                $this->onDelete = "onDelete";
                $this->onUpdate = "onUpdate";
        }

        function onInsert($post,$id) {
		//create family view
                $insert="INSERT INTO kms_sys_views (`creation_date`,`name`,`module`,`where`,`orderby`,`sort`,`fields`) VALUES ('".date("Y-m-d")."','".$post['name']."','db_families','catalog_id={$id}','creation_date','des','');";
                $result=mysqli_query($this->dblinks['client'],$insert);
		//create subfamily view
		$insert="INSERT INTO kms_sys_views (`creation_date`,`name`,`module`,`where`,`orderby`,`sort`,`fields`) VALUES ('".date("Y-m-d")."','".$post['name']."','db_subfamilies','family IN (select id from kms_db_families where catalog_id={$id})','creation_date','des','');";
                $result=mysqli_query($this->dblinks['client'],$insert);	
		//create object view
                $insert="INSERT INTO kms_sys_views (`creation_date`,`name`,`module`,`where`,`orderby`,`sort`,`fields`) VALUES ('".date("Y-m-d")."','".$post['name']."','db_objects','catalog_id={$id}','creation_date','des','');";
                $result=mysqli_query($this->dblinks['client'],$insert);
        }

}
?>
