<?php
// ******************************************************************
//
// 	Intergrid KMS Application Interface Class
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
include_once "/usr/local/kms/lib/tab.class.php";
include_once "/usr/share/kms/lib/css/csscolor.php";
// Global functions
include_once("/usr/share/kms/lib/app/blog/functions.php");
//include_once("/usr/share/kms/lib/conf/getlang.php");

// Base class for knowledge managment
class appInterface extends intergridKMS {

	// variables declaration
	var $delimiter	= "|";
	var $components      = array();
        var $buttons    = array();
	var $interfaces = array();
	var $tab	= array();  // array de tabs

 	// Constructor
	function appInterface() {
	  parent::intergridKMS();
//	  $this->kms_datapath = "/var/www/vhosts/".$current_domain."/subdomains/data/httpdocs/"; 
	}

	// appInterface getInstance function
	function &getInstance($i=0) {
		// inicialitzacions varies d'interficie
		$tab[$i] = new tab($i,$_GET['mod']);
		//$tab = & tab::getInstance(0,$_GET['mod']);
		return $tab[$i];
	}


	function draw_notice($notice) {
		echo "<div class='notice_ed'>".$notice."</div>";
	}

	function _load_interfaces() {
		$select = "SELECT * from kms_sys_interfaces where interface_app='".$_GET['app']."' and interface_mod='".$_GET['mod']."'";
		$result=mysqli_query($this->dblinks['client'],$select);
		$this->interfaces = mysqli_fetch_array($result);
		// default interface
		$select .= " and default=1 limit 1";
		$result=mysqli_query($this->dblinks['client'],$select);
		if (mysqli_num_rows($result)>0) {
				$interface=mysqli_fetch_array($result);
				$this->default_interface=$interface['id'];
				}
		return $this->interfaces;	
	}

	function _setup_interface($interface) {
		switch ($interface->type) {
                    case "f": // full
			_create_instance(1,"width:100%;height:100%");
                    break;
		    case "h": // horizontal split
			_create_instance(1,"width:100%;height:50%");            
                        _create_instance(2,"width:100%;height:50%");
                    break;
                    case "v": // vertical split
                        _create_instance(1,"width:50%;height:100%");
                        _create_instance(2,"width:50%;height:100%");
                    break;
		}
	}

	function _create_instance($instance,$style) {
		echo "<div class='instance' id='instance_{$instance}' style='{$style}'></div>";
	}

	 function _show_dom_head($client_account,$user_account,$extranet) {
		$headers=PATH_TPL."/".$extranet['theme']."/headers.php";
		if (!file_exists($headers)) $this->_error("","Headers not found. Check file ".$headers);
		else include $headers;
	}

        function _show_headers($client_account,$user_account,$extranet) {
                $this->_show_dom_head($client_account,$user_account,$extranet);
//                include PATH_TPL."/head.php";
                if ($extranet['header_style']=="") die ('header style not defined in extranet preferences.');
                echo $this->tpl->fetch("interfaces/headers/".$extranet['header_style'].".php");
        }

        function _show_modules($link) {

	       if ($this->client_account["username"]=="admin"||$_SESSION['username']=='root')  $cond="`group` like '%'";
               else $cond="`group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
	       $select = "SELECT * from kms_sys_apps WHERE (".$cond.") AND keyname='".$_GET['app']."'";
               $result=mysqli_query($this->dblinks['client'],$select);
               $app = mysqli_fetch_array($result);
		if ($app['name']=="") { $_GET['app']="";return 0;  }   // this causes to go to desktop
               $mods = $this->_get_mods($app);
               if ($app['default_module']!="") {echo "<script>document.location='//".$this->current_subdomain.".".$this->current_domain."/?app=".$_GET['app']."&mod=".$app['default_module']."&menu=1';</script>"; exit;}
               print "<div id='header'><table class='dataBrowser_content' style='padding:15px' height='100%' width='100%' bgcolor='#ffffff'><tbody><tr><td valign=\"top\" height=\"300\" style=\"vertical-align:top\">";

               foreach ($mods as $i => $mod) {
                        //read mod preferences
                        $select="SELECT * from kms_sys_mods where name='".$mod."'";
                        $result=mysqli_query($this->dblinks['client'],$select);
                        $mod_data = mysqli_fetch_array($result);
                 	$var=$this->_get_title($mod);
			echo $this->_draw_icon(strtolower($mod),strtolower($mod).".png","?app=".$_GET['app']."&mod=".strtolower($mod)."&menu=1&view=".$mod_data['default_view'],$var,"apps");
               }
               print "</tr></tbody></table></div>\n";
        }

        function _draw_icon($mod,$icon,$url,$name,$type,$target,$info,$color_row="") {
                 if (file_exists('/usr/share/kms/css/aqua/img/'.$type.'/'.strtolower($name).'.png')) $icon=$name.".png";
                 if (!file_exists('/usr/share/kms/css/aqua/img/'.$type.'/'.$icon)) $icon="unknown.png";


                parse_str(substr($url,1,strlen($url)-1),$url_components);
                $file_id=$info;
                if ($_SESSION['username']=='admin'||$_SESSION['username']=='root') $delete="<div class='delete_container'><a href='/?_=e&id=".$file_id."&mod=lib_files&app=".$_GET['app']."'><div class='delete_folder'>x</div></a></div>";
                if ($_GET['mod']=="lib_folders")   {
                return "<table width=100% style='background-color:".$color_row."'><tr><td width=30><div class='kms_icon_'><img width=20 height=20 src='//data.".$this->current_domain."/kms/css/aqua/img/".$type."/".$icon."'></div></td><td width=auto style='color:#111;font-weight:bold'>{$name}</td><td width=50 style='padding-left:10px'><a href='".$url."'>"._KMS_WEB_DOWNLOADS_DOWNLOAD."</a></td><td width=50 style='padding-left:10px'><a style='color:red' href='/?_=e&id=".$file_id."&mod=lib_files&app=".$_GET['app']."'>"._MB_DELETE."</a></td></tr></table></div>";
                } else {
                 return "<div class='kms_icon_2'>".$delete."<a title='{$name} {$info}' href='".$url."' target='{$target}'><img src='//data.".$this->current_domain."/kms/css/aqua/img/".$type."/".$icon."'><br><div class='icon_title'>".substr($name,0,17)."</div></a></div>";
                }

        }

        function _draw_folder_icon($mod,$icon,$url,$name,$type,$target,$info) {
                parse_str(substr($url,1,strlen($url)-1),$url_components);
                 if ($type!="big/folder_back.png") {
                 if ($_SESSION['username']=='admin'||$_SESSION['username']=='root') $delete="<div class='delete_container'><a href='/".$url."&id=".$url_components['folder']."&_=e'><div class='delete_folder'>x</div></a></div>";
                 return "<div class='kms_icon'>".$delete."<a title='{$info}' href='".$url."' target='{$target}'><img src='//data.".$this->current_domain."/kms/css/aqua/img/".$type."'></a><br><div class='icon_title'>".$name."</div></div>";     } else {
                return "<div class='kms_icon'><a title='{$info}' href='".$url."' target='{$target}'><img src='//data.".$this->current_domain."/kms/css/aqua/img/".$type."'></a><br><div class='icon_title'>".$name."</div></div>";
                }
        }

        function _login_screen($status="") {
                // login.php ha de ser nomes template.. treure codi cap aquesta funcio
		if ($this->extranet['theme']=="")  $this->_error("","Extranet theme not defined.","fatal");
//		echo PATH_TPL_TEMPLATE.$this->extranet['theme']."/login.php";
		include PATH_TPL_TEMPLATE.$this->extranet['theme']."/login.php";
        }


