<?php
// intergridKMS - data browser / editor
// Jason Hines, jason@greenhell.com
// $Id: dataBrowser.php,v 1.17 2004/08/24 13:30:44 openface Exp $

/**
 * dataBrowser lists the records in a table, providing pagination,
 * and links to edit, view, and delete records.
 */
class dataBrowser extends intergridKMS {

	function dataBrowser() {
    parent::intergridKMS();
	}

	function Main() {
		if (!$this->table) { $this->_error("Cannot start","No table defined."); }
		if (!$this->key) { $this->_error("Cannot start","No primary key defined."); }

                $this->dbi->connect($this->dbname,$this->dbuser,$this->dbpass);
		$this->_var_setup();
		$this->_field_setup();
	
		if (!$this->select) $this->select = "`{$this->key}`, {$this->field_str}";
		if (!$this->from) $this->from=$this->table; 

	
		$this->sql = "SELECT {$this->distinct} {$this->select} FROM {$this->from}";
		$this->_query_result();
		$this->_sortby_results();
		$this->_split_results();
		$this->result = $this->dbi->query($this->sql);
		$this->nrows  = $this->dbi->num_rows($this->result);

		if ($_REQUEST['_action']=="export" && $this->can_export) { // export tab-delimited
			$this->_export_records();
			exit();
		} elseif ($_REQUEST['_action']=="import" && $this->can_export) { // import tab-delimited
			$this->_import_records();
			$this->redirect("{$_SERVER['PHP_SELF']}?_=b");
		} elseif ($this->query) { // are we searching?
			$this->addmsg(_GLOBAL_SEARCHING." \"" . stripslashes($this->query) . "\".");
		}
		print $this->introtext;
		// DEBUG
		//echo $this->sql;

		$this->_head(($this->title?$this->title:$this->_format_name($this->table)),$this->default_content_type);

		print "<form action=\"{$_SERVER['PHP_SELF']}?_=b&parent=".$_GET["parent"]."&bf=".$_GET["bf"]."&dr_folder=".$_GET["dr_folder"]."\" method=\"POST\" name=\"dm\" enctype=\"multipart/form-data\">\n";
//		print $this->_draw_buttons_bar();
//		print "<font style='font-size:1px;'><br></font>";
		if ($this->nrows < 1) {
			$_SESSION['numresults']=0;
		} else {
			$_SESSION['numresults']=$this->nrows;
		//	print "<table cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" border=\"0\" class=\"LIST\">\n";
			if ($this->viewmode=="table") $this->_draw_header();

			for ($i=0;$i<$this->nrows;$i++) {
				$data	= $this->dbi->fetch_object($this->result);
				if ($this->viewmode=="grid") print "<div style='float:left;width:".$kms->divwidth.";padding:7px;clear:none;'>";
				$this->_draw_row($data,$i%2);
				if ($this->viewmode=="grid") print "</div>";
			}

	//	print "</table><hr>\n";
                if ($this->pagination) { $this->_draw_pages(); }
		}
		print "</form>\n";
		//$this->_foot();
	}


	// draws the next/prev page links and shows page/row count
	function _draw_pages() {
                $s = "<div style=\"float:left;width:100%;padding:5px;background-color:".$this->bgColorPagination."\"><table class=\"OPT\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n";
                $s .= "<tr>\n<td nowrap align=\"".$this->alignPagination."\"> ";
                $s .= $this->_display_links();
                if ($this->displayCount) {
                $s .= "</td>\n<td nowrap align=\"right\">";
                $s .= $this->_display_count();  }
                $s .= "</td>\n</tr></table></div>\n";
                print $s;
	}

