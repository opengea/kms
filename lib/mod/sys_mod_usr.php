<?

// ----------------------------------------------
// Class Objects for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_mod_usr extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $key	= "id";	
	var $orderby 	= "id";
	var $sortdir	= "desc";
	var $hidden     = array("sort_order");
//	var $readonly   = array("creation_date");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit 		= true;
        var $can_delete		= true;
        var $can_add  	  	= true;
        var $can_import 	= false;
        var $can_export 	= true;
        var $can_duplicate 	= true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_mod_usr ($table,$client_account,$user_account,$dm,$dblinks) {
		$this->table=$table;
                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]==================================================*/ 
        // To declare member functions outside the class, just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

        function __call($name, $args) {
                call_user_func_array(sprintf('%s__%s', $_GET['mod'],$name), array_merge(array($this), $args));
        }

        function setup($client_account,$user_account,$dm) {

                        // si existeix carreguem tambe modul fix
                        if (file_exists("/usr/local/kms/lib/mod/{$_GET['mod']}.php")) {
                              $m = new $_GET['mod']($client_account,$user_account,$dm,$dblinks);
                               $m->setup($client_account,$user_account,$dm,$this);
                        }
		$this->defvalue("status","1");
		$this->defvalue("creation_date",date('Y-m-d H:i:s'));
		$this->setStyle("id","width:50px","be");
		$name=str_replace("kms_sys_mod_usr_","",$this->table);
		$name=str_replace("kms_","",$name);

                $extra_include="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/".$_GET['mod'].".php";
       		if (file_exists($extra_include))  include $extra_include; 
		$n=strpos($name,"_");
		$type=substr($name,0,$n);
		$name=substr($name,$n+1);
		$obj=$this->dbi->get_record("select * from kms_sys_mod where name='$name'");
                if ($obj['orderby']!="") $this->orderby=$obj['orderby'];
                if ($obj['sortdir']!="") $this->sortdir=$obj['sortdir'];
		if ($obj['id']!="") { //die('[sys_mod_usr] object not found');
		if ($obj['show_fields']!="") $this->fields=explode(",",$obj['show_fields']);
		if ($obj['hidden_fields']!="") $this->hidden=explode(",",$obj['hidden_fields']);
		if ($obj['readonly_fields']!="") $this->readonly=explode(",",$obj['readonly_fields']);

                if ($obj['can_edit']!=NULL) $this->can_edit=$obj['can_edit'];
                if ($obj['can_delete']!=NULL) $this->can_delete=$obj['can_delete'];
                if ($obj['can_add']!=NULL) $this->can_add=$obj['can_add'];
                if ($obj['can_import']!=NULL) $this->can_import=$obj['can_import'];
                if ($obj['can_export']!=NULL) $this->can_export=$obj['can_export'];
                if ($obj['can_duplicate']!=NULL) $this->can_duplicate=$obj['can_duplicate'];


		$this->defvalue('page_rows',100);
		if ($obj['page_rows']!="") $this->page_rows=$obj['page_rows'];
		$select="select * from kms_sys_mod_attributes where mod_id=".$obj['id']." order by sort_order asc";
		$result=mysqli_query($this->dblinks['client'],$select);
		$this->classes=array();
		$this->styles=array();
		$this->clearfix=array();
		while ($field=mysqli_fetch_array($result)) {
			if ($field['readonly']) array_push($this->readonly,$field['name']);
			if ($field['hidden']) array_push($this->hidden,$field['name']);
	                if ($field['abbreviate']!="") $this->abbreviate($field['name'],$field['abbreviate']);
			if ($field['humanize']!="") $this->humanize($field['name'],$field['humanize']);
			if ($field['class']!="") $this->classes[$field['name']]=$field['class'];
			if ($field['style']!="") $this->styles[$field['name']]=$field['style'];
			$this->clearfix[$field['name']]=$field['clearfix'];

                        $split=explode(";",$field['options']);$options=array();
                        foreach($split as $opt) {
                                        $o=explode("=",$opt);
                                        $o[1]=trim($o[1]);
                                        if (trim($o[1])=="true") $o[1]=true; if (trim($o[1])=="false") $o[1]=false;
                                        $options[trim($o[0])]=$o[1];
                        }

			switch ($field['type']) {
			case 'integer':
                                break;
			case 'float':
				break;
			case 'autocomplete':
				$this->setComponent("autocomplete",$field['name'],array("xtable"=>$field['rel_table'],"xkey"=>$field['rel_field'],"xfield"=>$field['rel_field_show'],"orderby"=>$field['rel_orderby'],"defvalue"=>$field['defvalue'],"readonly"=>false,"required"=>$field['required'],"linkcreate"=>$options['linkcreate'],"linkedit"=>$options['linkedit'],"sql"=>"","where"=>$field['rule'],'options'=>$field['options']));
				break;
			case 'relation':
				$this->setComponent("xcombo",$field['name'],array("xtable"=>$field['rel_table'],"xkey"=>$field['rel_field'],"xfield"=>$field['rel_field_show'],"orderby"=>$field['rel_orderby'],"defvalue"=>$field['defvalue'],"readonly"=>$field['readonly'],"required"=>$field['required'],"linkcreate"=>$options['linkcreate'],"linkedit"=>$options['linkedit'],"sql"=>$options['sql'],"where"=>$field['rule']));	
                                break;
                        case 'textfield':
                                break;
                        case 'date':
                              //  $this->defvalue($field['name'],date('Y-m-d'));
                                break;
                        case 'datetime':
			//	$this->defvalue($field['name'],date('Y-m-d H:i:s'));
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
                                $colors=array("#06a7a","#890","#00C","#ff7f00","#7808d","#090","#ff00d0");
                                for ($i=0;$i<count($values);$i++) {
                                $values[$i]="<font color='".$colors[$i]."'>".$values[$i]."</font>";
                                }
				$this->setComponent("select",$field['name'],$values);
				//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125') { echo "define component for ".$field['name']; print_r($this); }
                                break;
                        case 'openlist':
                                $this->setComponent("uniselect",$field['name']);
                                break;
			case 'multiselect':
                                $this->setComponent("multiselect",$field['name'],array("sql"=>$field['options'],"xfield"=>$field['rel_field_show'],"xkey"=>$field['rel_field'],"xtable"=>$field['rel_table'],"orderby"=>$field['rel_orderby'],"options"=>$field['options']));
                                break;
			case 'multipleselect':
                                $this->setComponent("multiselect",$field['name'],array("sql"=>$field['options'],"xfield"=>$field['rel_field_show'],"xkey"=>$field['rel_field'],"xtable"=>$field['rel_table'],"orderby"=>$field['rel_orderby']));
                                break;
                        case 'multipleselect_rel':
				if ($field['rule']=="") $field['rule']="select ".$field['rel_field'].",".$field['rel_field_show']." from ".$field['rel_table'];
                                $this->setComponent("multiselect",$field['name'],array("sql"=>$field['options'],"xfield"=>$field['rel_field_show'],"xkey"=>$field['rel_field'],"xtable"=>$field['rel_table'],"orderby"=>$field['rel_orderby']));
                                break;
                        case 'text':
                                break;
			case 'richtext':
				if ($field['options']=="ckeditor") $this->setComponent("ckeditor_standard",$field['name'],array("type"=>"richtext"));
				else $this->setComponent("wysiwyg",$field['name'],array("type"=>"richtext"));
                                break;
                        case 'html':
                                $this->setComponent("wysiwyg",$field['name'],array("type"=>"full"));
                                break;
			case 'file':
                                $this->setComponent("file",$field['name'],array($this->kms_datapath."files/files","//data.".$this->current_domain."/files/files"));
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
				$this->setComponent("picture",$field['name'],array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs".$path,"url"=>"//data.".$this->current_domain.$path,"resize_max_width"=>$field['size'],"resize_max_height"=>$field['size'],"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>$options_arr['scaleType']));
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
                                $this->setComponent("video",$field['name'],array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs".$path,"url"=>"//data.".$this->current_domain.$path,"resize_max_width"=>$field['size'],"resize_max_height"=>$field['size'],"thumb_max_width"=>100,"thumb_max_height"=>100,"quality"=>$options_arr['quality']));
                                break;
                        case 'tags':
                               	$this->setComponent("tags",$field['name']);
                                break;
                        case 'json':
                                $this->setComponent("json",$field['name']);
                                break;
                        case 'multilang_textfield':
                                $this->setComponent("multilang",$field['name'],array("type"=>"textfield"));
                                break;
                        case 'multilang_richtext':
                                if ($field['options']=="ckeditor") $this->setComponent("ckeditor_multilang",$field['name'],array("type"=>"richtext"));
				else $this->setComponent("ckeditor_multilang",$field['name'],array("type"=>"richtext"));
                                break;
                        case 'multilang_html':
                                $this->setComponent("ckeditor_multilang",$field['name'],array("type"=>"full"));
                                break;

			} //switch	
			if ($field['defvalue']!="") $this->defvalue($field['name'],$field['defvalue']);
			} // while fields
		}

		$this->insert_label = constant("_NEW_".strtoupper($obj['name']));

		//actions
		$select="select * from kms_sys_mod_actions where mod_id=".$obj['id'];
                $result=mysqli_query($this->dblinks['client'],$select);
		if  (!$this->customOptions) $this->customOptions = Array();
		$i=count($this->customOptions);
		while ($action=mysqli_fetch_array($result)) {
                	$this->customOptions[$i] = Array("label"=>$action['name'],"url"=>$action['url'],"ico"=>$action['icon'],"params"=>"action=".$action['value']."&".$action['params'],"target"=>$action['target'],"checkFunction"=>$action['checkFunction']);
			$this->action($action['value'],"/usr/local/kms/mod/custom/".$action['value'].".php");
			$i++;
		}

                if (!in_array("status",$this->combos_arr)) {

                        if (substr($this->table,0,9)=="kms_docs_") {
                        $this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));      
                                } else {
                        $this->setComponent("select","status",array("1"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","0"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
                        }       
                }


	}
}
?>