        // draws the top application bar with buttons, filters and search options
        function _draw_buttons_bar($obj,$mode) {
                $s = "<div id=\"buttonbar\">\n<div id=\"leftbuttons\">";

		if ($_GET['xid']!="") {
			// si estem editant,etc. tornem un nivell enrere, sino tornem al mod original
			if ($_GET['_']=="b") $back_url = "/?app=".$_GET['app']."&mod=".$_GET['from']; else $back_url = $this->_link();
			$s .= "<input class=\"customButton\" value=\"&laquo; "._KMS_GL_BACK_BUT."\" style='width:55px;height:21px;padding-left:6px;' onclick=\"document.location='".$back_url."'\">";

		}
		if ($mode=="databrowser"||($mode=="desktop"&&$_GET['mod']!="")) {
			//sortable switch
	                if ($this->rowclick=="drag") {
			 if ($_GET['sortable']=="1") {  $add_drag="pressed"; $drag_title=_KMS_DATABROWSER_DRAG_ENABLED; }  else { $add_drag="";  $drag_title=_KMS_DATABROWSER_DRAG_DISABLED; }
//sortby']=="sort_order"||($_GET['sortby']==""&&$this->sortby=="sort_order")) { $add_drag="pressed"; $drag_title=_KMS_DATABROWSER_DRAG_ENABLED; }  else { $add_drag="";  $drag_title=_KMS_DATABROWSER_DRAG_DISABLED; }
			$view=array();
			if ($_GET['view']!="") { 
				$sel="select * from kms_sys_views where id=".$_GET['view'];
				$res=mysqli_query($this->dblinks['client'],$sel);
				$view=mysqli_fetch_array($res);
			}
			if ($view['sort_column']=="") $view['sort_column']="sort_order";
                         $disable_sort_url = "//".$_SERVER['SERVER_NAME']."/?_=b&app=".$_GET['app']."&mod=".$_GET['mod']."&menu=".$_GET['menu']."&view=".$_GET['view']."&v2=".$_GET['v2']."&sortable=0&sortby=".$_GET['sortby']."&query=".$_REQUEST['query']."&queryfield=".$_REQUEST['queryfield'];
                         $enable_sort_url = "//".$_SERVER['SERVER_NAME']."/?_=b&app=".$_GET['app']."&mod=".$_GET['mod']."&menu=".$_GET['menu']."&view=".$_GET['view']."&v2=".$_GET['v2']."&sortable=1&sortby=".$view['sort_column']."&sortdir=asc&query=".$_REQUEST['query']."&queryfield=".$_REQUEST['queryfield'];

                         $s .= "<div class=\"kmsbut pressedButton {$add_drag}\" title='{$drag_title}' onclick=\"if ('".$_GET['sortable']."'=='1') { document.location='{$disable_sort_url}'; } else { document.location='{$enable_sort_url}'; }  if ($(this).attr('class')=='pressedButton') { $(this).addClass('pressed');   $('#dbtable tr').removeClass('nodrag nodrop'); $('#dbtable tr.ROW_.draggable').draggable('enable');  setTableDnD(); $(this).attr('title','"._KMS_DATABROWSER_DRAG_ENABLED."'); $('tr.ROW_').addClass('draggable'); $('#dbtable tr.ROW_.draggable').bind('mouseenter mouseleave'); setDrag();} else { $(this).removeClass('pressed'); $(this).attr('title','"._KMS_DATABROWSER_DRAG_DISABLED."');  $('#dbtable tr.ROW_.draggable').unbind('mouseenter mouseleave'); $('#dbtable tr.ROW_.draggable').attr('draggable',false);  $('#dbtable tr').addClass('nodrag nodrop');  $('tr.ROW_.draggable').removeClass('draggable');   }\"><div class='updown1'></div></div>";
			}
                	if ($_REQUEST['_action']=="import_dialog" && $obj->can_import) { // import dialog
	                        $s .= "<form method='post' enctype='multipart/form-data'>&nbsp;&nbsp;Import CSV: ";
	//                      $s .= "</td><td>\n";
	                        $s .= "<input name=\"_action\" value=\"import\" type=\"hidden\">\n";
	                        $s .= "<input name=\"import\" type=\"file\" size=\"16\" accept=\"text/*\"> ";
	                        $s .= "<input class=\"commonButton\" type=\"submit\" value=\"Import File\"></form>";

	                } else {
                        	$separator = "<div class='kmsbut'><img src=\"//data.".$this->current_domain."/kms/css/aqua/img/interface/separator.gif\"></div>";
	                        $space = "<div style='float:left;width:5px;'>&nbsp;</div>";
	                        $s .= $obj->_display_per_page();
	//                      $s .= "</td>\n<td nowrap align=\"center\">";
	
				if ($obj->can_gohome) { // add button
                                        $s .= $obj->_render_button("< "._KMS_GL_HOME,'/','_self');
                                }

	                        if ($obj->can_add) { // add button
	                                $s .= $obj->_add_button();
	                        }
	                        $more = false;
	                        $s_tmp="";
	                        if ($obj->can_mupload) { // add button
	                                $s .= $space.$obj->_mupload_button();
	                        }

        	                if ($obj->can_import) { // import button
	                                $s_tmp .= $obj->_import_button();
	                                $more=true;
	                        }
	                        if ($obj->can_export) { // export button
	                                $s_tmp .= $obj->_export_button();
	                                $more=true;
	                        }
	
	                        if ($obj->can_print) {
	                                $s_tmp .= $obj->_print_button();
	                                $more=true;
	                        }

				if (is_array($obj->customButtons)) {
					$s_tmp .= $obj->_show_customButtons();
					$more=true;
				}
	
	                        if (($obj->can_config)&&($_GET['dr_folder']!=0)) {
	                                $s_tmp .= $obj->_config_button();
	                                $more=true;
	                        }
	                        if ($more) $s .= $separator.$s_tmp;
	        	        }
		} else if ($mode=="editor") {

			//TABS add main tab of current mod
			$current_mod="";
                        if ($_GET['tab']=="") { $current_mod=$_GET['mod']; $class=" active"; } else $class="";
                        $n=0;

			$select="select * from kms_".$_GET['mod']." where id=".$_GET['id'];
			$res=mysqli_query($this->dblinks['client'],$select);
			$fields=mysqli_fetch_array($res);
                        foreach ($obj as $_tab => $_value) {
				if ($_value['xfield1']=="") {
					$_id=$_SESSION['motherTabId'];//$_GET['id'];	$_SESSION['motherTabId'];
				} else {
					$_id=$fields[$_value['xfield1']];
//					$select="select id from kms_".$_value['mod']." where ".$_value['xfield2']."=".$fields[$_value['xfield1']];

					$select="select ".$_value['xfield1']." from kms_".$_GET['mod']." where id=".$_GET['id'];

					$res=mysqli_query($this->dblinks['client'],$select);
					$fields=mysqli_fetch_array($res);
					$_id=$fields[$_value['xfield1']];
				}
                                if ($_GET['tab']==$n) {$current_mod=$_value['mod']; $class=" active"; } else $class="";
				$_mod=$_SESSION['return_mod'];
				$_tabmod=$_value['mod'];
				if ($_SESSION['return_mod']=="") $_mod=$_GET['mod']; else { $_mod=$_SESSION['return_mod']; $_tabmod=""; }
				
                                $s.="<input type=\"button\" class=\"tab$class\" onclick=\"document.location='//".$_SERVER['SERVER_NAME']."/?app=".$_GET['app']."&mod=".$_mod."&tab=".$n."&tabmod=".$_tabmod."&id=".$_id."&_=".$_GET['_']."'\" value=\"".$_value['title']."\">";
                                $n++;
                        }


		} else if ($mode=="desktop") {
				$out="";
				include "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/include/desktop/buttonbar.php";
				$s.=$out;
		}
		//mobile menu button
                $s.="<div id=\"mobmenu\" style=\"float:right\"><input class=\"mobmenu\" type=\"button\" value=\"\" onclick=\"javascript:window.location='/?app=planner&amp;mod=planner_tasks&amp;_=i'\"></div>";

                $s .= "</div>\n";
	
		$s .= "<div id=\"rightbuttons\">";

		if (($mode=="databrowser"&&$obj->can_search)||($mode=="desktop"&&$_GET['mod']!="")) {
				$s.="<div id=\"search\">";
//				if ($_SESSION['query']!="") $obj->search_value=$_SESSION['query'];
				$s .= $obj->_display_search();
				$s .="</div>";
		} else if ($mode=="desktop") {
                                $out="";
                 //               include "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/include/desktop/buttonbar.php";
                                $s.=$out;
                } else {
				$s.="<div id=\"search\">";
				$s.= $obj->_display_viewChanger();
				$s.="</div>";
		} 
		

                // insert VIEWS combo
                $s .= "</div></div>\n";
//              if ($this->showButtons) {
                 //       print $s;
//              }

//	return $current_mod;   // no recordo perque
	return $s;
        }

