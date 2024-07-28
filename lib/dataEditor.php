<?php

// *********************************************************************************************
//
//      Intergrid KMS dataEditor Class
//
//      Intended use    : provides a unified form for editing any kind of record
//      Package version : 2.0
//      Last update     : 12/08/2011
//      Author          : Jordi Berenguer
//      Company         : Intergrid Tecnologies del coneixement SL
//      Country         : Catalonia
//      Email           : j.berenguer@intergrid.cat
//      Website         : www.intergrid.cat
//
// *********************************************************************************************

class dataEditor extends mod {

	var $value;
	var $table;
	var $key;
	var $test =1;

        function dataEditor($client_account,$extranet) {
            //parent::mod($client_account,$extranet);
            $_GET['menu']=1;

        }

	function Main($mod,$dbi) {  // render data manager
		if ($mod->datasource=="") $mod->datasource="dbi";
		if ($dbi) { $mod->dbi=$dbi; $this->dbi=$dbi; }
		/*$mod->setup();
		$tab_mod=$this->_get_mod_current_editor_tab($mod);
		echo "current tab_mod: $tab_mod:".$tab_mod;
		if ($tab_mod!=$_GET['mod']) {
			//include mod class
			include_once "/usr/local/kms/lib/mod/{$tab_mod}.php";
			$mod= $this->tab[0]->mod[0] = & mod::getInstance(0,$tab_mod,$this->client_account,$this->user_account);
		//	$Mod = & mod::getInstance(0,$tab_mod,$this->client_account,$this->user_account);
			$kmspath = "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/";
                   	if (file_exists($kmspath.$tab_mod.".php")) include_once ($kmspath.$tab_mod.".php");
		}*/
                // transfer mod propierties
		//$return_mod=$_GET['mod'];
//echo "GETmod=".$_GET['mod']." GETtabmod=".$_GET['tabmod']." REQUESTreturn_mod=".$_REQUEST['return_mod']."<br>";
		if ($_GET['tabmod']!="") { $_SESSION['return_mod']=$_GET['mod']; $_GET['mod']=$_GET['tabmod']; }
		if ($_GET['tabmod']==""&&$_REQUEST['return_mod']!="") { $return_mod=$_REQUEST['return_mod'];   } 
		if ($_GET['tabmod']==""&&$_REQUEST['return_mod']=="") $return_mod=$_GET['mod'];
//echo $return_mod;exit;
                foreach (get_object_vars($mod) as $name => $value) {
                    $this->$name = $value;
                }
		if ($this->onEdit!="") $this->_onEdit($mod,$_GET['id']);
		if ($this->onAdd!="") $this->_onAdd($mod);
		if (!$this->table) { $this->_error("No table defined.","You need to assign a table to the editor."); }
		if (!$this->key) { $this->_error("No primary key defined.","You need to assign a primary key to the editor."); }
		$this->_field_setup();
		$this->_value_setup();
//		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->link_clientdb;
		$dblink=$this->dbi->db_connect('client',$this->dbi); 
//		if ($_REQUEST['_action']=="") die('_action empty on dataeditor');
		if (_MB_SAVECHANGES=="") die ('There are important constants not defined on this language. Can\'t continue.');

		switch ($_REQUEST['_action']) {

			case _MB_SAVECHANGES:
			        if ($this->can_edit) {
					$return=$this->_onPreUpdate($_POST,$this->value,$mod);
					if (is_array($return)) { $_POST=$return; } 
					$this->_update($_POST,$this->value,$dblink);
					$this->_onUpdate($_POST,$this->value,$mod);
			        }
				if ($_SESSION['exec_mode']!="api") {
				if (isset($_GET["backto"])) {
					// si venim d'un altre tipus 
					$this->_redirect($this->_link("_=d"),_MB_CHANGED);	
				} else {
					if ($this->return_url_edit!="") $this->_redirect($this->return_url_edit,_MB_CHANGED);
                                        else $this->_redirect($this->_link("_=b"),_MB_CHANGED);
				}
				}
			break;
			case _MB_DELETE:
				if ($this->can_delete) {
					//die('delete'.$this->value);
					if ($this->value=="") $this->_error("","ID param is missing","fatal");
					$return=$this->_onPreDelete($_POST,$this->value,$mod);
					$this->_delete($this->value);
					$this->_onDelete($_POST,$this->value,$mod);
				} else {
					 $this->_error("","Validated invoices can't be deleted","fatal");
				}
//				$this->_redirect("{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$return_mod."&_=b&view=".$_GET['view'],_MB_REMOVED);				

                                if ($_GET['mod']=="lib_files") $_GET['mod']="lib_folders"; //get back to folders view

				if ($_SESSION['exec_mode']!="api") {
						if ($this->return_url_edit!="") $this->_redirect($this->return_url_edit,_MB_REMOVED);
	                                        else $this->_redirect($this->_link("_=b"),_MB_REMOVED);
				} else return true;
			break;
			case _MB_INSERT:
				if ($this->can_add) {
					if ($_GET['xid']!="") $_POST['xid']=$_GET['xid'];
                                        if ($_GET['from']!="") $_POST['from']=$_GET['from'];
					$return=$this->_onPreInsert($_POST,$mod);
					if (is_array($return)) $_POST=$return; 
					$id=$this->_insert($_POST,$dblink);
					//print_r($_POST); echo "<br><br>ID:".$id;exit;
					$this->_onInsert($_POST,$id,$mod);
				}
//				$this->_redirect("{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$return_mod."&_=b&view=".$_GET['view'],_MB_ADDED);
				if ($_SESSION['exec_mode']!="api") $this->_redirect($this->_link("_=b"),_MB_ADDED);
				else {  return $id; }
			break;
                        case _MB_DUPLICATE: //"confirm_duplicate":
                                if ($this->can_duplicate) {
					$return=$this->_onPreInsert($_POST,'',$mod);
					if (is_array($return)) $_POST=$return;
                                        $id=$this->_insert($_POST,$dblink);
					$this->_onInsert($_POST,$id,$mod);
					$this->_onDuplicate($_POST,$id,$mod);
                                }
//                                $this->_redirect("{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$return_mod."&_=b&view=".$_GET['view'],_MB_ADDED);
				 if ($_SESSION['exec_mode']!="api") $this->_redirect($this->_link("_=b"),_MB_ADDED);
				 else return $id;
                        break;
 			case "delete_confirm": 
	                        $showbuttons=false;
			break;
			default: // fall back to browser
				if (!$this->can_edit && !$this->can_add) {
//					$this->_redirect("{$_SERVER['PHP_SELF']}?app=".$_GET['app']."&mod=".$return_mod."&_=b&view=".$_GET['view']);
					if ($_SESSION['exec_mode']!="api") $this->_redirect($this->_link("_=b"));
				}
			break;
		}

		if ($_SESSION['exec_mode']=="api") { return $id; }
		$this->_var_setup();

		if ($mod->datasource=="dbi") {
			if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->link_clientdb;
			$this->sql = "SELECT {$this->edit_field_str} FROM `{$this->table}` ";
	
			//sometimes this is for security
			if ($this->where!="") { 
				$this->sql .= "WHERE ".$this->where." AND `{$this->key}` = '{$this->value}' LIMIT 1";
			} else {
				$this->sql .= "WHERE `{$this->key}` = '{$this->value}' LIMIT 1";
			}
			// echo $this->sql;
			$this->result = $this->dbi->query($this->sql,$dblink);
			$data = $this->dbi->fetch_array($this->result);
		} else if ($mod->datasource=="array") {
			$data=$mod->data;	
		}

		if ($_GET['_']=="e"&&count($data)==1) return $this->_error("",_KMS_WEB_SEARCH_NORESULTS);
		if ($this->value) {
			$this->_head($mod,_MB_EDITING." ".($this->title?$this->title:$this->_format_name($this->table))." #{$this->value}",$this->default_content_type);
		} else {
			$this->_head($mod,_MB_SENDNEW." ".($this->title?$this->title:$this->_format_name($this->table)),$this->default_content_type);
		}
		$onsubmit = $this->_js_validation();
		print "</td></div></table>";
		print "<div id=\"kmsbody\" style='width:100%;height:auto'>";
                $app=$this->_get_app();
                $mods=$this->_get_mods($app);
		if ($app['id']=="") { echo "<br>Invalid application";return; }
		if (is_array($this->scripts)) foreach ($this->scripts as $script) {
		print "<script language=\"javascript\">".$script."</script>\n";
		}
                if ($app['show_sidemenu']) { $this->_render_leftmenu($app,$mods); }
                print "<div id=\"contents\" class=\"contents\" style=\"width:auto;height:auto\">";
                if ($app['show_sidemenu']) $this->_render_menuswitcher();
		print "<div id=\"application\" class=\"application tab1\">";

		if (is_array($this->panel)) $this->_draw_panel($this->panel);

		if (!$this->panel['hide_table_title']) {
			if ($this->panel['table_title']=="") $this->panel['table_title']=$this->_get_title($_GET['panelmod']);
//			print $this->_draw_table_title($this->panel['table_title']);
		}


		if ($_GET['tab']!="") {
			//$obj=$this->tab[0]->mod[1];
			print $this->_draw_buttons_bar($_SESSION['editorTabs'],"editor");
		} else {
//			print $this->_draw_buttons_bar($this->editorTabs,"editor");
		}
		if ($current_mod!=$_GET['mod']) {
			// estem en un altre tab
			
		}	
?>
       <div class="tabswitcher">
	<div class="edit tab_but current">Edici&oacute;</div>
<? if ($_GET['_']=="e") { ?>	<div class="relations tab_but">Relacions</div> <? } ?>
       </div>
<?

//		print "<form action=\"{$_SERVER['PHP_SELF']}?_=e&app=".$_GET['app']."&mod=".$_GET['mod']."&view=".$_GET['view'];
//		if (isset($_GET['backto'])) print "&srid=".$_GET["srid"]."&drid=".$_GET["drid"]."&backid=".$_GET['backid']; else print "&id=".$_GET['id'];
//		print "&rid=".$_GET['rid']."&dr_folder=".$_GET['dr_folder'];
//		if (isset($_GET['backto'])) print "&backto=".$_GET['backto']."&backfolder=".$_GET['backfolder'];
//		print "&view=".$_GET['view'];
		print "<div id=\"application_contents\" class=\"dataEditor\">";

		$showbuttons=true;
        	if ($_REQUEST['_action']=="delete_confirm") {
                        $showbuttons=false;
                        print $this->draw_alert($this->alerts['delete']);
			print "<br>";
		}
		if ($this->notice!="") echo $this->draw_notice($this->notice);
		print "<form action=\"".$this->_link("_=".$_GET['_']."&id=".$_GET['id'])."\" method=\"POST\" name=\"dm\" id=\"dm\" enctype=\"multipart/form-data\"{$onsubmit}>\n";
                if ($_REQUEST['_action']=="delete_confirm") {
                        print "<input type='hidden' name='_action' value='"._MB_DELETE."'>\n";
		}
		print "<div id=\"listform\" width=\"auto\" class=\"LISTFORM\">\n";
		$i=0; 
		$j=0;
      // ---------- FORM BUILDER ----------
	//add virtual fields
	$form_fields=$this->edit_fields;
	foreach ($this->xvarr as $xv) array_push($form_fields,$xv['name']);

        //get field indexs
        $fields_indexs=array();
        if ($form_fields[0]=="id") $j=0; else $j=1;
        foreach ($form_fields as $field) {
                $fields_indexs[$field]=$j;//necessari per obtenir el tipus
                $j++;
        }


	//exclude fields in groups
	$form_fields_=array();
	foreach  ($form_fields as $field) {
		if (!$this->inGroup($field)) array_push($form_fields_,$field);
	}
        //$this->field_types=array();
	$form_fields=$form_fields_;
	//bucle fields
        if ($form_fields[0]=="id") unset($form_fields[0]);
	$fields=""; //list of fields
   	foreach ($form_fields as $field) {
		//$fields_indexs[$field]=$j;//per poder obtenir el tipus
		if (substr($field,0,3)!="vr_") 
			$column = $this->_fetch_field_info($data,$field);//,$fields_indexs[$field]);
			else 
			$column = $this->xvarr[$field];
	        $j++; 
	        $i++;
	        $bg = $i%2;
		// render form
	        if ($column['name']=="content_type") $content_type=$column['value'];
		$notedit_=false;
		if (@in_array($field,$this->notedit_insert)&&(!$this->value)) $notedit_=true; 
		if (@in_array($field,$this->notedit_edit)&&($this->value))  $notedit_=true; 
		if (!@in_array($field,$this->notedit)&&!$notedit_) {
					if (substr($field,0,3)!="vr_") $fields.=$field.",";
					print $this->_display_row($field, $bg, $column);
/*
					$css_add="";if (@in_array($field,$this->hidden)) $css_add="display:none;";
					if (in_array($field,$this->concatFields)) $css_add="float:left;"; 
					print "<div class=\"row\" id=\"tr_{$field}\" style=\"{$css_add}\"><div class=\"wrap\">";
					print "<div class=\"cell clear Label ROW{$bg}\" style=\"{$css_add_next}\">";$css_add_next="";
					if (in_array($field,$this->concatFields)) $css_add_next="width:auto;";
					print "<div class=\"middle\"><b><span id=\"label_$field\">{$column['label']}</span></b>";
					if ($column['desc']) {
						print "<br /><small>" . $column['desc'] . "</small>";
					}
					print "</div></div>"; //middle,label
					print "<div class=\"cell ROW{$bg}\" style=\"width:10px\"><div class=\"middle\">:</div></div>\n";
*/
				}
	        $i++;
	        $bg = $i%2;
	/*
		if (!@in_array($field,$this->notedit)&&!$notedit_) { 
		// show field
		print "<div class=\"cell ROW{$bg}\">";
			 if ($this->components[$field] && method_exists($this->components[$field],"display_component")) {
				// component
				if (@in_array($field,$this->readonly)) {
					 if ($column['type']=="blob") {
                                         echo "<div style='overflow:scroll;border:1px dotted #aaa;padding:5px;width:79%;height:200px'>".$column['value']."</div>"; } else {
                                         echo "<input style='display:block' type='text' class='readonly' readonly='readonly' name=\"{$field}\" value='".$column['value']."'>\n";
               				 }

                                 } else {
					  if (!@in_array($field,$this->hidden))  print $this->components[$field]->display_component($column['value']);
				 }
			} else { 
				// other fields... unificar.. html_input hauria de fer tots.
				  print $this->_html_input($column,$data,$mod);
				}
		print "</div>";  // ROW{$bg}
		}
		if (!@in_array($field,$this->notedit)&&!$notedit_) print "</div></div>"; // row

		*/
	} // foreach field
	
	// show fields in groups
	$g=0;
$j=0;
	print "<div><div class=\"sep\"></div></div>";
	echo "<script language='javascript'>function toggleGroup(group) { $('div#'+group).slideToggle('fast');
	if ($('div#c'+group).html()=='mostrar') $('div#c'+group).html('ocultar'); else $('div#c'+group).html('mostrar');
        setTimeout('refreshUI()',200); } </script>";
	foreach ($this->groups_arr as $group) {
		if (constant($group['title'])!="") $title=constant($group['title']);  else $title=$group['title'];
		echo "<div class='group' onclick=\"toggleGroup('group$g')\"><div class='left'>".$title."</div><div id='ctrl' class='ctr right'>".constant('_KMS_GL_HIDE')."</div>";
		if ($group['collapse']) $display="none"; else $display="block";
		
		echo "</div>"; //listform
		echo "<div id='group".$g."' style='display:$display'>";
		echo "<div width=\"auto\" class=\"LISTFORM\">";

		foreach ($group['fields'] as $field) {

		if (substr($field,0,3)!="vr_") $fields.=$field.",";
		if (substr($field,0,3)!="vr_") $column = $this->_fetch_field_info($data,$field);//,$fields_indexs[$field]);
                else $column = $this->xvarr[$field];	
//echo $field." ".$j." ".$column['value']."<br>";
		$j++;
                $i++;
                $bg = $i%2;
                // render form
                if ($column['name']=="content_type") $content_type=$column['value'];
                $notedit_=false;
                if (@in_array($field,$this->notedit_insert)&&(!$this->value))  $notedit_=true;
                if (@in_array($field,$this->notedit_edit)&&($this->value))  $notedit_=true; 
                if (!@in_array($field,$this->notedit)&&!$notedit_) {

                                        $css_add="";if (@in_array($field,$this->hidden)) $css_add="display:none";
					if (in_array($field,$this->concatFields)) $css_add="float:left;";

					if ($column['style']!="") $css_add=$column['style'];
                			if ($column['class']!="") $class="row ".$column['class']; else $class="row";
                                        if($column['clearfix']=="1") {
                                                 print "<div class='clearfix'></div>";
                                        }

                                        print "<div class=\"{$class}\" id=\"tr_{$field}\" style=\"{$css_add}\">";
					print "<div class=\"wrap\">";
                                        print "<div class=\"cell clear Label ROW{$bg}\" style=\"{$css_add_next}\">";$css_add_next="";
					if (in_array($field,$this->concatFields)) $css_add_next="width:auto;";
					print "<div class=\"middle\">";
					if (in_array($field,$this->mandatory)) $mandatory=" <span style='color:#d00'>*</span>"; else $mandatory="";
					print "<b><span id=\"label_$field\">{$column['label']}{$mandatory}:</span></b>";
                                        if ($column['desc']) {
                                                print "<br /><small>" . $column['desc'] . "</small>";
                                        }
                                        print "</div></div>"; // middle, Label
//					print "<div class=\"cell ROW{$bg} dospunts\" style=\"width:10px\"><div class=\"middle\">:</div></div>\n";
                                }
                $i++;
                $bg = $i%2;

                if (!@in_array($field,$this->notedit)&&!$notedit_) {
                // show field
                print "<div class=\"cell ROW{$bg}\">";
                         if ($this->components[$field] && method_exists($this->components[$field],"display_component")) {
                                // component
                                 print $this->components[$field]->display_component($column['value']);
                        } else {
                                // other fields... unificar.. html_input hauria de fer tots.
                                  print $this->_html_input($column,$data,$mod);
                                }
                print "</div></div>"; //cell
                }
                print "</div>\n"; 
		}
		echo "</div>"; //listform	
		echo "</div>";
		$g++;
	}