	// draws per_page and search menus
	function _draw_buttons_bar() {
		$s = "<table class=\"OPT\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"25\">\n";
		$s .= "<tr>\n<td nowrap>";

		if ($_REQUEST['_action']=="import_dialog" && $this->can_import) { // import dialog
			$s .= "Import Tab-Delimited: ";
			$s .= "</td><td>\n";
			$s .= "<input name=\"_action\" value=\"import\" type=\"hidden\">\n";
			$s .= "<input name=\"import\" type=\"file\" size=\"16\" accept=\"text/*\"> ";
			$s .= "<input class=\"commonButton\" type=\"submit\" value=\"Import File\">";

		} else {

			$s .= $this->_display_per_page();
			$s .= "</td>\n<td nowrap align=\"center\">";

			if ($this->can_add) { // add button
				$s .= $this->_add_button();
				$s .= "&nbsp;";
			}
			if ($this->can_import) { // import button
				$s .= " " . $this->_import_button();
			}
			if ($this->can_export) { // export button
				$s .= " " . $this->_export_button();
			}
		}

		$s .= "</td>\n<td nowrap align=\"right\">";

		if ($this->can_search) {
			$s .= $this->_display_search();
		}
                        $s .= "</td>\n</tr>\n";
                        $s .= "</table>\n";
//		if ($this->showButtons) {
			print $s;
//		}
	}

	// rows to display per page
	function _display_per_page() {
		//$s = "&nbsp;&nbsp;<input class=\"commonButton\" type=\"button\" value=\""._MB_START."\" onClick=\"location.href='index.php?_=b&_action=Clear'\">\n";
/*
		$s = _MB_SHOWING." ";
		$s .= "<select name=\"per_page\" onchange=\"document.dm.submit();\">\n";

		$max = $this->num_rows / 2;
		for ($i=$this->page_rows;$i<=$max;$i=$i*2) {
			$s .= "<option " . ($this->per_page==$i?"selected":"") . ">{$i}</option>\n";
		}			
		$s .= "<option " . ($this->per_page==$this->num_rows?"selected":"") . ">{$this->num_rows}</option>\n";	
		$s .= "</select>";
		$s .= " "._MB_PERPAGE." ";*/
		return $s;
	}

	// search menu
	function _display_search() {
		$s = "<select name=\"queryfield\">\n";
		$sel = ($this->queryfield=="*" ? "selected" : "");
		$s .= "<option {$sel}>*</option>\n";
		foreach ($this->fields as $field) {
			$sel = ($field==$this->queryfield ? "selected" : "");
			$fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : $this->_format_name($field);
			$s .= "<option value=\"{$field}\" {$sel}>{$fname}</option>\n";
		}
		$s .= "</select>\n";
		$s .= " ";
		$s .= "<input type=\"text\" name=\"query\" value=\"" . stripslashes($this->query) . "\" size=\"12\">\n";
		$s .= "<input class=\"searchButton\" type=\"submit\" name=\"search\" value=\"\" alt=\""._MB_SEARCH."\">\n";
		if (!isset($_GET['parent'])) {$parent="0";} else { $parent=$_GET['parent'];}
//		$s .= "&nbsp;<input class=\"showallButton\" type=\"submit\" name=\"showall\" value=\"\" alt=\""._MB_SHOWALL."\" onClick=\"javascript:window.location='/?_=b&_action=Clear&parent=".$parent."&bf=".$_GET['bf']."&dr_folder=".$_GET["dr_folder"]."'\">&nbsp;\n";
$s .= "<a href='?_=b&_action=Clear&parent=".$parent."&bf=".$_GET['bf']."&dr_folder=".$_GET["dr_folder"]."'>"._MB_SHOWALL."</a>&nbsp;\n";
		if ($_GET['bf']=="") {$bf = 0; } else {$bf=$_GET['bf'];
                if (isset($this->imgPrev)) $imgPrev = $this->imgPrev; else $imgPrev = PATH_IMG_SMALL."/prev.gif";

		$s .= "&nbsp;<a href='?_=b&_action=Clear&parent=".$bf."'><img src='".$imgPrev."' border='0'\"></a>&nbsp;\n";}
		return $s;
	}

