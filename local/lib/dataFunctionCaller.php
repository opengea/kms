<?php
// *********************************************************************************************
//
//      Intergrid KMS dataFunctionCaller Class
//
//      Intended use    : Interface for calling custom module functions 
//      Package version : 2.0
//      Last update     : 12/08/2011
//      Author          : Jordi Berenguer
//      Company         : Intergrid Tecnologies del coneixement SL
//      Country         : Catalonia
//      Email           : j.berenguer@intergrid.cat
//      Website         : www.intergrid.cat
//
// *********************************************************************************************

class dataFunctionCaller extends mod {

	var $value;
	var $table;
	var $key;

	function dataFunctionCaller($client_account) {
//            $this->client_account = $client_account;
//	    parent::mod($client_account);
	}

	function Main($mod) {

                // transfer mod propierties
                $this->mod=$mod;
                foreach (get_object_vars($mod) as $name => $value) $this->$name = $value;

                $dblink=$this->dbi->db_connect('client',$this->dbi);
		$this->_field_setup();
		if ($_REQUEST[$this->key]!="") {
			// Operation to a single RECORD 
			$this->value = $_REQUEST[$this->key];
			$this->_value_setup();
			$this->_var_setup();
			$this->sql = "SELECT {$this->edit_field_str} FROM `{$this->table}` ";
			$this->sql .= "WHERE `{$this->key}` = '{$this->value}' LIMIT 1";
			$this->result = $this->dbi->query($this->sql);
			$data	= $this->dbi->fetch_array($this->result);
		} else {
			// Global Operation 
		}

		if ($_SESSION['exec_mode']!="api") {
		$this->_head($mod,"Visualitzant detalls {$this->value}",$this->default_content_type);
                print "</td></tr></table>";
                print "<div id=\"kmsbody\">";
                $app=$this->_get_app();
		$mods=$this->_get_mods($app);
		if ($app['show_sidemenu']) $this->_render_leftmenu($app,$mods);
                print "<div id=\"contents\" class=\"contents\">"; 
                if ($app['show_sidemenu']) $this->_render_menuswitcher();
                print "<div id=\"application\" class=\"application ".$_GET['action']."\">";
		$show_databrowser=$this->_draw_panel($this->panel);
		if ($_GET['panelmod']!="") {
				print $this->_draw_table_title($this->_get_title($_GET['panelmod']));
				print  $this->_draw_buttons_bar($this,"dataFunctionCaller");
		}
		print "<div id=\"application_contents\">";
		}
		if ($_GET['action']=="")  $this->_error("","action parameter missing.");
		if ($this->actions[$_GET['action']]["url"]=="") $this->_error("","Action ".$_GET['action']." not defined in the module '".str_replace("kms_","",$mod->table)."'. Check your configuration.");

		include $this->actions[$_GET['action']]["url"];

		if ($_SESSION['exec_mode']!="api") {
			print "</div>"; //application_contents
			print "</div>"; //application
			print "</div>"; //contents
			print "</div>"; //kms_body 
		} else {
			return ($_SESSION['result']);
		}
	}

	function _customButtons() {

	if (isset($_GET['srid'])) $tmpid = $_GET['srid']; else $tmpid = $this->value;

	if (isset($this->custom_button1)) print "<br><input  class=\"commonButton\" type=\"button\" value=\"".$this->custom_button1."\" onClick=\"location.href='".$this->custom_action1."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button2)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button2."\" onClick=\"location.href='".$this->custom_action2."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button3)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button3."\" onClick=\"location.href='".$this->custom_action3."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button4)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button4."\" onClick=\"location.href='".$this->custom_action4."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
	 if (isset($this->custom_button5)) print "<input class=\"commonButton\"  type=\"button\" value=\"".$this->custom_button5."\" onClick=\"location.href='".$this->custom_action5."&id=".$tmpid."&query=".$tmpid."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['dr_folder']."&backid=".$_GET['id']."&srid=".$_GET['srid']."&drid=".$_GET['drid']."'\" />&nbsp;&nbsp;";
		

	}

	function _xlist_display() {
		// get list and print
		$sql = "SELECT {$this->xlist_ref_fields_str} FROM `{$this->xlist_ref_table}` ";
		$xvalue = $_GET[$this->xid];  // _format_field($xlist_value);   // hauriem d'extreure el valor de xlist_value q es el camp
		$sql .= "WHERE `{$this->xlist_ref_key}` = {$xvalue}";
		$result = $this->dbi->query($sql);
		$nrows = $this->dbi->num_rows($result);
	//echo $sql;	
		if ($nrows==0) return true; // do nothing
	
		$hdrs = array();
		$rows = array();
		for ($i=0;$i<$nrows;$i++) {
			$A = $this->dbi->fetch_array($result);
			$hdrs = $hdrs ? $hdrs : array_keys($A);
			$rows[] = $A;
		}

//    print "<h2>" . $this->_format_name($this->xlist_ref_table) . "</h2>\n";

		// S'HAURIA DE CRIDAR A DATABROWSER.. en comptes d'intentar simular un mini databrowser...
		// perque cal que es puguin definir Cross references (components) tambe a la taula referenciada....

		print "\n<table cellspacing=\"0\" cellpadding=\"2\" width=\"100%\" border=\"0\">\n";
		print "<tr>\n";
		foreach ($hdrs as $hdr) {
			print "<th class=\"HDR\">{$hdr}</th>";
		}
		print "\n</tr>\n";
		$j=0;
		foreach ($rows as $row) {
			$i++; $bg = $i%2;
			print "<tr>";
			foreach ($row as $data) {
					if (substr($hdrs[$j],0,3)=="dr_")  {
						$drid = $this->_format_field($data); //$data->$field;
						//	
						print "<td class=\"ROW{$bg}\">" . $this->_format_field($data) . "&nbsp;</td>";
						} else { print "<td class=\"ROW{$bg}\">" . $this->_format_field($data) . "&nbsp;</td>"; }
			}
			print "</tr>\n";
			$j++;
		}
		print "</table>\n";
		$var_tmp = $this->_format_name($this->xlist_ref_table);
//		print "<br><input type=\"button\" value=\"".$this->custom_button1."\" onClick=\"location.href='".strtolower(substr($var_tmp,4,strlen($var_tmp))).".php?_=e&id=".$this->value."&backto=".$_SERVER['PHP_SELF']."&backfolder=".$_GET['folder']."'\" />\n";


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

    print "<input  class=\"commonButton\" type=\"button\" value=\"Editar\" onClick=\"location.href='?mod=".$_GET['mod']."&_=e&{$this->key}={$this->value}&dr_folder=".$_GET['dr_folder']."'\" />\n";
		print "<input  class=\"commonButton\" type=\"button\" value=\"Imprimir\" onClick=\"javascript:print()\">\n";
    print "<input  class=\"commonButton\" type=\"button\" value=\"Cancel.lar\" onClick=\"location.href='?mod=".$_GET['mod']."&_=b&{$this->key}={$this->value}&dr_folder=".$_GET['dr_folder']."'\" />\n";
		print "</td></tr>\n";
		print "</table>\n";
	}

}

?>
