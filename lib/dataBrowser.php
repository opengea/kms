<?php
// *********************************************************************************************
//
//      Intergrid KMS dataBrowser Class
//
//      Intended use    : Browsing data in table format including search filters, views, etc.
//      Package version : 2.0
//      Last update     : 25/02/2020
//      Author          : Jordi Berenguer
//      Company         : Intergrid Tecnologies del coneixement SL
//      Country         : Catalonia
//      Email           : j.berenguer@intergrid.cat
//      Website         : www.intergrid.cat
//
// *********************************************************************************************

class dataBrowser extends mod {

	var $testBrowser = 1;
	var $mod;
        function dataBrowser($mod) {
             //parent::$_GET['mod']($client_account,$extranet);
	    //$this->mod = $mod;
	    $_GET['menu']=1;
        }

	function Main($mod) { // render data manager
		// transfer mod propierties
		$this->mod=$mod;

		$show_databrowser=true;
		foreach (get_object_vars($mod) as $name => $value) $this->$name = $value;
		if ((isset($_POST['query'])&&$_POST['query']=="")||($_GET['v2']=="*")) { //init search 
                        $this->_reset_param("query"); $this->_reset_param("queryfield"); $this->search_value="";
                        $_GET['query']="";$_GET['queryfield']="";$_REQUEST['query']="";$_REQUEST['queryfield']=""; 
		}
		// setup current view
                $this->_setup_view($_GET['view'],$_GET['v2']);
		if ($mod->datasource=="") $mod->datasource="dbi";
		if ($this->mod_type!="external") { 
			if (!$this->table) { $this->_error("Cannot start","No table defined."); }
			if (!$this->key) { $this->_error("Cannot start","No primary key defined."); }
			$this->_var_setup();
			if ($mod->datasource=="dbi"&&$this->dbname!="") $this->dblinks['custom']=$this->dbi->connect($this->dbname,$this->dbuser,$this->dbpass,$this->dbhost);
			$this->_field_setup();
			if ($this->onBrowse!="") $this->_onBrowse($mod,$this->view);
			if ($mod->datasource=="dbi") {
				$view=array();
				if (!$this->dblinks['client']) { $this->dblinks['client']=$this->dbi->db_connect('client',$this->dbi); }
                                if ($this->dblinks['custom'])   $dblink=$this->dblinks['custom'];  else $dblink=$this->dblinks['client'];

				if ($_GET['view']!="") {
                                $sel="select * from kms_sys_views where id=".$_GET['view'];
                                $res=mysqli_query($dblink,$sel);
                                $view=mysqli_fetch_array($res);
                        	}
				if ($view['sort_column']=="") $view['sort_column']="sort_order";
				if ($this->rowclick=='drag'&&$_REQUEST['query']!=""&&($_GET['sortby']==''||$_GET['sortby']==$view['sort_column'])) { $_GET['sortby']=$this->orderby; }//en mode drag, la cerca no pot ordenar

                                if ($this->dbhost!="") {
                                        $this->dblink=$dblink=mysqli_connect( $this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
                                }

				$this->_build_query(); // determines $this->sql
//				if ($_SERVER['REMOTE_ADDR']=='46.6.167.210') { echo $this->sql; exit; }
				$this->_field_types_setup(); //needed for displaying
				$this->_sortby_results(); // adds sortby	
				$this->_split_results($dblink);  // adds limit/offset for pagination
//echo $this->sql;
				$this->result = $this->dbi->query($this->sql,$dblink);
				$this->nrows  = $this->dbi->num_rows($this->result);

			} else if ($mod->datasource=="array") {
				$this->nrows = $mod->nrows;
				$this->num_rows = $mod->num_rows;
			}
		}
		if ($_GET['action']!="printDataBrowser"&&$_REQUEST['_action']!="export"&&$_SESSION['exec_mode']!="api") $printable=true; else $printable=false;
                $this->printable=$printable;
		if ($this->printable) {
		// show html head
		$this->_head($mod,($this->title?$this->title:$this->_format_name($this->table)),$this->default_content_type);
		print "</td></tr></table>";	
		}
		$app=$this->_get_app();
                if ($app['id']==""&&$_GET['app']!="") { echo "Invalid application ".$_GET['app'];return; }
		$valid_mods=$this->_explode($app['modules'].",".$app['ext_modules']);
		$mods=$this->_get_mods($app);
                if ($_GET['mod']!=""&&$_GET['app']!=""&&(($this->_group_permissions($app['group'])&&(in_array($_GET['mod'],$valid_mods))||($this->client_account["username"]=="admin"||$_SESSION['username']=="root"))))  {

		// browse as table -----------------------------------------------------------------
		if ($printable) {
			print "<div id=\"kmsbody\">";
//			$app=$this->_get_app();
//                	$mods=$this->_get_mods($app);
               	 	if ($app['show_sidemenu']) $this->_render_leftmenu($app,$mods);
                	print "<div id=\"contents\" class=\"contents\">";
                	if ($app['show_sidemenu']) $this->_render_menuswitcher();
                	print "<div id=\"application\" class=\"application\">";
		}
	                if ($_REQUEST['_action']=="export" && $this->can_export) { // export tab-delimited
        	                $this->_export_records("xls");
	                        exit();
	                } elseif ($_REQUEST['_action']=="import" && $this->can_export) { // import tab-delimited
	                        $this->_import_records();
	                       // $this->_redirect("{$_SERVER['PHP_SELF']}?_=b");
			} elseif ($this->search_value&&$_GET['xid']=="") {
				$this->addmsg(_GLOBAL_SEARCHING." \"" . stripslashes($this->search_value) . "\".");
	                } elseif (isset($_REQUEST['mod'])) {
	                         if (substr($_REQUEST['mod'],0,8)=="mailings") {
	                                if (isset($_REQUEST['error'])) $this->addmsg(_ERROR_ALREADYSENT); else if ($_GET['result']==1) $this->addmsg(_EXEC_MAILINGS);
                        	 }
	                }
//			if ($_SESSION[$this->table]["msgs"]&&$_GET['panelmod']=="") $this->render_messages($_SESSION[$this->table]["msgs"]);

			if ($this->mod_type=="external") {
				if ($_GET['action']!="") include $this->actions[$_GET['action']]["url"]; else include $this->load;
			} else {

				//show databrowser
				if ($this->nrows < 1) {
					// no resultats
					if (is_array($this->panel)) $show_databrowser=$this->_draw_panel($this->panel);
					if ($show_databrowser) {
					if (!$this->panel['hide_table_title']) print $this->_draw_table_title($this->_get_title($_GET['panelmod']));
					if ($_SESSION[$this->table]["msgs"]&&$_GET['panelmod']=="") $this->render_messages($_SESSION[$this->table]["msgs"]);
					if ($printable) print $this->_draw_buttons_bar($this,"databrowser"); 
					print "<p><b>&nbsp;&nbsp;"._MB_NOOBJECTS."</b></p>\n";
					}
				} else {
					// results
						$show_databrowser=true;
						if (is_array($this->panel)) {
							$show_databrowser=$this->_draw_panel($this->panel);	
						} 
						if ($_GET['xid']!="") {
							if (is_array($this->panel)) {
								if ($_GET['panelmod']==""&&$_GET['id']!="") {
									//pagina inicial del panel, mostrem panel table (infotable)
//									print $this->_draw_table_title($this->_get_title($_GET['panelmod']));
									print $this->_draw_buttons_bar($this,"databrowser");
						//			print $this->_draw_panel_table();
								} else {

									//resta de pagines del panel
									if (!$this->panel['hide_table_title']) print $this->_draw_table_title($this->_get_title($_GET['panelmod']));
									if ($_SESSION[$this->table]["msgs"]&&$_GET['panelmod']=="") $this->render_messages($_SESSION[$this->table]["msgs"]);
									if ($printable) print $this->_draw_buttons_bar($this,"databrowser");
								}
							} else {
								// mods relacionats pero sense panel
								if (!$this->panel['hide_table_title']) print $this->_draw_table_title($this->_get_title($_GET['panelmod']));
								if ($printable) print $this->_draw_buttons_bar($this,"databrowser");	
							}
						} else {
							if ($_SESSION[$this->table]["msgs"]&&$_GET['panelmod']=="") $this->render_messages($_SESSION[$this->table]["msgs"]);
							if ($printable) print $this->_draw_buttons_bar($this,"databrowser");
						}
						if ($show_databrowser) {
							if ($mod->rowclick=="drag") {	print "
<script type=\"text/javascript\">

function setDrag() {
	$(\"#dbtable tr.ROW_.draggable\").hover(function() {
	      $(this.cells[0]).addClass('showDragHandle');
	}, function() {
	      $(this.cells[0]).removeClass('showDragHandle');
	});
};

function setTableDnD() {
	$('#dbtable').tableDnD({
    	onDrop: function(table, row) {
        //save to database
        var tblstr = $('#dbtable').tableDnDSerialize();
        var tmparray = new Array();
        var x = 1;
        var id=0;
        tmparray = tblstr.split('&dbtable[]=');
	new_sort='';
        while (x < tmparray.length) {
	   id=$('tr#'+tmparray[x]).attr('rowid');
	   // console.log('pos '+x+' : id '+id);
	   // val=$('tr#'+tmparray[x]+' div.datacell.n0').html().trim();  //valor d'una cel.la
	   new_sort+=id+',';
           x++;
        }
	new_sort=new_sort.substr(0,new_sort.length-1);
	//console.log(new_sort);
	// update rows of database via ajax
	$.ajax({
                        url: '/kms/lib/ajax/updateSortDB.php',
                        type: 'GET',
			data: 'mod=".$_GET['mod']."'+'&new_sort='+new_sort+'&sortby=".$_REQUEST['sortby']."&query=".$_REQUEST['query']."&view=".$_GET['view']."&v2=".$_GET['v2']."',
                        cache: false,
                        global: true,
                        dataType: 'html',
                        success: function(msg){ 
                           if (msg!='OK') alert(msg);
                         },
                        error: function (xhr, ajaxOptions, thrownError){
                            alert(xhr.status);
                        }
	});

    },
    activeCols: [\"ROW_\"],
    dragHandle: \".dragHandle\",
});
//$('tr.ROW_').attr('class',$('tr.ROW_').attr('class')+' draggable'); 

//setDrag();

};";

if ($_GET['sortable']=="1")  print "$(document).ready(function(){
	setTableDnD();
	$('tr.ROW_').attr('class',$('tr.ROW_').attr('class')+' draggable'); 
	setDrag();
	
});";

print "</script>";
}

print "<table id=\"dbtable\" class=\"LIST ".$this->table."\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">\n";

							$this->_draw_table_header($this); 
							for ($i=0;$i<$this->nrows;$i++) {
								if ($mod->datasource=="dbi") $data = $this->dbi->fetch_object($this->result);
								else if ($mod->datasource=="array") $data = $mod->data[$i];
								$mod->fields_show=$this->fields_show;
								$mod->fields_search=$this->fields_search;
								$this->_draw_table_row($mod,$data,$i%2,"table",$i);
								// sumatori
			                                	foreach ($this->fields_show as $field) {
			                                                if (isset($this->sum)&&in_array($field,$this->sum))  {
		        	                                                if (!is_array($this->sumatori)) $this->sumatori = array();


										if (strpos($data->$field,",")) { // si té format monetari convertim
										$this->sumatori[$field] +=$this->money_to_real($data->$field);
										} else {
		                	                                        $this->sumatori[$field] += $data->$field;
										}
		                        	               		 }
								}
							}	
					}
        				if ($show_databrowser) {
		                		// draw totals
	                        		if (isset($this->sum)) {
	                                	print "<tr id='sumbar'>";
						$tc=0;
		                                foreach ($this->fields_show as $field) {
		                                //      if ($this->sum[$field]!=0) 
							if (!in_array($field,$this->excludeBrowser)) {
		                                        print "<td align='left'>";
						  	if (in_array($field,$this->sum)) { $sum = round($this->sumatori[$field],2);print $sum;	}
		                                        print "</td>";
							$tc++;
							}
	                	                }
						if ($tc<=count($this->fields)) print "<td></td>"; // this color fill all the row
                        	     		print "</tr>";
					}
                        	}
				if ($show_databrowser) print "</table>";
				$this->_draw_pages();
				}

			}
		} else if ($_SESSION['exec_mode']=="api") {
			// -- return API data -------------------------
			if ($_REQUEST['_action']=="export" && $this->can_export) { // export tab-delimited
                                $this->_export_records("xls");
                                exit();
                        } elseif ($_REQUEST['_action']=="import" && $this->can_export) { // import tab-delimited
                                $this->_import_records();
                             //   $this->_redirect("{$_SERVER['PHP_SELF']}?_=b");
                        } elseif ($_REQUEST['_action']=="fetch") {
				return $this->_export_records("object"); // cal fer json_decode() per obtenir objecte
                        }
 
		} else {
	                // -- browse as icons -------------------------
                        if ($printable) print $this->_draw_buttons_bar($this,"desktop");
                        // estem al desktop, mostrem icones d'aplicacions
                        if ($_GET['app']!="") {
                                $sel="select * from kms_sys_apps where keyname='".$_GET['app']."'";
                                $res=mysqli_query($this->dblinks['client'],$sel);
                                $app=mysqli_fetch_array($res);
                                if ($this->_group_permissions($app['group'],$user_account['groups'])||$user_account['groups']==0) {
                                 $this->_show_modules();//$this->result);
                                } else {
                                        $this->_error("","You don't have permissions to access this application.");
                                }

                                // s'hauria de mostrar menu i default app, o be, icones si defaultapp=""
                        }
                        if ($_GET['app']=="") {
//				if ($_SESSION['user_groups']=="") $this->_error("","No user groups defined.");
				//user_account = per usuaris extranet
				//client_account = per usuaris admin definits a fora de l'extranet
 				//session username = per superuser
//				if ($this->user_account["username"]=="admin"||$this->client_account["username"]=="admin"||$_SESSION['username']=="root")  $cond="`group` like '%'";
//				else $cond="`group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
				if ($_SESSION['username']=="admin"||$this->_group_permissions("admin")||$_SESSION['username']=='root')  $cond="`group` like '%'";  else $cond="`group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
//				if ($this->client_account["username"]=="admin"||$_SESSION['username']=='root')  $cond="`group` like '%'";  else $cond="`group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
				$select = "SELECT * from kms_sys_apps WHERE (".$cond.") and status='active' order by ".$view['sort_column'];
//echo $this->client_account['username'];
                                $result=mysqli_query($this->dblinks['client'],$select);
                                $num_apps = mysqli_num_rows($result);//,$this->dblinks['client']);
                                if ($num_apps==0) print "<p><h3>&nbsp;&nbsp;"._MB_NOOBJECTS."</h3></p>\n"; else {
                                print "<table class='dataBrowser_content' style='padding:15px' height='100%' width='100%' bgcolor='#ffffff'><tr><td valign=\"top\" height=\"300\" style=\"vertical-align:top\">";
                                while ($row=mysqli_fetch_array($result)) {
					$var=$this->_get_title($row['name']);
                                        $app_name="";
                                        if (file_exists('/usr/share/kms/css/aqua/img/apps/'.strtolower($row['name']).'.png')) $app_name=strtolower($row['name']);
                                        if ($app_name==""&&file_exists('/usr/share/kms/css/aqua/img/apps/'.strtolower($row['keyname']).'.png')) $app_name=strtolower($row['keyname']); else if ($app_name=="") $app_name="unknown";
                                         echo "<div class='kms_icon'><a href='?app=".strtolower($row['keyname'])."&menu=1'><img src='//data.".$this->current_domain."/kms/css/aqua/img/apps/".$app_name.".png' width=\"59\" height=\"60\"></a><div style='margin-top:5px'>".$var."</div></div>";
                                }
                                print "</tr></table>\n";
                                }
                        }
                }