	function _add_button() {
		if (!isset($_GET['parent'])) $parent = "0"; else $parent = $_GET['parent'];

		// return "<input class=\"commonButton\" type=\"button\" value=\"".(isset($this->insert_label) ? $this->insert_label : 'Insert') ."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?_=e&parent=".$parent."&dr_folder=".$_GET['dr_folder']."&srid=".$_GET['id']."'\">&nbsp;";
		if (!isset($_GET['dr_folder'])) $out = "<input class=\"newFolderButton\""; else $out = "<input class=\"newObjectButton\"";

		$out .= " type=\"button\" value=\"\" alt=\"".(isset($this->insert_label) ? $this->insert_label : 'Insert') ."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?_=e&parent=".$parent."&dr_folder=".$_GET['dr_folder']."&srid=".$_GET['id']."'\">&nbsp;".$this->insert_label;

		return $out;


//		return "<a href='{$_SERVER['PHP_SELF']}?_=e&parent=".$parent."' style='margin:0' class='BUT' ><img src='".PATH_IMG_SMALL."/".$this->default_content_type.".gif' border='0'>&nbsp;" .
                        (isset($this->insert_label) ? $this->insert_label : 'Insert') .
			"</a>";

	}

	function _import_button() {
		return "<input class=\"commonButton\" type=\"button\" value=\""._MB_IMPORT."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?_=b&_action=import_dialog&parent=".$parent."&bf=".$_GET['bf']."&dr_folder=".$_GET["dr_folder"]."'\">";
	}

	function _export_button() {
		return "<input class=\"commonButton\" type=\"button\" value=\""._MB_EXPORT."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?_=b&_action=export'\">";
	}

	// header row with sorting
	function _draw_header() {
//		print "<table>";
		print "<tr>\n";
		foreach ($this->fields as $field) {

// ocultem columnes que no volem que apareixin
if (($field !="content_type")&&($field !="shortcut_to")&&($field !="external_url")) {
			// set human readable field names
			$fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : $this->_format_name($field);

			// set sorting on field
			if ($this->sortby==$field) {
				if ($this->sortdir=="asc") {
					print "<th height=\"20\" class=\"HDR\" nowrap><a href=\"{$_SERVER['PHP_SELF']}?_=b&sortby={$field}&sortdir=desc&parent=".$_GET['parent']."&dr_folder=".$_GET['dr_folder']."\">{$fname}<img src=\"".PATH_IMG_SMALL."/arrow_down.gif\" alt=\"Descending\" border=\"0\" /></a></th>\n";
				} else {
					print "<th height=\"20\" class=\"HDR\" nowrap><a href=\"{$_SERVER['PHP_SELF']}?_=b&sortby={$field}&sortdir=asc&parent=".$_GET['parent']."&dr_folder=".$_GET['dr_folder']."\">{$fname}<img src=\"".PATH_IMG_SMALL."/arrow_up.gif\" alt=\"Ascending\" border=\"0\" /></a></th>\n";
				}
			} else {
				print "<th height=\"20\" class=\"HDR\" nowrap><a href=\"{$_SERVER['PHP_SELF']}?_=b&sortby={$field}&sortdir={$this->sortdir}&parent=".$_GET['parent']."&dr_folder=".$_GET['dr_folder']."\">{$fname}</a></th>\n";
			}
		}
// tanquem if content_type
		}
		print "<th class=\"HDR\">&nbsp;</th>\n";
		print "</tr>\n";
	}