	$fields=substr($fields,0,strlen($fields)-1); //remove last comma
	if ($this->extra_modules!="") echo $this->extra_modules;
//	print "</div>\n"; //listform
	if ($this->addObjectNavigator) print "------------------------------------";

                print "<div style=\"height:4px\"></div><table width=\"auto\" border=\"0\" class=\"OPT\">\n";
                print "<div><div nowrap style='float:left;max-width:200px'>\n";
                print "<input type=\"hidden\" id=\"kms_return_mod\" name=\"return_mod\" value=\"".$_SESSION['return_mod']."\"/>\n";
                print "<input type=\"hidden\" id=\"kms_from\" name=\"from\" value=\"".$_SESSION['from']."\"/>\n";
                print "<input type=\"hidden\" id=\"kms_panelmod\" name=\"panelmod\" value=\"".$_SESSION['panelmod']."\"/>\n";
                print "<input type=\"hidden\" id=\"kms_xid\" name=\"xid\" value=\"".$_SESSION['panelmod']."\"/>\n";
		print "<input type=\"hidden\" id=\"kms_id\" name=\"id\" value=\"".$_GET['id']."\"/>\n";
	        print "<input type=\"hidden\" id=\"kms_mod\" name=\"mod\" value=\"".$_GET['mod']."\" />\n";
	 	print "<input type=\"hidden\" id=\"kms_app\" _name=\"app\" value=\"".$_GET['app']."\" />\n";
		print "<input type=\"hidden\" id=\"kms_view\" _name=\"view\" value=\"".$_GET['view']."\" />\n";
		print "<input type=\"hidden\" id=\"kms_fields\" value=\"".$fields."\"/>\n";
	if ($showbuttons) {
		if ($_REQUEST['_action']=="Duplicate") { 
			 print "<input type='hidden' id='_action' name='_action' value='"._MB_DUPLICATE."'/>\n";

			print "<input class=\"customButton highlight big\"  type=\"submit\" _onclick=\"$('input#_action').value='confirm_duplicate';document.dm.submit();\" value=\""._MB_DUPLICATE."\"  />&nbsp;";

		} elseif ($this->value && $this->can_edit) {
                        print "<input type='hidden' name='_action' value='"._MB_SAVECHANGES."'/>\n";

			print "<input type=\"hidden\" name=\"{$this->key}\" value=\"{$this->value}\" />\n";
//                        print "<input class=\"customButton highlight big\"  type=\"button\"  onclick=\"if ( $('#dm').jVal({style:'pod',padding:3,border:1,wrap:true}) ) { document.dm._action.value='"._MB_SAVECHANGES."';document.dm.submit();}\" value=\""._MB_SAVECHANGES."\" />&nbsp;";

//dinamic (no fa events, onupdate, etc.)
//if ($_SERVER['REMOTE_ADDR']==_KMS_HOST_IP print "<input id=\"updateObject\" tab=\"1\" class=\"customButton highlight big\" type=\"button\" value=\""._MB_SAVECHANGES."\" />&nbsp;"; 
 print "<input class=\"customButton highlight big\"  type=\"submit\"  value=\""._MB_SAVECHANGES."\" />&nbsp;";


/*		  if ($this->can_delete) {
	
	                        $delcmd = $this->sd_label ? $this->sd_label : "Eliminar";
	                        print "<input type=\"hidden\" name=\"{$this->key}\" value=\"{$this->value}\">\n";
	                        print "&nbsp;<input class=\"customButton big\" type=\"button\" value=\"{$delcmd}\" onclick=\"document.dm._action.value='"._MB_DELETE."';document.dm.submit()\" onClick=\"return getconfirm()\">\n";
                		}
*/
		} elseif (!$this->value && $this->can_add) {
			if ($this->button_insert=="") $this->button_insert=_MB_INSERT;
			print "<input type='hidden' id='_action' name='_action' value='"._MB_INSERT."'/>\n";
//                        print "<input class=\"customButton highlight big\"  type=\"button\" onclick=\"if ( $('#dm').jVal({style:'pod',padding:3,border:1,wrap:true}) ) { document.dm._action.value='"._MB_INSERT."';document.dm.submit(); }\" value=\"".$this->button_insert."\"  />&nbsp;";
			print "<input class=\"customButton highlight big\" type=\"submit\" value=\"".$this->button_insert."\"  />&nbsp;";

		}
//		print "<input class=\"customButton big\" type=\"button\" type=\"reset\" onclick=\"document.dm.action='".$_SERVER['PHP_SELF']."?_=b&mod=".$_GET['mod']."&id=".$_GET['id']."&dr_folder=".$_GET['dr_folder']."';document.dm._action.value='"._MB_CLEAR."';document.dm.submit()\" value=\""._MB_CLEAR."\"  />\n";
		 //if ($_SERVER['PHP_SELF']!="index.php") print "<input type=\"hidden\" name=\"content_type\" value=\"".$content_type."\">\n";
		print "</div>\n";

		print "<div align=\"right\">\n";

                if ($this->can_delete) {
                                $delcmd = $this->sd_label ? $this->sd_label : "Eliminar";
                                print "<input type=\"hidden\" name=\"{$this->key}\" value=\"{$this->value}\">\n";
                                print "&nbsp;<input class=\"customButton big\" type=\"button\" value=\"{$delcmd}\" onClick=\"if (getconfirm('"._KMS_GL_CONFIRM_DELETE."')) { document.dm._action.value='"._MB_DELETE."';document.dm.submit(); }\">\n";
                                }

    // parametres del cancel.laci√
//     if ($_SERVER['PHP_SELF']!="index.php") print "<input type=\"hidden\" name=\"content_type\" value=\"".$content_type."\">\n";

    // parametres del cancel.laci√
    print "<input type=\"hidden\" name=\"mod\" value=\"".$_GET['mod']."\" />\n";

//     if ($_SERVER['PHP_SELF']!="index.php") print "<input type=\"hidden\" name=\"content_type\" value=\"".$content_type."\">\n";

                                        $link=$this->_link("_=b");
                                        if ($_GET['mod']=="lib_files") { $link.="&mod=lib_folders&folder=".$_REQUEST['folder']; }
print "<input style='float:right' class=\"customButton big\" type=\"button\" onclick=\"document.dm.action='".$link."';document.dm._action.value='"._MBB_CANCEL."';document.dm.submit()\"  value=\""._MB_CANCEL."\">\n";


	} //showbuttons