		if ($printable) {
			echo "</div>" ; // application
			echo "</div>" ; // contents
			echo "</div>";  // kmsbody
//			$this->_foot($mod);
		}
	}



	// ---------- class functions ------------


        function _setup_view($v1,$v2) {
		// v1 is the main view
                if ($v1==""&&$v2!="") { $v1=$v2; $v2=""; }
		// view 1
                if ($v1=="") {
                        $result = mysqli_query($this->dblinks['client'],"SELECT * FROM kms_sys_folders WHERE id='".$_GET['dr_folder']."'");
                         if (!$result) { echo "ERROR selecting folder ".mysqli_error(); exit; }
                        $current_folder = mysqli_fetch_array($result);
                        $v1 = $current_folder['default_view'];
                        $_GET['view'] = $v1;
                } else {
                        $result = mysqli_query($this->dblinks['client'],"SELECT * FROM kms_sys_views WHERE id='".$v1."'");
                        if (!$result) {     echo "ERROR selecting view ".mysqli_error();    exit;}
                        $current_view = mysqli_fetch_array($result);
                        //apply current view
                        if ($current_view['orderby']!='') $this->orderby = $current_view['orderby'];
			if ($current_view['groupby']!='') $this->groupby = $current_view['groupby'];
                        if ($current_view['sort']!='') $this->sort = $current_view['sort'];
                        if ($current_view['page_rows']!='') $this->page_rows = $current_view['page_rows'];
                        if ($current_view['fields']!='') $this->fields  = explode (",",$current_view['fields']);
                        if ($current_view['where']!='') {
                                     if ($this->where=="") $this->where = $current_view['where'];
                                     else { $this->where .=  " AND ".$current_view['where'];  }
                        }
			if ($current_view['sqljoin']!='') $this->sqljoin = $current_view['sqljoin'];

                }
		//echo "1-->".$current_view['where']."<br>";
		// view 2
		if ($v2!="") {
                        $result = mysqli_query($this->dblinks['client'],"SELECT * FROM kms_sys_views WHERE id='".$v2."'");
                        if (!$result) {     echo "ERROR selecting view ".mysqli_error();    exit;}
                        $current_view = mysqli_fetch_array($result);
                        // apliquem les regles de la v1
                        /*if ($current_view['orderby']!='') $this->orderby = $current_view['orderby'];
                        if ($current_view['groupby']!='') $this->groupby = $current_view['groupby'];
                        if ($current_view['sort']!='') $this->sort = $current_view['sort'];
                        if ($current_view['page_rows']!='') $this->sort = $current_view['page_rows'];
                        if ($current_view['fields']!='') $this->fields  = explode (",",$current_view['fields']);
			*/
                        if ($current_view['where']!='') {
                                     if ($this->where=="") $this->where = $current_view['where'];
                                     else { $this->where .=  " AND ".$current_view['where'];  }
                        }
			//echo "2-->".$current_view['where']."<br>";
                }
	//	echo "F-->".$this->where;	
        }

	function money($n) {
        return number_format($n, 2, ',', '.');
	}

	function money_to_real($m) {
        $m=str_replace(".","",$m);
        $m=str_replace(",",".",$m);
       	 return $m;
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
		$separator = "<div style='float:left;display:inline-block'><img src=\"//data.".$this->current_domain."/kms/css/aqua/img/interface/separator.gif\"></div>";
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
		$s .= "<div id=\"searchBox\" style='float:right;padding-top:0px;display:".$this->display['searchBox']."'><input autocomplete=\"off\" type=\"text\" id=\"query\" name=\"query\" value=\"" . stripslashes($this->search_value) . "\" id=\"searchBox\"></div>\n";
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
			if (substr($field,0,3)!="vr_")  { //penso que no te sentit que surtin els camps vr al buscador pq no funcionen..
			$pvr = strpos("-".$field,"vr_");if ($pvr) $fname = constant(strToUpper("_KMS_GL_".strToUpper(substr($field,$pvr+2,strlen($field)))));
			
			// grey label if constant not exists
                        if ($fname == "") $fname="<font style='color:#aaaaaa'>".$this->_format_name($field)."</a></font>";
			$s .= "<option value=\"{$field}\" {$sel}>{$fname}</option>\n";
			$j++;
			}
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
		$out = "<div class='kmsbut'>".$out;
		// new button
//		$out .= " type=\"button\" value=\"\" alt=\"".(isset($this->insert_label) ? $this->insert_label : 'Insert') ."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=e&parent=".$parent."&view=".$_GET['view']."'\" title=\"".$this->insert_label."\"></div>";
		$out .= " type=\"button\" value=\"\" alt=\"".(isset($this->insert_label) ? $this->insert_label : 'Insert') ."\" onClick=\"javascript:window.location='".$this->_link('_=i')."'\" title=\"".$this->insert_label."\"></div>";

		return $out;

               (isset($this->insert_label) ? $this->insert_label : 'Insert') .	"</a>";

	}

        function _mupload_button() {
                if (!isset($_GET['dr_folder'])) $dr_folder = "0"; else $dr_folder = $_GET['dr_folder'];
                if (!isset($_GET['dr_folder'])) $out = "<input class=\"mUploadButton\""; else $out = "<input class=\"mUploadButton\"";
                $out = "<div class='kmsbut'>".$out;
                // new button
                $out .= " type=\"button\" value=\"\" alt=\"".(isset($this->mupload_label) ? $this->mupload_label : 'Multiple upload') ."\" onClick=\"javascript:window.location='?_=f&app=".$_GET['app']."&mod=".$_GET['mod']."&action=mupload&view=".$_GET['view']."'\" title=\"".$this->mupload_label."\"></div>";

                return $out;

               (isset($this->insert_label) ? $this->mupload_label : 'Multiple upload') .  "</a>";


        }

	function _print_button() {
		return $this->_render_button(_CMN_PRINT,"javascript:printDataBrowser(\'".$_SERVER['QUERY_STRING']."\');",'_self');
	}

	function _import_button() {
		return "<div class='kmsbut'><input class=\"importButton\" type=\"button\" title=\""._MB_IMPORT."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&_action=import_dialog'\"></div>";
	}

	function _export_button() {
                return "<div class='kmsbut'><input class=\"exportButton\" type=\"button\" title=\""._MB_EXPORT."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&_action=export&view=".$_GET['view']."&v2=".$_GET['v2']."&where=".urlencode($this->where_)."&query=".$this->search_value."&queryfield=".$this->queryfield."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&xid=".$_GET['xid']."'\"></div>";

	}

        function _config_button() {
                        $select = "SELECT SQL_NO_CACHE parent from kms_sys_folders where id=".$_GET['dr_folder'];
                        $result=mysqli_query($this->dblinks['client'],$select);
                        $thisobject = mysqli_fetch_array($result);
                return "<div class='kmsbut'><input class=\"configButton\" type=\"button\" title=\""._MB_CONFIG."\" onClick=\"javascript:window.location='{$_SERVER['PHP_SELF']}?&app=".$_GET['app']."&mod=sys_folders&id=".$_GET['dr_folder']."&_=e'\"></div>";
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
		$this->sortby=str_replace(",","` ".$this->sortdir.",`",$this->sortby);  //per si posem mes d'un camp al sortby
		if ($this->sortby && $this->sortdir && substr($this->sortby,0,3)!="vr_" &&  substr($this->sortby,0,3)!="SUM" &&  substr($this->sortby,0,4)!="YEAR" && !strpos($this->sortby,"*")) {
			if ($this->sortdir=="'") $this->sortdir=""; //parche
			$this->sql .= " ORDER BY `{$this->table}`.`{$this->sortby}` {$this->sortdir}";
		} else if (substr($this->sortby,0,3)!="SUM" &&  substr($this->sortby,0,4)!="YEAR" && substr($this->sortby,0,3)!="vr_") { 
			$this->sql .= " ORDER BY {$this->sortby} {$this->sortdir}";
		} else if (substr($this->sortby,0,3)=="vr_"&&$this->sortrules[$this->sortby]!="") {
                        $this->sql .= " ORDER BY `{$this->sortrules[$this->sortby]}` {$this->sortdir}";
                }

	//	if ($_REQUEST['sortby']) $this->page = "1"; // rewind if sorting by a new field
		//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'||$_SERVER['REMOTE_ADDR']=='192.168.1.22') echo "SORTBY: ".$this->sql."<br>";
	}

	// determines the limit to append to sql query
	function _split_results($dblink) {
		if ($this->per_page==0) $this->per_page=50;
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
		//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'||$_SERVER['REMOTE_ADDR']=='192.168.1.22') echo "SPLIT: ".$this->sql."<br>";
	}

	// determines 'WHERE' to append in sql query
	function _build_query() {
//	if ($_SERVER['REMOTE_ADDR']=='46.6.167.210') 	$debug_search=true;
		if ($_SESSION['exec_mode']=="api") $this->where = $_GET['where'];
		//eliminem opcions de buscador en els databrowsers dels xmods
		if ($_GET['xid']!=""&&is_array($this->panel)&&$_GET['panelmod']!="") { $this->search_value="";$this->queryfield="*"; $this->can_search=false; }
		if ($_GET['queryop']!="") $queryop=strtoupper($_GET['queryop']); else $queryop="LIKE";
		if ($queryop=="EQUAL") $queryop="=";
		$this->sql = "SELECT `{$this->table}`.`{$this->key}`,{$this->field_str} FROM `{$this->table}` ";
		if ($this->queryfield) {  // && $this->search_value) {
			if ($this->queryfield=="*") {
				// ------------------------------------------------------------- search in all fields -----------------------------------------------------------
				$this->_reset_param('day1');$this->_reset_param('month1');$this->_reset_param('year1');
				$this->_reset_param('day2');$this->_reset_param('month2');$this->_reset_param('year2');
				$i=0;
				// ---------------------------- mount all the SELECT JOIN statements -----------------------------------
				$search_options=array();
				$search_options['table_joins'] = array();
				$search_options['table_joins_on'] = array();
				$where_toAdd="";
				$this->_field_types_setup();
				if (is_numeric($this->search_value)) $isnumeric=true; else $isnumeric=false;
				foreach ($this->fields_search as $field) {
                                        $i++;
					$search_value = $this->search_value;
					if ($queryop=="LIKE") {
						if ($_GET['queryop']=="equal") $search_value=$search_value;
                                                else $search_value="%".$search_value."%";
					}
					
					if ($debug_search) echo "<br><b>search filter {$i} $field</b><br>";

					$search_options = $this->_search_filter($field,$this->search_value,$queryop,$search_options);

					if ($debug_search) {
					echo "TABLE JOINS:";
					print_r($search_options['table_joins']);
					echo "<br>TABLE JOINS ON: ";
					print_r($search_options['table_joins_on']);
					echo "<br>ADD SQL QUERY (1): ";
	                                print_r($search_options['query']);
					}
					
					// aixo ho podrem eliminar despres quan tinguem tots els search filters (multiplexrefs i xvarrs virtuals)
					if (is_array($this->multixrefs[$field])||(is_array($this->xvarr[$field]['sql']))) { 
					//  multixrefs and xvarrs (virtual cross reference fields) will require JOINS
					 $this->sql =  str_replace(" WHERE ","",$this->sql);
						 // add LEFT JOIN conditions
						 if ($this->multixrefs[$field]["xtable"]!=""&&!in_array($this->multixrefs[$field]["xtable"],$search_options['table_joins'])&&!in_array($this->xvarr[$field]['sql']["xtable"],$search_options['table_joins'])) {
							 if (!in_array($this->multixrefs[$field]["xtable"],$search_options['table_joins'])) {
//		                                                echo "**".$this->multixrefs[$field]["xtable"]." es a table_join?<br>";
                                                                $search_options['query'] .= " LEFT JOIN `{$this->multixrefs[$field]["xtable"]}` ON ";
								 array_push($search_options['table_joins'],$this->multixrefs[$field]["xtable"]);
//								echo "<br>***AFEGIM !!! {$field}".$this->multixrefs[$field]["xtable"]."<br>";
                                                         } else if (is_array($this->xvarr[$field]['sql'])&&!in_array($this->xvarr[$field]['sql']['xtable'],$search_options['table_joins'])) {
                                                                $search_options['query'] .= " LEFT JOIN `{$this->xvarr[$field]['sql']["xtable"]}` ON ";
                                                         	array_push($search_options['table_joins'],$this->xvarr[$field]['sql']['xtable']);
//								echo "<br>***AFEGIM VR_!!! {$field} ->".$this->xvarr[$field]['sql']['xtable']."<br>";
							}
                                                         $multipleJOINS=true;
                                                }
                                                
						// add ON conditions
	                                        if (is_array($this->multixrefs[$field])) {
	                                                        if (!in_array($this->multixrefs[$field]["xtable"],$search_options['table_joins_on'])) {
									$search_options['query'] .= "`{$this->multixrefs[$field]["xtable"]}`.{$this->multixrefs[$field]["xkey"]}=`{$this->table}`.`{$field}` ";
									array_push($search_options['table_joins_on'],$this->multixrefs[$field]["xtable"]);
//									echo "<br>***AFEGIM ON 2!!! ".$this->multixrefs[$field]["xtable"]."<br>";
								}
								if (substr($this->multixrefs[$field]["xfield"],0,6)!="CONCAT") {
								$search_options['where'] .= " OR `{$this->multixrefs[$field]["xtable"]}`.{$this->multixrefs[$field]["xfield"]} {$queryop} \"{$search_value}\" ";	
								}
						} else if (is_array($this->xvarr[$field]['sql'])) {
	                                                        if (!in_array($this->xvarr[$field]['sql']["xtable"],$search_options['table_joins_on'])) { 


									//$search_options['query'] .= "`{$this->xvarr[$field]['sql']["xtable"]}`.{$this->xvarr[$field]['sql']["xkey"]}=`{$this->table}`.`{$this->xvarr[$field]['sql']["field"]}` ";
									$search_options['query'] .= "LEFT JOIN `{$this->xvarr[$field]['sql']["xtable"]}` ON `{$this->xvarr[$field]['sql']["xtable"]}`.{$this->xvarr[$field]['sql']["xkey"]}=`{$this->table}`.`{$this->xvarr[$field]['sql']["field"]}` ";
									array_push($search_options['table_joins_on'],$this->xvarr[$field]['sql']["xtable"]);
//									echo "<br>***AFEGIM ON 2 VR_ !!! {$field} ->".$this->xvarr[$field]['sql']['xtable']."<br>";
								};
								$search_options['where'].= " OR `{$this->xvarr[$field]['sql']["xtable"]}`.`{$this->xvarr[$field]['sql']["xkey"]}` {$queryop} \"{$search_value}\" ";
                                                                $search_options['where'].= " OR `{$this->xvarr[$field]['sql']["xtable"]}`.`{$this->xvarr[$field]['sql']["xfield"]}` {$queryop} \"{$search_value}\" ";
                                               }
                                        }
					if ($debug_search) {	                                        
					echo "<br>ADD SQL QUERY (2): ";
                                        print_r($search_options['query']);		
					}

					if ($search_options['where']==""&&substr($field,0,3)!="vr_") {
                                                // no search options -> regular search options
                                                if ($queryop=="LIKE") $where_toAdd.=" OR ".$this->table.".".$field." LIKE \"%{$this->search_value}%\"";
                                                else $where_toAdd.=" OR ".$this->table.".".$field."=\"{$this->search_value}\"";
                                        }

					if ($search_options['query']!="") { $this->sql.=$search_options['query']; $search_options['query']=""; }
                                        if ($search_options['where']!="") { $where_toAdd.=" OR ".$search_options['where']; $search_options['where']=""; }
				} // for each
				if ($debug_search) echo "<br>BEFORE WHERE:". $this->sql;
					
				// ------------------------------------- mount WHERE conditions ------------------------------
				$i=0;
				//$this->_field_types_setup();
				$this->sql .= " WHERE (";
				$multipleJOINS=false;
				if ($_GET['queryop']=="") $_GET['queryop']="like";
				//search labels preparation 
				if ($_GET['queryop']=="equal") $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"{$search_value}\""; 
				else $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"%{$search_value}%\"";
			
                                $res=mysqli_query($this->dblinks['client'],$sel);
				$labels_arr=array();$ii=0;


                                while ($labels_matched=mysqli_fetch_array($res)) { $labels_arr[$ii]=$labels_matched[0]; $ii++; }

				//search
				foreach ($this->fields_search as $field) {
				//	echo $field." : ".$this->field_types[$field]."<br>";
                                        if (!$isnumeric&&($this->field_types[$field]=="int"||$this->field_types[$field]=="real"||$this->field_types[$field]==""))  $skip=true; else $skip=false; //skip field
//if ($skip) echo $field." ".$this->field_types[$field]."SKIP<br>";
	                                if (!$skip) {
	
					if (substr($field,0,3)=="vr_") break;
					$i++;
					if (substr($field,0,3)!="SUM" && substr($field,0,4)!="YEAR") {
					$search_value = $this->search_value;
					if ($queryop=="LIKE") {
						if ($_GET['queryop']=="equal") $search_value=$search_value;
						else $search_value="%".$search_value."%";
					}
					if (!is_array($this->multixrefs[$field])&&(!is_array($this->xvarr[$field]))) { 
					// multixrefs and xvarrs are already processed on join clauses
					if (substr($this->sql,strlen($this->sql)-1,1)=="(") {
						if ($i>1) $add.=$add; else $add="";
					} else {
						if ($i>1) $add=" OR ".$add; else $add="";
					}
//change1:  _REQUEST['query']!=""
					if ($this->search_value!="") $this->sql .= $add."`{$this->table}`.`{$field}` = '{$this->search_value}' "; 
							  	   else $this->sql .= $add."`{$this->table}`.`{$field}` {$queryop} \"".mysqli_real_escape_string($search_value)."\" ";
					$add=""; 
					      //search labels etiqueta
                                              if (count($labels_arr)>0) { 
							foreach ($labels_arr as $label) {	
								if ($_GET['queryop']=="equal") $this->sql .= " OR `{$this->table}`.`{$field}`=\"".$label."\" "; else $this->sql .= " OR `{$this->table}`.`{$field}` like \"%".$label."%\" ";
							}
						}
					}

				       }

					unset($search_value);
				//	if ($i<$this->field_cnt) $this->sql .= "OR ";
					} //if skip
				} //foerach search

				$this->sql.=$where_toAdd;
				
				if (!$multipleJOINS) $this->sql .= ")";
				$this->sql=str_replace("SELECT", "SELECT DISTINCT",$this->sql);
				$this->sql=str_replace(" OR  OR "," OR ",$this->sql);	
				if ($debug_search) echo "<br>----------QUERY:<br>".$this->sql; 
			} else {
				// -------------------------------------------------------- search in one field only ------------------------------------------------------


                       //       echo "<br><b>search filter  $this->queryfield</b><br>";
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
	                        	$where_toAdd = "`".$this->queryfield."` {$queryop} \"$y-$m-$d%\"";
	                        	} else {
	                        	// between date
	                        	if ($_POST['day1']=="") $d="01"; else { $d=$_POST['day1']; if (strlen($d)==1) $d="0".$d; }
	                        	if ($_POST['month1']=="") $m="01"; else { $m=$_POST['month1']; if (strlen($m)==1) $m="0".$m; }
	                        	if ($_POST['year1']=="") $y="0"; else $y=$_POST['year1'];
	                        	if ($_POST['day2']=="") $d2="31"; else { $d2=$_POST['day2']; if (strlen($d2)==1) $d2="0".$d2; }
	                        	if ($_POST['month2']=="") $m2="12"; else { $m2=$_POST['month2']; if (strlen($m2)==1) $m2="0".$m2; }
	                        	if ($_POST['year2']=="") $y2=date('Y'); else $y2=$_POST['year2'];
	                        	$where_toAdd = "`".$this->queryfield."` BETWEEN \"$y-$m-$d\" AND \"$y2-$m2-$d2\"";
	                        	}
					$this->where_=$this->where." AND ".$where_toAdd;
					$this->sql .= " WHERE ".$where_toAdd;
                		} else {
	                                $search_options = $this->_search_filter($this->queryfield,$this->search_value,$queryop,$search_options);
					if ($search_options['where']=="") {
						if ($queryop=="LIKE") $search_options['where']="`".$this->queryfield."` ".$queryop." \"%{$this->search_value}%\""; 
						else $search_options['where']="`".$this->queryfield."` ".$queryop." \"{$this->search_value}\"";
					}
					$this->sql.=$search_options['query'];
//                                        $this->sql .= " WHERE ".str_replace(" OR","",$search_options['where']); // OR condition not needed in single field search
					$this->sql .= " WHERE ".$search_options['where'];
					$this->sql = str_replace("WHERE  OR","WHERE",$this->sql);
					$search_value_ = $search_value; //copy
/*					if ($queryop=="LIKE") {
						if ($_GET['queryop']=="equal") $search_value=$search_value;
                                                else $search_value="%".$search_value."%";
					}
*/
/*
	                                if (is_array($this->multixrefs[$this->queryfield])) {
	                                // multixrefs search
					$this->sql .= " WHERE Exists (select {$this->multixrefs[$this->queryfield]["xkey"]} from `{$this->multixrefs[$this->queryfield]["xtable"]}` where `{$this->multixrefs[$this->queryfield]["xtable"]}`.{$this->multixrefs[$this->queryfield]["xkey"]}=`{$this->table}`.{$this->queryfield} AND {$this->multixrefs[$this->queryfield]["xfield"]} {$queryop} \"{$search_value}\" limit 1)";
	                                } else 
*/
					if (is_array($this->xvarr[$this->queryfield]['sql'])) {
	                                // virtual fields search
	                                $this->sql .= " INNER JOIN (SELECT distinct {$this->xvarr[$this->queryfield]['sql']["xkey"]} FROM `{$this->xvarr[$this->queryfield]['sql']["xtable"]}` where {$this->xvarr[$this->queryfield]['sql']["xfield"]} {$queryop} \"{$search_value}\") t ON `{$this->table}`.{$this->xvarr[$this->queryfield]['sql']["field"]}=t.{$this->xvarr[$this->queryfield]['sql']["xkey"]}";
	                                } /*else {
	                                // regular fields search
					//if ($this->queryfield=="id") $this->sql .= " WHERE (`{$this->queryfield}`='{$search_value_}')"; else $this->sql .= " WHERE (`{$this->queryfield}` {$queryop} \"{$search_value}\")";
        	                        }
*/
	                                unset($search_value);
				}

			}
		} // end if
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

		$this->sql=str_replace(" WHERE ( OR"," WHERE ( ",$this->sql);

               if ($this->sqljoin) $this->sql .= " ".$this->sqljoin;