	function _render_button($name,$action,$target,$addclass,$title) {
		$class="customButton";
		if ($addclass!="") $class="customButton ".$addclass;
		return "<div id=\"{$name}\" class='kmsbut'><input class=\"{$class}\" type=\"button\" value=\"".$name."\" onClick=\"document.location='".$action."'\"  title=\"".$title."\"></div>";

	}
	function _show_customButtons() {
                $numbuts = count($this->customButtons);
		$render="";
                for ($i = 0; $i < $numbuts; $i++) {
                        $show=false;
                        $check_function = $this->customButtons[$i]['checkFunction'];
                        if ($check_function!="") $show=$this->$check_function($key); else $show=true;

                        if ($show) {
                                $flds = $this->dbi->list_fields($_SESSION['dbname'], $this->table);
                                $cols = $this->dbi->num_fields($flds);
                                $fields = array();
                                $params=$this->customButtons[$i]['params'];
                                for ($j = 0; $j < $cols; $j++) {
                                         $fn = $this->dbi->field_name($flds, $j);
//                                       $extra.="[".$fn."]->".strtolower($data->$fn);
                                                // OJO!: data nomes conte els camps visibles del databrowser
                                         $params = str_replace("[".$fn."]",strtolower($data[$fn]),$params);
                                }
                                if ($this->customButtons[$i]['target']=="dashboard") echo $div1."<a href=\"#\" onclick=\"loadURL('".$this->customButtons[$i]['url']."?id=".$key."&mod=".$_GET['mod']."&".$this->customButtons[$i]['params']."','".$this->customButtons[$i]['target']."')\" title='".constant($this->customButtons[$i]['label'])."'><img src='".PATH_IMG_SMALL."/".$this->customButtons[$i]['ico']."'></a>".$div2;
                                else {
                                        $href="id=".$key."&app=".$_GET['app']."&mod=".$_GET['mod'];
					if ($_GET['xid']!="")  $href.="&xid=".$_GET['xid'];
					if ($_GET['from']!="")  $href.="&from=".$_GET['from'];
					if ($_GET['panelmod']!="")  $href.="&panelmod=".$_GET['panelmod'];
					$href.="&".$params;
                                        if ($this->customButtons[$i]['url']!="") $href=$this->customButtons[$i]['url']."&".$href; else  $href="?_=f&".$href;
//                                        echo $div1."<a extra=\"".$extra."\" href=\"".$href."\" target='".$this->customButtons[$i]['target']."' title='".constant($this->customButtons[$i]['label'])."'><img src='".PATH_IMG_SMALL."/".$this->customButtons[$i]['ico']."'></a>".$div2;
					$label=constant($this->customButtons[$i]['label']);
					if ($label=="") $label=$this->customButtons[$i]['label'];
					$render.=$this->_render_button($label,$href,$this->customButtons[$i]['target'],$this->customButtons[$i]['class'],$this->customButtons[$i]['title']);
                                }
                        }
                }
	   return $render;
	}
        // Renders messages to screen
        function render_messages($msgs) {
            echo "<div class=\"MSG\" style='display:table;width:100%'>";
            foreach ($msgs as $message) {
                echo "<div style=\"left:0px;right:0px;width:100%;margin-left:auto;margin-right:auto\">";
		echo $message;
                echo "</div>";
            }
            echo "</div>";
        }

        function _head($mod,$title,$content_type) {
               if (!isset($mod->tpl)) $this->tpl = new template();
	       $mod->tpl->set('title',$title);
               $mod->tpl->set('content_type',$content_type);
               $mod->tpl->set('msgs',$_SESSION[$mod->table]["msgs"]);
//	       if ($_SESSION['xshowMenu']!="") $mod->showMenu=$_SESSION['xshowMenu'];
 //              $mod->tpl->set('showMenu', $mod->showMenu);
               $_SESSION[$mod->table]["msgs"] = array();
               $title="";
//                echo $mod->tpl->fetch("interfaces/headers/".$mod->extranet['header_style'].".php");
//             echo $this->tpl->fetch("head.php");
        }

        function _foot($mod) {
            $this->tpl->set("debug",$this->dbi->debug);
            $this->tpl->set("version",$this->version);
            $this->tpl->set("footer_align", "right");
	   // echo $this->mod->extranet['header_style']."/common_footer.php";
            echo $this->tpl->fetch($this->extranet['theme']."/common_footer.php",$this);
        }