		print "</div></div></table>\n";
		//print "<script>$(document).ready(function() { $('form#dm').formValidation();});</script>\n";
                print "</form></div>"; //close application_contents
		print "</div>";
		print "</div>";

		print "<div id=\"relations\" class=\"application tab2\" style=\"display:none\">";
		include "relations.php";
		print "</div>";

		print "</div></div>"; //contents & kmsbody

          // si s'escau...
                //echo "TEST:".$this->instance;
                // $this->mod[1] = new dataEditor($client_account);
                 //$this->mod[1]->Main($client_account);
                // El problema que hi ha es que abans de fer el main s'ha de carregar el mod....
                // i si el carreguem aqui, no podem utilitzar les funcions...
                // i si el carreguem com classe, que seria lo seu... llavors hi ha el conflicte de crides
                // mod -> get dm -> new modx : el constructor no sap quin dm cridar (i si li pasem per param?)
                // mod -> modx -> dm

	if ($this->onDocumentReady!="") echo "<script language='javascript'>".$this->onDocumentReady."</script>";

	}//Main

	function _display_row($field, $bg, $column) {
                $out="";$css_add="";if (@in_array($field,$this->hidden)) $css_add="display:none;";
		$css_add.="clear:left";
                if (in_array($field,$this->concatFields)) $css_add="float:left;";
		if ($column['style']!="") $css_add=$column['style'];
		if ($column['class']!="") $class=$column['class']; else $class="row";
		if($column['clearfix']=="1") {
                        $out.= "<div class='clearfix'></div>";
                }
                $out.= "<div class=\"row {$class}\" id=\"tr_{$field}\" style=\"{$css_add}\">";
			$out.= "<div class=\"wrap\">";
	                $out.= "<div class=\"cell clear Label ROW{$bg}\" style=\"{$css_add_next}\">";$css_add_next="";
        		        if (in_array($field,$this->concatFields)) $css_add_next="width:auto;";
	                	$out.= "<div class=\"middle\"><b><span id=\"label_$field\">{$column['label']}:</span></b>";
		                if ($column['desc']) $out.="<br /><small>" . $column['desc'] . "</small>";
	                	$out.="</div>"; //middle
			$out.="</div>"; //cell clear Label
//	                $out.="<div class=\"cell ROW{$bg}\" style=\"width:10px\">";
//				$out.="<div class=\"middle dospunts\">:</div>\n";
//			$out.="</div>";
	                // show field
	                $out.= "<div class=\"cell detail ROW{$bg}\">";
                         if ($this->components[$field] && method_exists($this->components[$field],"display_component")) {
                                // component
/*                                if (in_array($field,$this->readonly)) {
                                         if ($column['type']=="blob") {
                                         $out.= "<textarea readonly=readonly name='{$field}' style='overflow:scroll;padding:5px;width:79%;height:200px'>".$column['value']."</textarea>"; } else {
                                         $out.= "<input style='display:block' type='text' class='readonly' readonly='readonly' name=\"{$field}\" value='".$column['value']."'>\n";
                                         }

                                 } else {
                                          if (!@in_array($field,$this->notedit)) $out.= $this->components[$field]->display_component($column['value']);
                                 }
*/
				if (!@in_array($field,$this->notedit)) $out.= $this->components[$field]->display_component($column['value']);

                        } else { 
                                // other fields... unificar.. html_input hauria de fer tots.
//				echo "X";
                                $out.= $this->_html_input($column,$data,$mod);
			//		$out.="X";
                                }
	                $out.= "</div>";  // cell ROW{$bg}
                $out.= "</div>"; // wrap

		$out.= "</div>"; // row
		
		return $out;
	}

	// determine which record we are editing
	function _value_setup() {
/*		if ($_GET[$this->key]) {
			$this->value = $_GET[$this->key];
		} elseif ($_POST[$this->key]) {
			$this->value = $_POST[$this->key];
		} */
		// the id will always be 'id'
		 if ($_GET['id']) {
                        $this->value = $_GET['id'];
                } elseif ($_POST['id']) {
                        $this->value = $_POST['id'];
                }
	}

	// print client-side validation
	function _js_validation() { // validate component
		if (count($this->validates)>0) {
			print "<script language=\"JavaScript\">\n";
			print "<!--\n";
			print "function validate_dm() {\n";
//      print "\tupdateRTEs();\n";
			print "\tmsg = '';\n";
			foreach ($this->validates as $field) {
				$fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : $this->_format_name($field);
				print "\tif (document.dm.{$field}.value.length == 0) {\n";
				print "\t\tmsg = msg + '\\n - {$fname} cannot be blank';\n";
				//print "\t\tdocument.dm.{$field}.focus();\n";
				print "\t}\n";
			}
			print "\tif (msg != '') {\n";
			print "\t\tmsg = 'Invalid information entered:' + msg;\n";
			print "\t\tmsg = msg + '\\n\\nPlease make corrections and try again.';\n";
			print "\t\talert(msg);\n";
			print "\t\treturn false;\n";
			print "\t}\n";
			print "\treturn true;\n";
			print "}\n";
			print "//-->\n";
			print "</script>\n";
			return " onSubmit=\"return validate_dm();\"";
    } else {
      return "";//onSubmit=\"updateRTEs();\"";
    }
	}

        // insert a new record in the table
        function _insert($vars,$dbLink) {
                $sql = "INSERT INTO `{$this->table}` SET ";
                $added=0;
                $i=0;
                foreach ($this->edit_fields as $field) {
                      $i++;
                      $new_value = $this->_input_filter($field,$vars[$field]);  //transformacio

//                      if ($new_value != $old[$field]) {
                              // reeplace this ' caracter by \'
                              $arrSearch = array("'");
                              $arrReplace  = array("\'");
                              $new_valueOK =  str_replace ($arrSearch, $arrReplace, $new_value);
                              // reeplace this " caracter by \" 
                              $arrSearch = array('"');
                              $arrReplace  = array('\"');
                              $new_valueOK =  str_replace ($arrSearch, $arrReplace, $new_valueOK);
                              if ($field!="id") $sql .= " `{$field}` = '".$new_valueOK."',";
                                $added++;
//                      }
                        if (substr($new_value,0,1)=="_"&&$field!="const") { //$this->rules[$field] && method_exists($this->rules[$field],"identify")) {
                                //Multilanguage
                                //bucle idiomes
                                $select="select id from kms_sys_folders where description='_KMS_TY_SITES_LANG' and deleted!='Y'";
                                $result=mysqli_query($dbLink,$select);
                                $folder_lang=mysqli_fetch_array($result);
                                $folder=$folder_lang[0];
                                $select="select default_lang,available_languages from kms_sites";
                                $result=mysqli_query($dbLink,$select);
                                $site=mysqli_fetch_array($result);
				if ($site['available_languages']!="") {

                                $idiomes=explode(",",$site['available_languages']);
                                $var=$new_value;
                                //$var = "_".strtoupper($_GET['mod'])."_".strtoupper($field)."_";
                                // comprovar si existeix camp
                                $select="select const from kms_sites_lang where const='".$var."'";
                                $result=mysqli_query($dbLink,$select);
                                $const=mysqli_fetch_array($result);
                                if ($const[0]!=$var) {
                                        // si no existeix la creem
                                        $select="INSERT INTO kms_sites_lang SET const='".$var."',dr_folder=".$folder;
                                        if ($folder=="") $select="INSERT INTO kms_sites_lang SET const='".$var."'";
                                        $result=mysqli_query($dbLink,$select);
                                        if (!$result) die("[dataEditor] ".mysqli_error()."<br>".$select);
                                }
                                $sql2 = "UPDATE kms_sites_lang SET ";
                                foreach ($idiomes as $i=>$idioma) {
                                        $sql2.= " `{$idioma}` = '".trim(mysqli_real_escape_string($_POST[$field."_".$idioma]))."',";
                                }
                                $sql2=substr($sql2,0,strlen($sql2)-1); // remove last comma
                                $sql2.= " WHERE const='".$var."'";
                               // if ($_SERVER['REMOTE_ADDR']==_KMS_HOST_IP) { echo "<pre>".$sql2."</pre>";exit; } 
				$this->dbi->query($sql2);

				}
                      }
                      unset($new_value);

                } //foreach
//	if ($_SERVER['REMOTE_ADDR']==_KMS_HOST_IP) {print_r($sql);exit;}
                $sql = substr($sql,0,strlen($sql)-1); // remove the last comma
//if ($_SERVER['REMOTE_ADDR']=='88.12.33.163') die($sql);  // stop1
                if ($this->dbi->query($sql)) {
//              if ($added>0) {
                        $this->addmsg(_MB_ADDED);
                } else {
                        echo "FAIL: ".$sql;$this->addmsg(_MB_NOTADDED);exit;
                }

                return mysqli_insert_id($dbLink); //this->dblinks['client']);
        }

	// update a record in the table
	function _update($vars,$id,$dblink) {
	    $sql = "SELECT {$this->edit_field_str} FROM `{$this->table}` ";
	    $sql .= "WHERE `{$this->key}` = '{$vars[$this->key]}'";
	    $results = $this->dbi->query($sql,$dblink);
	    $old = $this->dbi->fetch_array($results);
	    // update them
	    $sql = "UPDATE `{$this->table}` SET ";
	    $changed = 0;
	    foreach ($this->edit_fields as $field) {
		      // update processor
		      $new_value = $this->_input_filter($field,$vars[$field]); // read value from components
	//	      if ($field=="subsector") {  echo $field."=".$new_value."|".$old[$field]."|".$_POST[$field]; exit; }

			//si camp es tipus data (acaba en _date o _datetime) convertim format d-m-Y H:i:s a Y-m-d H:i:s (per a emmagatzemar-lo a la base de dades)
			if (substr($field,strlen($field)-5)=="_date"&&substr($vars[$field],5,1)=="-") $new_value=substr($vars[$field],6,4)."-".substr($vars[$field],3,2)."-".substr($vars[$field],0,2);
			else if (substr($field,strlen($field)-9)=="_datetime"&&substr($vars[$field],5,1)=="-") $new_value= substr($vars[$field],6,4)."-".substr($vars[$field],3,2)."-".substr($vars[$field],0,2)." ".substr($vars[$field],11);

			
//echo $field."<br>";
//if ($field=="show_brandname") echo $field." ".$new_value.":".$old[$field]."->".isset($_POST[$field]);
/*		      if ($new_value != $old[$field]&&!in_array($field,$this->readonly)&&!in_array($field,$this->notedit)&&!in_array($field,$this->hidden)&&isset($_POST[$field])) {*/
			if ($new_value != $old[$field]&&!in_array($field,$this->readonly)&&!in_array($field,$this->notedit)&&isset($_POST[$field])) {
				// reeplace this ' caracter by \'
				$arrSearch = array("'");
				$arrReplace  = array("\'");
				$new_valueOK =  str_replace ($arrSearch, $arrReplace, $new_value);
                                // reeplace this " caracter by \" 
                                $arrSearch = array('"');
                                $arrReplace  = array('\"');
                                $new_valueOK =  str_replace ($arrSearch, $arrReplace, $new_valueOK);

                                $sql .= " `{$field}` = '{$new_valueOK}',";
		      	 	$changed++;
		      }
	 	   if (substr($new_value,0,1)=="_"&&$field!="const") { //$this->rules[$field] && method_exists($this->rules[$field],"identify")) {
                                //Multilanguage
                                //bucle idiomes
                                $select="select id from kms_sys_folders where description='_KMS_TY_SITES_LANG' and deleted!='Y'";
                                $result=mysqli_query($dblink,$select);
                                $folder_lang=mysqli_fetch_array($result);
                                $folder=$folder_lang[0];
                                $select="select default_lang,available_languages from kms_sites";
                                $result=mysqli_query($dblink,$select);
                                $site=mysqli_fetch_array($result);
                                $idiomes=explode(",",$site['available_languages']);
                                $var=$new_value;
                                //$var = "_".strtoupper($_GET['mod'])."_".strtoupper($field)."_";
                                // comprovar si existeix camp
				if ($site['available_languages']!="") {

                                $select="select const from kms_sites_lang where const='".$var."'";
                                $result=mysqli_query($dblink,$select);
                                $const=mysqli_fetch_array($result);
                                if ($const[0]!=$var) {
                                        // si no existeix la creem
                                        $insert="INSERT INTO kms_sites_lang SET const='".$var."'";//,dr_folder=".$folder;
                                        if ($folder=="") $insert="INSERT INTO kms_sites_lang SET const='".$var."'";
                                        $result=mysqli_query($dblink,$insert);
                                        if (!$result) die("[dataEditor] ".mysqli_error()."<br>".$insert);
                                }
                                $sql2 = "UPDATE kms_sites_lang SET ";
                                foreach ($idiomes as $i=>$idioma) {
					$_POST[$field."_".$idioma]=str_replace("\r","",$_POST[$field."_".$idioma]);
					$_POST[$field."_".$idioma]=str_replace("\n","",$_POST[$field."_".$idioma]);
                                        $sql2.= " `{$idioma}` = \"".trim(($_POST[$field."_".$idioma]))."\",";
                                }
                                $sql2=substr($sql2,0,strlen($sql2)-1); // remove last comma
                                $sql2.= " WHERE const='".$var."'";
			//	if ($_SERVER['REMOTE_ADDR']==_KMS_HOST_IP) { echo "<pre>".$sql2."</pre>";exit; }
                                $this->dbi->query($sql2);
	
				}
	    }
	    unset($new_value);

            } //for each
	    $sql = substr($sql,0,strlen($sql)-1); // remove the last comma
	    $sql .= " WHERE `{$this->key}` = '{$vars[$this->key]}'";
	    if ($changed>0) {
	    	$this->dbi->query($sql,$dblink);
		$this->addmsg(_MB_CHANGED);
	    } else {
		$this->addmsg(_MB_NOTCHANGED);
	    }
	    return $vars[$this->key];
	}

	function _validator_rule($field) {

		switch ($this->validators[$field]['type']) {
                        // blobs get a textarea

			case "alphanumeric": 
				 return "jval=\"{valid:/[A-Za-z0-9]/,message:'".str_replace("'","\'",_KMS_ERR_VALIDATE_ALPHANUMERIC)."'}\"";
                        case "notnull":
				return "jval=\"{valid:function (val) { if (val.length == 0) return '".str_replace("'","\'",_KMS_DATAEDITOR_MANDATORY_FIELD)."'; else return ''; }}\"";
			case "email":
				return "jval=\"{valid:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,15}$/, message:'".str_replace("'","\'",_KMS_ERR_VALIDATE_EMAIL)."'}\" jvalkey=\"{valid:/[a-zA-Z0-9._%+-@]/, cFunc:'alert', cArgs:['Email Address: '+$(this).val()]}\"";
//"jval=\"{valid:/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/, message:'"._KMS_ERR_VALIDATE_EMAIL."'}\"";
			case "numeric":
				return "jval=\"{valid:/^(\+|-)?\d+$/, message:'".str_replace("'","\'",_KMS_ERR_VALIDATE_NUMERIC)."'}\"";
			case "nameserver":
				return "jval=\"{valid:/[a-zA-Z0-9]+(\.[a-zA-Z0-9]+){2,}/, message:'".str_replace("'","\'",_KMS_ERR_VALIDATE_NAMESERVER)."'}\"";
			case "strongpw":
				return "jval=\"{valid:/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/,message:'".str_replace("'","\'",_KMS_ERR_VALIDATE_STRONGPW)."'}\"";
			case "url":
				return "jval=\"{valid:/^((ht|f)tp(s?))\://([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(/\S*)?$/,message:'Invalid URL'}\"";
			case "float":
				return "jval=\"{valid:/^[-+]?[0-9]*\.?[0-9]+$/,message:'".str_replace("'","\'",_KMS_ERR_VALIDATE_FLOAT)."'}\"";
			case "ccc":
				return "jval=\"{valid:function (val) { if (!validaCCC(val)) return '".str_replace("'","\'",_KMS_ERR_VALIDATE_CCC)."'; else return ''; }}\"";
			case "custom":
				return $this->validators[$field]['custom'];
		}
	}

	// delete a record in the table
	// if safe_delete is used, update the sd_field instead
	function _delete($id) {

		    if (!$this->can_delete) {
		        $this->addmsg(_MB_ACCESSDENIED);
		        return false;
		    }
		if ($this->sd_field && $this->sd_value) {

			$sql = "UPDATE `{$this->table}` SET ";
			$sql .= "{$this->sd_field} = '{$this->sd_value}' ";
			$sql .= " WHERE `{$this->key}` = '{$id}'";
			$this->result = $this->dbi->query($sql,$dblink);
			$this->addmsg(_MB_CHANGEDTO." {$this->sd_label}");
		} else {
			$sql = "DELETE FROM `{$this->table}` ";
			$sql .= " WHERE `{$this->key}` = '{$id}'";
			$this->result = $this->dbi->query($sql,$dblink);
			$sql = "ALTER TABLE `{$this->table}` auto_increment=1";
			$this->result = $this->dbi->query($sql,$dblink);
			$this->addmsg(_MB_REMOVED);
		}
		return $this->result;
	}


        function extraAttributes($field) {
                $out="";
                if (in_array($field,$this->readonly)) $out.=" readonly=\"readonly\"";
                if (is_array($this->fieldLoad_events[$field])) $out.=" onLoad=\"javascript:".$this->fieldLoad_events[$field]['action']."\"";
                if (is_array($this->fieldChange_events[$field])) $out.= " onChange=\"javascript:".$this->fieldChange_events[$field]['action']."\"";
                if (is_array($this->fieldFocus_events[$field])) $out.= " onFocus=\"javascript:".$this->fieldFocus_events[$field]['action']."\"";
                if (is_array($this->fieldBlur_events[$field])) $out.= " onBlur=\"javascript:".$this->fieldBlur_events[$field]['action']."\"";
                if (is_array($this->validators[$field])) $out.= " ".$this->_validator_rule($field);
                return $out;
        }

	// aquesta funcio s'hauria d'eliminar, i posar part del codi d'aquesta funcio les funcions display_component de cada component, i directament des del Main fer display_component(x)
	// i crear els components per cada tipus de camp q calgui, per xorres que siguin
	// independitzar-ho del dataEditor permetra utilitzar aquests components en altres llocs interficie, databrowsers o sites
	function _html_input($column,$data,$mod) {

		$out="";
		extract($column);
                $type=$column['type'];
		$value=$column['value'];
		if ($value=="") $value=$data[$column['name']];
		//$value = htmlentities($value); No descomentar perque no es veuen accents
//		echo $column.":".$column['name']."-".$column['type']."<br>";
		if ($column['type']=="date") $type='datehtml5';
                if ($column['type']=="date"&&substr($column['name'],strlen($column['name'])-5)=="_date"&&$type!="date"&&$type!="datetime") $type="date";
//echo $column['name'].":".$type."<br>";
		switch ($type) {
			// blobs get a textarea
			case "text":
				$out .= "<textarea title=\"{$helptip}\" class=\"{$textareatype}{$addclass}\" style='width:700px;height:400px' id=\"{$name}\" name=\"{$name}\" cols=\"".$wysiwyg->params['cols']."\" rows=\"".$wysiwyg->params['rows']."\" onresize=\"refreshUI()\" wrap";
                                if (in_array($name,$this->readonly)) $out .= " readonly=\"readonly\"";
                                $out .=">{$value}</textarea>\n";

				break;
			case "blob":
				if (!$this->components[$column['name']]) {
				$textareatype ="normal";
				if ($wysiwyg->field == $name) $textareatype ="rte"; else $textareatype ="normal"; 
				if ($wysiwyg->params['cols']=="") $wysiwyg->params['cols']=20;
				if ($wysiwyg->params['rows']=="") $wysiwyg->params['rows']=5;
				$helptip=constant(strtoupper("_".$this->table."_".$name."_HT"));
				if (substr($name,strlen($name)-5)=="notes") $addclass=" notes"; else $addclass="";
				$out .= "<textarea title=\"{$helptip}\" class=\"{$textareatype}{$addclass}\" style='width:700px' id=\"{$name}\" name=\"{$name}\" cols=\"".$wysiwyg->params['cols']."\" rows=\"".$wysiwyg->params['rows']."\" onresize=\"refreshUI()\" wrap";
                                if (in_array($name,$this->readonly)) $out .= " readonly=\"readonly\"";
				$out .=">{$value}</textarea>\n";
				} else {
				 $out.=$this->components[$column['name']]->input_display($value);
				}
			break;

			case "timestamp":
    		               $ut = mktime(substr($value, 8,2), substr($value, 10, 2), substr($value, 12, 2), substr($value, 4,2), substr($value, 6, 2), substr($value, 0, 4));
	  		       $out .=date($this->ts_format,$ut);
			break;

			case "datehtml5":
				
				$out .="<input type=\"date\" id=\"{$name}\" name=\"{$name}\" size=\"10\" maxlength=\"10\" value=\"{$value}\"";
                                if (@in_array($name,$this->readonly)) $out .=" readonly=\"readonly\"";
                                $out .=">";
			break;

			case "date":
				if (!in_array($name,$this->notedit)) {
                                if ($value=="1970-01-01"||$value=="NULL") $value="";
				if (strlen($value)>10) $type="datetime"; else $type="date";
				$out .="<input type=\"{$type}\" id=\"{$name}\" name=\"{$name}\" size=\"10\" maxlength=\"10\" value=\"{$value}\"";
                                if (@in_array($name,$this->readonly)) $out .=" readonly=\"readonly\"";
                                $out .=">";
				}
				break;

			case "datetime":
				if (!in_array($name,$this->notedit)) {
//                                        if ($value=="0000-00-00"||$value=="0000-00-00 00:00:00") $value=date('Y-m-d H:i:s'); else $value=date('Y-m-d H:i:s',strtotime($value));
                                if ($value=="1970-01-01"||$value=="NULL") $value="";	
//$value=date("d-m-Y",strtotime($value));

$out="
<div class=\"datetimepicker\">
        <input type=\"date\" id=\"date_{$name}\" value=\"".substr($value,0,10)."\"";
        if (@in_array($name,$this->readonly)) $out .=" readonly=\"readonly\"";$out.=" onchange=\"$('#{$name}').val(this.value+' '+$('#time_{$name}').val());\">
        <span></span>
        <input type=\"time\" id=\"time_{$name}\" value=\"".substr($value,11,5)."\"";
        if (@in_array($name,$this->readonly)) $out .=" readonly=\"readonly\"";$out.=" onchange=\"$('#{$name}').val($('#date_{$name}').val()+' '+this.value);\">
        <input type=\"hidden\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\">
</div>
";

/*				if (strlen($value)>10) {$value=substr($value,0,10); }
                                $out .="<input type=\"date\" id=\"{$name}\" name=\"{$name}\" placeholder=\"DD-MM-YYYY hh:ii:ss\" value=\"{$value}\"";
                                if (@in_array($name,$this->readonly)) $out .=" readonly=\"readonly\"";
                                $out .=">";
*/
				}

				break;
			// all remaining types get a text box
			default:
				if (strstr($name,"color")) {
					// color picker
					$out .="<div class='colorpicker'><div class='rel'><script type=\"text/javascript\" src=\"/kms/lib/jscolor/jscolor.js\"></script><input id=\"{$name}\" name=\"{$name}\" class=\"color {required:false}\" value=\"{$value}\" type=\"text\"></div></div>";
					break;
				}
				if ($this->maxlengths[$name]!="") $length=$this->maxlengths[$name]; else $length=250;
				$size = ($length > 60 ? 60 : $length);
				if ($this->inputsize[$name]!="") $size=$this->inputsize[$name];
				// loading other variables (aquest parent es el de la base de dades de kms_sys_folders), si es canvia ja no caldria.
				if ($name=="parent") { $value = $_GET['dr_folder'];  }
				if ($name=="dr_folder") { $value = $_GET['dr_folder'];  }

				// Virtual fields
				if (substr($name,0,3)=="vr_"&&$_GET['_']!="i") {
					if (!isset($this->xvarr[$name]['sql']["xtable"]))
	                                {       
	                                    $content_function=$this->xvarr[$name]["content_function"];
	                                    if (method_exists($mod,$content_function)) $value=strip_tags($mod->$content_function($_GET['id']));
	                                } else {
	                                    $tmp_row=$this->dbi->get_record("select ".$this->xvarr[$name]['sql']['field']." from ".$this->table." where id=".$_GET['id']);
	                                    $vsql = "SELECT ".$this->xvarr[$name]['sql']["xselectionfield"]." FROM ".$this->xvarr[$name]['sql']["xtable"]." WHERE ".$this->xvarr[$name]['sql']["xtable"].".".$this->xvarr[$name]['sql']["xfield"]."='".$tmp_row[0]."'";
					    $vrow=$this->dbi->get_record($vsql);
	                                    if (!$this->components[$field]) $value=$vrow[$this->xvarr[$name]['sql']["xselectionfield"]];	
					}
				}

				// Regular Text Input Field
//                                if (substr($value,0,1)=="_"&&$name!="target"&&$name!="const") {
                              // automatic multilang when detecting _
  //                                      $this->setComponent("multilang",$name);
//                                        $this->components[$name]->input_display($value);
    //                            } else {

				if (@in_array($name,$this->notedit)) $tipus="hidden"; else $tipus = "text";
				$helptip=constant(strtoupper("_".$this->table."_".$name."_HT"));
				if ($this->styleEditor[$name]!="") $add_=" style='".$this->styleEditor[$name]."'"; else $add_="";
				$add_.=" ".$this->extraAttributes($name);
				$out .="<input title=\"{$helptip}\" type=\"{$tipus}\" id=\"{$name}\" name=\"{$name}\" size=\"{$size}\" maxlength=\"{$length}\" value=\"{$value}\"$add_>";
				if ($this->comments[$name]!="") $out .="<span id='comment_$name'>".$this->comments[$name]."</span>\n";
				$out .="\n"; 
				break;
//				}
		}
		return $out;
	}


}

?>
