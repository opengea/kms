<?php
// *********************************************************************************************
//
//      Intergrid KMS dataDetailer Class
//
//	Intended use    : DataDetailer shows details of a single record for viewing and printing
//      Package version : 2.0
//      Last update     : 12/08/2011
//      Author          : Jordi Berenguer
//      Company         : Intergrid Tecnologies del coneixement SL
//      Country         : Catalonia
//      Email           : j.berenguer@intergrid.cat
//      Website         : www.intergrid.cat
//
// *********************************************************************************************

class dataDetailer extends mod {

	var $value;
	var $table;
	var $key;

	function dataDetailer($client_account) {
            $this->client_account = $client_account;
	    //parent::mod($client_account);
	}

        function Main($mod) { // render data manager

                $this->mod=$mod;

                // transfer mod propierties
                foreach (get_object_vars($mod) as $name => $value) {
                    $this->$name = $value;
                }

		if (!$this->table) { $this->_error("No table defined.","Data Detailer: You need to assign a table to this module."); }
		if (!$this->key) { $this->_error("No primary key defined.","You need to assign a primary key to this module."); }

		$this->_field_setup();

		    if ($_GET[$this->key]) {
		      $this->value = $_GET[$this->key];
		    } elseif ($_POST[$this->key]) {
		      $this->value = $_POST[$this->key];
		    }
		$this->_value_setup();

		if (!$this->value) { $this->_error("No value defined.","You need to pass a key value to this module."); }

		$this->_var_setup();

		$this->sql = "SELECT {$this->edit_field_str} FROM `{$this->table}` ";
		$this->sql .= "WHERE `{$this->key}` = '{$this->value}' LIMIT 1";

		$this->result = $this->dbi->query($this->sql);
		$data	= $this->dbi->fetch_array($this->result);

                $this->_head($mod,"Visualitzant detalls {$this->value}",$this->default_content_type);
                print "</td></tr></table>";
                print "<div id=\"kmsbody\">";
                $app=$this->_get_app();
                $mods=$this->_get_mods($app);
                $this->_render_leftmenu($app,$mods);

                print "<div id=\"contents\" class=\"contents\">";
                $this->_render_menuswitcher();
                print "<div id=\"application\" class=\"application\">";


		// load template from php file
		if (isset($_GET['tpl'])) { 
			$filename="/usr/share/kms/tpl/detailer/".$_GET['tpl'].".php";
			$filename="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/tpl/detailer/".$_GET['tpl'].".php";
			if (!file_exists($filename)) $this->_error("","Template $filename not found.");
			$fp = fopen($filename, "r");
			$template= fread($fp, filesize($filename));
		        ob_start();
		        eval(' ?'.'>'.$template.'<'.'?php ');
		        $template = ob_get_clean();
			fclose($fp);
		}	

		if ($template=="") echo "<hr>\n<table cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" border=\"0\" class=\"LIST\">\n";
		$i=0; $j=0;
		$this->meta = array();

		foreach ($this->edit_fields as $field) { // iterate through fields
			// set human readable field names
//			$fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : $this->_format_name($field);
                        // by default make humanize for all fields using predefined costants
                        $fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : constant(strToUpper("_".$this->table."_".$field));
			if ($fname == "") $fname = constant(strToUpper("_KMS_GL_".$field));
			$pvr = strpos("-".$field,"vr_");if ($pvr) $fname = constant(strToUpper("_KMS_GL_".strToUpper(substr($field,$pvr+2,strlen($field)))));
			if ($fname == "") $fname="<a style='color:#aaaaaa' title='Undefined ".strToUpper("_".$this->table."_".$field)."'>".$this->_format_name($field)."</a>";


			if ($template=="") {	
	                $i++;
                        $bg = $i%2;
			print "<td class=\"ROW{$bg}\" width=\"20%\" valign=\"top\" align=\"right\" nowrap valign=\"top\">";
			print "<b>{$fname}</b>";
			if ($this->humans[$field]["desc"]) print "<br><small>{$this->humans[$field]["desc"]}</small>";
			print "</td>\n";
		        print "<td class=\"ROW{$bg}\" valign=\"top\">:</td>\n";
      			$i++;
			$bg = $i%2;
			print "<td class=\"ROW{$bg}\" width=\"80%\" align=\"left\" valign=\"top\">" . $this->_output_filter($field,$data[$field]) . "&nbsp;</td>";
			print "</tr>\n";
			} else {
			$template=str_replace("[".$field."]",$data[$field],$template); //$this->_output_filter("upper",$data[$field]));
			
			if (substr($_GET['mod'],0,8)=="cat_cook") {
			$this->numpers=$data['persones'];
			 $template=str_replace('[upper:'.$field.']',$this->_output_filter("upper",$data[$field]),$template);
			 $template=str_replace('[ingredients:'.$field.']',$this->_output_filter("ingredients",$data[$field]),$template);
			 $template=str_replace('[list:'.$field.']',$this->_output_filter("list",$data[$field]),$template);
			 $template=str_replace('[titolelab:'.$field.']',$this->_output_filter("titolelab",$data[$field]),$template);
			 $template=str_replace('[season:'.$field.']',$this->_output_filter("seasontable",$data[$field]),$template);
			 $template=str_replace('[seasontrans:'.$field.']',$this->_output_filter("seasontrans",$data[$field]),$template);
			 $template=str_replace('[detail_coberts:'.$field.']',$this->_output_filter("detail_coberts",$data[$field]),$template);
			 $template=str_replace('[detail_degustar:'.$field.']',$this->_output_filter("detail_degustar",$data[$field]),$template);
			 $template=str_replace('['.$field.']',$this->_output_filter($field,$data[$field]),$template);			
			}
			}
	

		}

		//save to disk
		//$fp=fopen ("/var/www/vhosts/intergrid.cat/subdomains/code/httpdocs/recipe.html","w");
		$fp=fopen ("/tmp/".$data['num'].".html","w");
//		fwrite($fp, urldecode(str_replace("%3F","'",urlencode(utf8_decode($template)))));

		// eliminem elaboracions en blanc
		$template=str_replace("<TABLE WIDTH=680 BORDER=0 CELLPADDING=0 CELLSPACING=0><COL WIDTH=10><COL WIDTH=670><tr class=\"elab\"><td WIDTH=10></td><td WIDTH=670 class=\"title\" VALIGN=TOP><b></b></td></tr></TABLE><TABLE WIDTH=680 BORDER=0 CELLPADDING=0 CELLSPACING=0><COL WIDTH=10><COL WIDTH=670><tr><td WIDTH=10></td><td WIDTH=670><TABLE id=\"recipe\" width='665'><COL WIDTH=230><COL WIDTH=415><tr VALIGN=TOP><td class=\"ingredients\" align=\"top\"><table WIDTH=230 class=\"subingr\" cellspacing=\"0\" cellpadding=\"0\"><COL WIDTH=29><COL WIDTH=201><tr><td class='num' WIDTH=29><p align=right style='line-height:130%;padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'></p></td><td WIDTH=262 class='line-ingredient'><p style='line-height:130%;padding: 0cm;margin: 0cm;margin-right: 0.1cm;margin-bottom: 0.1cm'></p></td></tr></table></td><td valign=\"top\" class=\"description\"><ol style=\"padding-left:20px;margin-left:0px;padding-left: 0,10cm\">     </li></ol></td></tr></TABLE></td></tr></td></tr></TABLE>\n","",$template);

		$contentok= urldecode(str_replace("%92","'",urlencode($template)));
		$contentok= str_replace("N|2O","N&sup2;O",$contentok);	
		fwrite($fp,$contentok);

		if ($contentok=="") print "</table><hr>\n"; else print $contentok;
                $this->_options();
		
		fclose($fp);
		// comprova xrefs
		for ($i = 1; $i <= count($this->xlists); $i++) {	
      		    $this->_xlist_display($this->xlists[$i]);
    		}
		$this->_customButtons();
                print "</div>"; //application
                print "</div>"; //contents
                print "</div>"; //kms_body

	}

