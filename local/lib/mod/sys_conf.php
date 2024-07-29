<?
// ----------------------------------------------
// KMS System Configuration Params
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------
// call $val=getConf ($mod,$field); or $mod=getConf($mod);

class sys_conf extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $table	= "kms_sys_conf";
	var $key	= "id";	
	var $fields = array("family","description","value");
	var $hidden = array("creation_date","sort_order","def_value","rule");
	var $readonly = array();
	var $orderby = "sort_order";
	
	/*=[ PERMISOS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $import = false;
	var $export = false;
	var $search = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_conf ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                // set draggable
		$this->humanize("name","Field name");
                $this->uid=$this->key;
                $this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
                $this->orderby="sort_order";

		$this->setComponent("uniselect","family");
		if ($_GET['_']=="i"||$_GET['_action']=="Duplicate") array_push($this->hidden,"value");
		else if ($_GET['_']=="e") { array_push($this->readonly,"type"); array_push($this->readonly,"name");  }
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("select","type",array("integer"=>"integer","float"=>"float","relation"=>"relation","textfield"=>"textfield","date"=>"date","datetime"=>"datetime","boolean"=>"boolean","password"=>"password","color"=>"color","list"=>"list","openlist"=>"openlist","multiselect"=>"multiselect (2 rows)","multipleselect"=>"multiple select open","multipleselect_rel"=>"multiple select related","text"=>"text","richtext"=>"rich text","html"=>"html","file"=>"file","image"=>"image","video"=>"video","tags"=>"tags","json"=>"json","multilang_textfield"=>"multilanguage textfield","multilang_richtext"=>"multilanguage richtext","multilang_html"=>"multilanguage html"));
                $select="select * from kms_sys_conf where id=".$_GET['id'];
                $result=mysqli_query($this->dblinks['client'],$select);	
		$conf=mysqli_fetch_array($result);
		switch ($conf['type']) {
                        case 'integer':
                                break;
			case 'float':
				break;
                        case 'relation':
                                //$this->setComponent("xcombo","value",array("xtable"=>$field['rel_table'],"xkey"=>$field['rel_field'],"xfield"=>$field['rel_field_show'],"orderby"=>$field['rel_orderby'],"defvalue"=>$field['defvalue'],"readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
                                break;
                        case 'textfield':
                                break;
                        case 'date':
                                $this->defvalue("value",date('Y-m-d'));
                                break;
                        case 'datetime':
                                $this->defvalue("value",date('Y-m-d H:i:s'));
                                break;
                        case 'boolean':
                                $this->setComponent("checklist","value",array(1=>""));
                                break;
                        case 'password':
                                $this->setComponent("cipher","value","plain");
                                break;
                        case 'color':
                                break;
                        case 'list':
                                $values=explode(",",$field['rule']);
                                $colors=array("#06a7a","#890","#00C","#ff7f00","#7808d","#090","#ff00d0");
                                for ($i=0;$i<count($values);$i++) {
                                $values[$i]="<font color='".$colors[$i]."'>".$values[$i]."</font>";
                                }
                                $this->setComponent("select","value",$values);
                                break;
                        case 'openlist':
                                $this->setComponent("uniselect","value");
                                break;
			case 'multiselect':
                                $this->setComponent("multiselect","value",array("sql"=>$field['rule'],"xfield"=>$field['rel_field_show'],"xkey"=>$field['rel_field'],"xtable"=>$field['rel_table'],"orderby"=>$field['rel_orderby']));
                                break;
                        case 'multipleselect':
                                $this->setComponent("multiselect","value",array("sql"=>$field['rule'],"xfield"=>$field['rel_field_show'],"xkey"=>$field['rel_field'],"xtable"=>$field['rel_table'],"orderby"=>$field['rel_orderby']));
                                break;
                        case 'multipleselect_rel':
                                if ($field['rule']=="") $field['rule']="select ".$field['rel_field'].",".$field['rel_field_show']." from ".$field['rel_table'];
                                $this->setComponent("multiselect","value",array("sql"=>$field['rule'],"xfield"=>$field['rel_field_show'],"xkey"=>$field['rel_field'],"xtable"=>$field['rel_table'],"orderby"=>$field['rel_orderby']));
                                break;
                        case 'text':
				$this->setComponent("wysiwyg","value",array("type"=>"text"));
                                break;
                        case 'richtext':
                                $this->setComponent("wysiwyg","value",array("type"=>"richtext"));
                                break;
                        case 'html':
                                $this->setComponent("wysiwyg","value",array("type"=>"full"));
                                break;
                        case 'file':
                                $this->setComponent("file","value",array($this->kms_datapath."files/files","http://data.".$this->current_domain."/files/files"));
                                break;
                        case 'image':
                                if ($field['size']==""||$field['size']=="0") $field['size']="700";

                                $options=explode(",",$field['options']);
                                $options_arr=array();
                                for ($i=0;$i<count($options);$i++) {
                                        $opt=explode(":",$options[$i]);
                                        $options_arr[$opt[0]]=$opt[1];
                                }
                                if ($options_arr['scaleType']=="") $options_arr['scaleType']="w";
                                if ($obj['type']=="cat") $path="/files/catalog"; else $path="/files/pictures";
                                $this->setComponent("picture","value",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs".$path,"url"=>"http://data.".$this->current_domain.$path,"resize_max_width"=>$field['size'],"resize_max_height"=>$field['size'],"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>$options_arr['scaleType']));
                                break;
                        case 'video':
                                if ($field['size']==""||$field['size']=="0") $field['size']="700";
                                $options=explode(",",$field['options']);
                                $options_arr=array();
                                for ($i=0;$i<count($options);$i++) {
                                        $opt=explode(":",$options[$i]);
                                        $options_arr[$opt[0]]=$opt[1];
                                }
                                $path="/files/videos";
                                $this->setComponent("video",$field['name'],array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs".$path,"url"=>"http://data.".$this->current_domain.$path,"resize_max_width"=>$field['size'],"resize_max_height"=>$field['size'],"thumb_max_width"=>100,"thumb_max_height"=>100,"quality"=>$options_arr['quality']));
                                break;
                        case 'tags':
                                $this->setComponent("tags","value");
                                break;
                        case 'json':
                                $this->setComponent("json","value");
                                break;
                        case 'multilang_textfield':
                                $this->setComponent("multilang","value",array("type"=>"textfield"));
                                break;
                        case 'multilang_richtext':
                                $this->setComponent("multilang","value",array("type"=>"richtext"));
                                break;
                        case 'multilang_html':
                                $this->setComponent("multilang","value",array("type"=>"full"));
                                break;

                        } //switch      

	}
}
?>
