<?php
/**
 * multixref = multixref
 *
 */
class multixref {

    function multixref($field,$params,&$dm) {
        $this->field = $field;
	$this->query 	= $params["sql"];
        $this->xfield 	= $params["xfield"];
        $this->xkey 	= $params["xkey"];
	$this->xtable 	= $params["xtable"];
        $this->dm =& $dm;
    }

    function output_filter($value) {
	// show field value (usualy in databrowser)
	$this->delimiter=",";
        $_arr = explode($this->delimiter,$value);
	$tmp = array();
	foreach ($_arr as $key=>$value) {
		$f=$this->xfield;
		if (substr($f,0,6)!="CONCAT") $f="`{$f}`";
		$sql = "SELECT {$f} FROM `{$this->xtable}` WHERE `{$this->xkey}` = '{$value}'";
		if ($this->dblink) $dblink=$this->dblink; else $dblink=$this->dm->dblinks['client'];
		$result = mysqli_query($dblink,$sql);
		$row  = mysqli_fetch_array($result);
		$val = constant($row[$this->xfield]); if ($val=="") $val = $row[$this->xfield];
		$tmp[] = $val; 
		if (substr($tmp[0],0,4)=="_KMS") $tmp[0]=constant($tmp[0]);
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

	// returns sql query
/*        if (!empty($search_value)) {
		if ($queryop=="LIKE"&&$_GET['op']!="equal") {
			$query = "SELECT {$this->xkey},{$this->xfield} FROM {$this->xtable} WHERE {$this->xfield} LIKE '%".$search_value."%'";
		} else {
			$query = "SELECT {$this->xkey},{$this->xfield} FROM {$this->xtable} WHERE {$this->xfield} = '{$search_value}'";
		}
	    	return $query;
        }
        return false; */
	//if (is_array($this->multixrefs[$this->queryfield])) {
//echo "1";
         // multixrefs search
 //        $query = "SELECT {$this->xkey},{$this->xfield} FROM {$this->xtable} WHERE Exists (select {$this->xkey} from `{$this->xtable}` where `{$this->xtable}`.{$this->xkey}=`{$this->dm->table}`.{$this->field} AND {$this->xfield} {$queryop} \"{$search_value}\" limit 1)";

        // } else if (is_array($this->xvarr[$this->queryfield]['sql'])) {
//echo "2";
         // virtual fields search
//         $query= "SELECT {$this->xkey},{$this->xfield} FROM {$this->xtable} INNER JOIN (SELECT distinct {$this->xkey} FROM `{$this->xtable}` where {$this->xselectionfield} {$queryop} \"{$search_value}\") t ON `{$this->dm->table}`.{$this->field}=t.{$this->xkey}";



	//single field search  (potser el podrem eliminar... i fer ja directament el multiple)
	//$query= "SELECT * FROM {$this->dm->table} INNER JOIN (SELECT distinct {$this->xkey} FROM `{$this->xtable}` where {$this->xfield} {$queryop} \"{$search_value}\") t ON `{$this->dm->table}`.{$this->field} like CONCAT('%',t.{$this->xkey},'%')";
         //}


        // add LEFT JOIN conditions
	if (!in_array($this->xtable,$search_options['table_joins'])) {
		$query= " LEFT JOIN `{$this->xtable}` ON ";
		array_push($search_options['table_joins'],$this->xtable);
	}
        // add ON conditions
	if (!in_array($this->xtable,$search_options['table_joins_on'])) {
	    $query .= "`{$this->xtable}`.{$this->xfield} LIKE '%{$search_value}%' ";
            array_push($search_options['table_joins_on'],$this->xtable);
        }
        if (substr($this->xfield,0,6)!="CONCAT") {
            if ($queryop=="LIKE") $where_toAdd .= " OR `{$this->xtable}`.{$this->xfield} {$queryop} \"%{$search_value}%\" ";	
			     else $where_toAdd .= " OR `{$this->xtable}`.{$this->xfield} {$queryop} \"{$search_value}\" ";
        }

	$search_options['query']=$query;
	$search_options['where']=$where_toAdd;

	return $search_options; //$query
    }

    function display_component($value) {

	$out="";
        $list_values = array();
        $list_shows = array();
	$this->dm->delimiter=",";

        //en cas que tinguem que omplir el multixref de valors d'una bd    (parametre sql ha d'estar ple) 

	// assegurem-nos d'obrir la base de dades del client (podriem estar al webmail, per exemple)
        //$this->dm->dbi->connect($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpasswd']);

        if ($this->query=="") {
		$this->query="SELECT id,".$this->xfield." FROM ".$this->xtable;
	}

	$results = $this->dm->dbi->query($this->query);
	$nrows  = $this->dm->dbi->num_rows($results);
	for ($i=0;$i<$nrows;$i++) {
		$row  = $this->dm->dbi->fetch_array($results);
		// value is a list so we explode it
		$list_shows[$i] = $row[$this->xfield];
		$list_values[$i] = $row[$this->xkey];
	}
	$list_cnt = sizeof($list_shows);
	$currlist = explode($this->dm->delimiter,$value);

        $out= "<script language=\"javascript\">
		function getMultiple(ob)
		{
		//	alert(ob.al());
		arSelected =  Array();
		for (var i = 0; i < ob.options.length; i++) {
		    if (ob.options[i].selected) arSelected.push(ob.options[i].value);
		}
		 return arSelected.toString();
		}
                </script>";

        $out.= "<div class=\"multixref\">";
        $out.= "<div style=\"float:left\">\n";
	$out.= "<input type=\"hidden\" name=\"{$this->field}\" id=\"{$this->field}\" value=\"{$value}\">\n";
        $out.= "<select multiple multiple=\"multiple\" size=\"6\" width=\"120\" style=\"height:auto\" name=\"{$this->field}_select\" id=\"{$this->field}_select\" onchange=\"arrSel=[];$('#{$this->field}_select :selected').each(function(i,selected){arrSel[i]=$(selected).val();}); $('#{$this->field}').val(arrSel.toString());\">\n";
	$i=0;
        foreach ($list_values as $value) {
		 $sel = (@in_array($value,$currlist) ? "selected" : "");
		if ($list_shows) {
		 if (substr($list_shows[$i],0,5)=="_KMS_") $show=constant($list_shows[$i]); else $show=$list_shows[$i];
		} else {
			$show=$value;
		}
		 $out.= "\t<option {$sel} value=\"{$value}\">{$show}</option>\n";
		 $i++;
        }
        $out.= "</select>\n";
        $out.= "</div>\n";
        $out.= "<div style=\"float:left;font-size:11px;padding:5px\" valign='bottom'>"._KMS_FORMS_MULTISELECT_NOTE."</div>\n";
        $out.= "</div>\n";

	return $out;
    }

}

?>
