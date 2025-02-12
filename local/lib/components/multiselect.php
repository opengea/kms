<?php
/**
 *
 */
class multiselect {

    function multiselect($field,$params,&$dm) {
        $this->field = $field;
        $this->fixed = false;

	$this->query = $params["sql"];
        $this->xfield = $params["xfield"];
        $this->xkey = $params["xkey"];
	$this->xtable = $params["xtable"];
	$this->options = $params['options'];
	if ($this->query==""&&$this->xfield!="") $this->query="select {$this->xkey},{$this->xfield} from {$this->xtable}";
        $this->dm =& $dm;
//	$this->dm->multixref($field, $params['xkey'], $params['xfield'], $params['xtable']);
    }

    function output_filter($value) {
	// show field value (usualy in databrowser)
	if ($this->xkey==$this->xfield) return $value;

	$this->delimiter=",";
        $_arr = explode($this->delimiter,$value);
	$tmp = array();
	$i=0;
	foreach ($_arr as $key=>$value) {
		$f=$this->xfield;
		if ($f!="") {
		if (substr($f,0,6)!="CONCAT") $f="`{$f}`";
		include "/usr/local/kms/lib/dbi/openClientDB.php";include "/usr/local/kms/lib/dbi/dbconnect.php";
		$sql = "SELECT {$f} FROM `{$this->xtable}` WHERE `{$this->xkey}` = '{$value}'";
		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dblinks['client'];
		$result = mysqli_query($this->dm->dblinks['client'],$sql);
		$row  = mysqli_fetch_array($result);
		$val = constant($row[$this->xfield]); if ($val=="") $val = $row[$this->xfield];
		$tmp[] = $val; 
		if (substr($tmp[0],0,4)=="_KMS") $tmp[0]=constant($tmp[0]);

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
//	return str_replace(',','|',$data);
	//echo $data[1];exit;
//	 return @join($this->dm->delimiter,$data);
    }

    function search_filter($search_value,$queryop,$search_options) {
        if (!$this->multixrefstack[$data] && !empty($search_value)) {
            $sql = "SELECT {$this->xkey},{$this->xfield} FROM {$this->xtable} WHERE {$this->xfield} = '{$search_value}'";
            $result = $this->dm->dbi->query($sql);
            $row = $this->dm->dbi->fetch_array($result);
	   
        if ($queryop=="equal") {$queryop="=";$search_options['where']=$this->field." ".$queryop." '{$row['id']}'";}
        else {$search_options['where']=$this->field." ".$queryop." '%{$row['id']}%'";}
        return $search_options;
 
        //    $this->multixrefstack[$search_value] = $row[$this->xkey];
        }
        return $this->multixrefstack[$search_value];
    }

    function display_component($value) {
	$out="";
        $list_values = array();
        $list_shows = array();
	$this->dm->delimiter=",";
        //en cas que tinguem que omplir el multiselect de valors d'una bd    (parametre sql ha d'estar ple) 
        if ($this->query)  {
                $this->fixed = true;
		// assegurem-nos d'obrir la base de dades del client (podriem estar al webmail, per exemple)
   		//$this->dm->dbi->connect($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpasswd']);
                $results = $this->dm->dbi->query($this->query);
                $nrows  = $this->dm->dbi->num_rows($results);
                for ($i=0;$i<$nrows;$i++) {
                    $A  = $this->dm->dbi->fetch_array($results);
                        // value is a list so we explode it
	                 // per si a xfield tenim algo tipus "CONCAT(xx,' ',yy) as zz" agafem zz as real_field
	                 $real_field=$this->xfield;
                	 if (strpos($real_field," as ")>0) {
        	            $real_field=substr($real_field,strpos($real_field," as ")+4);
	                 }
			//$list_shows[$i] = $A[$this->xfield];
			$list_shows[$i] =$A[$real_field];
			$list_values[$i] = $A[$this->xkey];
                }
//	        $list = array_unique($list);
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

	
	$out="<script type=\"text/javascript\" src=\"/kms/lib/components/multiselect/js/ui.multiselect.js?k=".date('Ymdhi')."\"></script>";
	$out.="<script type=\"text/javascript\" src=\"/kms/lib/components/multiselect/js/plugins/localisation/jquery.localisation-min.js\"></script>";
	$out.="<link type=\"text/css\" href=\"/kms/lib/components/multiselect/css/ui.multiselect.css\" rel=\"stylesheet\" />";
        $out.= "<div id=\"multiselect_{$this->field}\" class=\"multiselect\" style='width:700px;min-height:200px'>";
//        $out.= "<div style=\"float:left\">\n";

	//remove any possible orphaned values 
	$value_ok=""; foreach ($currlist as $item) { if (in_array($item,$list_values)) $value_ok.=$item.",";    } $value_ok=substr($value_ok,0,strlen($value_ok)-1);


	$out.= "<input type=\"hidden\" name=\"{$this->field}\" id=\"{$this->field}\" value=\"{$value_ok}\">\n";
        $out.= "<select multiple multiple=\"multiple\" size=\"6\" width=\"120\" style=\"height:auto\" name=\"{$this->field}_select\" id=\"{$this->field}_select\">\n";
	$i=0;
	$sorted_sel=array();
        foreach ($list_values as $value) {
		$sel = (in_array($value,$currlist) ? "selected" : "");
		if ($list_shows) {
		 if (substr($list_shows[$i],0,5)=="_KMS_") $show=constant($list_shows[$i]); else $show=$list_shows[$i];
		} else {
			$show=$value;
		}

		if ($sel=="") $out.= "\t<option {$sel} value=\"{$value}\">{$show}</option>\n";
		else {
			$j = array_search($value, $currlist);
			$out2.=" $value:$j<br>";
			$sorted_sel[$j]="\t<option {$sel} value=\"{$value}\">{$show}</option>\n";
		}
		 $i++;
        }
	ksort($sorted_sel);
        $out=$out.implode("",$sorted_sel);
        $out.= "</select>\n";


	$out.= "<script type=\"text/javascript\">
$(function(){
  $.localise('ui-multiselect', {language: '".$_SESSION['lang']."', path: '/kms/lib/components/multiselect/js/locale/'});
  // var options_txt=$('select#{$this->field}_select').html();
  // $('#multiselect_{$this->field} select').append(options_txt);
  $(\"#multiselect_{$this->field}\").multiselect({sortable: true, searchable: true});
  $(\"#multiselect_{$this->field}\").bind('change', function() { $('input#{$this->field}').val(''); arrSel=[];$('#{$this->field}_select :selected').each(function(i,selected){arrSel[i]=$(selected).val(); }); $('input#{$this->field}').val(arrSel.toString()); });
}); 
</script>";
/*
        if (!$this->fixed) { 
            $out.= "<div style=\"float:left\" valign=\"top\">\n";
            $out.= "<input type=\"text\" name=\"{$this->field}_add\" id=\"{$this->field}_add\" size=\"32\"\"><br>";
            $out.= "<input type=\"button\" value=\""._MB_ADDTOLIST."\" ";
if ($this->query) {   $out.= "onClick=\"addItem(document.dm.elements['{$this->field}[]'],document.dm.{$this->field}_add.value,1,'');document.dm.{$this->field}_add.value='';\">\n"; } else  {
		$out.= "onClick=\"addItem(document.dm.elements['{$this->field}_select'],document.dm.{$this->field}_add.value,1,'{$this->field}');document.dm.{$this->field}_add.value='';\">\n";

		}
	    $out.= "<input type=\"button\" value=\""._MB_CLEARITEM."\" ";
if ($this->query) { 	    $out.= "onClick=\"removeOptionSelected('{$this->field}[]');$('#{$this->field}').val('');\"><br>"._CMN_CAUTIONMULTISELECT."\n";
} else  {
		$out.= "onClick=\"removeOptionSelected('{$this->field}_select');$('#{$this->field}').val('');\"><br>"._CMN_CAUTIONMULTISELECT."\n";
}
           $out.= "</div>\n";
	}
*/
        $out.= "</div>\n";
//	$out.= "</form>\n";

	return $out;
    }

}

?>
