<?php
// ******************************************************************
//
// 	Intergrid Model Object Definition (MOD) Class
//
//	Package version : 2.0
//      Last update     : 12/08/2011
// 	Author		: Jordi Berenguer
// 	Company 	: Intergrid Tecnologies del coneixement SL
// 	Country		: Catalonia
//      Email           : j.berenguer@intergrid.cat
//	Website		: www.intergrid.cat
//
// ******************************************************************

// Reporting
ini_set('register_globals',0);
error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT&~E_DEPRECATED);

include_once("/usr/local/kms/lib/dataDBI.php");  
include_once("/usr/local/kms/lib/template.php"); 
include_once("/usr/local/kms/lib/dataBrowser.php");
include_once("/usr/local/kms/lib/folderBrowser.php");
include_once("/usr/local/kms/lib/dataEditor.php");
include_once("/usr/local/kms/lib/dataDetailer.php");
include_once("/usr/local/kms/lib/dataFunctionCaller.php");

// Include mod class
if (file_exists("/usr/local/kms/lib/mod/{$_GET['mod']}.php")) include_once "/usr/local/kms/lib/mod/{$_GET['mod']}.php";
if (file_exists("/usr/local/kms/lib/mod/{$_GET['panelmod']}.php")) include_once "/usr/local/kms/lib/mod/{$_GET['panelmod']}.php";

// module object definition class

class mod extends tab {

	// variables declaration
	//var $mods	= array(); // data managers array
	// ==== Default mod values ====
	var $instance;		// instance id
	var $mod	= array();		// model object definition
	// ==== Default permissions ====
	var $can_view 	= false;
	var $can_edit 	= true;
	var $can_delete = true;
	var $can_add   	= true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;
	var $can_duplicate = false;
	var $can_config = true;
	// ==== misc options ====
	var $page_rows = 100;
	var $page_links = 10;
	var $notedit = array('dr_folder');
	var $ts_format  = "Y/m/d h:i A";
	var $iam2 = "mod";
	var $concatFields = array(); //camps que no poden saltar de linia en el databrowser

 	// Module Object Definition Constructor
	function mod($client_account,$user_account,$instance,$dblinks) {
	   $this->alerts = array();
	   $this->alerts['delete']=array("msg"=>_KMS_GL_CONFIRM_DELETE,"ok_label"=>_MB_CONFIRM_DELETE,"cancel_label"=>_MB_CANCEL,"ok_action"=>"document.dm._action.value='"._MB_DELETE."';document.dm.submit();","cancel_action"=>"document.dm.action='".$this->_link("_=b")."';document.dm._action.value='"._MB_CANCEL."';document.dm.submit()");

	   $this->instance = $instance;
	   global $KMS;
	   $this->current_domain=$KMS['current_domain'];
           $this->current_subdomain=$KMS['current_subdomain'];
  	   $this->kms_datapath = "/var/www/vhosts/".$KMS['current_domain']."/subdomains/data/httpdocs/";
	   $this->client_account = $client_account;
	   $this->user_account = $user_account;
	   $this->dblinks = $dblinks;
	   $this->dbi = new dataDBI();
  	   $this->dbi->dblinks=$this->dblinks;
           $this->tpl = new template();
	   $this->id = $instance; // instance id
  	   if (!$this->dblinks['client']) { 
//		echo "set dblink 3 "; 
		$this->dblinks['client']=$this->dbi->db_connect('client',$this->dbi);
	     }
	   //$this->testERPContracts();
	   // build data manager
          // setup mod
//echo "_presetup_";
          $this->setup($client_account,$user_account,$this->dm);
//echo "_postsetup_ ";
          if (!isset($this->fields_search)) $this->fields_search=$this->fields;
          // custom mod
          if (isset($_GET['mod'])&&($_GET['mod']!="")) {
                   $kmspath = "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/";
                   // include ("/usr/local/kms/lib/kms_defaults.php");
                   if (file_exists($kmspath.$_GET['mod'].".php")) include_once ($kmspath.$_GET['mod'].".php");
          }
	   //default action
	if ($_GET['_']=="") $_GET['_']="b";
	   if ($this->action['key']!=""&&($_GET['_']==""||$_GET['_']=="b")) {$_GET['_']=$this->action['key'];$_GET['action']=$this->action['action']; };
           $type = $_GET['_'];

           switch ($type) {
                    case "e": //edit
                           $this->dm = new dataEditor($this);
                    break;
                    case "i": //insert
                            $this->dm = new dataEditor($this);
                    break;
                    case "d": //view (detailer)
                            $this->dm = new dataDetailer($this);
                    break;
                    case "eb": //editable browser (prototype)
                            $this->dm = new dataEditableBrowser($this);
                    break;
                    case "f": //function caller
                            $this->dm = new dataFunctionCaller($this);
                    break;
                    case "b": //browse
                            $this->dm = new dataBrowser($this);
                    break;
		    case "fb": //folder browser
                            $this->dm = new folderBrowser($this);
                    break;
           }

/*	  // setup mod
	  $this->setup($client_account,$user_account,$this->dm);
	  if (!isset($this->fields_search)) $this->fields_search=$this->fields;
	  // custom mod
	  if (isset($_GET['mod'])&&($_GET['mod']!="")) {
                   $kmspath = "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/";
                   // include ("/usr/local/kms/lib/kms_defaults.php");
                   if (file_exists($kmspath.$_GET['mod'].".php")) include_once ($kmspath.$_GET['mod'].".php"); 
          }
*/
		//log
		$this->_log_session($type);
	}

