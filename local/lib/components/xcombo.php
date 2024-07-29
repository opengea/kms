<?php
/**
 * required params:
 *
 * values (array) - array of options
 */

class xcombo {

    function xcombo($field,$params,&$dm) {
        $this->field = $field;
        $this->values = $params;
        $this->dm =& $dm;
        $this->xcomboarr[$field]["xtable"] = $params["xtable"]; // cross table
        $this->xcomboarr[$field]["xfield"] = $params["xfield"]; // cross field name (show)
	$this->xcomboarr[$field]["xkey"] = $params["xkey"]; // key (value)
        $this->xcomboarr[$field]["readonly"] = $params["readonly"]; // readonly 
	$this->xcomboarr[$field]["notnull"] = $params["notnull"]; // don't allow blank/null value in combo
        $this->xcomboarr[$field]["linkcreate"] = $params["linkcreate"]; // small icon to go to the selected record (optional)
        $this->xcomboarr[$field]["linkedit"] = $params["linkedit"]; // small icon to edit the selected record (optional)
	$this->xcomboarr[$field]["sql"] = $params["sql"]; // custom select sql (optional)
	$this->xcomboarr[$field]["open"] = $params["open"]; // if we can add new values to the combo
	$this->xcomboarr[$field]["orderby"] = $params["orderby"];
	$this->xcomboarr[$field]["defvalue"] = $params["defvalue"];
	$this->xcomboarr[$field]["results"] = $params["results"]; // array with results
	$this->xcomboarr[$field]["where"] = $params['where']; //optional where
/*	$this->xtable = $params["xtable"];
	$this->xfield= $params["xfield"];
	$this->xkey = $params["xfield"];
	$this->readonly= $params["readonly"];
	$this->notnull= $params["notnull"]; 
	$this->linkcreate= $params["linkcreate"];
	$this->linkedit= $params["linkedit"]; 
	$this->sql= $params["sql"];
	$this->open= $params["open"];
	$this->orderby = $params["orderby"];
	$this->defvalue = $params["defvalue"];
	$this->results = $params["results"];
*/
        include "/usr/local/kms/lib/dbi/openClientDB.php";
        include "/usr/local/kms/lib/dbi/dbconnect.php";
        $this->dblink = $link_clientdb;

    }

    function output_filter($value,$id) {
/*	//include "/usr/local/kms/lib/dbi/openClientDB.php";
        //include "/usr/local/kms/lib/dbi/dbconnect.php";
         include_once("/usr/share/kms/lib/app/sites/getlang.php");
	if (substr($data,0,4)=="_KMS") $data=substr(constant($data),0,100); else if (substr($data,0,1)=="_") $data=$lang[$data];
        return $data;*/
	$extranet=true;
        include_once "/usr/share/kms/lib/app/sites/getlang.php"; 
        // show field value (usualy in databrowser)
        $this->delimiter=",";
        $_arr = explode($this->delimiter,$value);
        $tmp = array();
        foreach ($_arr as $key=>$value) {
                $f=$this->xcomboarr[$this->field]['xfield'];
                if (substr($f,0,6)!="CONCAT") $f="`{$f}`";
                $sql = "SELECT {$f} FROM `{$this->xcomboarr[$this->field]['xtable']}` WHERE `{$this->xcomboarr[$this->field]['xkey']}` = '{$value}'";
                $result = mysqli_query($this->dblink,$sql);
                $row  = mysqli_fetch_array($result);
		// per si a xfield tenim algo tipus "CONCAT(xx,' ',yy) as zz" agafem zz as real_field
                $real_field=$this->xcomboarr[$this->field]["xfield"];
                    if (strpos($real_field," as ")>0) {
                    $real_field=substr($real_field,strpos($real_field," as ")+4);
                }
                $val = constant($row[$real_field]); if ($val=="") $val = $row[$real_field];
                $tmp[] = $val;
                if (substr($tmp[0],0,4)=="_KMS") $tmp[0]=constant($tmp[0]);
		else if (substr($tmp[0],0,1)=="_") { 
				$translated=$lang[$tmp[0]];
				if ($translated!="") $tmp[0]=$translated;
		}
        }
	if ($this->xcomboarr[$this->field]['sql']!="") {
		// sql custom query---------------------------------------
           $this->xcomboarr[$this->field]['sql']= str_replace(" where "," WHERE ",$this->xcomboarr[$this->field]['sql']);
           $query_selected=$this->xcomboarr[$this->field]['sql'];
           //substitucio de variables. Permet fer un select in posar una variable q correspon a un camp
                if (strpos($this->xcomboarr[$this->field]['sql'],"INNER JOIN")) {
                        $query_selected = $this->xcomboarr[$this->field]['sql'];
                } else if (strpos($this->xcomboarr[$this->field]['sql'],"WHERE")) {
                        $query_selected = str_replace("WHERE","WHERE ".$this->xcomboarr[$this->field]["xkey"]."='".$value."' AND",$this->xcomboarr[$this->field]['sql']);
                } else {
                        $query_selected = $query_selected." WHERE ".$this->xcomboarr[$this->field]["xtable"].".".$this->xcomboarr[$this->field]["xkey"]."='".$value."'";
                }
		$result = mysqli_query($this->dblink,$query_selected);	
		$row  = mysqli_fetch_array($result);
		return $row[1];
	}
        $return = @join(", ",$tmp);


		$valor=$return;
                //el valor potser conte etiquetes d'idioma, mirem de traduirles
		if (substr($valor,0,1)=="_") {
                $pl=strpos($valor,"_");
                if ($pl) { $label=substr($valor,$pl);
                          $ll=strpos($label," ");
                          if ($ll==0) $ll=strlen($label); else $label=substr($valor,0,strpos($label," "));
                          $translated=$lang[$label];
                          $valor=str_replace($label,$translated,$valor);
			   $return=$label;
                        }
		}

        return $return;

    }