	function _customButtons() {

	if (isset($_GET['srid'])) $tmpid = $_GET['srid']; else $tmpid = $this->value;

	if (isset($this->custom_button1)) print "<br><input  class=\"commonButton\" type=\"button\" value=\"".$this->custom_button1."\" onClick=\"location.href='".$this->custom_action1."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button2)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button2."\" onClick=\"location.href='".$this->custom_action2."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button3)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button3."\" onClick=\"location.href='".$this->custom_action3."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button4)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button4."\" onClick=\"location.href='".$this->custom_action4."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button5)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button5."\" onClick=\"location.href='".$this->custom_action5."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
		

	}

        function _xlist_display($xlist) {
		$result = $this->dbi->query($xlist['query']);
		$nrows = $this->dbi->num_rows($result);
		 if ($nrows==0) return true; // do nothing
	                $hdrs = array();
                $rows = array();
                for ($i=0;$i<$nrows;$i++) {
                        $A = $this->dbi->fetch_array($result);
                        $hdrs = $hdrs ? $hdrs : array_keys($A);
                        $rows[] = $A;
                }
//		$mod = new mod..loadmod..
		if ($xlist['mod']=="") die('[dataDetailer] invalid xlist');

		$mod_tmp = & mod::getInstance(0,$xlist['mod'],$this->client_account);
//                $mod_tmp->dm->Main($mod_tmp);

                print "<h3>".$xlist['title']."</h3>";	

                print "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" class=\"LIST\">\n";
                $this->_draw_table_header($mod_tmp); 

/*	            print "\n<table cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" border=\"0\">\n";
                print "<tr>\n";
		$fields_show=array();
                foreach ($hdrs as $hdr) {
                        print "<th class=\"HDR\">{$hdr}</th>";
			array_push($fields_show,$hdr);
			
                }
                print "\n</tr>\n";
*/
                $j=0
		;
                foreach ($rows as $row) {
                        $i++; $bg = $i%2;
                        print "<tr>";
			$this->_draw_table_row($mod_tmp,$row,$i%2,"-");
/*
                        foreach ($row as $data) {
                                        if (substr($hdrs[$j],0,3)=="dr_")  {
                                                $drid = $this->_format_field($data); //$data->$field;
                                                //      
                                                print "<td class=\"ROW{$bg}\">" . $this->_format_field($data) . "&nbsp;</td>";
                                                } else { 	
						print "<td class=\"ROW{$bg}\">" . $this->_format_field($data) . "&nbsp;</td>"; 
						}
                        }
			*/
                        print "</tr>\n";
                        $j++;
                }
                print "</table>\n";

	}