	// draws a row of data
	function _draw_row($data,$bg) {
		$key = $this->key;
		$gridnode = array();
		if ($this->viewmode=="table") print "<tr>"; 
		foreach ($this->fields as $field) {
		// capturem shortcut_to, i external_url
		if ($field =="shortcut_to") $shortcut_to = $data->shortcut_to; 
		if ($field =="external_url") $external_url = $data->external_url;
		if ($field =="content_type") $content_type = $data->content_type;
		if (substr($field,0,3)=="sr_") { $srid = $data->$field;} //static reference  (1 a 1) ex:  contracte => 1 client unic
		if (substr($field,0,3)=="dr_") { $drid = $data->$field;} //dynamic reference (1 a molts)  client => multiples productes
		
                // ocultem columnes que no volem que apareixin
		if (($field !="content_type")&&($field !="shortcut_to")&&($field !="external_url")) 
		{
		  if ($this->viewmode=="table") print "<td class=\"ROW{$bg}\" valign=\"top\">\n";
			if ($field == "id")  $id = $this->_output_filter($field,$data->$field,$id); 
			if ($_GET['id']=="") $id=0; else $id=$_GET['id'];

			if  (($field == "description")||($field=="name")||($field==$this->linkField)||($field=="sr_name")) {
				if ($content_type!="folders") $content_type = $this->default_content_type; 
							      else $content_type = $data->content_type;
				// ---- CLIC DESCRIPTION ---
	
				print "<a href='";
				if ($content_type!=$this->default_content_type) {
					if ($external_url!="") {
 								print $external_url;
						               } else { 
						       	 	if ($shortcut_to=="-1") print $content_type.".php?dr_folder=".$data->$key;//$this->default_file."?dr_folder=".$_GET['dr_folder'];
								 else print $content_type.".php?dr_folder=".$shortcut_to;// $this->default_file."?dr_folder=".$_GET['dr_folder']; 
							       }
				} else {
					if ($content_type!="folders") {
                                           //is an object, open file

//						if ($external_url=="")  print "?_=d&id={$data->$key}&srid=".$srid."&drid=".$drid."&dr_folder=".$_GET['dr_folder'];
						if ($external_url=="")  print $_SERVER['REQUEST_URI']."&_=d&id={$data->$key}&srid=".$srid."&drid=".$drid."&dr_folder=".$_GET['dr_folder'];
									else print $external_url;
                                           } else {
						 if ($external_url!="")  print $external_url; 
 									 else if ($shortcut_to=="-1")  print "?parent=".$data->$key."&bf=".$this->bf;
									  else  print "?parent=".$shortcut_to."&bf=".$this->bf;									
					   }
				        }
 	 	 	 	        print "'>";

				}
			        if ($this->viewmode=="table") print $this->_output_filter($field,$data->$field,$data->$key);
  							  else $gridnode[$field] = $this->_output_filter($field,$data->$field,$data->$key);
 			        if  ($field == "description")  { print "</a>"; }
 		   	       if ($this->viewmode=="table")  print "<br>&nbsp;</td>\n";

		        } else {  // sino != description o name

			if ($content_type!="folders") $content_type = $this->default_content_type; else $content_type = $data->$field;
			//echo $content_type;
		}
		}



		print $this->_output_button($data->$key);

		if ($this->can_view) {
		print "<a href=\"{$_SERVER['PHP_SELF']}?_=d&{$key}={$data->$key}&srid=".$srid."&drid=".$drid."&parent=".$this->parent."&dr_folder=".$_GET['dr_folder']."\"><img src=\"".PATH_IMG_SMALL."/details.gif\" alt=\""._MB_DETALLS."\" title=\""._MB_DETALLS."\" border=\"0\"></a> \n";
		}
		if ($this->viewmode=="table") print "</td></tr>\n";

		if ($this->viewmode!="table") include $this->gridnode_template;

	}

	// determines sorting and appends to sql query
	function _sortby_results() {
		if ($this->sortby && $this->sortdir) {
			$this->sql .= " ORDER BY {$this->sortby} {$this->sortdir}";
		}
		if ($_REQUEST['sortby']) $this->page = "1"; // rewind if sorting by a new field
	}

	// determines the limit to append to sql query
	function _split_results() {
		if (empty($this->page)) $this->page = 1;

		$pos_to = strlen($this->sql);
		$pos_from = strpos($this->sql, 'FROM', 0);

		$pos_group_by = strpos($this->sql, ' GROUP BY', $pos_from);
		if (($pos_group_by < $pos_to) && ($pos_group_by != false)) {
			$pos_to = $pos_group_by;
		}
		$pos_having = strpos($this->sql, ' HAVING', $pos_from);
		if (($pos_having < $pos_to) && ($pos_having != false)) {
			$pos_to = $pos_having;
		}
		$pos_order_by = strpos($this->sql, ' ORDER BY', $pos_from);
		if (($pos_order_by < $pos_to) && ($pos_order_by != false)) {
			$pos_to = $pos_order_by;
		}
		$pos_limit = strpos($this->sql, ' LIMIT', $pos_from);
		if (($pos_limit < $pos_to) && ($pos_limit != false)) {
			$pos_to = $pos_limit;
		}
		$pos_procedure = strpos($this->sql, ' PROCEDURE', $pos_from);
		if (($pos_procedure < $pos_to) && ($pos_procedure != false)) {
			$pos_to = $pos_procedure;
		}
		$sql	= "select count(*) as total " . substr($this->sql, $pos_from, ($pos_to - $pos_from));
		$result = $this->dbi->query($sql);
		$count = $this->dbi->fetch_object($result);
		$this->num_rows = $count->total;
		$offset = ($this->per_page * ($this->page - 1));
		if ($offset < $this->num_rows) {
			$limit = " LIMIT {$offset}, {$this->per_page}";
		} else {
			$limit = " LIMIT {$this->per_page}";
		}
		$this->sql .= $limit;
	}

