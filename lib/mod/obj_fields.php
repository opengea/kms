<?

// ----------------------------------------------
// Class Ecommerce Families for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class obj_fields extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_obj_fields";
	var $key	= "id";	
	var $fields = array("obj_id", "name", "type", "size", "defvalue", "required", "readonly", "hidden", "humanize", "rule", "events", "options");
	var $orderby    = "id";
	var $sortdir    = "asc";
	var $readonly = array("");
	var $notedit= array("");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function obj_fields ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->setComponent("select","status",array("inactive"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "active"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->defvalue("priority","normal");
		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);


		//$this->validate("Email");
		//$this->validate("WWW");

		$this->insert_label = _NEW_PRODUCT_FAMILY;
		//$linkfield = "title";
		$this->setComponent("checklist","highlight",array("SI"=>"Si"));
		$this->setComponent("xcombo","obj_id",array("xtable"=>"kms_obj","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("select","type",array("integer"=>"integer","float"=>"float","textfield"=>"textfield","date"=>"date","datetime"=>"datetime","boolean"=>"boolean","password"=>"password","color"=>"color","list"=>"list","text"=>"text","html"=>"html","image"=>"image","video"=>"video","tags"=>"tags","json"=>"json"));
		$this->setComponent("file","zipfile",array($this->kms_datapath."files/catalog/download","files/catalog/download",true,"75","100"));
                $this->onInsert = "onInsert";
                $this->onDelete = "onDelete";
        }
        function onInsert($post,$id) {
		$obj=$this->dbi->get_record("SELECT * FROM kms_obj WHERE id=".$post['obj_id']);
		//add field
		switch ($post['type']) {
			case 'integer':
				$type="INT(11)";
				break;
			case 'float':
				$type="FLOAT";
				break;
			case 'textfield':
				if ($post['size']!="") $size=$post['size']; else $size=150;
				$type="VARCHAR($size)";
				break;
			case 'date':
				$type="DATE";
				break;
			case 'datetime':
                                $type="DATETIME";
                                break;
			case 'boolean':
                                $type="INT(1)";
                                break;
			case 'password':
                                $type="VARCHAR(16)";
                                break;
			case 'color':
                                $type="VARCHAR(7)";
                                break;
			case 'list':
                                $type="VARCHAR(40)";
                                break;
			case 'text':
                                $type="TEXT";
                                break;
			case 'html':
                                $type="TEXT";
                                break;
			case 'image':
				$type="VARCHAR(150)";
				break;
			case 'video':
				$type="VARCHAR(150)";
				break;
			case 'tags':
				$type="TEXT";
				break;
			case 'json':
				$type="TEXT";
				break;
		}
	
                $alter="ALTER TABLE `kms_obj_usr_".$obj['name']."` ADD ".$post['name']." ".$type;
                $result=$this->dbi->query($alter);
                if (!$result) $this->_error("","error onInsert ".mysqli_error($result),"fatal");

        }

        function onDelete($post,$id) {
		$obj=$this->dbi->get_record("SELECT * FROM kms_obj WHERE id=".$post['obj_id']);

                $delete="ALTER TABLE `kms_obj_usr_".$obj['name']."` DROP COLUMN ".$post['name'];
                $result=$this->dbi->query($delete);
                if (!$result) $this->_error("","error onDelete ".mysqli_error($result),"fatal");
        }


}
?>