	// dataManager getInstance function
	function &getInstance($instance,$mod_type,$client_account,$user_account,$dblinks) {
		$app=$this->_get_app();
		if ($_GET['mod']!="") {
			// load related application mod classes
			$mods = $this->_get_mods($app);
			foreach ($mods as $key=>$value) {
				//echo $value; //check enters
				 $class = "/usr/local/kms/lib/mod/{$value}.php";
			         include_once $class;
			}
			$ext_mods =  $this->_get_ext_mods($app);
	                foreach ($ext_mods as $key=>$value) {
			//	echo $value; //check enters
                                 $class = "/usr/local/kms/lib/mod/{$value}.php";
                                 include_once $class;
                        }
		} else {
			// browse apps
			include_once "/usr/local/kms/lib/mod/sys_apps.php";
			$mod_type="sys_apps";
		}
		// create instance for current object type
		if ($mod_type=="") die ("no mod_type specified creating new instance of mod class");
		if ($_GET['panelmod']!="") $mod_type=$_GET['panelmod'];

		$_pos=strpos($_GET['mod'],"_");
		$_mod_type=substr($_GET['mod'],0,$_pos);
		$_mod_name=substr($_GET['mod'],$_pos+1);
		$mod_defined=$this->dbi->get_record("SELECT id FROM kms_sys_mod WHERE name='".$_mod_name."' AND type='".$_mod_type."'");

		if (!file_exists("/usr/local/kms/lib/mod/{$_GET['mod']}.php")||($mod_defined[0]!="")) { 
			// database mod usr (custom user mod)
			$mod_type_real=$mod_type; $mod_type="sys_mod_usr"; 
			include_once "/usr/local/kms/lib/mod/sys_mod_usr.php";
			$table="kms_$mod_type_real";
			$m = new $mod_type($table,$client_account,$user_account,$instance,$this->dblinks);
		//} else if (substr($_GET['mod'],0,4)=="isp_") { 
	//		$m = new $mod_type($client_account,$user_account,$instance,$silent);
		} else {
			// file mod
			$m = new $mod_type($client_account,$user_account,$instance,$this->dblinks);
		}

		return $m; //od[$instance];
			
		// nomes en PHP 5.3  :
		// $mod[$instance] = & $mod_type::getInstance(0,$_GET['mod'],$client_account,$user_account);

	}

        // Mod loader
        function _load_mod($type,$mod) {
		global $KMS; // global variables
		$id = $this->id;
                include_once "/usr/local/kms/lib/mod/{$type}.php";
		$mod = new $type();
		return $mod;
        }


	// CAUTION! : must implement a security fix to block sql injections and session request overwrites
	function _var_setup() {
		if (!isset($this->sortable)) $this->sortable=$this->fields;
		if (isset($_REQUEST['page_rows'])) $this->page_rows=$this->per_page=$_GET['page_rows'];
		$this->sortby = $this->_get_param("sortby",$this->orderby?$this->orderby:$this->fields[0]);
		$this->sortdir = $this->_get_param("sortdir",$this->sortdir?$this->sortdir:"asc");
		$this->page = $this->_get_param("page","1");
		$this->day1 = $this->_get_param("day1",$_POST['day1']);
		$this->month1 = $this->_get_param("month1",$_POST['month1']);
		$this->year1 = $this->_get_param("year1",$_POST['year1']);
		$this->day2 = $this->_get_param("day2",$_POST['day2']);
		$this->month2 = $this->_get_param("month2",$_POST['month2']);
		$this->year2 = $this->_get_param("year2",$_POST['year2']);
		$this->search_value = $this->_get_param("query");// $_REQUEST['query'];
//print_r($_POST['query']);echo "search:".$this->search_value;
		if (isset($_POST['query'])&&$_POST['query']=="") { $this->_reset_param("query"); $this->_reset_param("queryfield"); $this->search_value=""; } //init search
		if ($this->search_value=="") {
//			if ($_GET['page']) $this->page = "1";
			if ($this->day1!=""||$this->month1!=""||$this->year1!="") {
				// search by date
				$_REQUEST['query']= ""; // no effect
				$this->queryfield = $this->_get_param("queryfield",""); //$_REQUEST['queryfield'];//$this->_get_param("queryfield","");
			} else {
			// empty search will clear search settings
			$this->search_value = "";
			$this->queryfield = "";
			$this->per_page	= $this->page_rows?$this->page_rows:100;
   			unset($_SESSION[$this->table]);
			}
		} else { 
			if ($_REQUEST['query']!="") {
				$this->search_value = $this->_get_param("query",$_REQUEST['query']); //$_REQUEST['query']; //$this->_get_param("query",$_REQUEST['query']);
				$this->page = 1;
			        $this->per_page = $this->page_rows?$this->page_rows:100;
			} else {
				// pull query from session data
				$this->search_value = $this->_get_param("query","");
			}
			$this->queryfield = $this->_get_param("queryfield",""); //$_REQUEST['queryfield']; //$this->_get_param("queryfield","");
		}
	}

	function _get_mod_current_editor_tab($This) {
		if ($This->editorTabs=="") die ('editorTabs not defined');
                $mod="";
                if ($_GET['tab']=="") { $current_mod=$_GET['mod']; $class=" active"; } else $class="";
                $n=0;
                foreach ($This->editorTabs as $tab => $value) {
                        if ($_GET['tab']==$n) {$current_mod=$value['mod']; $class=" active"; } else $class="";
                        $n++;
                }
		return $current_mod;
	}

	// construct array of field names of current module
	function _field_setup() {
		// browser field setup
		if (!$this->fields || !is_array($this->fields)) {
			$this->fields = $this->_get_fieldnames($this->dbname);
		}
		$this->field_cnt = sizeof($this->fields);
		// remove virtual fields, and other exceptions from array
		$this->fields_show = $this->fields;
		$addOTHER="";
		for ($r=0;$r<$this->field_cnt;$r++) { 
			if (substr($this->fields[$r],0,3)=="vr_") unset($this->fields[$r]); 
			if (substr($this->fields[$r],0,3)=="SUM"||substr($this->fields[$r],0,4)=="YEAR") { $addOTHER.=",".$this->fields[$r];  unset($this->fields[$r]); }
		}
//                $this->field_str = join("`, $this->table.`",$this->fields);
  //              $this->field_str = $this->table.".`" . $this->field_str . "`";
                $this->field_str = join("`,`".$this->table."`.`",$this->fields);
                $this->field_str = "`".$this->table."`.`" . $this->field_str . "`";
		$this->field_str.=$addOTHER;
		// editor field setup
		$this->edit_fields = $this->_get_fieldnames($this->dbname);
//echo $this->dbname;
//print_r($this->fields);
//print_r($this->edit_fields);die('---');
		$this->edit_field_cnt = sizeof($this->edit_fields);
                $this->edit_field_str = join("`, `",$this->edit_fields);
                $this->edit_field_str = "`" . $this->edit_field_str . "`";
		$this->export_field_str = $this->edit_field_str;
		if (isset($this->export_f)) { 
			$this->export_field_str = join("`, `",$this->export_f); 
			$this->export_field_str = "`" . $this->export_field_str. "`";
		}	
	}

