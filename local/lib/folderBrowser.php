<?php
// *********************************************************************************************
//
//      Intergrid KMS folderBrowser Class
//
//      Intended use    : Browsing data in table format including search filters, views, etc.
//      Package version : 2.0
//      Last update     : 12/05/2014
//      Author          : Jordi Berenguer
//      Company         : Intergrid Tecnologies del coneixement SL
//      Country         : Catalonia
//      Email           : j.berenguer@intergrid.cat
//      Website         : www.intergrid.cat
//
// *********************************************************************************************

class folderBrowser extends mod {

	var $testBrowser = 1;
	var $mod;
        function folderBrowser($mod) {
             //parent::$_GET['mod']($client_account,$extranet);
	    //$this->mod = $mod;
	    $_GET['menu']=1;
        }

	function Main($mod) { // render data manager
		// transfer mod propierties
		$this->mod=$mod;
		$show_databrowser=true;
		foreach (get_object_vars($mod) as $name => $value) $this->$name = $value;
		// setup current view
                $this->_setup_view($_GET['view']);
		if ($mod->datasource=="") $mod->datasource="dbi";

		if ($this->mod_type!="external") { 
			if (!$this->table) { $this->_error("Cannot start","No table defined."); }
			if (!$this->key) { $this->_error("Cannot start","No primary key defined."); }
			$this->_var_setup();
			if ($mod->datasource=="dbi"&&$this->dbname!="") $this->dblinks['custom']=$this->dbi->connect($this->dbname,$this->dbuser,$this->dbpass,$this->dbhost);
			$this->_field_setup();
			if ($this->onBrowse!="") $this->_onBrowse($mod,$this->view);
			if ($mod->datasource=="dbi") {
				$this->_build_query();
				$this->_field_types_setup();
				$this->_sortby_results();	
				if (!$this->dblinks['client']) { $this->dblinks['client']=$this->dbi->db_connect('client',$this->dbi); }
				if ($this->dblinks['custom'])   $dblink=$this->dblinks['custom'];  else $dblink=$this->dblinks['client'];
				$this->_split_results($dblink); 
				$this->result = $this->dbi->query($this->sql,$dblink);
				$this->nrows  = $this->dbi->num_rows($this->result);
			} else if ($mod->datasource=="array") {
				$this->nrows = $mod->nrows;
				$this->num_rows = $mod->num_rows;
			}
		}
		if ($_GET['action']!="printDataBrowser"&&$_REQUEST['_action']!="export"&&$_SESSION['exec_mode']!="api") $printable=true; else $printable=false;
		if ($_GET['_action']=="download_all") $printable=false;
                $this->printable=$printable;
		if ($this->printable) {
		// show html head
		$this->_head($mod,($this->title?$this->title:$this->_format_name($this->table)),$this->default_content_type);
		print "</td></tr></table>";	
		}
		$app=$this->_get_app();
		$valid_mods=$this->_explode($app['modules'].",".$app['ext_modules']);
		$mods=$this->_get_mods($app);
		if ($_GET['mod']!=""&&$_GET['app']!=""&&(($this->_group_permissions($app['group'])&&(in_array($_GET['mod'],$valid_mods))||($this->client_account["username"]=="admin"))))  {
		// browse as table -----------------------------------------------------------------
	                // -- browse as icons -------------------------
                        if ($printable) print $this->_draw_buttons_bar($this,"desktop");
                        // estem al desktop, mostrem icones d'aplicacions
                        $this->_show_folders($link,$printable);//$this->result);

                                // s'hauria de mostrar menu i default app, o be, icones si defaultapp=""
                        if ($_GET['app']=="") {
//				if ($_SESSION['user_groups']=="") $this->_error("","No user groups defined.");
				//user_account = per usuaris extranet
				//client_account = per usuaris admin definits a fora de l'extranet
 				//session username = per superuser
				if ($this->user_account["username"]=="admin"||$this->client_account["username"]=="admin"||$_SESSION['username']=="root")  $cond="`group` like '%'";
				else $cond="`group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
                                $select = "SELECT * from kms_sys_apps WHERE (".$cond.") and status='active' order by sort_order";
                                $result=mysql_query($select,$this->dblinks['client']);
                                $num_apps = mysql_num_rows($result);
                                if ($num_apps==0) print "<p><h3>&nbsp;&nbsp;"._MB_NOOBJECTS."</h3></p>\n"; else {
                                print "<table class='folderBrowser_content' style='padding:15px' height='100%' width='100%' bgcolor='#ffffff'><tr><td id=\"desktop\" valign=\"top\" height=\"300\" style=\"vertical-align:top\">";
                                while ($row=mysql_fetch_array($result)) {
					$var=$this->_get_title($row['name']);
                                        if (file_exists('/usr/share/kms/css/aqua/img/apps/'.strtolower($row['name']).'.png')) $app_name=strtolower($row['name']); else $app_name="unknown";
                                        if (file_exists('/usr/share/kms/css/aqua/img/apps/'.strtolower($row['keyname']).'.png')) $app_name=strtolower($row['keyname']);
					if ($printable) { 
					 if ($_SERVER['REMOTE_ADDR']=='81.0.57.125')   {
						echo "<tr><td><div class='kms_icon'><img src='http://data.".$this->current_domain."/kms/css/aqua/img/apps/".$app_name.".png' width=\"20\" height=\"30\"></div></td><td>".$var."</td><td><a href='?app=".strtolower($row['keyname'])."&menu=1'>Download</a></td></tr>";

					} else {
						echo "<div class='kms_icon'><a href='?app=".strtolower($row['keyname'])."&menu=1'><img src='http://data.".$this->current_domain."/kms/css/aqua/img/apps/".$app_name.".png' width=\"59\" height=\"60\"></a><br><div class='icon_title''>".$var."</div></div>";

					}
					}
                                }
                                print "</tr></table>\n";
                                }
                        }


			echo "</div>" ; // application
			echo "</div>" ; // contents
			echo "</div>";  // kmsbody
//			$this->_foot($mod);
		}
	}



