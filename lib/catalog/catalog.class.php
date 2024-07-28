<?php
// TaskManager

// some required settings
//error_reporting(E_ALL);
//ini_set('display_errors', '1');


set_magic_quotes_runtime(0);
ini_set('magic_quotes_gpc',1);
ini_set('register_globals',0);
error_reporting(E_ERROR | E_WARNING | E_USER_ERROR);


// constants
define("PATH_TPL","/usr/local/kms/tpl");

define("PATH_IMG_BIG","/kms/css/aqua/img/big");
define("PATH_IMG_SMALL","/kms/css/aqua/img/small");
define("PATH_IMG_FILETYPES","/kms/css/aqua/img/filetypes");

define("PATH_LIB","/usr/local/kms/lib");
define("PATH_RULES","/usr/local/kms/lib/components");
define("PATH_BUTTONS","/usr/local/kms/lib/buttons");

// include the required classes
include_once("/usr/local/kms/lib/template.php");
include_once("/usr/local/kms/lib/dataDBI.php");
include_once("/usr/local/kms/lib/catalog/dataBrowser.php");
include_once("/usr/local/kms/lib/catalog/dataDetailer.php");


/**
 * Base class for the editor, browser, and detailer.
 */
class intergridKMS {

	// some global defaults
	var $version		= "1.00";
	var $delimiter	= "|";
	var $components      = array();
        var $buttons    = array();
	var $conf       = array();

  // constructor, set configuration
	function intergridKMS() {
    if ($dbconf = parse_ini_file("conf/database.ini.php")) {
        $this->dbi = new dataDBI($dbconf);
    } else {
        $this->_error("Configuration Error","Unable to locate configuration file 'database.ini.php'");
    }

    $this->tpl = new template();
	}

  // factory method for retrieving the appropriate
  // intergridKMS class instance.
  function &getInstance() {
    switch ($_GET['_']) {
	    // the editor handles all operations dealing with editing the field
	    // values.
	    case "e":
		    $kms = new dataEditor();
	    break;

  	  // the detailer handles the printing or detailing of a specific record
	    // in the database table.  it is used for making a printable page of the
	    // record details for reports and statistics.
	    case "d":
		    $kms = new dataDetailer();
	    break;

	    // the browser handles all operations dealing with listing and searching
	    // the data.
	    case "b":
	    default:
		  $kms = new dataBrowser();
	    break;
    }

    return $kms;
  }

	// vars that can be overridden by session,post,get
	// needs reworking, this is a problem area
	function _var_setup() {
		$this->per_page		= $this->_get_value("per_page",$this->page_rows);
		$this->sortby 		= $this->_get_value("sortby",$this->orderby?$this->orderby:$this->fields[0]);
		$this->sortdir 		= $this->_get_value("sortdir",$this->sortdir?$this->sortdir:"asc");
		$this->page				= $this->_get_value("page","1");

		if ($_REQUEST['_action']=="Clear") { // clear settings
			$this->page				= "1";
			$this->query			= "";
			$this->queryfield	= "";
			$this->per_page		= $this->page_rows?$this->page_rows:10;
      unset($_SESSION[$this->table]);
	//		$this->addmsg("Cleared search query and restored all display settings.");
		} else { // fall through
			// if the user performed a search, clean up some variables:
			if (!empty($_POST['query'])) {
				$this->query = $_POST['query'];
				$_SESSION[$this->table]["query"]	= $this->query;
				$this->page = 1;	// put them on first page of results
        $this->per_page = $this->page_rows?$this->page_rows:10;
			} else {
				// pull query from session data:
				$this->query			= $this->_get_value("query","");
			}
			$this->queryfield = $this->_get_value("queryfield","");
		}
	}