        // renders the left menu
        function _render_leftmenu($app,$mods) {
		// "/usr/share/kms/lib/menus/setShowMenu.php";
	        if ($_SESSION['xshowMenu']==""||$_SESSION['xshowMenu']=="block") { $display="inline-block";$_SESSION['xshowMenu']="block"; } else $display="none";
		print "<div id=\"leftmenu\" style=\"display:{$display}\">";
		$app['menu_xml']=htmlentities(utf8_decode($app['menu_xml']));
		
		if ($app['show_menu_xml']) {
		// ------- menu xml ----------
                ?>
<? if ($_SERVER['SERVER_NAME']!="intranet.intergrid.cat") { ?>

        <div class="user-panel">
            <div class="pull-left image">
<?if ($_SESSION['user_name']!="admin") { ?>
            <a href="/index.php?app=pref&mod=sys_users&_=e&id=<?=$_SESSION['user_id']?>">
<? } ?>
                    <img src="/kms/tpl/themes/img/icons/default_user.png" class="img-circle avatar" alt="<?=$_SESSION['user_name']?>">
<? if ($_SESSION['user_name']!="admin") { ?>
                </a>
<? } ?>
            </div>
            <div class="pull-left info">
                <p><?=$_SESSION['user_name']?></p>
                    <i class="fa fa-circle text-success"></i> <span style="color:#fff">Online</span>
            </div>
        </div>
<? } ?>

<div id="topMenuBar" style='padding-left:20px'><?//=$app['name']?></div><?
                print "<ul id=\"leftmenu\" class=\"menu_xml\">";
		$app['menu_xml']=str_replace("\n","",$app['menu_xml']);
		$app['menu_xml']=str_replace("\r","",$app['menu_xml']);
		$app['menu_xml']=str_replace("&gt;",">",$app['menu_xml']);
		$app['menu_xml']=str_replace("&lt;","<",$app['menu_xml']);
		$menu_xml = new SimpleXMLElement($app['menu_xml']);
		foreach ($menu_xml->menu as $menu) {
		   //comprovem si el menu ha de sortir activat 
		   $addclass="";
		   $submenu->action=utf8_decode($submenu->action);
		   foreach ($menu->submenu as $submenu) { 
			if (($_SERVER['REQUEST_URI']==$submenu->action)&&($submenu->action!="")) {
                        $_SESSION['submenu_xml']=(string)$submenu->action;
			$_SESSION['submenu_mod']=$_GET['mod'];
			}
		   }
		   if (constant($menu->title)!="") $title=constant($menu->title); else {
			    $translation=$this->dbi->get_record("select ".$_SESSION['lang']." from kms_sys_lang where const='".$menu->title."'");
			if ($translation[0]!="") $title=$translation[0];  else $title=$menu->title; 
		   }

                   $permission=false;
                   $valid_groups=explode(",",$menu->group);
                   foreach ($valid_groups as $g) {
                                if (in_array($g,explode(',',$_SESSION['user_groups']))) { $permission=true; break; }

                   }

//		   if ($menu->group==""||in_array($menu->group,explode(',',$_SESSION['user_groups']))||$_SESSION['username']=='admin') {
		   if ($menu->group==""||$permission||$_SESSION['username']=='admin') {
		   echo "<li class=\"item_menu{$addclass}\"><div id=\"butmenu\" class=\"category\"><div class=\"menu_name\" id=\"menu\">".strtoupper_accents($title)."</div><div style=\"clear:left\"></div></div>";
		   echo "<ul id=\"category\">";
			foreach ($menu->submenu as $submenu) {
				$submenu_mod=(string)$submenu->mod;

                               //submenu permissions
                                   $permission=false;
                                   $valid_groups=explode(",",$submenu->group);
                                   foreach ($valid_groups as $g) {
                                           if (in_array($g,explode(',',$_SESSION['user_groups']))) { $permission=true; break; }

                                   }

//                              if ($submenu->group==""||in_array($submenu->group,explode(',',$_SESSION['user_groups']))||$_SESSION['username']=='admin') {
                                if ($submenu->group==""||$permission||$_SESSION['username']=='admin') {

				//selected
	                        if ((substr($_SESSION['submenu_xml'],1)==$submenu->action||substr($_SESSION['submenu_xml'],1)==$submenu_mod)&&($_SESSION['submenu_mod']==$_GET['mod']||$_SESSION['submenu_mod']==$_GET['from'])) $class=" selected"; else $class="";
				//title
				if (constant($submenu->title)!="") $title=constant($submenu->title); else {
				$translation=$this->dbi->get_record("select ".$_SESSION['lang']." from kms_sys_lang where const='".$submenu->title."'");
			 	if ($translation[0]!="") $title=$translation[0]; else $title=$submenu->title;
				}

				echo "<li class='sub";
        	                if (($_GET['mod']==$submenu_mod||$_GET['from']==$submenu_mod)&&$_GET['tabmod']==""&&$submenu_mod!=""&&!strpos($submenu->action,"&_=f")) { 
					echo "_selected"; $adds=" id='menu_selected'";
				} else {
	                                $adds="";
        	                        if ($_GET['tabmod']!=""&&$_SESSION['return_mod']==$submenu_mod) { echo " selected"; $adds=" id='menu_selected'";} else $adds="";
                        	}
	                        echo "'";
        
		                if ($var_short!=$var) echo " title=\"{$var}\"";
				if ($submenu->action=="") $submenu->action="/?app=".$_GET['app']."&mod={$submenu_mod}&menu=1&_=b";
				//$submenu->action.="&view=".$submenu->defaultView;
				if ($submenu->icon!="") $icon=$submenu->icon; else $icon=$submenu_mod.".png";
				if (!file_exists('/usr/share/kms/css/aqua/img/apps/'.$icon)) $icon=substr($icon,0,strpos($icon,"_"))."_generic.png";
				if ($submenu_mod=="") $icon=$_GET['app'].".png";

	                        echo " onclick=\"location.href='".$submenu->action."'\"><div id='butmenu'><div class='menu_icon'><img src='//data.".$this->current_domain."/kms/css/aqua/img/apps/{$icon}' width=16></div><div class='menu_name'{$adds}>".$title."</div><div style='clear:left'></div></div>";

				// display mod views
	                        if ($_GET['mod']==$submenu_mod&&!strpos($submenu->action,"&_=f")||$_GET['from']==$submenu_mod) echo $this->_display_views($submenu_mod);
				echo "</li>";
				} //permissions
			}
		   echo "</ul>";
		   echo "</li>";
		   } // if menu->group


		}
                print "</ul>";
		}


		if ($app['show_modules']) { 
		// ------- menu mods and views ----------
                ?><div id="topMenuBar"></div> <? /*<?=_KMS_IF_FOLDERSANDFILTERS?></div><?*/
		print "<ul id=\"leftmenu\">";
		$i=0; foreach ($mods as $j => $mod) {
 	               //read mod preferences
                       $select="SELECT * from kms_sys_mods where name='".$mod."'";
                       $result=mysqli_query($this->dblinks['client'],$select);
                       $mod_data = mysqli_fetch_array($result);
                       $var=$this->_get_title($mod);
                       $var_short= $this->_shorten_linkname ($var,19);
                       if (file_exists('/usr/share/kms/css/aqua/img/apps/'.strtolower($mod.'.png'))) $mod_name=strtolower($mod); else $mod_name="unknown";
			echo "<li class='item_menu";
                       if (($_GET['mod']==$mod||$_GET['from']==$mod)&&$_GET['tabmod']=="") { echo " selected"; $adds=" id='menu_selected'";} else {
				 $adds="";
		       		 if ($_GET['tabmod']!=""&&$_SESSION['return_mod']==$mod) { echo " selected"; $adds=" id='menu_selected'";} else $adds=""; 
			}
                       echo "'";
                       if ($var_short!=$var) echo " title=\"{$var}\"";
			echo " onclick=\"location.href='/?_=b&app=".$_GET['app']."&mod={$mod}&menu=1&view='\"><div id='butmenu'><div class='menu_icon'><img src='//data.".$this->current_domain."/kms/css/aqua/img/apps/{$mod_name}.png' width=16></div><div class='menu_name' {$adds}>".$var_short."</div><div style='clear:left'></div></div>";
			// display mod views
			if ($_GET['mod']==$mod||$_GET['from']==$mod) echo $this->_display_views($mod);	
			echo "</li>";
                       $i++;
                       }
		print "</ul>"; 
		}

		print "</div>";
	}

	function _render_menuswitcher() {
		print "<div class=\"menuSwitcher\"><table height=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"vertical-align:middle\"><img width=\"6\" height=\"60\" src=\"//data.".$this->current_domain."/kms/css/aqua/img/interface/bar_close.gif\" id=\"bar_button\" title=\"Hide/show the navigation pane\" onclick=\"switchMenu('default','aqua');\" style=\"cursor:pointer\" alt=\"\"></td></tr></tbody></table></div>";
	}

        // header with sorting
        function _draw_table_header($mod) {
		if (!isset($mod->fields_show)) $mod->fields_show=$mod->fields;
		if (!isset($mod->fields_search)) $mod->fields_search=$mod->fields;
                print "<tr class=\"HDR\">\n";
		if ($mod->rowclick=="drag") print "<th></th>";
                foreach ($mod->fields_show as $field) {
                if (!@in_array($field, $mod->excludeBrowser)) {
                        // set human readable field names
                        $fname = $mod->humans[$field]["name"] ? $mod->humans[$field]["name"] : constant(strToUpper("_".$mod->table."_".$field));
                        if ($fname == "") $fname = constant(strToUpper("_KMS_GL_".$field));
                        $pvr = strpos("-".$field,"vr_");
                        $addtitle="";
                        if ($pvr&&$fname=="") { 
				if ($mod->xvarr[$field]["xtable"]=="") $r=strToUpper(substr($field,$pvr+2,strlen($field))); else $mod->xvarr[$field]["xtable"]."_".strToUpper(substr($field,$pvr+2,strlen($field)));
				$const=strToUpper("_KMS_".str_replace("kms_","",$r));
                                    if (constant($const)) $fname=constant($const); else $addtitle="title=\"{$const}\"";
                        }
                        if ($mod->abbrev[$field]!="") { $addtitle="title=\"{$fname}\"";$fname=$mod->abbrev[$field]; }
			if ($fname == "") $fname=constant("_KMS_GL_".strtoupper(str_replace("vr_","",$field)));
			if ($fname == "") $fname=constant("_KMS_GL_".strtoupper(str_replace("_idxxxx","",$field."xxxx")));
                        if ($fname == "") { $fname="<font style='color:#aaaaaa'>".$mod->_format_name($field)."</a></font>"; }
                        // set sorting on field
			$sortby=$field;
			$sort_case=false;
			//special case in "status_icon" components with orderby parameter
			if ($this->components[$field]->class=="status_icon"&&$this->components[$field]->orderby!="") {
					$sort_case=true;
					 $sortby=$this->components[$field]->orderby;
			}

			$th_link="?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b";
			if ($_GET['parent']!="") $th_link.="&parent=".$_GET['parent'];
			if ($_GET['view']!="") $th_link.="&view=".$_GET['view'];
			if ($_GET['v2']!="") $th_link.="&v2=".$_GET['v2'];
			if ($_GET['page_rows']!="") $th_link.="&page_rows=".$_GET['page_rows'];
//			if (substr($field,0,3)=="vr_")  $th_link="#"; 
			if ($this->styleBrowser[$field]!="") $add_=" style='".$this->styleBrowser[$field]."'"; else $add_="";
                        if ($mod->sortby==$field||$sort_case) {
                                if ($mod->sortdir=="asc") {
					$th_link.="&sortby={$sortby}&sortdir=desc&xid=".$_GET['xid'];
					if (!in_array($field,$this->sortable)) $tmp=$fname;
					
					else $tmp="<a href=\"".$th_link."\" {$addtitle}>{$fname}<img src=\"".PATH_IMG_SMALL."/arrow_down.gif\" height=\"11\" alt=\"Descending\" border=\"0\" /></a>"; 
					print "<th class=\"HDR\" nowrap{$add_}>".$tmp."</th>\n";
                                } else {
					$th_link.="&sortby={$sortby}&sortdir=asc&xid=".$_GET['xid'];
					if (!in_array($field,$this->sortable)) $tmp=$fname; 
					else $tmp="<a href=\"".$th_link."\" {$addtitle}>{$fname}<img src=\"".PATH_IMG_SMALL."/arrow_up.gif\" height=\"11\" alt=\"Ascending\" border=\"0\" /></a>";
					print "<th class=\"HDR\" nowrap{$add_}>".$tmp."</th>\n";
                                }
                        } else {
				$th_link.="&sortby={$sortby}&sortdir={$mod->sortdir}&xid=".$_GET['xid'];	
				if (!in_array($field,$this->sortable)) $tmp=$fname;
				else $tmp="<a href=\"".$th_link."\" {$addtitle}>{$fname}</a>";	
				print "<th class=\"HDR\" nowrap{$add_}>".$tmp."</th>\n";
                        }
                }
// tanquem if content_type
                }
                print "<th class=\"HDR\"></th>\n";
                print "</tr>\n";
        }