	// determines where clause to append to sql query
	function _query_result() {
		if ($this->queryfield && $this->query) {
			if ($this->queryfield=="*") {
				$i=0;
				$this->sql .= " WHERE (";
				foreach ($this->fields as $field) {
					$i++;
				        $search_value = $this->_search_filter($field,$this->query);
					$this->sql .= "`{$field}` LIKE '%{$search_value}%' ";
				        unset($search_value);
					if ($i<$this->field_cnt) $this->sql .= "OR ";
				}
				$this->sql .= ")";
			} else {
			        $search_value = $this->_search_filter($this->queryfield,$this->query);
				$this->sql .= " WHERE (`{$this->queryfield}` LIKE '%{$search_value}%')";
			        unset($search_value);
			}
			if ($this->where) {
				$this->sql .= " AND ({$this->where})";
				return true;
			}
		}
		if ($this->where) {
			$this->sql .= " WHERE ({$this->where})";
		}
	}

	// draws next/prev and page links
	function _display_links() {
		$string = "";
		$this->num_pages = intval($this->num_rows / $this->per_page);

		if ($this->num_rows % $this->per_page) $this->num_pages++;
		if ($this->page > 1) {
		if ($this->imgFirst) { 
			$string .= "<a class=\"\" href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page=1\"><img src=\"".PATH_IMG_SMALL."/first.gif\" border=\"0\" alt=\"First\"></a>";
		}
                 if (isset($this->imgPrev)) $imgPrev = $this->imgPrev; else $imgPrev = PATH_IMG_SMALL."/prev.gif";
                        $string .= "<a href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page=" . ($this->page - 1) ."\"><img src=\"".$imgPrev."\" border=\"0\" alt=\"Prev\"></a>&nbsp;";

		} else {
//			$string .= "<img src=\"".PATH_IMG_SMALL."/first.gif\" border=\"0\" alt=\"First\">";
//			$string .= "<img src=\"".PATH_IMG_SMALL."/prev.gif\" alt=\"Prev\">&nbsp;";
		}
		$cur_window_num = intval($this->page / $this->page_links);
		if ($this->page % $this->page_links) $cur_window_num++;
		$max_window_num = intval($this->num_pages / $this->page_links);
		if ($this->num_pages % $this->page_links) $max_window_num++;
		if ($cur_window_num > 1) {
			$string .= "<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page=" . (($cur_window_num - 1) * $this->page_links) ."\">...</a>";
		}
		for ($jump_to_page = 1 + (($cur_window_num - 1) * $this->page_links); ($jump_to_page <= ($cur_window_num * $this->page_links)) && ($jump_to_page <= $this->num_pages); $jump_to_page++) {
			if ($jump_to_page == $this->page) {
				// PAGINA SELECCIONADA
				$string .= "&nbsp;<span class=\"PAGE\" style=\"font-weight:bold;border:1px solid #cccccc;\">" . $jump_to_page . "</span>&nbsp;";
			} else {
				$string .= "&nbsp;<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page={$jump_to_page}\"><u>" . $jump_to_page . "</u></a>&nbsp;";
			}
		}
		if ($cur_window_num < $max_window_num) {
			$string .= "<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page=" . (($cur_window_num) * $this->page_links + 1) . "\">...</a>&nbsp;";
		}
		if (($this->page < $this->num_pages) && ($this->num_pages != 1)) {

		if (isset($this->imgNext)) $imgNext = $this->imgNext; else $imgNext = PATH_IMG_SMALL."/next.gif";
			$string .= "&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page=" . ($this->page + 1) . "\"><img src=\"".$imgNext."\" border=\"0\" alt=\"Next\"></a>&nbsp;";
		if ($this->imgLast) {
			$string .= "<a href=\"{$_SERVER['PHP_SELF']}?_=b&".$this->addparam."&page={$this->num_pages}\"><img src=\"".PATH_IMG_SMALL."/last.gif\" border=\"0\" alt=\"Last\"></a>"; }
		} else {
//			$string .= "&nbsp;<img src=\"".PATH_IMG_SMALL."/next.gif\" alt=\"Next\">&nbsp;";
//			$string .= "<img src=\"".PATH_IMG_SMALL."/last.gif\" border=\"0\" alt=\"Last\">";
		}
		return "<font class=\"footer\">".$string."</font>";
	}

