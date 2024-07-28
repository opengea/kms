<?php
// Taskman - taskmanager

/**
 * dataDetailer shows details of a single record for viewing
 * and printing.
 */
class dataDetailer extends intergridKMS {

	var $value;
	var $table;
	var $key;

	function dataDetailer() {
    parent::intergridKMS();
	}

	function Main() {
		if (!$this->table) { $this->_error("No table defined.","You need to assign a table to the detailer."); }
		if (!$this->key) { $this->_error("No primary key defined.","You need to assign a primary key to the detailer."); }

		$detailer_data = array();
                $this->dbi->connect($this->dbname,$this->dbuser,$this->dbpass);
		$this->_field_setup();

		    if ($_GET[$this->key]) {
		      $this->value = $_GET[$this->key];
		    } elseif ($_POST[$this->key]) {
		      $this->value = $_POST[$this->key];
		    }
		$this->_value_setup();

		if (!$this->value) { $this->_error("No value defined.","You need to assign a record value to the detailer."); }

		$this->_var_setup();

		$this->sql = "SELECT {$this->edit_field_str} FROM `{$this->table}` ";
		$this->sql .= "WHERE `{$this->key}` = '{$this->value}' LIMIT 1";

		$this->result = $this->dbi->query($this->sql);
		$data	= $this->dbi->fetch_array($this->result);

		$this->_head("Visualitzant detalls {$this->value}",$this->default_content_type);

		if (!isset($this->detailer_template))  {
			print "<hr>";
			print "\n<table cellspacing=\"0\" cellpadding=\"3\" width=\"100%\" border=\"0\" class=\"LIST\">\n";
                }
		$i=0; $j=0;
		$this->meta = array();

		foreach ($this->edit_fields as $field) { // iterate through fields
			// set human readable field names
			$fname = $this->humans[$field]["name"] ? $this->humans[$field]["name"] : $this->_format_name($field);

				$i++; 
			        $bg = $i%2;
			if (!isset($this->detailer_template)) {
				print "<td class=\"ROW{$bg}\" width=\"20%\" valign=\"top\" align=\"right\" nowrap valign=\"top\">";
				print "<b>{$fname}</b>";
				if ($this->humans[$field]["desc"]) {
					print "<br><small>{$this->humans[$field]["desc"]}</small>";
				}
				print "</td>\n";
			        print "<td class=\"ROW{$bg}\" valign=\"top\">:</td>\n";
	      			$i++;
				$bg = $i%2;
				print "<td class=\"ROW{$bg}\" width=\"80%\" align=\"left\" valign=\"top\">";
				print $this->_output_filter($field,$data[$field]);
				print "&nbsp;</td>";
				print "</tr>\n";
			} else {
                                $detailer_data[$field] = $data[$field];
                        }

		}
	        if (!isset($this->detailer_template)) print "</table><hr>\n";

                include $this->detailer_template;
//		$this->_options();

		// comprova xrefs
		if ($this->xlist_ref_table) { // check for XLIST component
      		    $this->_xlist_display();
    		}
	//	$this->_customButtons();

		$this->_foot();
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

    print "<input  class=\"commonButton\" type=\"button\" value=\"Editar\" onClick=\"location.href='?_=e&{$this->key}={$this->value}&dr_folder=".$_GET['dr_folder']."'\" />\n";
		print "<input  class=\"commonButton\" type=\"button\" value=\"Imprimir\" onClick=\"javascript:print()\">\n";
    print "<input  class=\"commonButton\" type=\"button\" value=\"Cancel.lar\" onClick=\"location.href='?_=b&{$this->key}={$this->value}&dr_folder=".$_GET['dr_folder']."'\" />\n";
		print "</td></tr>\n";
		print "</table>\n";
	}

}

?>