    function search_filter($search_value,$queryop,$search_options) {

        $where_toAdd="";
	$query="";
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

        $search_options['query']=$query;
        $search_options['where']=$where_toAdd;
     	return $search_options; //$query

    }

    function display_component($value,$add) {
	if ($this->xcomboarr[$this->field]["readonly"]) $disabled="disabled"; else $disabled="";
	if (in_array($this->field,$this->dm->readonly)) $disabled="disabled"; else $disabled="";

        $helptip=constant(strtoupper("_".$this->dm->table."_".$this->field."_HT"));
	$this->dm->fieldChange_events[$this->field];
        if (is_array($this->dm->fieldChange_events[$this->field])) $add.=" onChange=\"javascript:".$this->dm->fieldChange_events[$this->field]['action']."\"";	
	$s="";

        //interesting trick, we set the field with the query value when we add a record 
        if ($_GET['_']=='i'&&$value==""&&$_GET['queryfield']==$this->field) $value=$_GET['query'];

	if ($disabled=="disabled") $s.="<input type='hidden' name=\"{$this->field}\" value=\"{$value}\">";

        $s.= "<div class='xcombo' style='float:left'><select $disabled title=\"{$helptip}\" id=\"{$this->field}\" name=\"{$this->field}\"{$add}>";
	if ($this->xcomboarr[$this->field]["results"]!="") {
	// primer mostrem el seleccionat, default -------------------------------------------------------------
        if ($this->xcomboarr[$this->field]["notnull"]==false) $s.= "<option value=''></option>";

	 // simply populate =========================================================================================
		for ($i=0;$i<count($this->xcomboarr[$this->field]["results"]);$i++) {
			if ($this->xcomboarr[$this->field]["results"][$i][0]==$value) $addsel="selected"; else $addsel="";
			$s .= "<option value='".$this->xcomboarr[$this->field]["results"][$i][0]."' {$addsel}>".substr(strip_tags($this->xcomboarr[$this->field]["results"][$i][1]),0,100)."</option>";
		}
	} else {
	   // database query =======================================================================================
           include "/usr/local/kms/lib/dbi/openClientDB.php";
           include "/usr/local/kms/lib/dbi/dbconnect.php";
	   $extranet=true;
	   include "/usr/share/kms/lib/app/sites/getlang.php"; //no fer include_once!
	   if ($this->xcomboarr[$this->field]['sql']=="") {
   //normal-------------------------------------------------
   $query_selected = "SELECT id,".$this->xcomboarr[$this->field]["xfield"] ." FROM ".$this->xcomboarr[$this->field]["xtable"]." WHERE ".$this->xcomboarr[$this->field]["xkey"]."='$value'";
   $query_all = "SELECT DISTINCT ".$this->xcomboarr[$this->field]["xkey"] .",".$this->xcomboarr[$this->field]["xfield"]." FROM ".$this->xcomboarr[$this->field]["xtable"];
if ($this->xcomboarr[$this->field]["where"]!="") $query_all=$query_all." WHERE ".$this->xcomboarr[$this->field]["where"];
//echo $query_all;
   if ($this->xcomboarr[$this->field]["orderby"]=="") $query_all.=" ORDER BY ".$this->xcomboarr[$this->field]["xfield"]." ASC";
   	} else  {
   // sql custom query---------------------------------------
   $this->xcomboarr[$this->field]['sql']= str_replace(" where "," WHERE ",$this->xcomboarr[$this->field]['sql']);
   $query_selected=$this->xcomboarr[$this->field]['sql'];
   //substitucio de variables. Permet fer un select in posar una variable q correspon a un camp
   foreach ($this->dm->fields as $field) {
	      $query_selected=str_replace ("[".$field."]",$value,$query_selected);
   }
   $query_all=$query_selected;
   if ($value!="") {
	if (strpos($this->xcomboarr[$this->field]['sql'],"INNER JOIN")) {
		$query_selected = $this->xcomboarr[$this->field]['sql'];
	} else if (strpos($this->xcomboarr[$this->field]['sql'],"WHERE")) {
		$query_selected = str_replace("WHERE","WHERE ".$this->xcomboarr[$this->field]["xkey"]."='".$value."' AND",$this->xcomboarr[$this->field]['sql']);
	} else {
		$query_selected = $query_selected." WHERE ".$this->xcomboarr[$this->field]["xtable"].".".$this->xcomboarr[$this->field]["xkey"]."='".$value."'";
	}
   }
   }
// MOSTREM VALOR DEL ITEM SELECCIONAT
if ($value!="") {
  $result = mysqli_query($this->dblink,$query_selected);
  if (!$result) {  echo "ERROR 1:".$query_selected;   exit; }
  $row = mysqli_fetch_array($result);

  $_val=$row[$this->xcomboarr[$this->field]["xfield"]];
  if (substr($_val,0,4)=="_KMS") $_val=substr(constant($_val),0,100); else if (substr($_val,0,1)=="_") $_val=$lang[$_val];
  $row[$this->xcomboarr[$this->field]["xfield"]]=$_val;
//          $s .= substr($row[$this->xcomboarr[$this->field]["xfield"]],0,100)."</option>";
  $okval=$lang[$row[1]]; if ($okval=="") $okval=constant($row[1]); if ($okval=="") $okval=$row[1];
  $s .= $encoding.substr(strip_tags($okval),0,100)."</option>";
}
if ($this->xcomboarr[$this->field]["notnull"]==false) $s.= "<option value=''></option>";
// A CONTINUACIO MOSTREM LA RESTA DE RESULTATS
if (isset($query_all)) {
if ($this->xcomboarr[$this->field]["orderby"]!="") $query_all.=" ORDER BY ".$this->xcomboarr[$this->field]["orderby"];
$result = mysqli_query($this->dblink,$query_all);
	if (!$result) {    echo "ERROR 2:".$query_all;   exit; }
	while($row = mysqli_fetch_array($result)){
	    // per si a xfield tenim algo tipus "CONCAT(xx,' ',yy) as zz" agafem zz as real_field
	    $real_field=$this->xcomboarr[$this->field]["xfield"];
	    if (strpos($real_field," as ")>0) $real_field=substr($real_field,strpos($real_field," as ")+4);

	    if (getlang(strip_tags($row[$real_field]),$lang)!="") {
		$valor=$encoding.substr(getlang(strip_tags($row[$real_field]),$lang),0,100);
	    } else {
		$valor=$row[$real_field];
	    }
	    $key=$row[$this->xcomboarr[$this->field]["xkey"]];
	    if ($valor=="") { $valor=$row[1]; $key=$row[0]; }
// --------
	//el valor potser conte etiquetes d'idioma, mirem de traduirles
/*	$pl=strpos($valor,"_");
	if ($pl) { $label=substr($valor,$pl); 
		  $ll=strpos($label," ");
		  if ($ll==0) $ll=strlen($label); else $label=substr($valor,0,strpos($label," "));
		  $translated=$lang[$label];
		  $valor=str_replace($label,$translated,$valor);
		}
*/
//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125') echo $valor."<br>";
	    if (substr($row[1],0,4)=="_KMS") $row[1]=substr(constant($row[1]),0,100); else if (substr($row[1],0,1)=="_") $row[1]=$lang[$row[1]];
	    if ($key==$value) $addsel="selected"; else $addsel="";
	    if ($valor!="")  $s .= "<option value=\"".$key."\" {$addsel}>".$valor."</option>";
	}
}

} // if db


$s .= "</select></div>";

if ($this->xcomboarr[$this->field]["linkcreate"]) $s .= "<div class='ico16' style='padding-top:5px;padding-left:3px'><a href=\"?app=".$_GET['app']."&mod=".substr($this->xcomboarr[$this->field]["xtable"],4)."&_=i\" target=\"kms_add\" title=\""._KMS_GL_ADD_RECORD."\"><img src=\"kms/css/aqua/img/small/plus.png\"></a></div>";
if ($this->xcomboarr[$this->field]["linkedit"]) $s .= " <div class='ico16' style='padding-top:4px;'><a href=\"?app=".$_GET['app']."&mod=".substr($this->xcomboarr[$this->field]["xtable"],4)."&_=e&id=".$value."\" target=\"kms_add\" title=\""._LINKEDIT."\"><img src=\"kms/css/aqua/img/small/edit.png\"></a></div>";
if ($this->dm->comments[$this->field]!="") $s .="<div class='comment' style='float:left;padding-left:5px;padding-top:8px'><span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span></div>\n";
//---

/*                              print "<div style=\"float:left\">";
			print "<input type=\"hidden\" id=\"{$name}\" name=\"{$name}\" value=\"{$value}\" />\n";
			print "<select id=\"{$name}_xcombosql\" onchange=\"$('#".$name."').val($('#{$name}_xcombosql').val());\">";
                                print "<option value=''></option>";
                                 $result = mysqli_query($this->dblinkm$query_selected);

                                 if ($result) {
                                        while($row = mysqli_fetch_array($result)){
                                                // constants 
                                                if (substr($row[$this->xcomboarr[$this->field]["xfield"]],0,4)=="_KMS") {
                                                        $row[$this->xcomboarr[$this->field]["xfield"]] = constant($row[$this->xcomboarr[$this->field]["xfield"]]);
                                                } else if (substr($row[$this->xcomboarr[$this->field]["xfield"]],0,1)=="_") {
                                                        include_once("/usr/share/kms/lib/conf/getlang.php");
                                                        $row[$this->xcomboarr[$this->field]["xfield"]] = trim(strip_tags($lang[$row[$this->xcomboarr[$this->field]["xfield"]]]));
                                                }
                                                if ($value!="") $sel = ($value==$row[$this->xcomboarr[$this->field]["xkey"]] ? " selected" : "");
                                                print "<option value=\"".$row[$this->xcomboarr[$this->field]["xkey"]]."\"".$sel.">".$row[$this->xcomboarr[$this->field]["xfield"]]."</option>";
                                          }

                                 } else {
                                        print "<option value=\"\"></option>"; // no views for this content_type

                                }
                                print "</select>";
                                if ($open) print "<input type=\"text\" id=\"".$name."_open\" onchange=\"$('#".$name."').val($('#{$name}_open').val());\"></input>";
                                        print "</div></div>";


*/
//$s.= "<div style=\"float:left;font-size:11px;padding:5px\" valign='bottom'>"._KMS_FORMS_MULTISELECT_NOTE."</div>\n";
//----
	return $s;
    }

}

?>