  function _value_setup() {
    if ($_GET[$this->key]) {
      $this->value = $_GET[$this->key];
    } elseif ($_POST[$this->key]) {
      $this->value = $_POST[$this->key];
    }
  }

	function _options() {
		print "<table cellpadding=3 cellspacing=0 border=0 width=\"100%\">\n";
		print "<tr><td align=\"right\">";
//if ($this->xlist_ref_table) {  $var_tmp = $this->_format_name($this->xlist_ref_table); print "<input type=\"button\" value=\"".$this->edit_rfile."\" onClick=\"location.href='".strtolower(substr($var_tmp,4,strlen($var_tmp))).".php?_=e&id=".$this->value."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['folder']."'\" />\n"; }

    print "<input  class=\"commonButton\" type=\"button\" value=\"Editar\" onClick=\"location.href='?app=".$_GET['app']."&mod=".$_GET['mod']."&_=e&{$this->key}={$this->value}&dr_folder=".$_GET['dr_folder']."'\" />\n";
		print "<input  class=\"commonButton\" type=\"button\" value=\"Imprimir\" onClick=\"javascript:print()\">\n";
    print "<input  class=\"commonButton\" type=\"button\" value=\"Cancel.lar\" onClick=\"location.href='?app=".$_GET['app']."&mod=".$_GET['mod']."&_=b&{$this->key}={$this->value}&dr_folder=".$_GET['dr_folder']."'\" />\n";
		print "</td></tr>\n";
		print "</table>\n";
	}

}

?>
