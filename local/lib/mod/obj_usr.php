<?
// ----------------------------------------------
// Class Objects for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class obj_usr extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $key	= "id";	
//	var $fields 	= array"id", "status", "name", "orderby", "sortdir", "perm", "show_fields" );
	var $orderby 	= "id";
/*	var $notedit 	= array("");
	var $readonly 	= array("");
*/
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit 		= true;
        var $can_delete		= true;
        var $can_add  	  	= true;
        var $can_import 	= false;
        var $can_export 	= true;
        var $can_duplicate 	= true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function obj_usr ($table,$client_account,$user_account,$dm,$dblinks) {
		$this->table=$table;
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
//		$this->table="kms_obj_".$this->
		$this->defvalue("status","active");
		$this->defvalue("creation_date",date('Y-m-d H:i:s'));
		$name=str_replace("kms_obj_usr_","",$this->table);
		$obj=$this->dbi->get_record("select * from kms_obj where name='$name'");
		$select="select * from kms_obj_fields where obj_id=".$obj['id'];
		$result=mysqli_query($this->dblinks['client'],$select);
		while ($field=mysqli_fetch_array($result)) {
			if ($field['readonly']) array_push($this->readonly,$field['name']);
			if ($field['hidden']) array_push($this->hidden,$field['name']);
			if ($field['humanize']!="") $this->humanize($field['name'],$field['humanize']);

			switch ($field['type']) {
			case 'integer':
                                break;
                        case 'textfield':
                                break;
                        case 'date':
                                $this->defvalue($field['name'],date('Y-m-d'));
                                break;
                        case 'datetime':
				$this->defvalue($field['name'],date('Y-m-d H:i:s'));
                                break;
                        case 'boolean':
                                $this->setComponent("checklist",$field['name'],array(1=>""));
                                break;
                        case 'password':
                         	$this->setComponent("cipher",$field['name'],"plain");
                                break;
                        case 'color':
                                break;
                        case 'list':
				$values=explode(",",$field['rule']);
                                $this->setComponent("select",$field['name'],$values);
                                break;
                        case 'text':
                                break;
                        case 'html':
                                $this->setComponent("wysiwyg",$field['name']);
                                break;
                        case 'image':
				if (strpos("scaleType:v","_".$field['options'])) $scaleType="v"; else $scaleType="w";
				$this->setComponent("picture",$field['name'],array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>$field['size'],"resize_max_height"=>$field['size'],"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>$scaleType));
                                break;
                        case 'tags':
                               	$this->setComponent("tags",$field['name']);
                                break;
			case 'json':
                                $this->setComponent("json",$field['name']);
                                break;
			}	
		}

		$this->insert_label = constant("_NEW_".strtoupper($obj['name']));
	
		// objecte relacionat
		if ($obj['parent']!=""&&$obj['parent']!=0) {
			$this->defvalue("parent",$obj['parent']);
			$this->setComponent("xcombo","parent",array("xtable"=>"kms_obj","xkey"=>"id","xfield"=>"name","readonly"=>true,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		}
		$this->onInsert = "onInsert";
		$this->onUpdate = "onUpdate";
		$this->onDelete = "onDelete";	
	}

}
?>