        // draws a row of data
        function _draw_table_row ($mod,$data,$bg,$optionview,$n) {
                $key = $mod->key;
//echo "FIRST:".$data['creation_date'];
		$_data=$data;
		if (!is_array($data)) {
			$_data=get_object_vars($data);
		}
		if (!is_object($data)) {
//			$data=json_decode(json_encode($data), FALSE);
		}
		$add="";
		if ($mod->rowclick=="edit") { $add=" onclick=\"document.location='".$this->_link('_=e&id='.$_data[$mod->uid])."&_action=View'\""; $bg.=" click"; 
		} else if ($mod->rowclick=="drag") { $add=" ondrop=\"drop(event)\" ondragover=\"allowDrop(event)\" draggable=\"false\" ondragstart=\"drag(event)\" "; $add=" ondrop=\"onDrop(event)\" draggable=\"false\" "; 
		}
		if (is_array($mod->styleRow)) {
			if ($mod->styleRow['field']!="") { // by field
				$_style=$mod->styleRow['styles'][$_data[$mod->styleRow['field']]];
			} else if ($mod->styleRow['rule']!="") { // by rule (function)
				$_style=$mod->styleRow['styles'][call_user_func_array (array($mod,$mod->styleRow['rule']),array($data))];
			}
			$_color= trim(strtoupper(substr($_style,strpos($_style,"background-color:#")+18,6)));
                        $base = new CSS_Color($_color);
                        $add.=" style=\"".$_style."\" onmouseover=\"$(this).css('background-color','#".$base->bg['-1']."')\" onmouseout=\"$(this).attr('style','".$_style."')\"";
		}
		if ($this->rowclick=='drag') $draggable="false"; else $draggable="false";
                if ($optionview!="icons") print "<tr draggable=\"{$draggable}\" id=\"r{$n}\" rowid=\"".$_data['id']."\" class='ROW_ ROW{$bg}'{$add}>";
                else print "<div style=\"margin:5px;float:left;width:90px;height:70px;text-align:center\">";
	        if ($mod->rowclick=="drag") print "<td class=\"dragHandle\"></td>";

		$this->fields_show=$mod->fields_show;
	        $fields_show=$this->fields_show;

		$n=0;
		foreach ($fields_show as $field) {
                        // capturem shortcut_to, i external_url
                        if ($field =="shortcut_to") $shortcut_to = $_data['shortcut_to'];
                        if ($field =="external_url") $external_url = $_data['external_url'];
                        if ($field =="content_type") $content_type = $_data['content_type'];
        //              if ($field =="default_view") $view = $_data['default_view'];
                        if ($field =="custom_icon") $custom_icon = $_data['custom_icon'];
                        if ($optionview=="icons"&&$field =="custom_icon")  {
                                $icon1= "<div style='padding:10px;padding-left:0px;padding-right:0px;height:30px;width:90px;text-align:center'><a href='";
                                $iconurl = PATH_IMG_BIG."/".$content_type."_big.png";
                                if (!file_exists('/usr/share'.$iconurl)) $iconurl = "//data.".$this->current_domain."/kms/css/aqua/img/big/folders_big.png";
                                if ($custom_icon=="") $icon2="'><img src='".$iconurl."' width='32' height='32'></a></div>";
                                else $icon2="'><img src='".PATH_IMG_BIG."/".$custom_icon."' width='32' height='32'></a></div>";
                         }

                        if ($optionview=="icons"&&$field =="content_type")  {
                                $icon1= "<div style='padding:10px;height:30px;width:80px;text-align:center'><a href='";
                                $iconurl = PATH_IMG_BIG."/".$content_type."_big.png";
                                if (!file_exists('/usr/share'.$iconurl)) $iconurl = "//data.".$this->current_domain."/kms/css/aqua/img/big/folders_big.png";
                                $icon2="'><img src='".$iconurl."' width='32' height='32'></a></div>";
                                if ($custom_icon!="") $icon2="'><img src='".PATH_IMG_BIG."/".$custom_icon."' width='32' height='32'></a></div>";
                         }
                        //if ($custom_icon=="") $custom_icon="folders_big.png";
                        //if (substr($field,0,3)=="sr_") { $srid = $_data[$field];} //static cross reference  (1 a 1) ex:  contracte => 1 client unic
                        if (substr($field,0,3)=="dr_") { $drid = $_data[$field];} //dynamic cross reference (1 a molts)  client => multiples productes
                        if (substr($field,0,3)=="vr_") $virtual = true; else $virtual=false; //virtual cross reference  
                        if ($this->field_types[$field]=="date") {
                                if ($_data[$field]=="0000-00-00"||$_data[$field]=="") $_data[$field]=""; else $_data[$field]=date('d-m-Y',strtotime($_data[$field]));

                        } else if ($this->field_types[$field]=="datetime") {
                                if ($_data[$field]=="0000-00-00 00:00:00"||$_data[$field]=="") $_data[$field]=""; else $_data[$field]=date('d-m-Y H:i:s',strtotime($_data[$field]));
                        }

//                        if ((substr($field,strlen($field)-5)=="_date")) $_data[$field]=date('d-m-Y',strtotime($_data[$field]));
  //                      if ((substr($field,strlen($field)-5)=="_datetime")) $_data[$field]=date('d-m-Y H:i:s',strtotime($_data[$field]));

                        // ocultem columnes que no volem que apareixin
                        if (!in_array($field, $mod->excludeBrowser))
                        {
				$add_2="";
				if (in_array($field,$mod->nowrap)) $class_cell = "datacell nowrap n{$n}"; else $class_cell="datacell n{$n}";
				if ($field=="file") $class_cell = "datacell auto n{$n}";
				if ($this->styleBrowser[$field]!="") $add_=" style='".$this->styleBrowser[$field]."'"; else $add_="";
//                              if ($optionview!="icons") print "<td$add_><div class='".$class_cell."' title=\"\">\n";
                                if ($virtual) {
                                        if (!isset($mod->xvarr[$field]['sql']["xtable"]))
                                        { 	
						$content_function=$mod->xvarr[$field]["content_function"];
						if (method_exists($mod,$content_function)) $add_2=$mod->$content_function($data->id);
                                        } else {
					//virtual fields on databrowser
					if ($_data[$mod->xvarr[$field]['sql']['field']]=="") {
						// aixo es per evitar que s'hagi de posar el camp field a l'array de fields 
						$tmp_sel="select ".$mod->xvarr[$field]['sql']['field']." from ".$this->table." where id=".$data->id;
						$tmp_res=mysqli_query($this->dblinks['client'],$tmp_sel);
						$tmp_row=mysqli_fetch_array($tmp_res);
						$_data[$mod->xvarr[$field]['sql']['field']]=$tmp_row[0];
					}
                                        $vsql = "SELECT ".$mod->xvarr[$field]['sql']["xfield"]." FROM ".$mod->xvarr[$field]['sql']["xtable"]." WHERE ".$mod->xvarr[$field]['sql']["xtable"].".".$mod->xvarr[$field]['sql']["xkey"]."='".$_data[$mod->xvarr[$field]['sql']['field']]."'";
                                        $vresult = $mod->dbi->query($vsql);
                                        $vrow = $mod->dbi->fetch_array($vresult);
                                        if (!$mod->components[$field]) $add_2=$vrow[$mod->xvarr[$field]['sql']["xfield"]];
                                        }
                                }
                                if ($field == "id")  { $id=$mod->_output_filter($field,$_data[$field],$data->id); }
                                if ($_GET['id']=="") $id=0; else $id=$_GET['id'];

                                if  ($field==$mod->linkfield['field']&&$optionview!="icons") {
					$flds = $this->dbi->list_fields($_SESSION['dbname'], $this->table);
	                                $cols = $this->dbi->num_fields($flds);
	                                $fields = array();
					$link = $mod->linkfield['link'];
	                                for ($j = 0; $j < $cols; $j++) {
                                         $fn = $this->dbi->field_name($flds, $j);
                                         $link = str_replace("[".$fn."]",$data->$fn,$link);
                                	}
					$add_2="<a class='o' href='".$link."'>";
				}

				//load lang table
				$extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
                                // opcions de visualitzacio databrowser
                                if (($optionview=="icons"&&$field=="description")||($optionview!="icons"))
                                        {
				                $linkname= $mod->_output_filter($field,$_data[$field],$_data[$key]);
						if($_data[$field] != strip_tags($_data[$field])) $ishtml=true; else $ishtml=false;	
                                                if (strpos($_data[$field],"|")) {
                                                        $arrc = explode(",",$linkname);
                                                        $strc="";
                                                        foreach ($arrc as $keyc => $val) {
                                                                $val=trim($val);
                                                                if (substr($val,0,4)=="_KMS") $strc .= constant($val).", "; else { $strc .= $val.", ";
                                                                if (substr($val,0,1)=="_") $strc .= $lang[$val];  }
                                                        }
                                                        $linkname= substr($strc,0,strlen($strc)-2);
                                                } else if (!$ishtml&&strlen($_data[$field])>60&&substr(strtolower($_data[$field]),0,4)!="http") { $linkname=substr(strip_tags($_data[$field]),0,120)."&#8230;"; //  suspensius
                                                } else if (substr($_data[$field],0,1)=="_"&&$field!="const") {
                                                         $linkname=$lang[$_data[$field]];
							if ($linkname=="") $linkname=constant($_data[$field]);
                                                } else if (substr($_data[$field],0,1)=="_"&&$field=="const") {
                                                        // etiqueta
                                                        if ($field=="const") $linkname="<span style='background-color:#aee7ec;padding:2px' title='etiqueta'>".$data->$field."</span>"; else $linkname=$lang[$_data[$field]];
                                                }
                                        }
				if ($linkname==""&&substr($_data[$field],0,1)=="_") { 
					$linkname=$lang[$_data[$field]];
					if ($linkname=="") $linkname=$_data[$field];
				}
				if (substr($linkname,0,1)=="_") {
					if ($lang[$linkname]!="") $linkname=$lang[$linkname];
				}
				if ($optionview!="icons"&&$add_2!="") print "<td$add_><div class='".$class_cell."'>".$add_2."\n";
				if ($optionview!="icons"&&$add_2=="") print "<td$add_><div class='".$class_cell."' title=\"".strip_tags($linkname)."\">\n";
                                if ($optionview!="icons") { if (substr($linkname,0,1)=="_")  print "<span style='color:#999;font-style:italic'>".$linkname."</span>"; else print str_replace("<br />"," ",$linkname); }
                                if  ($field == "description"&&$optionview!="icons")  { print "</a>"; }
                                if ($optionview!="icons") print "</div></td>\n";

                        } else {  // excludeBrowser ... sino != description o name
                                //if ($content_type!="sys_folders") $content_type = $mod->default_content_type; else $content_type = $_data[$field];
                                //echo $content_type;
//				echo "A";exit;
				$n--;
                        }
		$n++;
                } // foreach

                if ($optionview=="icons") print $icon1.$link.$icon2."<a style='text-decoration:none;color:#444' href='".$link."'>".$linkname."</a>";
                if ($optionview!="icons") {

                $delcmd = $mod->sd_label ? $mod->sd_label : "Eliminar";
                //$duplicmd = $mod->sd_label ? $mod->sd_label : "Duplicar";
                $duplicmd = "Duplicar";
                print "<td align=\"right\" valign=\"top\" nowrap>";
		// quan hi ha groupby no te sentit mostrar icones
		if ($this->groupby=="") {
			print "<table class=\"smallicons\" cellspacing=\"0\" cellpadding=\"0\"><tbody><tr><td>\n";
	                $div1 = "<td><div class='ico16'>";//</div>";
	                $div2 = "</div></td>";
	                // custom buttons
	                print $mod->_output_button($_data[$key],$_data,$mod);
	                // predefined buttons
	                print "</td>";
	
	 		if ($_GET['action']!="printDataBrowser"&&$_GET['_action']!="export") {
			$url_but = $this->_link('_=e&'.$key.'='.$_data[$key]);
			if ($_GET['page_rows']!="") $url_but.="&page_rows=".$_GET['page_rows'];	
	                if ($mod->can_edit) {
	                        //id es el de la fitxa actual, srid i drid son els referenciats estatics o dinamics
	               //         print $div1."<a href=\"?app="._$_GET['app']."&mod=".$_GET['mod']."&_=e&id={$_data[$key]}&view=".$_GET['view']."\"><img src=\"".PATH_IMG_SMALL."/edit.gif\" alt=\"Editar\" title=\"Editar\" border=\"0\"></a>".$div2;
				print $div1."<a href=\"".$url_but."\"><img src=\"".PATH_IMG_SMALL."/edit.png\" alt=\"Editar\" title=\"Editar\" border=\"0\"></a>".$div2;
	                }
	                if ($mod->can_view) {
	                print $div1."<a href=\"".$url_but."&_action=View\"><img src=\"".PATH_IMG_SMALL."/details.png\" alt=\"Detalls\" title=\"Detalls\" border=\"0\"></a>".$div2;
	                }
	                 if ($mod->can_duplicate) {
	                        print $div1."<a href=\"".$url_but."&_action=Duplicate\" onClick=\"return true;\"><img src=\"".PATH_IMG_SMALL."/duplicate.png\" alt=\"{$duplicmd}\" title=\"{$duplicmd}\" border=\"0\"></a>".$div2;
	                }
	                if ($mod->can_delete) {
	                        print $div1."<a href=\"".$url_but."&_action=delete_confirm\" onClick=\"return true;\"><img src=\"".PATH_IMG_SMALL."/trash.png\" alt=\"{$delcmd}\" title=\"{$delcmd}\" border=\"0\"></a>".$div2;
				
	                }
	
			} //  ($_GET['action']!="printDataBrowser") ajax calls

	                print "</table>";
		}
                print "</td>\n";
                print "</tr>\n";

                } else {
                        print "</div>";
                }
        }

