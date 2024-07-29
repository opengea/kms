<?php
// intergridKMS - data browser / editor
/**
 * A rich-text html editor rule.  Useful for textarea fields.
 */
class multilang {

    var $allowed_tags = "<p><a><em><tt><span><center><b><strong><div><h1><h2><h3><h4><h5><h6><font><pre><br><hr><ul><ol><li><php>";

    function multilang($field,$params,&$dm) {
        $this->field = $field;
        $this->params = $params; 
	$this->dm =& $dm;
    }
	
    function identify() {
	return "multilang";
    }

    function input_filter($value) {
        $value = str_ireplace("'", "\'", $value);
        $value = str_ireplace('"', '\"', $value);
//        $value = htmlentities(utf8_decode($value));
        return stripslashes($value);
    }

    function output_filter($value,$id) {
        return strip_tags($value,$this->allowed_tags);
    }

    function display_component($value) {
	if ($_GET['id']=="") {
	  // new object. retrieve last id
//          $select="select id from `kms_".$this->dm->div."` order by id desc limit 1";
	$select="select id from `kms_".$_GET['mod']."` order by id desc limit 1";
///echo $select;
//if ($this->dm->div=="") print_r($this->dm);
	  $result=mysqli_query($this->dm->dblinks['client'],$select);
	  $row=mysqli_fetch_assoc($result);	
	  $_GET['id']=$row[0]+1;
	}
	$default_var="_".strtoupper($_GET['mod'])."_".strtoupper($this->field)."_".$_GET['id'];
	if ($value!=$default_var&&$value!="") {$alter=1;$variable=trim(strip_tags($value)); } else {$alter=0;$variable=$default_var;} 
        $select="select * from kms_sites";
        $result=mysqli_query($this->dm->dblinks['client'],$select);
        $site=mysqli_fetch_assoc($result);
	?>
	<?
	$idiomes=explode(",",$site['available_languages']);
	$select="SELECT * FROM kms_sites_lang WHERE const='".$variable."'";
        // mysqli_query("SET NAMES utf8");
	$result2=mysqli_query($this->dm->dblinks['client'],$select);
	$txt = mysqli_fetch_assoc($result2);
	if ($this->params['type']=="") $this->params['type']="full";
	$out="<div class=\"component rte_".$this->params['type']."\" id=\"multilang_".$this->field."\" border=\"0\"><div>";
	//$this->params['type']="full";
	foreach ($idiomes as $i=>$idioma) {
		if ($idioma==$site['default_lang']) $display="block"; else $display="none";
/*		$out.="<textarea id=\"".$this->field."_".$idioma."\" name=\"".$this->field."_".$idioma."\" class=\"rte_".$this->params['type']."\" rows=\"5\" cols=\"80\" style=\"width:500px;height:30px;display:".$display."\">";
		//=mb_convert_encoding($this->rtesafe($txt[$idioma]), "HTML-ENTITIES", "UTF-8");
		//=mb_convert_encoding($this->rtesafe($value), "HTML-ENTITIES", "UTF-8");
		$out.=$this->rtesafe($txt[$idioma]);
		$out.="</textarea>";
*/
		$out.="<input type='text' style='display:block !important' id=\"".$this->field."_".$idioma."\" name=\"".$this->field."_".$idioma."\" value=\"".$txt[$idioma]."\" data-lpignore=\"true\"/>";
		 //$out.=$txt[$idioma];

	}
	$out.="</div><div class=\"field_opt_box\">";
	$out.="<select class=\"langselector\" onchange=\"makevisible_".$this->field."(this.value)\" style=\"float:left\">";
	$out.="<script language=\"javascript\">";
        $out.="function reloadvar(variable,defaultvalue,customvalue) {
                if ($('input#'+variable).val()!=defaultvalue) $('input#'+variable).val(defaultvalue); else $('input#'+variable).val(customvalue);
        }
	</script>";
	$out.="<script language=\"javascript\">
        function makevisible_".$this->field."(lang) {
		$(\"div#tr_".$this->field." input\").hide();	
		$(\"input#".$this->field."\_\"+lang).show();
	}
	setTimeout(\"makevisible_".$this->field."('".$site['default_lang']."')\",3000);
	setTimeout(\"$('.langselector').prop('disabled',false); \",3010);
	$('.langselector').prop('disabled','disabled');
        </script>";
	foreach ($idiomes as $i=>$idioma) { 
		if ($site['default_lang']==$idioma) $selected="selected"; else $selected="";
		$out.="<option value=\"".$idioma."\"".$selected.">".constant('_KMS_WEB_LANG_'.strtoupper($idioma))."</option>";
	} 

	$out.="	
	</select>
	<div id=\"label_".$this->field."\" style=\"padding-left:5px;float:left\"><div><img title='"._KMS_DATAEDITOR_MULTILANG_LABEL."'class='label_icon' onclick=\"$('#label_".$this->field." div.floating').toggle()\" src=\"/kms/css/aqua/img/icons/label.png\"></div><div class='floating'><div><input style='display:block' title=\""._KMS_GL_CLICK_TO_EDIT."\" type=\"input\" class=\"label\" id=\"".$this->field."\" name=\"".$this->field."\" value=\"".str_replace('"','&quot;',$variable)."\"></div>";
	if ($alter==1) { //echo $default_var; 
	$out.="<div class='reload_icon' title=\"Reset variable\" onclick=\"reloadvar('".$this->field."','".$default_var."','".str_replace('"',"&quot;",trim(strip_tags($value)))."')\"><img src=\"/kms/tpl/themes/common/img/icons/reload.png\"></div>";
	 } 
	if ($_GET['_action']=='Duplicate') $out.= "<script>reloadvar('".$this->field."','".$default_var."','".str_replace('"',"&quot;",trim(strip_tags($value)))."_');</script>";
	$out.="</div>";
	$out.="<div style=\"clear:left\"></div>";
	$out.="</div>";
	if ($this->dm->comments[$this->field]!="") $out .="<div class='comment'><span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span></div>\n";
	$out.="</div></div>";
	return $out;
    }

    function rtesafe($strText) {
	$tmpString = trim($strText);
    	$tmpString = str_replace(chr(145), chr(39), $tmpString);
    	$tmpString = str_replace(chr(146), chr(39), $tmpString);
    	$tmpString = str_replace("'", "&#39;", $tmpString);
    	$tmpString = str_replace(chr(147), chr(34), $tmpString);
    	$tmpString = str_replace(chr(148), chr(34), $tmpString);
    	$tmpString = str_replace(chr(10), "", $tmpString);
    	$tmpString = str_replace(chr(13), "", $tmpString);
	$tmpString = str_replace('<strong>', "<b>", $tmpString);
	$tmpString = str_replace('</strong>', "</b>", $tmpString);
	$tmpString=trim($tmpString);
    	return $tmpString;
    }
}
?>