	// draws page/row count
	function _display_count() {
		$to_num = ($this->per_page * $this->page);
		if ($to_num > $this->num_rows) {
			$to_num = $this->num_rows;
		}
		//if ($this->nototals) return sprintf("<font class='footer'><b>Total: %s</b> ("._MB_PAG.". %s / %s)</font>\n", $this->num_rows, $this->page, $this->num_pages); else 
		return sprintf("<font class='footer'><b>"._MB_PAG." %s / %s</font>\n", $this->page, $this->num_pages);
	}

	function _import_records() {
		$name = $_FILES["import"]["name"];
		$type = $_FILES["import"]["type"];
		$tmp	= $_FILES["import"]["tmp_name"];
		$size	= $_FILES["import"]["size"];
		if (is_uploaded_file($tmp)) {

			$datafile = dirname($tmp)."/".$name;
			move_uploaded_file($tmp,$datafile);
			chmod($datafile,0777);
			$sql = "LOAD DATA INFILE '{$datafile}' REPLACE ";
			$sql .= "INTO TABLE `{$this->table}` ";
			$sql .= "({$this->edit_field_str}) ";
      //$sql .= "({$this->key},{$this->edit_field_str}) ";
			$result = $this->dbi->query($sql);
			unlink($datafile);
			if ($result) {
				$this->addmsg(_MB_SUCCESSIMPORT);
			} else {
				$this->addmsg(_MB_IMPORTFAILED);
			}
		} else {
			$this->addmsg(_MB_IMPORTABORTED);
		}

	}

	function _export_records() {

		$file = $this->table . "-" . date("dmy",time()) . ".xml";
                header("Content-Type: application/force-download");
                header("Content-Length: $size");
                // IE5.5 just downloads index.php if we don't do this
                if(preg_match("/MSIE 5.5/", $_SERVER['HTTP_USER_AGENT'])) {
                        header("Content-Disposition: filename=$file");
                } else {
                        header("Content-Disposition: attachment; filename=$file");
		}
		include('xls/ExcelWriterXML.php');
		$xml = new ExcelWriterXML;
		$xml->docAuthor('Intergrid');
		$format = $xml->addStyle('StyleHeader');
		$format->fontBold();
		$format2 = $xml->addStyle('StyleNormal');
//		$format->alignRotate(45);
		$sheet = $xml->addSheet('Dades');
		$sql = "SELECT `{$this->key}`, {$this->edit_field_str} ";
		$sql .= "FROM `{$this->table}` ";
		$result = $this->dbi->query($sql);
		$nrows	= $this->dbi->num_rows($result);
		$output = "";
		$colnames = split("`, `", $this->edit_field_str);
			$output .= $sheet->writeString(0,3,'id','StyleHeader');
                        foreach ($colnames as $k => $valor) {
                                $output .= $sheet->writeString(0,$k+3, $valor, 'StyleHeader');
                        }

		for ($i=0;$i<$nrows;$i++) {
			$row = $this->dbi->fetch_array($result);
			$n = count($row);
			foreach ($row as $j => $valor) {
				$output .= $sheet->writeString($i+1,$j, $valor, 'StyleNormal');
			}
		}
//		$output = $xml->sendHeaders();
                $output = $xml->writeData();
		$size = strlen($output);
		return true;
	}

}

?>
