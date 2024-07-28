<?

// ----------------------------------------------
// KMS System Mod Attributes Class
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_mod_attributes extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_mod_attributes";
	var $key	= "id";	
	var $fields = array("mod_id", "name", "type", "size", "defvalue", "required", "readonly", "hidden", "humanize", "rule", "events", "options");
	var $orderby    = "id";
	var $sortdir    = "asc";
	var $hidden = array("sort_order");
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

        function sys_mod_attributes ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                // set draggable
                $this->uid=$this-key;
                $this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
                $this->orderby="sort_order";
		$this->addComment("name"," Nom del camp intern de la base de dades, no pot contenir espais ni caracters especials");
		$this->defvalue("status","active");
		$this->setComponent("select","status",array("inactive"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "active"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("checklist","readonly",array("1"=>""));
		$this->setComponent("checklist","hidden",array("1"=>""));	
		$this->setComponent("checklist","required",array("1"=>""));
		$this->setComponent("checklist","clearfix",array("1"=>""));
		
		$this->setComponent("xcombo","mod_id",array("xtable"=>"kms_sys_mod","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));

		$this->setComponent("select","type",array("autocomplete"=>"autocomplete","integer"=>"integer","float"=>"float","relation"=>"relation","textfield"=>"textfield","date"=>"date","date-html5"=>"date (html5)","datetime"=>"datetime","boolean"=>"boolean","password"=>"password","color"=>"color","list"=>"list","openlist"=>"openlist","multiselect"=>"multiselect (2 rows)","multipleselect"=>"multiple select open","multipleselect_rel"=>"multiple select related","text"=>"text","richtext"=>"rich text","html"=>"html","file"=>"file","image"=>"image","video"=>"video","tags"=>"tags","json"=>"json","multilang_textfield"=>"multilanguage textfield","multilang_richtext"=>"multilanguage richtext","multilang_html"=>"multilanguage html"));

		$this->setComponent("file","zipfile",array($this->kms_datapath."files/catalog/download","files/catalog/download",true,"75","100"));

                $this->onInsert = "onInsert";
		$this->onUpdate = "onUpdate";
                $this->onDelete = "onDelete";
        }

	function _getType($t) {
		switch ($t) {
                        case 'integer':
                                $type="INT(11)";
                                break;
			 case 'float':
                                $type="FLOAT";
                                break;
			case 'autocomplete':
                                if ($post['size']!="") $size=$post['size']; else $size=150;
                                $type="VARCHAR($size)";
                                break;
                        case 'relation':
                                $type="INT(11)";
                                break;
                        case 'textfield':
                                if ($post['size']!="") $size=$post['size']; else $size=150;
                                $type="VARCHAR($size)";
                                break;
                        case 'date':
                                $type="DATE";
                                break;
			case 'date-html5':
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
                                $type="VARCHAR(150)";
                                break;
                        case 'openlist':
                                $type="VARCHAR(255)";
                                break;
			case 'multiselect':
                                $type="VARCHAR(255)";
                                break;
                        case 'multipleselect':
                                $type="VARCHAR(255)";
                                break;
                        case 'multipleselect_rel':
                                $type="VARCHAR(255)";
                                break;
                        case 'text':
                                $type="TEXT";
                                break;
                        case 'richtext':
                                $type="TEXT";
                                break;
                        case 'html':
                                $type="TEXT";
                                break;
                        case 'file':
                                $type="VARCHAR(150)";
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
                        case 'multilang_textfield':
                                if ($post['size']!="") $size=$post['size']; else $size=150;
                                $type="VARCHAR($size)";
                                break;
                        case 'multilang_richtext':
                                $type="TEXT";
                                break;
                        case 'multilang_html':
                                $type="TEXT";
                                break;
		}
		return $type;
	}

        function onInsert($post,$id) {
		$obj=$this->dbi->get_record("SELECT * FROM kms_sys_mod WHERE id=".$post['mod_id']);
		//add field
		$type=$this->_getType($post['type']);
		if ($type=="") $this->_error("","[sys_mod_attributes] error type ".$post['type']." not found","fatal");
		include_once "/usr/share/kms/lib/app/sites/functions.php";
                $normalized=str_replace("-","_",strtolower(urlize($obj['name'])));
	
                $alter="ALTER TABLE `kms_".$obj['type']."_".$normalized."` ADD `".$post['name']."` ".$type;
                $result=$this->dbi->query($alter);
                if (!$result) $this->_error("","error onInsert ".mysqli_error($result)."<br><br>SQL:".$alter,"fatal");

        }

	function onUpdate($post,$id) {
                $obj=$this->dbi->get_record("SELECT * FROM kms_sys_mod WHERE id=".$post['mod_id']);
                include_once "/usr/share/kms/lib/app/sites/functions.php";
                $normalized=str_replace("-","_",strtolower(urlize($obj['name'])));
		$type=$this->_getType($post['type']);
                $alter="ALTER TABLE `kms_".$obj['type']."_".$normalized."` CHANGE COLUMN `".$post['name']."` `".$post['name']."` ".$type;
                $result=$this->dbi->query($alter);
                if (!$result) $this->_error("","error onUpdate ".mysqli_error($result),"fatal");
        }

        function onDelete($post,$id) {
		$obj=$this->dbi->get_record("SELECT * FROM kms_sys_mod WHERE id=".$post['mod_id']);
		include_once "/usr/share/kms/lib/app/sites/functions.php";
                $normalized=str_replace("-","_",strtolower(urlize($obj['name'])));
                $delete="ALTER TABLE `kms_".$obj['type']."_".$normalized."` DROP COLUMN `".$post['name']."`";
                $result=$this->dbi->query($delete);
                if (!$result) $this->_error("","error onDelete ".mysqli_error($result),"fatal");
        }


}
?>