        function _show_folders($link,$printable) {
               if ($this->client_account["username"]=="admin")  $cond=" AND `group` like '%'";
               else $cond=" AND `group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
		if ($_GET['folder']=="") $_GET['folder']=0;
		$cond.=" AND parent=".$_GET['folder'];
               $select = "SELECT * from kms_lib_folders WHERE status!=0 $cond";
		 if ($printable) print "<div id='header'><table class='dataBrowser_content' style='padding:15px' height='100%' width='100%' bgcolor='#ffffff'><tr><td id=\"desktop\" valign=\"top\" height=\"300\" style=\"vertical-align:top\">";
		// show folders
	       if ($printable&&$_GET['folder']!=0&&$this->user_account['root_folder']=="") { //back folder 
				          echo $this->_draw_folder_icon("back","folder_back.png","?app=".$_GET['app']."&mod=".$_GET['mod']."&menu=".$_GET['menu']."&folder=".$_GET['fback']."&view=".$mod_data['default_view'],strtolower(_KMS_GL_BACK_BUT),"big/folder_back.png"); 
					}
		$result=mysql_query($select,$this->dblinks['client']);
		$num=mysql_num_rows($result);
               while ($folder=mysql_fetch_array($result)) {
                        echo $this->_draw_folder_icon(strtolower($folder['name']),strtolower($folder['name']).".png","?app=".$_GET['app']."&mod=".$_GET['mod']."&menu=".$_GET['menu']."&fback=".$_GET['folder']."&folder=".$folder['id']."&view=".$mod_data['default_view'],$folder['name'],"big/folder.png");
               }
		// show files
		if ($this->client_account["username"]=="admin")  $cond=" AND `group` like '%'";
                else $cond=" AND `group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
		if ($_GET['folder']=="") $_GET['folder']=0;
                $select = "SELECT * from kms_lib_files WHERE folder_id='".$_GET['folder']."' $cond";
		$result=mysql_query($select,$this->dblinks['client']);
                $num=mysql_num_rows($result);
		$i=0;
		$contents="";
                if ($_GET['_action']=="download_all") { $download_filename_zip="download_".$_GET['folder'].".zip ";
							$fpath="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/tmp/";
							$cmd="zip -r ".$fpath.$download_filename_zip." ";}

                while ($file=mysql_fetch_array($result)) {
			$ext=substr($file['file'],strrpos($file['file'],".")+1);
			$link="?_=e&menu=0&tpl=".$_GET['mod']."&app=".$_GET['app']."&mod=lib_files&fback=".$_GET['folder']."&folder=".$_GET['folder']."&view=".$mod_data['default_view']."&id=".$file['id'];
			$link="http://data.".$this->current_domain."/files/".$file['file'];
			if($i%2==0) $color_row="#fff"; else $color_row="#cbd6e1";
                        $contents.=$this->_draw_icon($_GET['mod'],strtolower($ext).".png",$link,$file['name'],"mimetypes",'',$file['id'],$color_row);
			$i++;
			 //prepare zip
                if ($_GET['_action']=="download_all") {
			chdir("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/");
                        $cmd.=$file['file']." ";

                }

  
             }

		//get zip
		if ($_GET['_action']=="download_all") {
			//echo $cmd."<br>";
			exec($cmd,$out);
                        //print_r($out)."<br>";//echo "//.getitdone.consulting/files/tmp/".$download_filename_zip;
	//echo $fpath.$download_filename_zip;
	error_reporting(E_ALL);     
			set_time_limit(0);
//			echo "size=".filesize(trim($fpath.$download_filename_zip));
			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$download_filename_zip);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize(trim($fpath.$download_filename_zip)));
			readfile(trim($fpath.$download_filename_zip));
			exit;
				
		}
		
		if ($i>0) echo "<table width=100% style='background-color:#abb8c6;padding:10px;color:#444'><tr><td style=''><table width=100% border=0><tr><td><h2>".$this->user_account['root_folder']." Folder</h2></td><td style='text-align:right'><a href='?app=files&mod=lib_folders&menu=1&fback=".$_GET['fback']."&folder=".$_GET['folder']."&_action=download_all'>Download all</a></td></tr></table></td></tr><tr><td>".$contents."</td></tr></table>";
//               print "</td></tr></table></div>\n";
		 $upload_dir="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/files"; 
		 $_SESSION['mod']=$_GET['mod'];
		 if ($_GET['folder']=="") $_GET['folder']=0;
		 $_SESSION['folder']=$_GET['folder'];
		?>
<form id="file_upload" action="." method="POST" enctype="multipart/form-data">
   <input type="hidden" name="mod" value="<?=$_GET['mod']?>">
   <input type="hidden" name="dr_folder" value="<?=$_GET['dr_folder']?>">
   <input type="hidden" name="view" value="<?=$_GET['view']?>">
   <input type="hidden" name="v2" value="<?=$_GET['v2']?>">
   <input type="hidden" name="album_id" value="<?=$_GET['album']?>" id="input_album">
    <input type="file" name="file" multiple style="display:none">
    <button style="display:none" type="submit">Upload</button>
    <div id="caixa" class="js" style="position:relative;width:100%;height:100% !important;"><?/*=_KMS_LIBRARY_MUPLOAD_PICTURES_DRAG*/?></div>
</div>
</form>
<script language="javascript">
$('#input_album').val($('#album').val());
</script>
<table id="files">
    <tr id="template_upload">
        <td class="file_upload_preview"></td>
        <td class="file_upload_name"></td>
        <td class="file_upload_progress"><div></div></td>
        <td class="file_upload_start" style="display:none" >
            <button class="ui-button ui-widget ui-state-default ui-corner-all" title="Start">
                <span class="ui-icon ui-icon-circle-arrow-e"><?=_KMS_GL_GO?></span>
            </button>
        </td>
    </tr>
  <tr id="template_download" style="display:none;">
        <td class="file_upload_preview"></td>
        <td class="file_upload_name"><a></a></td>
        <td class="file_upload_delete" colspan="3">
            <button class="ui-button ui-widget ui-state-default ui-corner-all" title="Delete">
                <span class="ui-icon ui-icon-trash"><?=_KMS_GL_DELETE?></span>
            </button>
        </td>
    </tr>
</table>
<div id="file_upload_progress" class="js file_upload_progress"><div style="display:none;"></div></div>
<div class="js">
    <button id="file_upload_start" class="ui-button ui-state-default ui-corner-all ui-button-text-icon-primary" style="display:none" >
        <span class="ui-button-icon-primary ui-icon ui-icon-circle-arrow-e"></span>
        <span class="ui-button-text"><?=_KMS_GL_SEND?></span>
    </button>