       // draws a row of data
        function _draw_table_row_file ($mod,$data,$bg,$optionview,$n) {
                $key = $mod->key;
//echo "FIRST:".$data['creation_date'];
                $_data=$data;
                if (!is_array($data)) {
                        $_data=get_object_vars($data);
                }
                if (!is_object($data)) {
//                      $data=json_decode(json_encode($data), FALSE);
                }
                $this->fields_show=$mod->fields_show;
                $fields_show=$this->fields_show;

                $n=0;
                foreach ($fields_show as $field) {
                        // capturem shortcut_to, i external_url
                        if ($optionview=="icons"&&$field =="custom_icon")  {
                                $icon1= "<div style='padding:10px;padding-left:0px;padding-right:0px;height:30px;width:90px;text-align:center'><a href='";
                                $iconurl = PATH_IMG_BIG."/".$content_type."_big.png";
                                if (!file_exists('/usr/share'.$iconurl)) $iconurl = "//data.".$this->current_domain."/kms/css/aqua/img/big/folders_big.png";
                                if ($custom_icon=="") $icon2="'><img src='".$iconurl."' width='32' height='32'></a></div>";
                                else $icon2="'><img src='".PATH_IMG_BIG."/".$custom_icon."' width='32' height='32'></a></div>";
                         }

                        if ($this->field_types[$field]=="date") {
                                if ($_data[$field]=="0000-00-00"||$_data[$field]=="") $_data[$field]=""; else $_data[$field]=date('d-m-Y',strtotime($_data[$field]));

                        } else if ($this->field_types[$field]=="datetime") {
                                if ($_data[$field]=="0000-00-00 00:00:00"||$_data[$field]=="") $_data[$field]=""; else $_data[$field]=date('d-m-Y H:i:s',strtotime($_data[$field]));
                        }

                        // ocultem columnes que no volem que apareixin
                        if (!in_array($field, $mod->excludeBrowser))
                        {
                                $add_2="";
                                if (in_array($field,$mod->nowrap)) $class_cell = "datacell nowrap n{$n}"; else $class_cell="datacell n{$n}";
                                if ($field=="file") $class_cell = "datacell auto n{$n}";
                                if ($this->styleBrowser[$field]!="") $add_=" style='".$this->styleBrowser[$field]."'"; else $add_="";
//                              if ($optionview!="icons") print "<td$add_><div class='".$class_cell."' title=\"\">\n";
                                if ($virtual) {
                                        if (!isset($mod->xvarr[$field]['sql']["xtable"]))
                                        {
                                                $content_function=$mod->xvarr[$field]["content_function"];
                                                if (method_exists($mod,$content_function)) $add_2=$mod->$content_function($data->id);
                                        } else {
                                        //virtual fields on databrowser
                                        if ($_data[$mod->xvarr[$field]['sql']['field']]=="") {
                                                // aixo es per evitar que s'hagi de posar el camp field a l'array de fields 
                                                $tmp_sel="select ".$mod->xvarr[$field]['sql']['field']." from ".$this->table." where id=".$data->id;
                                                $tmp_res=mysqli_query($this->dblinks['client'],$tmp_sel);
                                                $tmp_row=mysqli_fetch_array($tmp_res);
                                                $_data[$mod->xvarr[$field]['sql']['field']]=$tmp_row[0];
                                        }
                                        $vsql = "SELECT ".$mod->xvarr[$field]['sql']["xfield"]." FROM ".$mod->xvarr[$field]['sql']["xtable"]." WHERE ".$mod->xvarr[$field]['sql']["xtable"].".".$mod->xvarr[$field]['sql']["xkey"]."='".$_data[$mod->xvarr[$field]['sql']['field']]."'";
                                        $vresult = $mod->dbi->query($vsql);
                                        $vrow = $mod->dbi->fetch_array($vresult);
                                        if (!$mod->components[$field]) $add_2=$vrow[$mod->xvarr[$field]['sql']["xfield"]];
                                        }
                                }
                                if ($field == "id")  { $id=$mod->_output_filter($field,$_data[$field],$data->id); }
                                if ($_GET['id']=="") $id=0; else $id=$_GET['id'];

                                if  ($field==$mod->linkfield['field']&&$optionview!="icons") {
                                        $flds = $this->dbi->list_fields($_SESSION['dbname'], $this->table);
                                        $cols = $this->dbi->num_fields($flds);
                                        $fields = array();
                                        $link = $mod->linkfield['link'];
                                        for ($j = 0; $j < $cols; $j++) {
                                         $fn = $this->dbi->field_name($flds, $j);
                                         $link = str_replace("[".$fn."]",$data->$fn,$link);
                                        }
                                        $add_2="<a class='o' href='".$link."'>";
                                }

                                //load lang table
                                $extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
                                // opcions de visualitzacio databrowser
                                if (($optionview=="icons"&&$field=="description")||($optionview!="icons"))
                                        {
                                                $linkname= $mod->_output_filter($field,$_data[$field],$_data[$key]);
                                                if($_data[$field] != strip_tags($_data[$field])) $ishtml=true; else $ishtml=false;
                                                if (strpos($_data[$field],"|")) {
                                                        $arrc = explode(",",$linkname);
                                                        $strc="";
                                                        foreach ($arrc as $keyc => $val) {
                                                                $val=trim($val);
                                                                if (substr($val,0,4)=="_KMS") $strc .= constant($val).", "; else { $strc .= $val.", ";
                                                                if (substr($val,0,1)=="_") $strc .= $lang[$val];  }
                                                        }
                                                        $linkname= substr($strc,0,strlen($strc)-2);
                                                } else if (!$ishtml&&strlen($_data[$field])>60&&substr(strtolower($_data[$field]),0,4)!="http") { $linkname=substr(strip_tags($_data[$field]),0,120)."&#8230;"; //  suspensius
                                                } else if (substr($_data[$field],0,1)=="_"&&$field!="const") {
                                                         $linkname=$lang[$_data[$field]];
                                                        if ($linkname=="") $linkname=constant($_data[$field]);
                                                } else if (substr($_data[$field],0,1)=="_"&&$field=="const") {
                                                        // etiqueta
                                                        if ($field=="const") $linkname="<span style='background-color:#aee7ec;padding:2px' title='etiqueta'>".$data->$field."</span>"; else $linkname=$lang[$_data[$field]];
                                                }
                                        }
                                if ($linkname==""&&substr($_data[$field],0,1)=="_") {
                                        $linkname=$lang[$_data[$field]];
                                        if ($linkname=="") $linkname=$_data[$field];
                                }
                                if (substr($linkname,0,1)=="_") {
                                        if ($lang[$linkname]!="") $linkname=$lang[$linkname];
                                }
                                if ($optionview!="icons"&&$add_2!="") print "<td$add_><div class='".$class_cell."'>".$add_2."\n";
                                if ($optionview!="icons"&&$add_2=="") print "<td$add_><div class='".$class_cell."' title=\"".strip_tags($linkname)."\">\n";
                                if ($optionview!="icons") { if (substr($linkname,0,1)=="_")  print "<span style='color:#999;font-style:italic'>".$linkname."</span>"; else print str_replace("<br />"," ",$linkname); }
                                if  ($field == "description"&&$optionview!="icons")  { print "</a>"; }
                                if ($optionview!="icons") print "</div></td>\n";

                        } else {  // excludeBrowser ... sino != description o name
                                //if ($content_type!="sys_folders") $content_type = $mod->default_content_type; else $content_type = $_data[$field];
                                //echo $content_type;
//                              echo "A";exit;
                                $n--;
                        }
                $n++;
                } // foreach

                if ($optionview=="icons") print $icon1.$link.$icon2."<a style='text-decoration:none;color:#444' href='".$link."'>".$linkname."</a>";
                if ($optionview!="icons") {

                $delcmd = $mod->sd_label ? $mod->sd_label : "Eliminar";
                //$duplicmd = $mod->sd_label ? $mod->sd_label : "Duplicar";
                $duplicmd = "Duplicar";
                print "<td align=\"right\" valign=\"top\" nowrap>";
                // quan hi ha groupby no te sentit mostrar icones
                if ($this->groupby=="") {
                        print "<table class=\"smallicons\" cellspacing=\"0\" cellpadding=\"0\"><tbody><tr><td>\n";
                        $div1 = "<td><div class='ico16'>";//</div>";
                        $div2 = "</div></td>";
                        // custom buttons
                        print $mod->_output_button($_data[$key],$_data,$mod);
                        // predefined buttons
                        print "</td>";

                        if ($_GET['action']!="printDataBrowser"&&$_GET['_action']!="export") {
                        $url_but = $this->_link('_=e&'.$key.'='.$_data[$key]);
                        if ($_GET['page_rows']!="") $url_but.="&page_rows=".$_GET['page_rows'];
                        if ($mod->can_edit) {
                                //id es el de la fitxa actual, srid i drid son els referenciats estatics o dinamics
                       //         print $div1."<a href=\"?app="._$_GET['app']."&mod=".$_GET['mod']."&_=e&id={$_data[$key]}&view=".$_GET['view']."\"><img src=\"".PATH_IMG_SMALL."/edit.gif\" alt=\"Editar\" title=\"Editar\" border=\"0\"></a>".$div2;
                                print $div1."<a href=\"".$url_but."\"><img src=\"".PATH_IMG_SMALL."/edit.png\" alt=\"Editar\" title=\"Editar\" border=\"0\"></a>".$div2;
                        }
                        if ($mod->can_download) {
                        print $div1."<a href=\"".$url_but."&_action=View\"><a src=\"".$link."\">-download</a>".$div2;
                        }
                        if ($mod->can_delete) {
                                print $div1."<a href=\"".$url_but."&_action=delete_confirm\" onClick=\"return true;\"><img src=\"".PATH_IMG_SMALL."/trash.png\" alt=\"{$delcmd}\" title=\"{$delcmd}\" border=\"0\"></a>".$div2;

                        }

                        } //  ($_GET['action']!="printDataBrowser") ajax calls

                        print "</table>";
                }
                print "</td>\n";
                print "</tr>\n";

                } else {
                        print "</div>";
                }
        }