	// return a value set in GET,POST,SESSION
	function _get_value($var,$val) {
		if ($_GET[$var]) {
			$_SESSION[$this->table][$var] = $_GET[$var];
			return $_GET[$var];
		} elseif ($_POST[$var]) {
			$_SESSION[$this->table][$var] = $_POST[$var];
			return $_POST[$var];
		} elseif ($_SESSION[$this->table][$var]) {
			return $_SESSION[$this->table][$var];
		} else {
			return $val;
		}
	}

	// construct array of field names to use
	function _field_setup() {
		// browser field setup
		if (!$this->fields || !is_array($this->fields)) {
			$this->fields = $this->_get_fieldnames();
		}
		$this->field_cnt = sizeof($this->fields);
                $this->field_str = join("`, `",$this->fields);
                $this->field_str = "`" . $this->field_str . "`";

		// editor field setup
		$this->edit_fields = $this->_get_fieldnames();
		$this->edit_field_cnt = sizeof($this->edit_fields);
                $this->edit_field_str = join("`, `",$this->edit_fields);
                $this->edit_field_str = "`" . $this->edit_field_str . "`";
	}

	// determine field name list from database
	function _get_fieldnames() {
		if (!$flds = $this->dbi->list_fields($this->dbi->conf['name'], $this->table)) {
			$this->_error("Configuration Error","Unable to get field names from {$this->table} {$this->dbi->conf['name']}");
		} else {
			$cols = $this->dbi->num_fields($flds);
			$fields = array();
			for ($i = 0; $i < $cols; $i++) {
				$fn = $this->dbi->field_name($flds, $i);
				if (!@in_array($fn, $this->exclude) && $fn!=$this->key) { // exclude
					array_push($fields, $fn);
				}
				if ($fn==$this->key && $this->show_key) {
					array_push($fields, $fn);
				}
			}
			return $fields;
		}
	}

