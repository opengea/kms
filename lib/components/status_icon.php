<?php

class status_icon {

    function status_icon($field,$params,&$dm) {
	$this->class="status_icon";
        $this->field = $field;
	$this->path = $params['path'];
        $this->script = $params['script'];
	$this->orderby = $params['orderby'];
	$this->show_label = $params['show_label'];
	$this->data = $params['data'];
	if ($this->path=="") $this->path="status_icon/";


	//require "status_icon/{$type}.php";
	//$this->res=_set_fields($dm);
	$this->dm=& $dm;
	//print_r($dm->fields);exit;
    }

    function output_filter($data,$id) {
	//connexions: $this->dm->dblinks
       include "{$this->path}{$this->script}.php";
//	   echo output_status_filter($id);
	return $out;
    }

    function search_filter($search_value,$queryop,$search_options) {
//echo $this->field." ".$queryop." '%{$search_value}%'";

        $where_toAdd="";
        $query="";

/*
       if (!in_array($this->xcomboarr[$this->field]["xtable"],$search_options['table_joins'])) {
                //left join 
                $query= " LEFT JOIN `{$this->xcomboarr[$this->field]['xtable']}` ON ";
                if (!is_array($search_options['table_joins'])) $search_options['table_joins']=array();
                array_push($search_options['table_joins'],$this->xcomboarr[$this->field]['xtable']);
                $multipleJOINS=true;
        }
        if (!in_array($this->xcomboarr[$this->field]["xtable"],$search_options['table_joins_on'])) {
                // add on condition
                $query .= "`{$this->xcomboarr[$this->field]['xtable']}`.{$this->xcomboarr[$this->field]['xkey']}=`{$this->dm->table}`.{$this->field}";
                if (!is_array($search_options['table_joins_on'])) $search_options['table_joins_on']=array();
                array_push($search_options['table_joins_on'],$this->xcomboarr[$this->field]['xtable']);
        }
        if (substr($this->xcomboarr[$this->field]['xfield'],0,6)!="CONCAT") {

                // add where
            if ($queryop=="LIKE") $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.{$this->xcomboarr[$this->field]['xfield']} {$queryop} \"%{$search_value}%\" ";
                             else $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.{$this->xcomboarr[$this->field]['xfield']} {$queryop} \"{$search_value}\" ";

                //search labels preparation 
                if ($queryop=="equal") $sel="select const from kms_sites_lang where ".$_SESSION['lang']."=\"{$search_value}\"";
                else $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"%{$search_value}%\"";

                $res=mysqli_query($this->dblink,$sel);
                $labels_arr=array();$ii=0;
                while ($labels_matched=mysqli_fetch_array($res)) { $labels_arr[$ii]=$labels_matched[0]; $ii++; }

                // add where multiple labels if any
                if (count($labels_arr)>0) {
                        foreach ($labels_arr as $label) {
                                if ($_GET['op']=="equal") $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.`{$this->xcomboarr[$this->field]['xfield']}`=\"".$label."\" "; else $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.`{$this->xcomboarr[$this->field]['xfield']}` LIKE \"%".$label."%\" ";
                        }
                }


        } else if (substr($this->xcomboarr[$this->field]['xfield'],0,6)=="CONCAT") {

                $clean=str_replace("CONCAT(","",$this->xcomboarr[$this->field]['xfield']);
                $clean=str_replace(")","",$clean);
                $clean=str_replace("'","",$clean);
                $clean=str_replace(" ","",$clean);
                $clean=str_replace(",,",",",$clean);
                $fields=explode(",",$clean);

                foreach ($fields as $fn => $field) {
                // add where
                if ($field=="/") break;
                if ($queryop=="LIKE") $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.{$field} {$queryop} \"%{$search_value}%\" ";
                             else $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.{$field} {$queryop} \"{$search_value}\" ";

                //search labels preparation 
                if ($queryop=="equal") $sel="select const from kms_sites_lang where ".$_SESSION['lang']."=\"{$search_value}\"";
                else $sel="select const from kms_sites_lang where ".$_SESSION['lang']." like \"%{$search_value}%\"";
                $res=mysqli_query($this->dblink,$sel);
                $labels_arr=array();$ii=0;
                while ($labels_matched=mysqli_fetch_array($res)) { $labels_arr[$ii]=$labels_matched[0]; $ii++; }
                // add where multiple labels if any
                if (count($labels_arr)>0) {
                        foreach ($labels_arr as $label) {
                                if ($_GET['op']=="equal") $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.`{$field}`=\"".$label."\" "; else $where_toAdd .= " OR `{$this->xcomboarr[$this->field]['xtable']}`.`{$field}` LIKE \"%".$label."%\" ";
                        }
                }
                }
        }
*/
        $search_options['query']=$query;
        $search_options['where']=$where_toAdd;
        return $search_options; //$query

    }


    function input_filter($data) {
            return $data;
    }

    function display_component($value) {
            //print "<input type=\"text\" name=\"{$this->field}\" value=\"{$value}\" />\n";
	    $value=str_replace("<",htmlentities("<"),$value);
	    $value=str_replace(">",htmlentities(">"),$value);
            return $value;
    }


}

?>