        // allows to change the view of current module to one of the available views
        function _display_viewChanger() {
		$groups=explode(",",$_SESSION['user_groups']);
               
		$add="";
                $add.="`group`='' or `group` is null";
                if (! empty($groups)) {
                     foreach ($groups as $g) { $add.=" or `group`='{$g}'"; }
                }

		#$add="";foreach ($groups as $g) { $add.="`group`='{$g}' or "; } $add.="`group`='' or `group` is null or "; //substr($add,0,strlen($add)-4);
                

		if ($this->client_account["username"]=="admin"||$_SESSION['username']=='root') $add="1=1";
                $selectViews = "SELECT id,name from kms_sys_views where `type`='top' and `module`='".$_GET['mod']."' and (`app` is NULL or `app`='' or `app`='".$_GET['app']."') and ({$add}) order by name";
                $viewresult = $this->dbi->query($selectViews);
                $i=0;
		if (mysqli_num_rows($viewresult)>0) {
		$s = "<div id=\"viewChanger\" style='float:right;padding-top:1px'><select style=\"max-width:200px\" id=\"viewchange\" name=\"viewchange\" onChange=\"document.location='/?_=b&app=".$_GET['app']."&mod=".$_GET['mod']."&view=".$_GET['view']."&v2='+this.options[this.selectedIndex].value\">\n";
                $s .= "<option value='*' {$sel}>".constant("_MB_SHOWALL")."</option>";
                while ($view = $this->dbi->fetch_array($viewresult)) {
                        if ($_GET['v2']=="default"&&$loadview=="") $loadview=$view['id'];
                        $sel = ($_GET['v2']==$view['id'] ? "selected" : "");
                         if (substr($view['name'],0,4)=="_KMS") {
                                  $s .= "<option value='".$view['id']."' {$sel}>".constant($view['name'])."</option>";
                        } else {  $s .= "<option value='".$view['id']."' {$sel}>".$view['name']."</option>"; }
                                $i++;
                                //echo $view['name'];
                }

                $s .= "</select></div>";
		}
                if ($i==0) $s="";
                return $s;
        }


