<?php

// ----------------------------------------------
// Class System Folders for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_folders extends mod {

	/*=[ CONFIGURACIO ]=====================================================*/

	var $table	= "kms_sys_folders";
	var $key	= "id";	
	var $fields 	= array("id", "shortcut_to", "external_url", "content_type", "default_view", "description", "group",  "creation_date","custom_icon");
	// no tots els clients tenen custom_icon. Revisar
	var $notedit 	= array("permisions","owner");
	var $orderby	= "description";
	var $sortdir	= "asc";
	var $exclude 	= array("deleted");
	var $excludeBrowser = array("default_view","content_type","external_url","shortcut_to","custom_icon");
	//var $readonly = array("creation_date");
	var $linkfield	= "description";
	var $page_rows = 200;
	var $page_links = 200;
	var $ts_format  = "m/d/Y h:i A";
	//var $show_key = true;
	var $insert_label = _NEW_FOLDER;
	var $default_content_type = "sys_folders";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = false;
        var $can_import = false;
        var $can_export = false;
        var $can_search = false;
	var $can_config = false;
	var $can_duplicate = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

       function sys_folders($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

       function setup($client_account,$user_account,$dm) {

	if ((isset($_GET["dr_folder"])&&($_GET["dr_folder"]!=''))) {
	        $where = "parent = ".$_GET['dr_folder']." and deleted != 'Y'";
	        $this->bf = $_GET['dr_folder'];
        	$this->dr_folder = $_GET['dr_folder'];
	} else {
	        $where = "parent = '".$_SESSION['user_folderid']."' and deleted != 'Y'";
         	$this->bf = "0";
         	$this->dr_folder = "0";
        	 // serveix per a que surti el nom del directori del home user
         	$_GET['dr_folder']=$_SESSION['user_folderid'];
	}

	$title = ucfirst($this->current_subdomain); 

	$this->safedel("deleted","Y",_MB_SENDTOTRASH);
	$this->defvalue("shortcut_to","-1");
	$this->defvalue("status","pendent");
	$this->defvalue("priority","normal");
	$this->defvalue("content_type","folders");
	$this->defvalue("deleted","N");
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	

	// ----------- components -----------------
	// Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
	//$this->setComponent("cipher","Password","MD5");
	//$this->setComponent("cipher","CardNum","MD5");
	$this->setComponent("uniselect","content_type");
	//$this->setComponent("multiselect","Colors");
	$user_groups = explode ("|", $_SESSION['user_groups']);
	if (in_array("admin",$user_groups)||$_SESSION['user_name']=="root") {
		// l'usuari amb grup admin ho veu tot
		$this->xcombo("group", "kms_groups", "id", "name", false, false ,false);	
	} else {
		// l'usuari nomes pot crear carpetes dels grups al que pertany
		for ($i=0;$i<count($user_groups);$i++) { 
			$conditions.="id='".$user_groups[$i]."' OR ";
		 }
		$conditions  = substr($conditions,0,strlen($conditions)-4);
		$this->xcombosql("group","select * from kms_groups where  (".$conditions.")","name","id",false);
	}
	$this->setComponent("select","show_as",array(""=>"list","icons"=>"icons","menu"=>"menu"));
	$this->setComponent("uniselect","custom_icon",true);
	$this->xcombosql("default_view", "select * from kms_sys_views where `module`='[content_type]' order by name","name","id",false);
	// editor wysiwyg
	//$this->setComponent("wysiwyg","notes");
	//$this->dbi->debug = true;


	} // constructor

} // end class
?>