</div>
</div>
<?/*<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script src="/kms/lib/mupload/js/jquery.fileupload.js"></script>
<script src="/kms/lib/mupload/js/jquery.fileupload-ui.js"></script>
*/?>
<script src="/kms/lib/mupload/application.js"></script>
</div>
<?
               print "</td></tr></table></div>\n";

        }


	// ---------- class functions ------------


        function _setup_view($selectedView) {
                if ($selectedView=="") {
                        $result = mysql_query("SELECT * FROM kms_sys_folders WHERE id='".$_GET['dr_folder']."'",$this->dblinks['client']);
                         if (!$result) { echo "ERROR selecting folder ".mysql_error(); exit; }
                        $current_folder = mysql_fetch_array($result);
                        $selectedView = $current_folder['default_view'];
                        $_GET['view'] = $selectedView;
                } else {
                        $result = mysql_query("SELECT * FROM kms_sys_views WHERE id='".$selectedView."'",$this->dblinks['client']);
                        if (!$result) {     echo "ERROR selecting view ".mysql_error();    exit;}
                        $current_view = mysql_fetch_array($result);
                        //apply current view
                        if ($current_view['orderby']!='') $this->orderby = $current_view['orderby'];
			if ($current_view['groupby']!='') $this->groupby = $current_view['groupby'];
                        if ($current_view['sort']!='') $this->sort = $current_view['sort'];
                        if ($current_view['page_rows']!='') $this->sort = $current_view['page_rows'];
                        if ($current_view['fields']!='') $this->fields  = explode (",",$current_view['fields']);
                        if ($current_view['where']!='') {
                                     if ($this->where=="") $this->where = $current_view['where'];
                                     else { $this->where .=  " AND ".$current_view['where'];  }
                        }
                }
        }


	// draws the next/prev page links and shows page/row count
	function _draw_pages() {
		$s = "<table class=\"OPT\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"padding:5px\">\n";
		$s .= "<tr>\n<td nowrap>";
	
	  	 if ($this->printable) $s .= $this->_display_links();
		$s .= "</td>\n<td nowrap align=\"right\">";
		$s .= $this->_display_count();
		$s .= "</td>\n</tr></table>\n";
		print $s;
	}


	// rows to display per page
	function _display_per_page() {
		$separator = "<div style='float:left'><img src=\"http://data.".$this->current_domain."/kms/css/aqua/img/interface/separator.gif\"></div>";
		return $s;
	}


	// search menu
	function _display_search() {
		// search form
//                $s = "<form action=\"?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&view=".$_GET['view']."\" method=\"POST\" id=\"filter_options\" name=\"dm\" enctype=\"multipart/form-data\">\n";
		$s = "<form action=\"".$this->_link('_=b')."\" method=\"POST\" id=\"filter_options\" name=\"dm\" enctype=\"multipart/form-data\">\n";
		// invisible search button - enter hit
 		$s .= "<div style='width:0px;height:0px;top:0px;left:0px;pointer-events:none;pointer-events:auto;'><input class=\"searchButton\" style=\"height:0px;background-image:none;background:none;border:0px;padding:0px;width:0px;\" type=\"submit\" name=\"search\" value=\"\" alt=\""._MB_SEARCH."\"></div>\n";
		$this->_setup_searchEngine();
		// searchBox query 
		$s .= "<div id=\"searchBox\" style='float:right;padding-top:0px;display:".$this->display['searchBox']."'><input type=\"text\" id=\"query\" name=\"query\" value=\"" . stripslashes($this->query) . "\" id=\"searchBox\"></div>\n";
		// start search button (for dates and combos)
                $s .= "<div id=\"searchBut\" style=\"float:right;display:".$this->display['searchButton']."\"><input class=\"searchButton\" type=\"submit\" name=\"search\" value=\"\" alt=\""._MB_SEARCH."\"></div>\n";
		// ---- searchCombos ----
		$s .= "<div id=\"searchCombo\" style='float:right;padding-top:0px;display:none'>"; //display:".$this->display['searchCombo']."'>";
		foreach ($this->field_types as $field=>$type) {
			if ($type=="combo") { 
                	       $s .= $this->components[$field]->display_component($column['value']," onchange=\"setQuery(this.value)\"");
			} else if ($type=="xcombo") {
//			       $s .= $this->components[$field]->display_component($column['value']," onchange=\"setQuery(this.value)\"");
			} 
		}

		$s .= "</div>";
		// ---- dateSearch -----
		$s .= $this->_display_date_search();

		// ----- fieldSelector ------
		$s .= "<div id=\"fieldSelector\" style='float:right;padding-top:1px;'>";
		$s .= "<script language='javascript'>";
		$s .= "function sUpdate(field) {\n";
		$s .= " var types=new Array();\n";
		foreach ($this->fields_show as $field) {
			 $s .= "types['{$field}']='".$this->field_types[$field]."';\n";
		}
		$s .= "searchUpdate(field,types[field]);";
		$s .= "}";
		$s .= "</script>";
		$s .= "<select name=\"queryfield\" id=\"queryfield\" onchange=\"sUpdate($('#queryfield').val())\">\n";
		$sel = ($this->queryfield=="*" ? "selected" : "");
		$s .= "<option {$sel}>*</option>\n";
		$j=0;
		foreach ($this->fields_show as $field) {
			$sel = ($field==$this->queryfield ? "selected" : "");
//			$fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : $this->_format_name($field);
                        $fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : constant(strToUpper("_".$this->table."_".$field));
                        if ($fname == "") $fname = constant(strToUpper("_KMS_GL_".$field));
			$pvr = strpos("-".$field,"vr_");if ($pvr) $fname = constant(strToUpper("_KMS_GL_".strToUpper(substr($field,$pvr+2,strlen($field)))));
			// grey label if constant not exists
                        if ($fname == "") $fname="<font style='color:#aaaaaa'>".$this->_format_name($field)."</a></font>";
			$s .= "<option value=\"{$field}\" {$sel}>{$fname}</option>\n";
			$j++;
		}
		$s .= "</select></div>\n";
		if (!isset($_GET['dr_folder'])) {$dr_folder="0";} else { $dr_folder=$_GET['dr_folder'];}
                // ---------- top viewChanger -----------
                $s .= $this->_display_viewChanger();

		$s .= "</form>";
		return $s;
	}

	function _setup_searchEngine() {
                // display options
                $this->display=array();

		// date search display
                if ($this->day1!=""||$this->month1!=""||$this->year1!="") {
                                $this->display['dateSearch1']="block";
                                $this->display['searchButton']="block";
                                $this->display['searchBox']="none";
                } else {
                                $this->display['dateSearch1']="none";
                                $this->display['searchButton']="none";
                                $this->display['searchBox']="block";
                }
		if ($this->day2!=""||$this->month2!=""||$this->year2!="") $this->display['dateSearch2']="block"; else $this->display['dateSearch2']="none";
		// combo search display
		if (($this->field_types[$this->fieldsearch]=="combo")||($this->field_types[$this->fieldsearch]=="xcombo")) {
			$this->display['searchCombo']="block";
		}   else $this->display['searchCombo']="none";

	}

	function _display_date_search() {
		$months=array("_JAN","_FEB","_MAR","_APR","_MAY","_JUN","_JUL","_AUG","_SEP","_OCT","_NOV","_DEC");
		// date search 2
                $s .= "<div id=\"dateSearch2\" style=\"float:right;display:".$this->display['dateSearch2']."\">";
                $s .= "<select id=\"day2\" name=\"day2\"><option value=''></option>";for ($j=1;$j<32;$j++) { 
                        if ($j==$this->day2) $sel=" selected"; else $sel="";
                        $s .= "<option value='{$j}'{$sel}>".$j."</option>"; } 
                $s .= "</select>";
                if ($this->month2=="") $sel=" selected"; else $sel="";
                $s .= "<select id=\"month2\" name=\"month2\"><option value=''{$sel}></option>";for ($j=1;$j<13;$j++) { 
                        if ($j==$this->month2) $sel=" selected"; else $sel="";
                        $s .= "<option value='{$j}'{$sel}>".constant($months[$j-1])."</option>"; } 
                $s .= "</select>";
                $s .= "<input id=\"year2\" name=\"year2\" value=\"{$this->year2}\" size=4>";
                $s .= "</div>";
		// date search 1
                $s .= "<div id=\"dateSearch1\" style=\"float:right;display:".$this->display['dateSearch1'].";\">";
                $s .= "<select name=\"day1\"><option value=''></option>";for ($j=1;$j<32;$j++) { 
                        if ($j==$this->day1) $sel=" selected"; else $sel="";
                        $s .= "<option value='{$j}'{$sel}>".$j."</option>"; } 
                $s .= "</select>";
                $s .= "<select name=\"month1\"><option value=''></option>";for ($j=1;$j<13;$j++) {
                        if ($j==$this->month1) $sel=" selected"; else $sel="";
                        $s .= "<option value='{$j}'{$sel}>".constant($months[$j-1])."</option>"; } 
                $s .= "</select>";
                $s .= "<input id=\"year1\" name=\"year1\" value=\"".$this->year1."\" size=4>";
                $s .= "<a href=\"#\" style=\"text-decoration:none\" onclick=\"toggleSearch2('".$_GET['mod']."')\"> &#8230;&nbsp; </a>";
                $s .= "</div>";
		return $s;

	}

	function _add_button() {
	
		if (!isset($_GET['dr_folder'])) $dr_folder = "0"; else $dr_folder = $_GET['dr_folder'];
		$out = "<input class=\"newObjectButton\"";
		$out = "<div style='float:left'>".$out;
		// new button
//		$out .= " type=\"button\" value=\"\" alt=\"".(isset($this->insert_label) ? $this->insert_label : 'Insert') ."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=e&parent=".$parent."&view=".$_GET['view']."'\" title=\"".$this->insert_label."\"></div>";
		$out .= " type=\"button\" value=\"\" alt=\"".(isset($this->insert_label) ? $this->insert_label : 'Insert') ."\" onClick=\"javascript:window.location='".$this->_link('_=i')."&folder=".$_GET['folder']."&parent=".$_GET['folder']."'\" title=\"".$this->insert_label."\"></div>";

		return $out;

               (isset($this->insert_label) ? $this->insert_label : 'Insert') .	"</a>";

	}

        function _mupload_button() {
                if (!isset($_GET['dr_folder'])) $dr_folder = "0"; else $dr_folder = $_GET['dr_folder'];
                if (!isset($_GET['dr_folder'])) $out = "<input class=\"mUploadButton\""; else $out = "<input class=\"mUploadButton\"";
                $out = "<div style='float:left'>".$out;
                // new button
                $out .= " type=\"button\" value=\"\" alt=\"".(isset($this->mupload_label) ? $this->mupload_label : 'Multiple upload') ."\" onClick=\"javascript:window.location='?_=f&app=".$_GET['app']."&mod=".$_GET['mod']."&action=mupload&view=".$_GET['view']."'\" title=\"".$this->mupload_label."\"></div>";

                return $out;

               (isset($this->insert_label) ? $this->mupload_label : 'Multiple upload') .  "</a>";


        }

	function _print_button() {
		return $this->_render_button(_CMN_PRINT,"javascript:printDataBrowser(\'".$_SERVER['QUERY_STRING']."\');",'_self');
	}

	function _import_button() {
		return "<div style='float:left'><input class=\"importButton\" type=\"button\" title=\""._MB_IMPORT."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&_action=import_dialog'\"></div>";
	}

	function _export_button() {
		return "<div style='float:left'><input class=\"exportButton\" type=\"button\" title=\""._MB_EXPORT."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&_action=export&view=".$_GET['view']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."'\"></div>";
	}

        function _config_button() {
                        $select = "SELECT SQL_NO_CACHE parent from kms_sys_folders where id=".$_GET['dr_folder'];
                        $result=mysql_query($select,$this->dblinks['client']);
                        $thisobject = mysql_fetch_array($result);
                return "<div style='float:left;'><input class=\"configButton\" type=\"button\" title=\""._MB_CONFIG."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?&app=".$_GET['app']."&mod=sys_folders&id=".$_GET['dr_folder']."&_=e'\"></div>";
        }


	function _getLink($content_type,$shortcut_to,$optionview,$external_url,$key,$view) {

		 if ($view=="") $view=$_GET['view'];
 	         if ($content_type!=$this->default_content_type) {
                          if ($external_url!="") { 
                                      $link=$external_url;
                          } else { 
                                      if ($shortcut_to=="-1") $link="?app=".$_GET['app']."&mod=".$content_type."&view=".$view;
        	 	              else $link="?app=".$_GET['app']."&mod=".$content_type."&view=".$view; 
		          }
                 } else { 
	                 if ($content_type!="sys_folders") {
        	                    //is an object, open file
                                    if ($external_url=="")  $link= "?app=".$_GET['app']."&mod=".$_GET['mod']."&_=d&id={$key}&view=".$view; else $link=$external_url;
                         } else {
                                    if ($external_url!="")  $link= $external_url; 
                                    else if ($shortcut_to=="-1") $link="?app=".$_GET['app']."&mod=".$content_type."&view=".$view;
                                    else  $link="?view=".$view;                        
                         }
                }

		return $link;
	}



	// determines sorting and appends to sql query
	function _sortby_results() {
		if ($this->groupby) {
			$this->sql .= " GROUP BY {$this->table}.{$this->groupby}";
		}

		// els camps virtuals no es poden ordenar perque no existeixen, s'hauria de crear una taula temporal CREATE TEMPORARY TABLE table select.... i despres ordenar-la.
		if ($this->sortby && $this->sortdir && substr($this->sortby,0,3)!="vr_" &&  substr($this->sortby,0,3)!="SUM" &&  substr($this->sortby,0,4)!="YEAR" && !strpos($this->sortby,"*")) {
			if ($this->sortdir=="'") $this->sortdir=""; //parche
			$this->sql .= " ORDER BY `{$this->table}`.`{$this->sortby}` {$this->sortdir}";
		} else if (substr($this->sortby,0,3)!="SUM" &&  substr($this->sortby,0,4)!="YEAR" && substr($this->sortby,0,3)!="vr_") { 
			$this->sql .= " ORDER BY {$this->sortby} {$this->sortdir}";
		}
		if ($_REQUEST['sortby']) $this->page = "1"; // rewind if sorting by a new field
	}

	// determines the limit to append to sql query
	function _split_results($dblink) {
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
		$result = $this->dbi->query($sql,$dblink);
		$count = $this->dbi->fetch_object($result);
		$this->num_rows = $count->total;
		$offset = ($this->per_page * ($this->page - 1));
		if ($offset < $this->num_rows) {
			$limit = " LIMIT {$offset}, {$this->per_page}";
		} else {
			$limit = " LIMIT {$this->per_page}";
		}
		$this->sql .= $limit;
//DEBUG
//echo $this->sql;
	}

	// determines 'WHERE' to append to sql query
	function _build_query() {
		if ($_SESSION['exec_mode']=="api") $this->where = $_GET['where'];
		//eliminem opcions de buscador en els databrowsers dels xmods
		if ($_GET['xid']!=""&&is_array($this->panel)&&$_GET['panelmod']!="") { $this->query="";$this->queryfield="*"; $this->can_search=false; }
		if ($_GET['queryop']!="") $queryop=strtoupper($_GET['queryop']); else $queryop="LIKE";
		if ($queryop=="EQUAL") $queryop="=";
		$this->sql = "SELECT `{$this->table}`.`{$this->key}`,{$this->field_str} FROM `{$this->table}`";
		if ($this->queryfield) {  // && $this->query) {
		// textBox search
			if ($this->queryfield=="*") {
				// reset session search variables
				$this->_reset_param('day1');$this->_reset_param('month1');$this->_reset_param('year1');
				$this->_reset_param('day2');$this->_reset_param('month2');$this->_reset_param('year2');
				$i=0;
				// mount all the SELECT JOIN statements
				$table_joins = array();
				$table_joins_on = array();
				$where_toAdd="";
				foreach ($this->fields_search as $field) {
                                        $i++;
					$search_value = $this->query;
					if ($queryop=="LIKE") {
						if ($_GET['op']=="equal") $search_value=$search_value;
                                                else $search_value="%".$search_value."%";
					}
					if (is_array($this->multixrefs[$field])||(is_array($this->xvarr[$field]['sql']))) { 
					//  multixrefs and xvarrs (virtual cross reference fields) will require JOINS
					 $this->sql =  str_replace(" WHERE ","",$this->sql);
						 // add LEFT JOIN conditions
						 if (!in_array($this->multixrefs[$field]["xtable"],$table_joins)&&!in_array($this->xvarr[$field]['sql']["xtable"],$table_joins)) {
                                                         if (is_array($this->multixrefs[$field])) {
                                                                $this->sql .= " LEFT JOIN `{$this->multixrefs[$field]["xtable"]}` ON ";
								 array_push($table_joins,$this->multixrefs[$field]["xtable"]);
                                                         } else if (is_array($this->xvarr[$field]['sql'])) {
                                                                $this->sql .= " LEFT JOIN `{$this->xvarr[$field]['sql']["xtable"]}` ON ";
                                                         	array_push($table_joins,$this->xvarr[$field]['sql']["xtable"]);
							}
                                                         $multipleJOINS=true;
                                                }
                                                
						// add ON conditions
	                                        if (is_array($this->multixrefs[$field])) {
	                                                        if (!in_array($this->multixrefs[$field]["xtable"],$table_joins_on)) {
									$this->sql .= "`{$this->multixrefs[$field]["xtable"]}`.{$this->multixrefs[$field]["xkey"]}=`{$this->table}`.`{$field}` ";
									array_push($table_joins_on,$this->multixrefs[$field]["xtable"]);
								}
								if (substr($this->multixrefs[$field]["xfield"],0,6)!="CONCAT") {
								$where_toAdd .= " OR `{$this->multixrefs[$field]["xtable"]}`.{$this->multixrefs[$field]["xfield"]} {$queryop} \"{$search_value}\" ";	
								}
						} else if (is_array($this->xvarr[$field]['sql'])) {
	                                                        if (!in_array($this->xvarr[$field]['sql']["xtable"],$table_joins_on)) { 
									$this->sql .= "`{$this->xvarr[$field]['sql']["xtable"]}`.{$this->xvarr[$field]['sql']["xkey"]}=`{$this->table}`.`{$this->xvarr[$field]['sql']["field"]}` ";
									array_push($table_joins_on,$this->xvarr[$field]['sql']["xtable"]);
								};
								$where_toAdd .= " OR `{$this->xvarr[$field]['sql']["xtable"]}`.`{$this->xvarr[$field]['sql']["xfield"]}` {$queryop} \"{$search_value}\" ";
                                                                $where_toAdd .= " OR `{$this->xvarr[$field]['sql']["xtable"]}`.`{$this->xvarr[$field]['sql']["xselectionfield"]}` {$queryop} \"{$search_value}\" ";
                                               }
                                        }
				} // for each
//				echo $this->sql;exit;
				// mount WHERE conditions
				$i=0;
				$this->sql .= " WHERE (";
				$multipleJOINS=false;

				//search labels preparation 
				if ($_GET['op']=="equal") $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"{$search_value}\""; 
				else $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"%{$search_value}%\"";
			
                                $res=mysql_query($sel,$this->dblinks['client']);
				$labels_arr=array();$ii=0;
                                while ($labels_matched=mysql_fetch_array($res)) { $labels_arr[$ii]=$labels_matched[0]; $ii++; }

				//search
				foreach ($this->fields_search as $field) {
					if (substr($field,0,3)=="vr_") break;
					$i++;
					if (substr($field,0,3)!="SUM" && substr($field,0,4)!="YEAR") {
					$search_value = $this->query;
					if ($queryop=="LIKE") {
						if ($_GET['op']=="equal") $search_value=$search_value;
						else $search_value="%".$search_value."%";
					}
					if (!is_array($this->multixrefs[$field])&&(!is_array($this->xvarr[$field]))) { 
					// multixrefs and xvarrs are already processed on join clauses
					if (substr($this->sql,strlen($this->sql)-1,1)=="(") {
						if ($i>1) $add.=$add; else $add="";
					} else {
						if ($i>1) $add=" OR ".$add; else $add="";
					}
					if (isset($_GET['query'])) $this->sql .= $add."`{$this->table}`.`{$field}` = '{$this->query}' "; 
							  	   else $this->sql .= $add."`{$this->table}`.`{$field}` {$queryop} \"".mysql_escape_string($search_value)."\" ";
					$add=""; 
					      //search labels etiqueta
                                              if (count($labels_arr)>0) { 
							foreach ($labels_arr as $label) {	
								if ($_GET['op']=="equal") $this->sql .= " OR `{$this->table}`.`{$field}` like \"".$label."\" "; else $this->sql .= " OR `{$this->table}`.`{$field}` like \"%".$label."%\" ";
							}
						}
					}

				       }

					unset($search_value);
				//	if ($i<$this->field_cnt) $this->sql .= "OR ";
				}
				$this->sql.=$where_toAdd;
				
				if (!$multipleJOINS) $this->sql .= ")";
				$this->sql=str_replace("SELECT", "SELECT DISTINCT",$this->sql);
//				echo $this->sql; 
			} else {
				// search by field

		                // date search
				$current_field_type=$this->_field_type($this->queryfield,$this->result);
				if ($current_field_type=="date"||$current_field_type=="datetime") {
					// when clicking views, we don't send POST variables..
					$_POST['day1']=$this->_get_param("day1");$_POST['month1']=$this->_get_param("month1");$_POST['year1']=$this->_get_param("year1");
					$_POST['day2']=$this->_get_param("day2");$_POST['month2']=$this->_get_param("month2");$_POST['year2']=$this->_get_param("year2");
				}
		                if ($_POST['day1']!=""||$_POST['month1']!=""||$_POST['year1']!="") {

                	        	if ($_POST['day2']==""&&$_POST['month2']==""&&$_POST['year2']=="") {
	                        	// single date
					$this->_reset_param('day2');$this->_reset_param('month2');$this->_reset_param('year2');
	                        	if ($_POST['day1']=="") $d="%"; else { $d=$_POST['day1']; if (strlen($d)==1) $d="0".$d; }
	                        	if ($_POST['month1']=="") $m="%"; else { $m=$_POST['month1']; if (strlen($m)==1) $m="0".$m; }
	                        	if ($_POST['year1']=="") $y="%"; else $y=$_POST['year1'];
	                        	$where_toAdd = $this->queryfield." {$queryop} \"$y-$m-$d%\"";
	                        	} else {
	                        	// between date
	                        	if ($_POST['day1']=="") $d="01"; else { $d=$_POST['day1']; if (strlen($d)==1) $d="0".$d; }
	                        	if ($_POST['month1']=="") $m="01"; else { $m=$_POST['month1']; if (strlen($m)==1) $m="0".$m; }
	                        	if ($_POST['year1']=="") $y="0"; else $y=$_POST['year1'];
	                        	if ($_POST['day2']=="") $d2="31"; else { $d2=$_POST['day2']; if (strlen($d2)==1) $d2="0".$d2; }
	                        	if ($_POST['month2']=="") $m2="12"; else { $m2=$_POST['month2']; if (strlen($m2)==1) $m2="0".$m2; }
	                        	if ($_POST['year2']=="") $y2=date('Y'); else $y2=$_POST['year2'];
	                        	$where_toAdd = $this->queryfield." BETWEEN \"$y-$m-$d\" AND \"$y2-$m2-$d2\"";
	                        	}
					$this->sql .= " WHERE ".$where_toAdd;
                		} else {

	                                $search_value = $this->_search_filter($this->queryfield,$this->query);
					$search_value_ = $search_value;
					if ($queryop=="LIKE") {
						if ($_GET['op']=="equal") $search_value=$search_value;
                                                else $search_value="%".$search_value."%";
					}
	                                if (is_array($this->multixrefs[$this->queryfield])) {
	                                // multixrefs search
//	                                 $this->sql .= " WHERE {$this->queryfield}=(SELECT {$this->multixrefs[$this->queryfield]["xkey"]} FROM {$this->multixrefs[$this->queryfield]["xtable"]} where {$this->multixrefs[$this->queryfield]["xfield"]} {$queryop} \"{$search_value}\") ";

					$this->sql .= " WHERE Exists (select {$this->multixrefs[$this->queryfield]["xkey"]} from `{$this->multixrefs[$this->queryfield]["xtable"]}` where `{$this->multixrefs[$this->queryfield]["xtable"]}`.{$this->multixrefs[$this->queryfield]["xkey"]}=`{$this->table}`.{$this->queryfield} AND {$this->multixrefs[$this->queryfield]["xfield"]} {$queryop} \"{$search_value}\" limit 1)";

	                                } else if (is_array($this->xvarr[$this->queryfield]['sql'])) {
	                                // virtual fields search
	                                $this->sql .= " INNER JOIN (SELECT distinct {$this->xvarr[$this->queryfield]['sql']["xkey"]} FROM `{$this->xvarr[$this->queryfield]['sql']["xtable"]}` where {$this->xvarr[$this->queryfield]['sql']["xselectionfield"]} {$queryop} \"{$search_value}\") t ON `{$this->table}`.{$this->xvarr[$this->queryfield]['sql']["field"]}=t.{$this->xvarr[$this->queryfield]['sql']["xkey"]}";
	                                } else {
	                                // regular fields search
					if ($this->queryfield=="id") $this->sql .= " WHERE (`{$this->queryfield}`='{$search_value_}')"; else $this->sql .= " WHERE (`{$this->queryfield}` {$queryop} \"{$search_value}\")";
        	                        }
	                                unset($search_value);

				}

			}
	//		if ($this->where) {
		//		$this->sql .= " AND ({$this->where})";
	//			return true;
	//		}
		} // end textBox search

		// append where clause (from views..)
		if ($this->where) {
			if (strpos($this->sql,"WHERE")) $this->sql .= " AND ({$this->where})"; else $this->sql .= " WHERE ({$this->where})";

                        if ($this->table =="kms_sys_folders") { // passar a sys_apps i aplicar permisos per aplicacio
							if ($this->_group_permissions("admin")||$_SESSION['user_name']=="root") {	
							// mostra tot
							$this->sql .= "";	
							} else {
	                                                // mostra nomes les carpetes amb permisos / grup de lectura 
	                                                $sqlgroupstr = str_replace(",", "' OR kms_sys_folders.group = '", $_SESSION['user_groups']);
	                                                $this->sql .= " AND ((kms_sys_folders.group = '".$sqlgroupstr."')";
	                                                // o usuaris permesos
	                                                $this->sql .= " OR (kms_sys_folders.owner {$queryop} \"%".$_SESSION['user_name']."%\"))";
							// $this->sql .= " or kms_sys_folders.group like '%'";
							}
                                                }
		}
//if ($_SERVER['REMOTE_ADDR']=='88.12.33.163') echo $this->sql;  // SQL de la cerca DEBUG
//
	}

	// draws next/prev and page links
	function _display_links() {
		$string = "";
		$this->num_pages = intval($this->num_rows / $this->per_page);

		if ($this->num_rows % $this->per_page) $this->num_pages++;
		if ($this->page > 1) {
			$string .= "<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page=1&view=".$_GET['view']."\"><img src=\"".PATH_IMG_SMALL."/first.gif\" border=\"0\" alt=\"First\"></a>";
			$string .= "<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page=" . ($this->page - 1) . "&view=".$_GET['view']."\"><img src=\"".PATH_IMG_SMALL."/prev.gif\" border=\"0\" alt=\"Prev\"></a>&nbsp;";
		} else {
			$string .= "<img src=\"".PATH_IMG_SMALL."/first.gif\" border=\"0\" alt=\"First\">";
			$string .= "<img src=\"".PATH_IMG_SMALL."/prev.gif\" alt=\"Prev\">&nbsp;";
		}
		$cur_window_num = intval($this->page / $this->page_links);
		if ($this->page % $this->page_links) $cur_window_num++;
		$max_window_num = intval($this->num_pages / $this->page_links);
		if ($this->num_pages % $this->page_links) $max_window_num++;
		if ($cur_window_num > 1) {
			$string .= "<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page=" . (($cur_window_num - 1) * $this->page_links) ."&view=".$_GET['view']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."\">...</a>";
		}
		for ($jump_to_page = 1 + (($cur_window_num - 1) * $this->page_links); ($jump_to_page <= ($cur_window_num * $this->page_links)) && ($jump_to_page <= $this->num_pages); $jump_to_page++) {
			if ($jump_to_page == $this->page) {
				$string .= "&nbsp;<span class=\"PAGE\" style=\"font-weight:bold\">" . $jump_to_page . "</span>&nbsp;";
			} else {
				$string .= "&nbsp;<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page={$jump_to_page}&view=".$_GET['view']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."\"><u>" . $jump_to_page . "</u></a>&nbsp;";
			}
		}
		if ($cur_window_num < $max_window_num) {
			$string .= "<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page=" . (($cur_window_num) * $this->page_links + 1) . "&view=".$_GET['view']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."\">...</a>&nbsp;";
		}
		if (($this->page < $this->num_pages) && ($this->num_pages != 1)) {
			$string .= "&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page=" . ($this->page + 1) . "&view=".$_GET['view']."\"><img src=\"".PATH_IMG_SMALL."/next.gif\" border=\"0\" alt=\"Next\"></a>&nbsp;";
			$string .= "<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&page={$this->num_pages}&view=".$_GET['view']."\"><img src=\"".PATH_IMG_SMALL."/last.gif\" border=\"0\" alt=\"Last\"></a>";
		} else {
			$string .= "&nbsp;<img src=\"".PATH_IMG_SMALL."/next.gif\" alt=\"Next\">&nbsp;";
			$string .= "<img src=\"".PATH_IMG_SMALL."/last.gif\" border=\"0\" alt=\"Last\">";
		}
		if ($this->num_pages>1) $string .= "&nbsp;"._KMS_GL_SHOW." <input id='page_rows' value='".$this->per_page."' style='width:50px;' maxlength='5'> "._KMS_GL_RESULTS."<input type='button' value='>' onclick=\"document.location='".$_SERVER['REQUEST_URI']."&page_rows='+$('#page_rows').val()\">";
		return $string;
	}

	// draws page/row count
	function _display_count() {
		$to_num = ($this->per_page * $this->page);
		if ($to_num > $this->num_rows) {
			$to_num = $this->num_rows;
		}
		return sprintf("<b>Total: %s</b> ("._MB_PAG.". %s / %s)\n", $this->num_rows, $this->page, $this->num_pages);
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
//			mysql_query("SET CHARACTER SET utf8");
//                        mysql_query("SET NAMES utf8");
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


        function _export_records($format) {
		//header("Content-Type: application/force-download");
		if ($format=="xls") {
			$file = $this->table . "-" . date("dmy",time()) . ".xls";
                	include('xls/ExcelWriterXML.php');
                	$xml = new ExcelWriterXML;
                	$xml->docAuthor('Intergrid');
                	$format = $xml->addStyle('StyleHeader');
                	$format->fontBold();
                	$format2 = $xml->addStyle('StyleNormal');
	//              $format->alignRotate(45);
           		$sheet = $xml->addSheet('Dades');
				
                	$sql = "SELECT SQL_NO_CACHE `{$this->key}`, {$this->export_field_str} ";
			$sql = "SELECT SQL_NO_CACHE  {$this->export_field_str} ";
			
		 	if ($this->where!="") { 
				$sql .= "FROM `{$this->table}` WHERE ".$this->where;
				if ($_GET['sortby']!=""&&(substr($_SESSION['sortby'],0,3)!="vr_")) $sql.=" order by ".$_SESSION['sortby'];
				if ($_GET['sortdir']!="") $sql.=" ".$_SESSION['sortdir'];
			} else {
			 	$sql .= "FROM `{$this->table}` order by id";
			}
//		mysql_query("SET CHARACTER SET utf8");
  //              mysql_query("SET NAMES utf8");
	                $result = $this->dbi->query($sql);
        	        $nrows  = $this->dbi->num_rows($result);
                	$output = "";
		//	echo $this->edit_field_str;exit;
			//header
        	        $colnames = split("`, `", $this->export_field_str);
                        $output .= $sheet->writeString(0,3,'id','StyleHeader');
                        foreach ($colnames as $k => $valor) {
                                $output .= $sheet->writeString(0,$k, str_replace('`','',$valor), 'StyleHeader');
                        }
			//values
                	for ($i=1;$i<=$nrows;$i++) {
                        $row = $this->dbi->fetch_array($result);
                        $n = count($row);
				foreach ($colnames as $k => $valor) {
				$valor=str_replace('`','',$valor);
                                $output .= $sheet->writeString($i,$k,$row[$valor], 'StyleNormal');
                        	}
                	}
			header("Content-Type: application/force-download");
                        if(preg_match("/MSIE 5.5/", $_SERVER['HTTP_USER_AGENT'])) {
                                header("Content-Disposition: filename=$file");
                        } else {
                                header("Content-Disposition: attachment; filename=$file");
                        }

                	$output = $xml->writeData();
	                $size = strlen($output);
        	        return true;

		} else if ($format=="csv") {

                $file = $this->table . "-" . date("dmy",time()) . ".csv";
                $sql = "SELECT SQL_NO_CACHE `{$this->key}`, {$this->edit_field_str} ";
		$sql = "SELECT SQL_NO_CACHE {$this->edit_field_str} ";
		if ($_GET['sortby']==""||(substr($_GET['sortby'],0,3)=="vr_")) $_GET['sortby']="id";
		if ($_GET['sortdir']=="") $_GET['sortdir']="asc";
                if ($this->where!="")  $sql .= "FROM `{$this->table}` WHERE ".$this->where." order by ".$_GET['sortby']." ".$_GET['sortdir'];
                        else    $sql .= "FROM `{$this->table}` order by ".$_GET['sortby']." ".$_GET['sortdir'];
                $result = $this->dbi->query($sql);
                $nrows  = $this->dbi->num_rows($result);
		$delimiter = "\"";
		$separator = ",";
		$line_separator = "\n";
                $output = $delimiter;
		
                for ($i=0;$i<$nrows;$i++) {
                        $row = $this->dbi->fetch_array($result);
			if ($i==0) { //titles
				$titles=$row;
				foreach ($titles as $j => $valor) {
                                 $titles[$j]=utf8_decode($j);
                                 $titles[$j]=html_entity_decode($titles[$j]);
                                 $titles[$j]=str_replace('"','\"',$titles[$j]);
                                }
				$output .= join($delimiter.$separator.$delimiter,$titles) . $delimiter . $line_separator . $delimiter;

			}
			// format content
			foreach ($row as $j => $valor) {
                                 $row[$j]=utf8_decode($row[$j]);
                                 $row[$j]=html_entity_decode($row[$j]);
				 $row[$j]=str_replace("&euro;","EUR",$row[$j]);
				 $row[$j]=str_replace('"','\"',$row[$j]);
			}
                        $output .= join($delimiter.$separator.$delimiter,$row) . $delimiter . $line_separator . $delimiter;
                }
		$output = trim($output);
		
                $size = strlen($output);
                header("Content-Type: application/force-download; charset=utf-8");
                header("Content-Length: $size");
                // IE5.5 just downloads index.php if we don't do this
                if(preg_match("/MSIE 5.5/", $_SERVER['HTTP_USER_AGENT'])) {
                        header("Content-Disposition: filename=$file");
                } else {
                        header("Content-Disposition: attachment; filename=$file");
                }
                //header("Content-Transfer-Encoding: binary"); 
                print utf8_encode($output);
                return true;

		} else if ($format=="object") {
		$file = $this->table . "-" . date("dmy",time()) . ".csv";
                $sql = "SELECT SQL_NO_CACHE `{$this->key}`, {$this->edit_field_str} ";
                $sql = "SELECT SQL_NO_CACHE id,{$this->edit_field_str} ";
//                if ($_GET['sortby']=="") $_GET['sortby']="id";
		if ($_GET['sortby']==""||(substr($_GET['sortby'],0,3)=="vr_")) $_GET['sortby']="id";
                if ($_GET['sortdir']=="") $_GET['sortdir']="asc";
                if ($this->where!="")  $sql .= "FROM `{$this->table}` WHERE ".$this->where." order by ".$_GET['sortby']." ".$_GET['sortdir']; else $sql .= "FROM `{$this->table}` order by ".$_GET['sortby']." ".$_GET['sortdir'];
                $result = $this->dbi->query($sql);
                $nrows  = $this->dbi->num_rows($result);
		$result_arr = array();
                for ($i=0;$i<$nrows;$i++) {
                        $result_arr[$i] = $this->dbi->fetch_array($result);
                }
//                return (array)$result_arr;
		return json_encode($result_arr);

		}

        }
}
?>
