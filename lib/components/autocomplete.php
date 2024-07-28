<?php
/**
 * required params:
 *
 * values (array) - array of options
 */


class autocomplete {

    function autocomplete($field,$params,&$dm) {

        $this->field = $field;
        $this->values = $params;
        $this->dm =& $dm;

        $this->xtable = $params["xtable"]; // cross table
        $this->xfield = $params["xfield"]; // cross field name (show)
        $this->xkey = $params["xkey"]; // key (value)
	$this->options = $params['options'];
	$this->xwhere = $params['where'];
	$this->required = $params["required"]; 

        include "/usr/local/kms/lib/dbi/openClientDB.php";
        include "/usr/local/kms/lib/dbi/dbconnect.php";
	$this->dblink = $link_clientdb;

    }

    function output_filter($value) {

                $sql = "SELECT {$this->xfield} FROM `{$this->xtable}` WHERE `{$this->xkey}` = '{$value}'";
                $result = mysqli_query($this->dblink,$sql);
                $row  = mysqli_fetch_array($result);
		return $row[0];
    }

    function search_filter($search_value,$queryop,$search_options) {
        $where_toAdd="";
        $query="";
        if (!in_array($this->xtable,$search_options['table_joins'])) {
                //left join 
                $query= " LEFT JOIN `{$this->xtable}` ON ";
                if (!is_array($search_options['table_joins'])) $search_options['table_joins']=array();
                array_push($search_options['table_joins'],$this->xtable);
                $multipleJOINS=true;
        }
        if (!in_array($this->xtable,$search_options['table_joins_on'])) {
                // add on condition
                $query .= "`{$this->xtable}`.{$this->xkey}=`{$this->dm->table}`.{$this->field}";
                if (!is_array($search_options['table_joins_on'])) $search_options['table_joins_on']=array();
                array_push($search_options['table_joins_on'],$this->xtable);
        }
        if (substr($this->xfield,0,6)!="CONCAT") {

                // add where
            if ($queryop=="LIKE") $where_toAdd .= " OR `{$this->xtable}`.{$this->xfield} {$queryop} \"%{$search_value}%\" ";
                             else $where_toAdd .= " OR `{$this->xtable}`.{$this->xfield} {$queryop} \"{$search_value}\" ";

                //search labels preparation 
                if ($queryop=="equal") $sel="select const from kms_sites_lang where ".$_SESSION['lang']."=\"{$search_value}\"";
                else $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"%{$search_value}%\"";

                $res=mysqli_query($this->dblink,$sel);
                $labels_arr=array();$ii=0;
                while ($labels_matched=mysqli_fetch_array($res)) { $labels_arr[$ii]=$labels_matched[0]; $ii++; }

                // add where multiple labels if any
                if (count($labels_arr)>0) {
                        foreach ($labels_arr as $label) {
                                if ($_GET['op']=="equal") $where_toAdd .= " OR `{$this->xtable}`.`{$this->xfield}`=\"".$label."\" "; else $where_toAdd .= " OR `{$this->xtable}`.`{$this->xfield}` LIKE \"%".$label."%\" ";
                        }
                }


        } else if (substr($this->xfield,0,6)=="CONCAT") {

                $clean=str_replace("CONCAT(","",$this->xfield);
                $clean=str_replace(")","",$clean);
                $clean=str_replace("'","",$clean);
                $clean=str_replace(" ","",$clean);
                $clean=str_replace(",,",",",$clean);
                $fields=explode(",",$clean);

                foreach ($fields as $fn => $field) {
                // add where
                if ($field=="/") break;
                if ($queryop=="LIKE") $where_toAdd .= " OR `{$this->xtable}`.{$field} {$queryop} \"%{$search_value}%\" ";
                             else $where_toAdd .= " OR `{$this->xtable}`.{$field} {$queryop} \"{$search_value}\" ";

                //search labels preparation 
                if ($queryop=="equal") $sel="select const from kms_sites_lang where ".$_SESSION['lang']."=\"{$search_value}\"";
                else $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"%{$search_value}%\"";
                $res=mysqli_query($this->dblink,$sel);
                $labels_arr=array();$ii=0;
                while ($labels_matched=mysqli_fetch_array($res)) { $labels_arr[$ii]=$labels_matched[0]; $ii++; }
                // add where multiple labels if any
                if (count($labels_arr)>0) {
                        foreach ($labels_arr as $label) {
                                if ($_GET['op']=="equal") $where_toAdd .= " OR `{$this->xtable}`.`{$field}`=\"".$label."\" "; else $where_toAdd .= " OR `{$this->xtable}`.`{$field}` LIKE \"%".$label."%\" ";
                        }
                }
                }
        }

        $search_options['query']=$query;
        $search_options['where']=$where_toAdd;
        return $search_options; //$query

    }

    function display_component($value,$add) {
//	$this->dm->fieldChange_events[$this->field];
//	if (is_array($this->dm->fieldChange_events[$this->field])) $add.=" onChange=\"javascript:".$this->dm->fieldChange_events[$this->field]['action']."\""; 
		$sql = "SELECT {$this->xfield} FROM `{$this->xtable}` WHERE `{$this->xkey}` = '{$value}'";
                $result = mysqli_query($this->dblink,$sql);
                $row  = mysqli_fetch_array($result);

	$helptip=constant(strtoupper("_".$this->dm->table."_".$this->field."_HT"));
	if ($this->required) $addrequired="required";
        $s = "<input type=\"text\" title=\"{$helptip}\" id=\"{$this->field}_autocomplete\" value=\"{$row[0]}\" {$addrequired} size=\"70\">\n";
	$s.= "<input type=\"hidden\" id=\"{$this->field}\" name=\"{$this->field}\"{$add} value=\"{$value}\">\n";
	$s.= "<script>

$(document).ready(function () {
    $('#{$this->field}_autocomplete').autocomplete({
        source: '/kms/lib/components/autocomplete/autocomplete.php?table={$this->xtable}&key={$this->xkey}&field={$this->xfield}&options={$this->options}&where={$this->xwhere}',
        minLength: 2,
        focus: function (event, ui) {
            event.preventDefault();
        },
        select: function (event, ui) {
           //event.preventDefault();
	   // $('#{$this->field}').val($('#{$this->field}_autocomplete').val());
		 $('#{$this->field}').val(ui.item.id);
        }
    });
});
</script>";

	if ($this->dm->comments[$this->field]!="") $s .="<span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span>\n";

	return $s;
    }

}

?>