        // allows to change the view of current module to one of the available views
        function _display_views($mod) {
 //               if (!isset($_GET['view'])) $_GET['view']=0;
                $s = "<ul id=\"viewchange_left\">";
                $selectViews = "SELECT * from kms_sys_views where `type`='left' and `module`='".$mod."' and (`app` is NULL or `app`='' or `app`='".$_GET['app']."') order by sort_order asc";

                $viewresult = $this->dbi->query($selectViews);
                $i=0;
                //$s .= "<option value='*' {$sel}>".constant("_MB_SHOWALL")."</option>";
                while ($view = $this->dbi->fetch_array($viewresult)) {
                        if ($_GET['view']=="default"&&$loadview=="") $loadview=$view['id'];
                        $sel = ($_GET['view']==$view['id'] ? "class='selected'" : "");
                        $view_link="/?_=b&app=".$_GET['app']."&mod=".$mod."&view=".$view['id'];
                        if ($_GET['v2']!=""&&$_GET['v2']!="*") $view_link.="&v2=".$_GET['v2']; else $view_link.="&v2=".$view['default_view2'];

                         if (substr($view['name'],0,4)=="_KMS") {
                                  $s .= "<li value='".$view['id']."' {$sel}><a href='".$view_link."'>".constant($view['name'])."</a></li>";
                        } else {  $s .= "<li value='".$view['id']."' {$sel}><a href='".$view_link."'>".$view['name']."</a></li>"; }
                                $i++;
                                //echo $view['name'];
                }

                $s .= "</ul>";
                if ($i==0) $s="";
                return $s;
        }

        function _get_title($name) {
                if (constant($name)!="") {
                        $title=constant($name);
                } else {
                        $title=constant("_KMS_TY_".strtoupper($name));
                        if ($title=="") {
                                  $extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
                                  $title=getlang('_KMS_TY_'.strtoupper($name),$lang);
                        }
                        if ($title=="") $title=str_replace("_"," ",$name);
                }
		//titol de mods personalitzats catalegs
        	if (substr($_GET['mod'],0,4)=="cat_") {
                $sel="select name from kms_sys_mod where `type`='cat' and name='".substr($_GET['mod'],4)."'";
                $res=mysqli_query($this->dblinks['client'],$sel);
                $row=mysqli_fetch_array($res);
                $title=ucfirst($row['name']);
	        }


                return $title;
        }

	function editorTabs($tabs) {
		$this->editorTabs=$tabs;
	}

	function setPanel($panel_arr) {
		$this->panel = $panel_arr;
	}

        function draw_alert($alert) {
                print "<div class=\"alert\">";
                print "<table width=100% border=0><tbody><tr><td></td><td class='msg'>".$alert['msg']."</td><td></td></tr></tbody></table>";
                print $alert['add_html'];
                print "<br><br>";
                print "<input type=\"button\" class=\"delete\" value=\"".$alert['ok_label']."\" onclick=\"".$alert['ok_action']."\">";
                print "<input type=\"button\" value=\"".$alert['cancel_label']."\" onclick=\"".$alert['cancel_action']."\">";
                print "</div>";
	}
	
	function _draw_panel_table() {
		print "<div id=\"panel_table\">";
//		print "<div class=\"separator\"></div>";
		print "<div style=\"width:100%\">";
		print "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" class=\"LIST\">";
		print "<tbody><tr class=\"HDR\"><th width=\"30%\" class=\"HDR\">Param</th><th class=\"HDR\">Value</th></tr></tbody>\n";
		$i=0;
		foreach ($this->panel['infotable'] as $row=>$value) {
			$n=$i%2;
			print "<tr class=\"ROW_ ROW".$n."\"><td>$row</td><td>$value</td></tr>";
			$i++;
		}
		print "</table>";
		print "</div></div>";

	}

	function _draw_table_title($title) {
		if ($title=="") {
			if ($this->title!="") $title=$this->title; else $title=$this->_get_title($_GET['mod']);
		}
		return "<div class='panel_title'>".$title."</div>";
	}

	function _draw_panel($panel) {
		$class=$_GET['mod'];
		if ($_GET['action']!="") $class.=" ".$_GET['action'];
		$s="<div id='panel' class='".$class."'>";
		if (!$panel['hide_table_title']) $s.=$this->_draw_table_title($panel['title']);
		$s.= "<div class='panel_container' style='width:100%;height:".$panel['height']."'>";
		//text
		if ($panel['content']!="") $s.="<div class='content'>".$panel['content'];
		//buttons
		foreach ($panel['buttons'] as $button => $value) {
			if ($value[1]['target']=="") {
		 	$s.=$this->_draw_icon($value[1]['mod'],$value[1]['icon'],$value[1]['action']."&xid=".$_GET['xid']."&from=".$_GET['from']."&panelmod=".$value[1]['mod'],$value[0],"big","",$value[1]['info']);
			} else {
			$s.=$this->_draw_icon($value[1]['mod'],$value[1]['icon'],$value[1]['action'],$value[0],"big",$value[1]['target'],$value[1]['info']);
			}
		}
		if ($panel['content']!="") $s.="</div>";
		$s.="</div>";
		print $s;
		if ($_GET['panelmod']!=""||$panel['hide_databrowser']==false) $show_databrowser=true; else $show_databrowser=false;
		return $show_databrowser;
	}
}  // end class
?>
