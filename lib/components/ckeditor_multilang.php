<?php
// intergridKMS - data browser / editor
/**
 * A rich-text html editor rule.  Useful for textarea fields.
 */
class ckeditor_multilang {


    function ckeditor_multilang($field,$params,&$dm) {
        $this->field = $field;
        $this->params = $params; 
	$this->dm =& $dm;
    }
	
    function identify() {
	return "multilang";
    }

    function input_filter($value) {
        return stripslashes($value);
    }

    function output_filter($value,$id) {
        return $value;
    }

    function display_component($value) {
	if ($_GET['id']=="") {
		$select="select id from `kms_".$_GET['mod']."` order by id desc limit 1";
		$result=mysql_query($select);
		$row=mysql_fetch_array($result);	
		$_GET['id']=$row[0]+1;
	}
	$default_var="_".strtoupper($_GET['mod'])."_".strtoupper($this->field)."_".$_GET['id'];
	if ($value!=$default_var&&$value!="") {$alter=1;$variable=trim(strip_tags($value)); } else {$alter=0;$variable=$default_var;} 
        $select="select default_lang,available_languages from kms_sites";
        $result=mysql_query($select);
        $site=mysql_fetch_array($result);
	$idiomes=explode(",",$site['available_languages']);
	$select="SELECT * FROM kms_sites_lang WHERE const='".$variable."'";
	//mysql_query("SET CHARACTER SET utf8");
        //mysql_query("SET NAMES utf8");
	$result2=mysql_query($select);
	$txt = mysql_fetch_array($result2);
	if ($this->params['type']=="") $this->params['type']="full";
	$out="";
        //----editor
        $out.="<div class=\"component rte_".$this->params['type']."\" id=\"multilang_".$this->field."\" border=\"0\">";
        //$this->params['type']="full";
        foreach ($idiomes as $i=>$idioma) {
                if ($idioma==$site['default_lang']) $display="block"; else $display="none";
                $out.="<textarea id=\"".$this->field."_".$idioma."\" name=\"".$this->field."_".$idioma."\" class=\"ckeditor\" rows=\"15\" cols=\"80\" style=\"width:100%;height:30px;display:".$display."\">";
                $out.=$txt[$idioma];
                $out.="</textarea>";
        }
	$out.="</div>";
	//---language selector
	$out.="<div class=\"field_opt_box\">";
	$out.="<select class=\"langselector\" onchange=\"makevisible_".$this->field."(this.value)\" style=\"float:left\">";
	$out.="<script language=\"javascript\">";
        $out.="function reloadvar(variable,defaultvalue,customvalue) {
                if ($('input#'+variable).val()!=defaultvalue) $('input#'+variable).val(defaultvalue); else $('input#'+variable).val(customvalue);
        }
	</script>";
	$out.="<script language=\"javascript\">
        function makevisible_".$this->field."(lang) {
		console.log('make visible ".$this->field." '+lang);
		$(\"div#multilang_".$this->field." div.cke\").hide();
                $(\"div#multilang_".$this->field." div#cke_".$this->field."_\"+lang).show();
	}
	setTimeout(\"makevisible_".$this->field."('".$site['default_lang']."')\",3000);
	setTimeout(\"makevisible_".$this->field."('".$site['default_lang']."')\",5000);
	setTimeout(\"makevisible_".$this->field."('".$site['default_lang']."')\",10000);
	setTimeout(\"$('.langselector').prop('disabled',false); \",3010);
	$('.langselector').prop('disabled','disabled');
        </script>";

	if ($this->params['type']=="richtext")  {
	foreach ($idiomes as $i=>$idioma) {
	$out.="<script language=\"javascript\">
		CKEDITOR.replace('".$this->field."_".$idioma."', { toolbar: [         ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'] ],resize_enabled:true,height:200,width:300 });	
		
        </script>";
	}
	}
	foreach ($idiomes as $i=>$idioma) { 
		if ($site['default_lang']==$idioma) $selected="selected"; else $selected="";
		$out.="<option value=\"".$idioma."\"".$selected.">".constant('_KMS_WEB_LANG_'.strtoupper($idioma))."</option>";
	} 

	$out.="	
	</select>
	<div id=\"label_".$this->field."\" style=\"padding-left:5px;float:left\">
		<div><img title='"._KMS_DATAEDITOR_MULTILANG_LABEL."'class='label_icon' onclick=\"$('#label_".$this->field." div.floating').toggle()\" src=\"/kms/css/aqua/img/icons/label.png\"></div>
		<div class='floating'><input title=\""._KMS_GL_CLICK_TO_EDIT."\" type=\"input\" class=\"label\" id=\"".$this->field."\" name=\"".$this->field."\" value=\"".str_replace('"','&quot;',$variable)."\"></div>";
	$out.="</div>"; //label

	if ($alter==1) { //echo $default_var; 
	$out.="<div class='reload_icon' title=\"Reset variable\" onclick=\"reloadvar('".$this->field."','".$default_var."','".str_replace('"',"&quot;",trim(strip_tags($value)))."')\"><img src=\"/kms/tpl/themes/common/img/icons/reload.png\"></div>";
	 } 
	if ($_GET['_action']=='Duplicate') $out.= "<script>reloadvar('".$this->field."','".$default_var."','".str_replace('"',"&quot;",trim(strip_tags($value)))."_');</script>";
//	$out.="</div>";
	$out.="<div style=\"clear:left\"></div>";
//	$out.="</div>";
	if ($this->dm->comments[$this->field]!="") $out .="<div class='comment'><span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span></div>\n";
//	$out.="</div>";

	$out.="</div>"; //field_opt_box

	return $out;
    }

}
?>