	// returns safe data with clickable uri's
	function _format_field($data) {
		$data = htmlspecialchars($data); // formatted html
		$query_string = stripslashes($this->query);
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
				"<a target=_new href=\"\\1\">\\1</a>");
			$data = preg_replace($searcharray, $replacearray, $data);
		}	
		return nl2br(stripslashes($data));
	}

	// makes a table/field name pretty
	function _format_name($text) {
		$s = str_replace("_"," ",$text);
		return ucwords(strtolower($s));
	}

	// add a message to the message stack
	function addmsg($msg) {
		$_SESSION[$this->table]["msgs"][] = $msg;
	}

	// draws a pretty error page
	function _error($head,$msg) {
		$this->_head($head,null);
    $this->tpl->set('msg',$msg);
	//    echo $tpl->fetch('error.php');
	echo $msg;exit;
		$this->_foot();
		exit();
	}

	function _head($title,$content_type) {
	    $this->tpl->set('title',$title);
	    $this->tpl->set('content_type',$content_type);

	    $this->tpl->set('msgs',$_SESSION[$this->table]["msgs"]);
	    $this->tpl->set('showMenu', $this->showMenu);
	    $_SESSION[$this->table]["msgs"] = array();
  	   // echo $this->tpl->fetch("head.php");
	}
	
	function _foot() {
    $this->tpl->set("debug",$this->dbi->debug);
    $this->tpl->set("version",$this->version);
    $this->tpl->set("footer_align", "right");
  //  echo $this->tpl->fetch("common_footer.php");
	}

	function redirect($url, $msg="", $delay=0) {
    if (headers_sent()) {
    		$delay = ($this->dbi->debug ? 3 : $delay);
	      echo "<meta http-equiv=\"refresh\" content=\"{$delay};URL={$url}\">";
    	  if (!empty($msg)) echo "<div style=\"font-family: Arial, Sans-serif; font-size: 12pt; font-weight:bold;\">{$msg}</div>";
        exit();
    } else {
        header("location: {$url}");
        exit();
    }
	}

	//button filter
	 function _output_button($key) {

	}

	// output filter
	function _output_filter($field,$data,$id) {

// posem link a description
//if ($field=="description") echo "<b><A href='http://intranet.intergrid.cat/taskman/index.php?port='>(+)</a>";

//if  ($this->buttons['groupmail']) echo "BUT";

      if ($this->components[$field] && method_exists($this->components[$field],"output_filter")) {
      return $this->components[$field]->output_filter($data,$id);

//---- start multixref

		} elseif (is_array($this->multixrefs[$field])) { // check for multixrefs
			//if (!$this->mxrefstack[$data] && !empty($data)) {
				$_arr = explode($this->delimiter,$data);
				$tmp = array();
				foreach ($_arr as $key=>$value) {
					$sql = "SELECT `{$this->multixrefs[$field]["xfield"]}` FROM `{$this->multixrefs[$field]["xtable"]}` ";
					$sql .= "WHERE `{$this->multixrefs[$field]["xkey"]}` = '{$value}'";
					$result = $this->dbi->query($sql);
					$A  = $this->dbi->fetch_array($result);
					$tmp[] = $A[$this->multixrefs[$field]["xfield"]];
				}

				$this->mxrefstack[$data] = @join(", ",$tmp);
			//}
			return $this->mxrefstack[$data];

//---- end multixref

		} else {
			return $this->_format_field($data);
		}
	}

  function _input_filter($field,$value) {
      if ($this->components[$field] && method_exists($this->components[$field],"input_filter")) {
          $value = $this->components[$field]->input_filter($value);  
      }
      return $value;
  }

  function _search_filter($field,$query) {
      if ($this->components[$field] && method_exists($this->components[$field],"search_filter")) {
          $query = $this->components[$field]->search_filter($query);  
      }
      return $query;
  }

	// humanize component
	function humanize($field,$name,$desc="") {
		$this->humans[$field]["name"]	= $name;
		$this->humans[$field]["desc"]	= $desc;
	}

	// cross-reference a field with a field from another table for a multi-select
	function multixref($field,$xkey,$xfield,$xtable) {
		$this->multixrefs[$field]["xkey"] = $xkey;
		$this->multixrefs[$field]["xfield"] = $xfield;
		$this->multixrefs[$field]["xtable"] = $xtable;
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

	// require component
	function validate($field) {
		$this->validates[] = $field;
	}

	// cross-reference a field from another table for listing items
	function xlist($xlist_ref_table,$xlist_ref_key,$xid,$xlist_ref_fields="") {
		$this->xlist_ref_table = $xlist_ref_table;
		$this->xlist_ref_key = $xlist_ref_key;
		$this->xid = $xid;
		if (is_array($xlist_ref_fields)) {
			$quoted_fields = array();
			foreach ($xlist_ref_fields as $f)
				$quoted_fields[] = "`" . $f . "`";
			$this->xlist_ref_fields_str = join(", ", $quoted_fields);
		} else {
			$this->xlist_ref_fields_str = "*";
		}
	}

  /*=== components handler =====*/

  function setComponent($component,$field,$params=array()) {
      if ($this->components[$field]) {
          $this->_error("Configuration Error","Field '{$field}' already has a component applied.");
      }
      if (!file_exists(PATH_RULES . "/{$component}.php")) {
          $this->_error("Invalid Component","Component '{$component}' not found. This feature is not supported.");
      }
      include_once(PATH_RULES . "/{$component}.php");
      $this->components[$field] =& new $component($field,$params,$this);
  }

  function hasComponent($field,$component) {
      return is_a($this->components[$field],$component);
  }

/*=== components handler =====*/

  function addButton($buttype,$recipients=array()) {

      if (!file_exists(PATH_BUTTONS . "/{$buttype}.php")) {
          $this->_error("Invalid Button type","Button '{$buttype}' not found. This feature is not supported.");
      }
      include_once(PATH_BUTTONS . "/{$buttype}.php");
      $this->buttons[$buttype] =& new $buttype($recipients,$this);
  }


}
?>