        // construct array of field types of current mod
        function _field_types_setup() {
		// array of fields types 
        	if (is_array($this->field_types)) return true; //already exists
		$this->field_types = array();
		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];
                $this->result = $this->dbi->query($this->sql,$dblink);
                foreach ($this->fields_show as $field) { 
                        if (is_array($this->xvarr[$field])) {
                                $this->field_types[$field]="string";
                        } else {
                                $this->field_types[$field]= $this->_field_type($field,$this->result,$dblink);
                         	$j++;
                        }
                }
	}

	// utf8 to html 
	function u2h($str) {
		return htmlentities(utf8_decode($str));
	}

	// determine field name list from database
	function _get_fieldnames($dbname) {
		
                if ($dbname=="") $dbname=$this->client_account['dbname'];
//              $this->dbi->dblinks=$this->dblinks;
                if ($this->dblinks['custom'])   $dblink=$this->dblinks['custom'];  else $dblink=$this->dblinks['client'];
                if (!$flds = $this->dbi->list_fields($this->table,$dblink)) {
                        $this->_error("Configuration Error","[KMS.mod.class] Unable to get field names from '{$this->table}' table on '{$dbname}' database");
                } else {

//                        $cols = $this->dbi->num_fields($flds);//number of cols
			$cols = count($flds);
                        $fields = array();
			if ($_GET['mod']!="") {
                        $query="select id from kms_sys_mod where name='".substr($_GET['mod'],strrpos($_GET['mod'],"_")+1)."' and `type`='".substr($_GET['mod'],0,strpos($_GET['mod'],"_"))."'";
                        $mod_id=$this->dbi->get_record($query);
                        $mod_id=$mod_id[0];
			}
                        for ($i = 0; $i < $cols; $i++) {
                                //posicio del camp segons base de dades
//                                $fn = $this->dbi->field_name($flds, $i);
				$fn = $flds[$i]['Field'];
                                //posicio del camp segons definicio a sys_mod_attributes
                                if ($mod_id!="") {
				$query="select id,sort_order from kms_sys_mod_attributes where mod_id={$mod_id} and name='{$fn}'";
                                $field_kms = $this->dbi->get_record($query);
				}
//                      echo $i." ".$query."<br>";
                                if (substr($_GET['mod'],0,4)=="cat_") $cond=!@in_array($fn, $this->exclude);
                                else $cond=!@in_array($fn, $this->exclude) && $fn!=$this->key;
                                if ($cond) {
                                //      array_push($fields, $fn);
                                        if ($field_kms['id']&&$field_kms['sort_order']!=0) $fields[$field_kms['sort_order']]=$fn; else array_push($fields, $fn);
                                        
                                }
                                if ($fn==$this->key && $this->show_key) {
//                                      array_push($fields, $fn);
                                        if ($field_kms['id']&&$field_kms['sort_order']!=0) $fields[$field_kms['sort_order']]=$fn; else array_push($fields, $fn);
                                }
                        }
                        ksort($fields);

                        return $fields;
                }


	}

	function _getLabel($field) {
		$label=$this->humans[$field]["name"] ? $this->humans[$field]["name"] : constant(strToUpper("_".$this->table."_".$field));
		if ($label== "") $label= constant(str_replace("VR_","",strToUpper("_KMS_GL_".$field)));

                if ($label == "") {
                                $xpl=explode("_",$field);
                                $label = constant(strToUpper("_KMS_GL_".$xpl[count($xpl)-1]));
                }

		if ($label== "") {
			$extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
			$label=$lang[strToUpper("_".$this->table."_".$field)];
		}

//		$pvr = strpos("-".$field,"vr_");if ($pvr) $label= constant(strToUpper("_KMS_GL_".strToUpper(substr($field,$pvr+2,strlen($field)))));
		if ($label == "") $label="<a style='color:#aaaaaa' id='label_".$field."' title='Undefined ".strToUpper("_".$this->table."_".$field)."'>".$this->_format_name($field)."</a>";
		return $label;
	}

        function _fetch_field_info($data,$field) {

		if (!$dblink) {
                       if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];
                }

		$fields=$this->dbi->list_fields($this->table,$dblink);
		foreach($fields as $field_data) { if ($field_data['Field']==$field) break; }
                $column = array();
                $column['name'] = $field_data['Field'];
                if (!isset($data[$field]) && isset($this->defvalues[$field])) {
                        $column['value'] = $this->defvalues[$field];
                } else {
                        $column['value'] = $data[$field];
                }
                $column['label'] = $this->_getLabel($field);
                if ($this->humans[$field]["desc"]) $column['desc'] = $this->humans[$field]["desc"];
		$p=strpos($field_data['Type'],"(")+1;
		$f=strpos($field_data['Type'],")");
		$d=$f-$p;
                $column['length'] = substr($field_data['Type'],$p,$d);
                $query="select id from kms_sys_mod where name='".substr($_GET['mod'],strrpos($_GET['mod'],"_")+1)."' and `type`='".substr($_GET['mod'],0,strpos($_GET['mod'],"_"))."'";
                $mod_id=$this->dbi->get_record($query);
                $mod_id=$mod_id[0];
		$definition=array();
		if ($mod_id!="") {
			$sql="select `type` from kms_sys_mod_attributes where name='".$column['name']."' and mod_id=".$mod_id;
                	$definition=$this->dbi->get_record($sql);
		}	
		if ($definition[0]!="") $column['type'] = $definition[0]; else $column['type']=substr($field_data['Type'],0,strpos($field_data['Type'],"("));
		if ($column['type']=="") $column['type']=$field_data['Type'];
                $column['class'] = $this->classes[$field];
                $column['style'] = $this->styles[$field];
                $column['clearfix'] = $this->clearfix[$field];
                return $column;

        }

        function _field_type ($field,$result,$dblink) {
		$column=$this->_fetch_field_info("",$field);
		return $column['type'];
        }


	// formats data depending of its nature
	function _format_field($data) {
		$data = htmlspecialchars($data); // formatted html
		$query_string = stripslashes($this->search_value);
		if ($query_string && @stristr($data,$query_string) !== false) {
			// search string highlight
			$query_string = str_replace('/','\/',$query_string);  // a query with a / can kill the next line
			$data = preg_replace("/$query_string/i","<span class=\"HILITE\">\\0</span>",$data);
		} else {
			// clickable url's
			$searcharray = array(
				"'([-_\w\d.]+@[-_\w\d.]+)'",
				//"'((?:(?!://).{3}|^.{0,2}))(www\.[-\d\w\.\/]+)'", 
				"'(http[s]?:\/\/[-_~\w\d\.\/]+)'"); 
			$replacearray = array(
				"<a href=\"mailto:\\1\">\\1</a>",
				//"\\1http://\\2",
				"<a target=\"_new\" href=\"\\1\">\\1</a>");
			$data = preg_replace($searcharray, $replacearray, $data);
			if (strpos($data,"NVALID ")) { 
				$data=str_replace("INVALID ","<span style='padding-bottom:1px;color:#fff;font-size:9px;background-color:#ccc'>INVALID</span> ",$data); 
				$data=str_replace("<a ","<a style='color:#aaa' ",$data);
			}
		}
		return nl2br(stripslashes($data));
	}

	// Makes a table/field name pretty
	function _format_name($text) {
		$s = str_replace("_"," ",$text);
		return ucwords(strtolower($s));
	}

	// Adds a message to the message stack
	function addmsg($msg) {
		$_SESSION[$this->table]["msgs"][] = $msg;
	}

	function _onInsert($post,$id,$mod) {
		// remove check if method_exists to allow call member functions outside the class 
		// Watch out: on functions outside the class, the given params are ($mod,$post,$id) not ($post,$id)!
//		if (method_exists($mod,$mod->onInsert)) { call_user_func_array (array($mod,$mod->onInsert),array($post,$id)); }
		call_user_func_array (array($mod,$mod->onInsert),array($post,$id));
	}
        function _onDelete($post,$id,$mod) {
		 call_user_func_array (array($mod,$mod->onDelete),array($post,$id));
        }
        function _onUpdate($post,$id,$mod) {
		 call_user_func_array (array($mod,$mod->onUpdate),array($post,$id));
        }
        function _onDuplicate($post,$id,$mod) {
                 $returns=call_user_func_array (array($mod,$mod->onDuplicate),array($post,$id));
		 return $returns;
        }
        function _onPreInsert($post,$mod) {
                $returns=call_user_func_array (array($mod,$mod->onPreInsert),array($post));
		return $returns;
        }
        function _onPreDelete($post,$id,$mod) {
                $returns=call_user_func_array (array($mod,$mod->onPreDelete),array($post,$id));
		return $returns;
        }
        function _onPreUpdate($post,$id,$mod) {
                 $returns=call_user_func_array (array($mod,$mod->onPreUpdate),array($post,$id));
		return $returns;
        }
	function _onBrowse($mod,$view) {
		$returns=call_user_func_array (array($mod,$mod->onBrowse),array($mod,$view));
		return $returns;
	}
	function _onEdit($mod,$id) {
		$returns=call_user_func_array (array($mod,$mod->onEdit),array($mod,$id));
                return $returns;
	}
	function _onAdd($mod,$id) {
                $returns=call_user_func_array (array($mod,$mod->onAdd),array($mod,$id));
                return $returns;
	}

	//button filter
        function _output_button($key,$data,$mod) {
                $div1 = "<div class='ico16'>";
                $div2 = "</div>";
		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];

                $numbuts = count($mod->customOptions);
                for ($i = 0; $i < $numbuts; $i++) {
                        $show=false;
			$check_function = $mod->customOptions[$i]['checkFunction'];
			if ($check_function!="") $show=$mod->$check_function($key); else $show=true;

                        if ($show) {
                        	$flds = $this->dbi->list_fields($this->table,$dblink);
                        	$cols = $this->dbi->num_fields($flds);
                        	$fields = array();
				$params=$this->customOptions[$i]['params'];
                        	for ($j = 0; $j < $cols; $j++) {
	                                 $fn = $this->dbi->field_name($flds, $j);
//					 $extra.="[".$fn."]->".strtolower($data->$fn);
						// OJO!: data nomes conte els camps visibles del databrowser
        	                       	 $params = str_replace("[".$fn."]",strtolower($data[$fn]),$params);
                        	}
                                if ($this->customOptions[$i]['target']=="dashboard") echo $div1."<a href=\"#\" onclick=\"loadURL('".$this->customOptions[$i]['url']."?id=".$key."&mod=".$_GET['mod']."&".$this->customOptions[$i]['params']."','".$this->customOptions[$i]['target']."')\" title=\"".$this->customOptions[$i]['label']."\"><img src='".PATH_IMG_SMALL."/".$this->customOptions[$i]['ico']."'></a>".$div2;
                                else {
					$href="id=".$key."&app=".$_GET['app']."&mod=".$_GET['mod']."&".$params;
					if ($this->customOptions[$i]['url']!="") $href=$this->customOptions[$i]['url']."&".$href; else  $href="?_=f&".$href;
					echo $div1."<a extra=\"".$extra."\" href=\"".$href."\" target='".$this->customOptions[$i]['target']."' title=\"".$this->customOptions[$i]['label']."\"><img src='".PATH_IMG_SMALL."/".$this->customOptions[$i]['ico']."'></a>".$div2;
				}
                        }
                }
        }

	// output filter: shows value (used in databrowser)
	function _output_filter($field,$data,$id) {
		// check for multixrefs
		if (is_array($this->multixrefs[$field])) { // check for multixrefs
				$this->delimiter=",";
                              $_arr = explode($this->delimiter,$data);
                                $tmp = array();
                                foreach ($_arr as $key=>$value) {
					$f=$this->multixrefs[$field]["xfield"];
					if (substr($f,0,6)!="CONCAT") $f="`{$f}`";
                                        $sql = "SELECT {$f} FROM `{$this->multixrefs[$field]["xtable"]}` ";
                                        $sql .= "WHERE `{$this->multixrefs[$field]["xkey"]}` = '{$value}'";
					if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];
			                $result = $this->dbi->query($sql,$dblink);
                                        $A  = $this->dbi->fetch_array($result);
                                        $tmp[] = $A[$this->multixrefs[$field]["xfield"]];
                                        if (substr($tmp[0],0,4)=="_KMS") $tmp[0]=constant($tmp[0]);
                                }

                        $this->mxrefstack[$data] = @join(", ",$tmp);
                        return $this->mxrefstack[$data];

                //---- component
                } else if ($this->components[$field] && method_exists($this->components[$field],"output_filter")) {
//			$returnvalue = $this->components[$field]->output_filter($data,false,$id);
//			$returnvalue = $this->components[$field]->output_filter($field,$data,$id);
			$returnvalue = $this->components[$field]->output_filter($data,$id);
	                if ($this->search_value!="") {
                           $query_string = stripslashes($this->search_value);
			   $returnvalue = preg_replace("/$query_string/i","<span class=\"HILITE\">\\0</span>",$returnvalue);
        	        }
			$max_chars = 200;
			// COMPTE !!! ES TALLEN LES IMATGES
			// return substr($returnvalue,0,$max_chars);	
			return $returnvalue;

		//---- start multixref (camps relacionats)
		} else if ($field=="color") {
                        return "<div style='width:16px;height:16px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;background-color:#".$data."' title='#".$data."'></div>";

		} else if ($field=="ingredients") {
			$pad=5;
			$chr="&nbsp;";
			$dataOK=$this->_format_field($data);
			//$dataOK=htmlspecialchars_decode($dataOK);
			
			$lines=explode("\n",$dataOK);
			$dataOK="<table WIDTH=230 class=\"subingr\" cellspacing=\"0\" cellpadding=\"0\"><COL WIDTH=29><COL WIDTH=201>";
			foreach ($lines as $i=>$val) {
				$val=trim($val);
				$val=str_replace("`","'",$val);
				$val=str_replace("'","'",$val);
				$first=substr($val,0,1);
				if ($first=="0"||$first=="1"||$first=="2"||$first=="3"||$first=="4"||$first=="5"||$first=="6"||$first=="7"||$first=="8"||$first=="9"||ord($first)==189) {
	                                $pos_spc=strpos($val," ");
					if (ord($first)==189) { $complex="mig"; $pos_spc=1; }
					else if (ord(substr($val,$pos_spc+1,1))==189) { $complex="imig"; $pos_spc=$pos_spc+2; } 
					else $complex="";
					// get num persones

					$n=substr($val,0,$pos_spc);
					$persones=$this->numpers;
					if ($persones=="") die ('[mod.class] empty num persones');
					if ($_GET['pers']!=""&&$_GET['pers']!=$persones&&$complex=="") { 
						$n=str_replace(".","",$n);
						$n=str_replace(",",".",$n);
						$n_base=$n/$persones; $n=$n_base*$_GET['pers']; 
						if ($n==0) $n=""; 
					} else if ($_GET['pers']!=""&&$_GET['pers']!=$persones&&$complex=="imig") {
						$n=substr($val,0,$pos_spc-2);
						$n=str_replace(".","",$n); // unitats de mil fora
						$n=str_replace(",",".",$n); // comes a punts per poder computar
						$n=$n+0.5; // afegim el mig
						$n_base=$n/$persones; $n=$n_base*$_GET['pers']; if ($n==0) $n="";
					} else if ($_GET['pers']!=""&&$_GET['pers']!=$persones&&$complex=="mig") {
						$n=0.5;
						$n_base=$n/$persones; $n=$n_base*$_GET['pers']; if ($n==0) $n="";
					}
					$dataOK.="<tr><td class='num' WIDTH=29><p align=right style='line-height:130%;padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'>".$n."</p></td><td WIDTH=262 class='line-ingredient'><p style='line-height:130%;padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'>".substr($val,$pos_spc+1)."</p></td></tr>";

					// te el problema que no fa els canvis de linia als numero quan un ingredient fa mes d'una linia
//					$qOK .= $n."<br>";
//					$iOK .= substr($val,$pos_spc+1);
				} else {
					//$dataOK.="<tr><td class='num' WIDTH=29></td><td WIDTH=262 class='line-ingredient'>".$val."</td></tr>"	
	                                $val=str_replace("Nota:", "NOTA:",$val);
	                                $val=str_replace("Note:", "NOTE:",$val);
					$val=str_replace("&lt;","<",$val);
		                        $val=str_replace("&gt;",">",$val);
					$val=str_replace("<video>","&lt;video&gt;",$val);
					$val=str_replace("</video>","&lt;/video&gt;",$val);
					if (substr($val,0,3)=="NOT") {$val="<div class='note' style='margin:0px'><span>".$val."</span></div>";}
					if (substr($val,0,8)=="<b>Para ") $dataOK.="<tr><td class='num' WIDTH=29 style='padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm;text-align:left' colspan=2><p style='line-height:130%;padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'>".$val."</p></td></tr>"; else $dataOK.="<tr><td class='num' WIDTH=29 style='padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'><p style='line-height:130%;padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'></p></td><td style='padding:0px' WIDTH=262 class='line-ingredient'><p style='line-height:130%;margin:0px;margin-bottom:3px'>".$val."</p></td></tr>"; 
					//$iOK .= $val;
				}
			}
//			$dataOK.= "<tr><td class='num' WIDTH=29 VALIGN=TOP><p align=right style='margin-right: 0.1cm'>".$qOK."</p></td><td WIDTH=262 class='line-ingredient'>".$iOK."</td></tr>";
			$dataOK.="</table>";
			return $dataOK;
		} else if ($field=="detail_coberts") {
			$val=$this->_format_field($data);
			$val=str_replace("&lt;","<",$val);
                        $val=str_replace("&gt;",">",$val);
                        if ($val!="") $dataOK="<b>CUBIERTOS</b><br>".$val;
			return $dataOK;
		} else if ($field=="detail_degustar") {
			$val=$this->_format_field($data);
			$val=str_replace("&lt;","<",$val);
                        $val=str_replace("&gt;",">",$val);
			if ($val!="") $dataOK="<br><b>MANERA DE DEGUSTAR</b><br>".$val;
			return $dataOK;
                } else if ($field=="upper") {
                        $val=$this->_format_field($data);
                        if ($val!="") $dataOK=mb_strtoupper($val,'iso-8859-1');
                        return $dataOK;
		} else if ($field=="list") {
			$dataOK=$this->_format_field($data);
			$dataOK=str_replace("&lt;","<",$dataOK);
			$dataOK=str_replace("&gt;",">",$dataOK);
			$lines=explode("\n",$dataOK);
			$dataOK="<ol style=\"padding-left:20px;margin-left:0px;padding-left: 0,10cm\">     ";
			foreach ($lines as $i=>$val) {
				$val=trim($val);
				//for ($i=1;$i<40;$i++) { $val=str_replace($i.". ","",$val); }
				$note=0;
				$first=substr($val,0,3);
				$val=str_replace("<video>","<br>&lt;video&gt;",$val);
				$val=str_replace("</video>","&lt;/video&gt;",$val);
				$val=str_replace("\r","",$val);
				for ($i=40;$i>0;$i--) { $val=str_replace($i.". ","",$val); }
				$val=str_replace("Nota:", "NOTA:",$val);
				$val=str_replace("Note:", "NOTE:",$val);
				// si ha un exces de <br> eliminem el darrer
//				if (substr($val,0,6)=="<br />") $val=substr($val,0,strlen($val)-6); //str_replace("<br /> <br />","",$val);	
				if (substr($val,0,3)=="NOT") {$note=1; $dataOK.="</ol><div class='note'><span>".$val."</span></div>";}
				else if ($first!="1. "&&$first!="2. "&&$first!="3. "&&$first!="4. "&&$first!="5. "&&$first!="6. "&&$first!="7. "&&$first!="8. "&&$first!="9. "&&$first!="10."&&$first!="11."&&$first!="12."&&$first!="13."&&$first!="14."&&$first!="15."&&$first!="16."&&$first!="17."&&$first!="18."&&$first!="19."&&$first!="20."&&$first!="21."&&$first!="22."&&$first!="23."&&$first!="24."&&$first!="25."&&$first!="26."&&$first!="27."&&$first!="28."&&$first!="29."&&$first!="30.") {
				// es part de la linia anterior!
//				$dataOK=substr($dataOK,0,strlen($dataOK)-5); //traiem </li>
				$dataOK.=trim($val)."</li>";
				} else if ($val!=""&&$val!="<br />") $dataOK.="<li style='margin-left:20px;list-style-position: inside;'>".$val."</li>";
				
			}
			if ($note==0) $dataOK.="</ol>";
			return $dataOK;

		}  else if ($field=="seasontrans") { 
			$dataOK=$this->_format_field($data);
			$dataOK=str_replace("12","DICIEMBRE",$dataOK);
			$dataOK=str_replace("11","NOVIEMBRE",$dataOK);
			$dataOK=str_replace("10","OCTUBRE",$dataOK);
                        $dataOK=str_replace("9","SETIEMBRE",$dataOK);
                        $dataOK=str_replace("8","AGOSTO",$dataOK);
                        $dataOK=str_replace("7","JULIO",$dataOK);
                        $dataOK=str_replace("6","JUNIO",$dataOK);
                        $dataOK=str_replace("5","MAYO",$dataOK);
                        $dataOK=str_replace("4","ABRIL",$dataOK);
                        $dataOK=str_replace("3","MARZO",$dataOK);
                        $dataOK=str_replace("2","FEBRERO",$dataOK);
                        $dataOK=str_replace("1","ENERO",$dataOK);
			$dataOK=str_replace(",",", ",$dataOK);
			return "<div style='width:260px;overflow:hidden;height:auto'>".$dataOK."</div>";
		} else if ($field=="seasontable") {
			$dataOK=$this->_format_field($data);
			if (substr($dataOK,0,1)=="T"||substr($dataOK,0,1)=="A"||substr($dataOK,0,1)=="G") $dataOK="1,2,3,4,5,6,7,8,9,10,11,12";
                        $lines=explode(",",$dataOK);
                        $dataOK="<div class='season'>";
			
                        for ($i=1;$i<=12;$i++) {
                                $active=trim($lines[$i-1]);
				
                                if ($i==1) $val="GEN";
				if ($i==2) $val="FEB";
				if ($i==3) $val="MAR";
                                if ($i==4) $val="ABR";
                                if ($i==5) $val="MAI";
                                if ($i==6) $val="JUN";
                                if ($i==7) $val="JUL";
                                if ($i==8) $val="AGO";
                                if ($i==9) $val="SET";
                                if ($i==10) $val="OCT";
                                if ($i==11) $val="NOV";
                                if ($i==12) $val="DES";

                                if ($active!="") $dataOK.="<div class='yes'>".$val."</div>"; else $dataOK.="<div class='no'>".$val."</div>";
                        }
                        return $dataOK."</div>";
		} else if ($field=="titolelab") {
			if ($this->_format_field($data)!="") return "<br>".$this->_format_field($data)."<br><br>"; else $this->_format_field($data);
		} else {

			return $this->_format_field($data);
		}
	}

	function _input_filter($field,$value) {
		if ($this->components[$field] && method_exists($this->components[$field],"input_filter")) {
			$value = $this->components[$field]->input_filter($value);  
		} else if ((substr($field,strlen($field)-5)=="_date"||substr($field,strlen($field)-9)=="_datetime")&&substr($value,5,1)=="-") {
			//date
			$value=substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2)." ".substr($value,11);
		}
		return $value;
 	}

       function _search_filter($field,$search_value,$queryop,$search_options) {
		if ($this->components[$field] && method_exists($this->components[$field],"search_filter")) {
	           $search_options = $this->components[$field]->search_filter($search_value,$queryop,$search_options);  
		}
		return $search_options;
	}

        // action function
        function action($name,$url) {
                $this->actions[$name]["url"] = $url;
        }

	// humanize function
	function humanize($field,$name,$desc="") {
		$this->humans[$field]["name"]	= $name;
		$this->humans[$field]["desc"]	= $desc;
	}

        // abbreviate function
        function abbreviate($field,$desc) {
                $this->abbrev[$field]=$desc;
        }
	
	// nowrap function
	function nowrap($field) {
		array_push($this->nowrap,$field);
	}

	// cross-reference a field with a field from another table, used in dataBrowser
	function multixref($field,$xkey,$xfield,$xtable) {
		$this->multixrefs[$field]=array();
		$this->multixrefs[$field]["xkey"] = $xkey;
		$this->multixrefs[$field]["xfield"] = $xfield;
		$this->multixrefs[$field]["xtable"] = $xtable;
	}

       // camps virtuals
       function xvField($xv_selectionfield, $params) { 
		 $this->xvarr[$xv_selectionfield]["name"]= $xv_selectionfield;
		 $this->xvarr[$xv_selectionfield]["label"]= $this->_getLabel($xv_selectionfield);
		 $this->xvarr[$xv_selectionfield]["value"]= $params['value'];
 		 $this->xvarr[$xv_selectionfield]["length"]= $params['length'];
		 if ($params['type']=="") $params['type']="string";
		 $this->xvarr[$xv_selectionfield]["type"]= "vr_".$params['type'];
		 $this->xvarr[$xv_selectionfield]["content_function"]= $params['content_function'];
		 // sql
		 if (is_array($params['sql'])) {
		 $this->xvarr[$xv_selectionfield]['sql']=array();
		 $this->xvarr[$xv_selectionfield]['sql']["selectionfield"] = $params['sql']['xv_selectionfield'];
		 $this->xvarr[$xv_selectionfield]['sql']["xselectionfield"] = $params['sql']['xv_xselectionfield'];
                 $this->xvarr[$xv_selectionfield]['sql']["xtable"] = $params['sql']['xv_xtable'];
                 $this->xvarr[$xv_selectionfield]['sql']["field"] = $params['sql']['xv_field'];
                 $this->xvarr[$xv_selectionfield]['sql']["xkey"] = $params['sql']['xv_xkey'];
                 $this->xvarr[$xv_selectionfield]['sql']["xfield"] = $params['sql']['xv_xfield'];
//		 $this->xvarr[$xv_selectionfield]['sql']["xkey"] = $params['sql']['xv_xfield'];
		 }
        }

	// safe_delete component
	function safedel($field,$value,$label="") {
		$this->sd_field = $field;
		$this->sd_value = $value;
		$this->sd_label = $label;
	}

	// default value component
	function defvalue($field,$value) {
		$this->defvalues[$field] = $value;
	}

        // default style component
        function setStyle($field,$value,$apl) {
		if (strpos(" ".$apl,"e")) $this->styleEditor[$field] = $value;
		if (strpos(" ".$apl,"b")) $this->styleBrowser[$field] = $value;
        }

	function concatField($field) {
		array_push($this->concatFields,$field);
	}

	// input max length
	function maxlength($field,$value) {
		$this->maxlengths[$field] = $value;
	}

	// require component
	function validate($field) {
		$this->validates[] = $field;
	}

        // add cross-reference dataBrowsers in dadaDetailer
        function xlist($xlist_title,$select_SQL,$mod) {
		$index=count($this->xlists)+1;
		$this->xlists[$index] = array();
		$this->xlists[$index]['query']= $select_SQL;
		$this->xlists[$index]['title'] = $xlist_title;
		$this->xlists[$index]['mod'] = $mod;
		if ($mod=="") die ('[mod]: invalid xlist');
        }

        function addObjectNavigator ($query) {
                if ($query!="") {
                        $this->addObjectNavigator = true;
                        }
        }

        function event($field, $eventtype, $condition, $call) {
                // no es pot guardar en array per tema  de classes
                $_SESSION ["event_".$field."_eventtype"] = $eventtype;
                $_SESSION ["event_".$field."_condition"] = $condition;
                $_SESSION ["event_".$field."_call"] = $call;
                //$this->events[$field]["eventtype"] = $eventtype;
                //$this->events[$field]["condition"] = $condition;
                //$this->events[$field]["call"] = $call;
        }

	function addComment ($field,$value) {
			$this->comments[$field]=$value;
	}

	function inputSize ($field,$value) {
                        $this->inputsize[$field]=$value;
        }

	function getConf($mod,$field) {

		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];

		if ($field!="") {
			$sel="SELECT value FROM kms_{$mod} WHERE name='{$field}'";
			$result = mysqli_query($dblink,$sel);
			$value  = mysqli_fetch_array($result);
			return $value[0];
		} else {
			//all
			$sel="SELECT name,value FROM kms_{$mod}";
			$data=array();
			while ($row=mysqli_fetch_array($result)) {
				$data[$row['name']]=$row['value'];
			}
			return $data;
		}

	}

	function onFieldLoad($field,$js) {
                $params=array();
                $params['action']=$js;
                if (!is_array($this->fieldLoad_events)) $this->fieldLoad_events=array();
                $this->fieldLoad_events[$field]=$params;
        }

	function onFieldChange($field,$js) {
		$params=array();
		$params['action']=$js;
		if (!is_array($this->fieldChange_events)) $this->fieldChange_events=array();
//		array_push($this->fieldChange_events,$c);
		$this->fieldChange_events[$field]=$params;
	}

	function onFieldFocus($field,$js) {
		$params=array();
                $params['action']=$js;
                if (!is_array($this->fieldFocus_events)) $this->fieldFocus_events=array();
                $this->fieldFocus_events[$field]=$params;
	}

        function onFieldBlur($field,$js) {
                $params=array();
                $params['action']=$js;
                if (!is_array($this->fieldBlur_events)) $this->fieldBlur_events=array();
                $this->fieldBlur_events[$field]=$params;
        }

        function onDocumentReady($js) {
                $this->onDocumentReady=$js;
        }

	function script($js) {
		if (!is_array($this->scripts)) $this->scripts=array();
		array_push($this->scripts,$js);
	}

	function setComponent($component,$field,$params=array()) {
		if ($component=="select") { 
			if (!is_array($this->combos_arr)) $this->combos_arr=array();
			array_push($this->combos_arr,$field); 
		}

                $user_data_path = "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/";
                if (file_exists($user_data_path."/components/{$component}.php")) {
                                include_once ($user_data_path."/components/{$component}.php");
                } else {
                        if (!file_exists(PATH_RULES . "/{$component}.php")) {
                        $this->_error("Invalid Component","Component '{$component}' not found. This feature is not supported.");
                        }
                        include_once(PATH_RULES . "/{$component}.php");
                }

                if ($this->components[$field]) {
//                        $this->components[$field]=null;
			$this->components[$field]=array($this->components[$field]); //convert to array of components!
                        //   $this->_error("Configuration Error","Field '{$field}' already has a component applied.");
			array_push(new $component($field,$params,$this),$this->components[$field]);
                } else {

		$this->components[$field] = new $component($field,$params,$this);
		}
	}

	function hasComponent($field,$component) {
		return is_a($this->components[$field],$component);
	}

	function setGroup($title,$collapse,$fields=array()) {
                 if (!is_array($this->groups_arr)) $this->groups_arr=array();
                 $group=array("title"=>$title,"collapse"=>$collapse,"fields"=>$fields); 
		 //array_push($this->groups_arr,$group);
	 	 $this->groups_arr[$title]=$group; //this way overrides
        }

	function inGroup($field) {
		foreach ($this->groups_arr as $group) {
			if (in_array($field,$group['fields'])) return true;
		}
		return false;
	}

	function setValidator($field,$type,$custom) {
		if (!is_array($this->validators)) $this->validators=array();
		$this->validators[$field]=array("type"=>$type,"custom"=>$custom);
	}

	function addButton($buttype,$recipients=array()) {
		if (!file_exists(PATH_BUTTONS . "/{$buttype}.php")) {
			$this->_error("Invalid Button type","Button '{$buttype}' not found. This feature is not supported.");
		}
		include_once(PATH_BUTTONS . "/{$buttype}.php");
		$this->buttons[$buttype] = new $buttype($recipients,$this);
	}

	function _shorten_linkname ($s,$maxlen) {
		$spc_pos=true;$n=0;
		while (strlen($s)>$maxlen&&$spc_pos) {
			$spc_pos=strrpos($s," ");
			if ($spc_pos) $s=substr($s,0,$spc_pos)."&#8230;"; // suspensius
			$n++;
		}
		return $s;
	}

	function _transfer_record($table,$id,$dbid) {
		

	}

        function createRandomPassword($n) {
            $chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHJKLMNPQRSTUVWXYZ";
            srand((double)microtime()*1000000);
            $i = 0;
            $pass = '' ;
            while ($i <= $n) {
                $num = rand() % strlen($chars);
                $tmp = substr($chars, $num, 1);
                $pass = $pass . $tmp;
                $i++;
            }
            return $pass;
        }

	function _link($add) {
		$link="";
		if ($_GET['app']!="") $link.="&app=".$_GET['app'];
		if ($_GET['mod']!="") $link.="&mod=".$_GET['mod'];
		if ($_GET['view']!="") $link.="&view=".$_GET['view'];
		if ($_GET['v2']!="") $link.="&v2=".$_GET['v2'];
		if ($_GET['from']!="") $link.="&from=".$_GET['from'];
		if ($_GET['op']!="") $link.="&op=".$_GET['op'];
		if ($_REQUEST['queryfield']!="") $link.="&queryfield=".$_REQUEST['queryfield'];
		if ($_REQUEST['query']!="") $link.="&query=".$_REQUEST['query'];
		if ($_GET['panelmod']!="") $link.="&panelmod=".$_GET['panelmod'];
		if ($_GET['xid']!="") $link.="&xid=".$_GET['xid'];
		if ($_GET['page_rows']!="") $link.="&page_rows=".$_GET['page_rows'];
		if ($_GET['sortby']!="") $link.="&sortby=".$_GET['sortby'];
		if ($_GET['sortdir']!="") $link.="&sortdir=".$_GET['sortdir'];
		if ($_GET['page']!="") $link.="&page=".$_GET['page'];
		$link=substr($link,1);
		return "/?".$link."&".$add;
	}

	function filter_fields($post) {
		$new_post=array();
		foreach ($post as $i => $val) {
			if ($i!="app"&&$i!="mod"&&$i!="view"&&$i!="panelmod"&&$i!="xid"&&$i!="return_mod"&&$i!="from") {
				$new_post[$i]=$val;
			}
		}
		return $new_post;
	}

}  // end class
?>
