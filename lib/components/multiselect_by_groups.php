<?php
/**
 *
 */
class multiselect_by_groups {

    function multiselect_by_groups($field,$params,&$dm) {
        $this->field = $field;
        $this->fixed = false;
	$this->query = $params["sql"];
        $this->xfield = $params["xfield"];
        $this->xkey = $params["xkey"];
	$this->xtable = $params["xtable"];
	$this->rule = $params['rule'];
	$this->options = $params['options'];
	$this->groupBy = $params['groupBy'];
	$this->familyNames = $params['familyNames'];
        $this->dm =& $dm;
//	$this->dm->multixref($field, $params['xkey'], $params['xfield'], $params['xtable']);
    }

    function output_filter($value) {
	// show field value (usualy in databrowser)
	if ($this->xkey==$this->xfield) return $value;
        $extranet=true;
        include "/usr/share/kms/lib/app/sites/getlang.php";
	$this->delimiter=",";
        $_arr = explode($this->delimiter,$value);
	$tmp = array();
	$i=0;
	foreach ($_arr as $key=>$value) {
		$f=$this->xfield;
		if ($f!="") {
		if (substr($f,0,6)!="CONCAT") $f="`{$f}`";
		$sql = "SELECT {$f} FROM `{$this->xtable}` WHERE `{$this->xkey}` = '{$value}'";
		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];
		$result = mysqli_query($dblink,$sql);
		$row  = mysqli_fetch_array($result);
		$val = constant($row[$this->xfield]); if ($val=="") $val = $row[$this->xfield];
		//$tmp[] = $val; 
		//if (substr($tmp[0],0,4)=="_KMS") $tmp[0]=constant($tmp[0]);
		//if (substr($tmp[0],0,1)=="_") $tmp[0]=$lang[$tmp[0]];
		$tmp[$i]=$val;
		if (substr($tmp[$i],0,1)=="_") $tmp[$i]=$lang[$tmp[$i]];

		} else $tmp[$i]=$value;
		$i++;
	}
        $return = @join(", ",$tmp);
	return $return;
    }

    function input_filter($data) {	
	// reads the value from the form to be inserted or updated in database
	//echo gettype($data);
	return $data;
    }

    function display_component($value) {
	$out="";
        $list_values = array();
        $list_shows = array();
	$this->dm->delimiter=",";
        //en cas que tinguem que omplir el multiselect de valors d'una bd    (parametre sql ha d'estar ple) 
        if ($this->query)  {
	        $extranet=true;
	        include "/usr/share/kms/lib/app/sites/getlang.php";
                $this->fixed = true;
                $results = $this->dm->dbi->query($this->query);
                $nrows = $this->dm->dbi->num_rows($results);
        	for ($i=0;$i<$nrows;$i++) {
                    $A  = $this->dm->dbi->fetch_array($results);

	                 $real_field=$this->xfield;
                	 if (strpos($real_field," as ")>0) {
        	            $real_field=substr($real_field,strpos($real_field," as ")+4);
	                 }
			$list_shows[$i] = $A[$this->xfield];

			$list_shows[$i] =$A[$real_field];
			$list_values[$i]['family'] = $A[$this->groupBy];
			$list_values[$i]['id'] = $A[$this->xkey];
			$list_values[$i]['name'] = $A[$real_field];
	
			if (substr($list_shows[$i],0,1)=="_") $list_shows[$i]=$lang[$list_shows[$i]];
                }
			// new list and families
			$new_list = array();
			foreach ($list_values as $key => $itemvalue) {
				$optgroup = $itemvalue['family'];
				$selectvalue = $itemvalue['id'];
				$name = $itemvalue['name'];
				
				$new_list[$optgroup][$key][0] = $selectvalue;
				$new_list[$optgroup][$key][1] = $name;

				}
				ksort($new_list,SORT_NUMERIC);

		#$list = array_unique($list);
	        $list_cnt = sizeof($list_shows);
                $currlist = explode($this->dm->delimiter,$value);
        } else { 
		// no base de dades, llista que treu del mateix camp
	        $sql = "SELECT DISTINCT `{$this->field}` FROM `{$this->dm->table}` ";
	        $sql .= "ORDER BY `{$this->field}`";
	        $result = $this->dm->dbi->query($sql);
	        $nrows  = $this->dm->dbi->num_rows($result);

	        for ($i=0;$i<$nrows;$i++) {
	            $A	= $this->dm->dbi->fetch_array($result);
	            if (strstr($A[$this->field],$this->dm->delimiter)) {
	                // value is a list so we explode it
	                $_arr = explode($this->dm->delimiter,$A[$this->field]);
	                foreach ($_arr as $_item) {
	                    $list[] = $_item;
	                }
	            }
	            elseif (!empty($A[$this->field])) {
	                $list[] = $A[$this->field];
	            }
	        }
        $list_values =  array_unique($list);
        $list_cnt = sizeof($list);
	$currlist = explode($this->dm->delimiter,$value);
	}

	//de la configuracio de la base de dades
	if ($this->options!="") { $list_values=explode(',',$this->options); $list_cnt = count($list_values); }

	$out.="<link rel=\"stylesheet\" href=\"/kms/lib/components/multiselect_by_group/chosen.css\" type=\"text/css\"/>";
	$out.="<script type=\"text/javascript\" src=\"/kms/lib/components/multiselect_by_group/chosen.jquery.js?k=".date('Ymdhi')."\"></script>";
        $out.= "<div id=\"multiselect_chosen_{$this->field}\" class=\"multiselect_chosen\" style='width:815px;min-height:275px'>";
	$out.= "<input type=\"hidden\" name=\"{$this->field}\" id=\"{$this->field}\" value=\"{$value}\">\n";
	$out.="<select name=\"{$this->field}_select\" id=\"{$this->field}_select\" multiple=\"multiple\" data-placeholder=\"Clic per seleccionar articles\" style=\"width:100%;height:auto\">\n";

	$families = explode(',',$this->familyNames);
	$families = array_values($families);

	foreach ($new_list as $family_id => $item): 
		$family_name = $families[$family_id];
                $out.= "<optgroup label=\"".$family_name."\">";
                    foreach ($item as $item_name):
			$sel = (in_array($item_name[0],$currlist) ? "selected" : "");
                        $out.= "<option value=\"$item_name[0]\"".$sel.">".$item_name[1]."</option>";
                    endforeach;
                $out.= "</optgroup>";
            endforeach;
	$out.="</select>";

	/*
	$i=0;
	$sorted_sel=array();
        foreach ($list_values as $familyValue) {
		
		list($family, $value) = explode(",",$familyValue, 2);		
		
		$sel = (in_array($value,$currlist) ? "selected" : "");
		if ($list_shows) {
		 if (substr($list_shows[$i],0,5)=="_KMS_") $show=constant($list_shows[$i]); else $show=$list_shows[$i];
		} else {
			$show=$value;
		}

		if ($sel=="") $out.= "\t<option {$sel} value=\"{$value}\">{$family} | {$show}</option>\n";
		else {
			$j = array_search($value, $currlist);
			$out2.=" $value:$j<br>";
			$sorted_sel[$j]="\t<option {$sel} value=\"{$value}\">{$family} - {$show}</option>\n";
		}
		 $i++;
        }
	ksort($sorted_sel);
        $out=$out.implode("",$sorted_sel);
	*/
        $out.= "</select>\n";
        $out.= "</div>\n";
	
	
	$out.="
	<script type=\"text/javascript\">
	var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, sense resultats'},
      '.chosen-select-width'     : {width:\"100%\"}
    	}
	    for (var selector in config) {
	      $('#{$this->field}_select').chosen(config[selector]);
	    }
	 $(\"#multiselect_chosen_{$this->field}\").bind('change', function() { $('input#{$this->field}').val(''); arrSel=[];$('#{$this->field}_select :selected').each(function(i,selected){arrSel[i]=$(selected).val(); }); $('input#{$this->field}').val(arrSel.toString()); });
	</script>
	";
	
	return $out;
    }

}

?>