//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'||substr($_SERVER['REMOTE_ADDR'],0,7)=='192.168') echo "<br>: ".$this->sql;  // SQL de la cerca DEBUG final
//
	}

	// draws next/prev and page links
        // draws next/prev and page links
        function _display_links() {
                $string = "";
                $this->num_pages = intval($this->num_rows / $this->per_page);
                if ($_GET['page_rows']=="") $_GET['page_rows']=100;
                if ($this->num_rows % $this->per_page) $this->num_pages++;
                if ($this->page > 1) {
                        $string .= "<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page=1&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\"><img src=\"".PATH_IMG_SMALL."/first.gif\" border=\"0\" alt=\"First\"></a>";
                        $string .= "<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page=" . ($this->page - 1) . "&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\"><img src=\"".PATH_IMG_SMALL."/prev.gif\" border=\"0\" alt=\"Prev\"></a>&nbsp;";
                } else {
                        $string .= "<img src=\"".PATH_IMG_SMALL."/first.gif\" border=\"0\" alt=\"First\">";
                        $string .= "<img src=\"".PATH_IMG_SMALL."/prev.gif\" alt=\"Prev\">&nbsp;";
                }
                $cur_window_num = intval($this->page / $this->page_links);
                if ($this->page % $this->page_links) $cur_window_num++;
                $max_window_num = intval($this->num_pages / $this->page_links);
                if ($this->num_pages % $this->page_links) $max_window_num++;
                if ($cur_window_num > 1) {
                        $string .= "<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page=" . (($cur_window_num - 1) * $this->page_links) ."&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\">...</a>";
                }
                for ($jump_to_page = 1 + (($cur_window_num - 1) * $this->page_links); ($jump_to_page <= ($cur_window_num * $this->page_links)) && ($jump_to_page <= $this->num_pages); $jump_to_page++) {
                        if ($jump_to_page == $this->page) {
                                $string .= "&nbsp;<span class=\"PAGE\" style=\"font-weight:bold\">" . $jump_to_page . "</span>&nbsp;";
                        } else {
                                $string .= "&nbsp;<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page={$jump_to_page}&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\"><u>" . $jump_to_page . "</u></a>&nbsp;";
                        }
                }
                if ($cur_window_num < $max_window_num) {
                        $string .= "<a class=\"PAGE\" href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page=" . (($cur_window_num) * $this->page_links + 1) . "&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\">...</a>&nbsp;";
                }
                if (($this->page < $this->num_pages) && ($this->num_pages != 1)) {
                        $string .= "&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page=" . ($this->page + 1) . "&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\"><img src=\"".PATH_IMG_SMALL."/next.gif\" border=\"0\" alt=\"Next\"></a>&nbsp;";
                        $string .= "<a href=\"{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$_GET['mod']."&page={$this->num_pages}&view=".$_GET['view']."&v2=".$_GET['v2']."&sortby=".$_GET['sortby']."&sortdir=".$_GET['sortdir']."&page_rows=".$_GET['page_rows']."\"><img src=\"".PATH_IMG_SMALL."/last.gif\" border=\"0\" alt=\"Last\"></a>";
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
                $tmp    = $_FILES["import"]["tmp_name"];
                $size   = $_FILES["import"]["size"];
                $delimiter = ";";

                if (is_uploaded_file($tmp)) {
                        $datafile = dirname($tmp)."/".$name;
                        move_uploaded_file($tmp,$datafile);

                        chmod($datafile,0777);

                        $row = 1;
                        $fields=array();
                        if (($handle = fopen($datafile, "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {


                                $num = count($data);
                                $row++;
                                $article=array();
                                for ($c=0; $c < $num; $c++) {
                                        if (count($fields)<$num) {
                                        //header
                                        array_push($fields,str_replace(" ","",$data[$c]));
                                        } else {
                                        //data
                                        $article[$fields[$c]]=$data[$c];
                                        }
                                }

                                if (count($article)>1) {
                                //perform insert
                                    $currenttime = date("Y-m-d H:i:s");

                                    $customer_id=$article['customer_id'];
                                    if ($customer_id=="") $customer_id=1; //CFE-CGC

                                    $q = "INSERT IGNORE INTO `{$this->table}` (";
                                    $values="";
                                    foreach ($fields as $field) {
                                        $q.=$field.",";
                                        $values.="'".mysqli_real_escape_string($article[$field])."',";

                                    }
                                    $q=substr($q,0,strlen($q)-1);  $values=substr($values,0,strlen($values)-1);
                                    $q.=") VALUES (".$values.")";

                                    if (!$this->dblinks['client']) { $this->dblinks['client']=$this->dbi->db_connect('client',$this->dbi); }

                                     $this->dblinks['client']=$this->dbi->db_connect('client',$this->dbi);

                                        mysqli_query($this->dblinks['client'],"SET CHARACTER SET utf8");
                                        mysqli_query($this->dblinks['client'],"SET NAMES utf8");

                                        $result = mysqli_query($this->dblinks['client'],$q);
//echo $q."<br>";
                                        if (!$result) echo "<b>ERROR importing data:</b><br>".$q;
                                        $this->_show_warnings();

                                }
                             }
                             fclose($handle);
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


        }

        function _show_warnings() {
                $warningCountResult = mysqli_query($this->dblinks['client'],"SELECT @@warning_count");
                if ($warningCountResult) {
                    $warningCount = mysqli_fetch_row($warningCountResult );
                            if ($warningCount[0] > 0) {
                        //Have warnings
                        $warningDetailResult = mysqli_query($this->dblinks['client'],"SHOW WARNINGS");
                        if ($warningDetailResult ) {
                            while ($warning = mysqli_fetch_assoc($warningDetailResult)) {
                                //Process it
                                        $this->addmsg("<span style='color:#ccc;line-height:140%'>WARNING: ".$warning['Message']."</span><br>");
                                        $result=false;
                            }
                        }
                    }//Else no warnings
                }
        }

        function _export_records($format) {

		$where=$this->where;
		if ($this->orderby!="") $orderby.=" ORDER BY ".$this->orderby." ".$this->sort;
		if ($this->sort=="des") $orderby.="c"; // falta la c de desc

                if ($format=="xls") {
                        $file = $this->table . "-" . date("dmy",time()) . ".xls";
                        include('xls/ExcelWriterXML.php');
                        $xml = new ExcelWriterXML;
                        $xml->docAuthor($_SESSION['username']);
                        $xml->docLastAuthor('Self');
                        $xml->docCompany("Intergrid SL");
                        $format = $xml->addStyle('StyleHeader');
                        $format->fontBold();
                        $format2 = $xml->addStyle('StyleNormal');
        //              $format->alignRotate(45);
                        $sheet = $xml->addSheet('Dades');

                        $sql = "SELECT SQL_NO_CACHE `{$this->key}`, {$this->export_field_str} ";
                        $sql = "SELECT SQL_NO_CACHE  {$this->export_field_str} ";

                        if ($where!="") {
                                $sql .= "FROM `{$this->table}` WHERE ".$where." ".$orderby;
                                if ($_GET['sortby']!=""&&(substr($_GET['sortby'],0,3)!="vr_")) $sql.=" ORDER BY ".$_GET['sortby'];
                        } else {
                                $sql .= "FROM `{$this->table}` ".$orderby; //order by id";
                        }

                	mysqli_query($this->dblinks['client'],"SET NAMES utf8");
			mysqli_query($this->dblinks['client'],"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
			$sql.=" LIMIT 5380";
                        $result = $this->dbi->query($sql,$this->dblinks['client']);
                        $nrows  = $this->dbi->num_rows($result);
                        $output = "";
                //      echo $this->edit_field_str;exit;
                        //header
                        $colnames = explode("`, `", $this->export_field_str);
			$colnames[0]=str_replace("`","",$colnames[0]);
                        $colnames[count($colnames)-1]=str_replace("`","",$colnames[count($colnames)-1]);
                        $output .= $sheet->writeString(0,3,'id','StyleHeader');
                        foreach ($colnames as $k => $fieldname) {
                                $output .= $sheet->writeString(0,$k, str_replace('`','',$fieldname), 'StyleHeader');
                        }
                        // lng
                        $extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
                        //values
                        for ($i=1;$i<=$nrows;$i++) {
                        $row = $this->dbi->fetch_array($result);
//print_r($row);echo "<br>";
                        $n = count($row);
                                foreach ($colnames as $k => $value) {
				$colnames[$k]=str_replace('`','',$colnames[$k]);
                                $value=str_replace('`','',$value);
				$value=$row[$value];
//echo $colnames[$k]."=".$value."<br>";
//                                $output .= $sheet->writeString($i,$k,htmlentities(strip_tags(utf8_decode($value)), 'StyleNormal');
				  if ($colnames[$k]=="id") $id=$value;
//echo $colnames[$k].":";
				  if ($this->components[$colnames[$k]] && method_exists($this->components[$colnames[$k]],"output_filter")) {  
					//		echo $colnames[$k]."--".$value."({$id})"; 
						$value=$this->_output_filter($colnames[$k],$value,$id);
						//echo " NOU VALUE ".$value."<br>";
			
				  }
                                if ($colnames[$k]!="const") $v=str_replace("&rsquo;","'",html_entity_decode(strip_tags(utf8_decode(getlang($value,$lang)))));
                                else $v=str_replace("&rsquo;","'",html_entity_decode(strip_tags(utf8_decode($value))));

                                $v=utf8_encode($v);
                                $output .= $sheet->writeString($i,$k,$v, 'StyleNormal');
				$v=str_replace("&","and",$v);
                                }
                        }
//exit;
                        header("Content-Type: application/force-download; charset=utf-8");
                         //header("Content-type: application/vnd.ms-excel");
                        if(preg_match("/MSIE 5.5/", $_SERVER['HTTP_USER_AGENT'])) {
                                header("Content-Disposition: filename=$file");
                        } else {
                                header("Content-Disposition: attachment; filename=$file");
                        }
                        header('Pragma: no-cache');
                        header('Expires: 0');
                        $output = trim($xml->writeData());
                        $size = strlen($output);
                        return true;

                } else if ($format=="csv") {

                $file = $this->table . "-" . date("dmy",time()) . ".csv";
                $sql = "SELECT SQL_NO_CACHE `{$this->key}`, {$this->edit_field_str} ";
                $sql = "SELECT SQL_NO_CACHE {$this->edit_field_str} ";
                if ($_GET['sortby']==""||(substr($_GET['sortby'],0,3)=="vr_")) $_GET['sortby']="id";
                if ($_GET['sortdir']=="") $_GET['sortdir']="asc";
                if ($_GET['where']!="") $this->where=urldecode($_GET['where']);
                if ($this->where!="")  $sql .= "FROM `{$this->table}` WHERE ".$this->where." order by ".$_GET['sortby']." ".$_GET['sortdir'];
                        else    $sql .= "FROM `{$this->table}` order by ".$_GET['sortby']." ".$_GET['sortdir'];

//              if ($_SERVER['REMOTE_ADDR']=='81.0.57.125') { echo $sql;exit;}
                $result = $this->dbi->query($sql,$this->dblinks['client']);
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
                                 //$row[$j]=html_entity_decode($row[$j]);
                                 $row[$j]=strip_tags($row[$j]);
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
                if ($where!="")  $sql .= "FROM `{$this->table}` WHERE ".$where." order by ".$_GET['sortby']." ".$_GET['sortdir']; else $sql .= "FROM `{$this->table}` order by ".$_GET['sortby']." ".$_GET['sortdir'];

                $result = $this->dbi->query($sql,$this->dblinks['client']);
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
