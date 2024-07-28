<?

// ----------------------------------------------
// Class System Applications KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_lang extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table		= "kms_sys_lang";
	var $key		= "id";
	var $fields		= array("id","const", "ca", "es", "en", "eu", "fr");
	var $title		= _KMS_TY_APPS;
	var $orderby		= "id";
	var $sortdir		= "desc";
	var $notedit		= array("dr_folder","labels");
	var $readonly 		= array("dr_folder");
	var $linkfield 		= "fullname";
	var $insert_label 	= _NEW_CONTACT;

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_import 	= false;
	var $can_export 	= true;
	var $can_duplicate  	= true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_lang($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->defvalue("status","active");
		$this->defvalue("newsletter","1");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);

		$this->subtitle = "Contacts";
		$this->humanize ("const","Constant (maj&uacute;scules)");
		$this->defvalue("const","_KMS_");	
		$this->setComponent("cipher","cpassword","MD5");
		$this->setComponent("checklist","show_sidemenu",array("1"=>""));
		$this->setComponent("checklist","show_menu_xml",array("1"=>""));
		$this->setComponent("checklist","show_modules",array("1"=>""));
		$this->setComponent("checklist","show_views",array("1"=>""));
		$this->setComponent("checklist","show_labels",array("1"=>""));
		$this->setComponent("uniselect","country");
		$this->setComponent("uniselect","location");
		$this->setComponent("wysiwyg","ca",array("type"=>"full"));
		$this->setComponent("wysiwyg","es",array("type"=>"full"));
		$this->setComponent("wysiwyg","en",array("type"=>"full"));
		$this->setComponent("wysiwyg","eu",array("type"=>"full"));
		$this->setComponent("wysiwyg","fr",array("type"=>"full"));
		$this->setComponent("wysiwyg","de",array("type"=>"full"));
		//$this->setComponent("uniselect","organization");
		$this->setComponent("checklist","newsletter",array("1"=>"Si"));
		$this->setComponent("select","language",array("en"=>"English","es"=>"Spanish","ca"=>"Catalan","fr"=>"French","de"=>"Deutch","it"=>"Italiano","eu"=>"Euskera"));
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$select="select id from kms_folders where content_type='groups'";
		$result=mysqli_query($this->dblinks['client'],$select);
		$row=mysqli_fetch_array($result);
		$this->setComponent("multiselect","groups",array("select * from kms_groups where dr_folder=".$row[0]." and name!='_KMS_GROUPS_ALL'","name","id"));

//		$this->customButtons=Array();
//                $this->customButtons[0] = Array ("label"=>_KMS_ISP_UPDATELANGUAGEPACKS,"url"=>"","ico"=>"pdf.gif","params"=>"action=update_languagepacks","target"=>"new","checkFunction"=>"");
 //               $this->action("update_languagepacks","/usr/local/kms/mod/isp/updates/update_languagepacks.php");	
		$this->customOptions=Array();
		$this->customOptions[0] = Array ("label"=>"_KMS_ISP_UPDATELANGUAGEPACKS","url"=>"","ico"=>"pdf.gif","params"=>"action=update_languagepacks","target"=>"new","checkFunction"=>"");
	        $this->action("update_languagepacks","/usr/local/kms/mod/isp/updates/update_languagepacks.php");
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
		$this->onUpdate="updateFiles";
		$this->onInsert="updateFiles";
		$this->onDelete="updateFiles";
		}
	}

	function updateFiles() {
		$path = "/usr/local/kms/lang/";
  		// Generem fitxer LANG a partir dels records de la base de dades
		$idiomes=array("ca","en","es","eu","fr");
		foreach ($idiomes as $lang) {
	  		$select = "SELECT ".$lang.",const FROM kms_sys_lang order by const";
		        $result = mysqli_query($this->dblinks['client'],$select);
			if (!$result){ echo "La conexi&oacute; a la BBDD es correcte per&ograve; hi ha un error en alg&uacute;n par&agrave;metre introduit.<br>&Eacute;s provable que l'idioma ".$lang." no existeixi a la taula.<br>";exit;}
			$str = "<?\n//NO ACTUALITZEU AQUEST FITXER DIRECTAMENT!\n//Utilitzeu l'intranet > Perferencies > Idiomes\n";
			$i =0;
			$entities1="html_entities("; $entities2=")";
			while ($row=mysqli_fetch_array($result)) {
				         $str .= "define(\"".$row['const']."\",\"".$this->convertchars($row[$lang])."\",\$case);\n";
        				$i++;
  			}
			$str .= "\n?>";

  			$fp = fopen($path.$lang.".php", "w");
			if (!$fp) {echo "Error al escriure el fitxer ".$lang.".php"."<br>"."en la seg&uacute;ent ubicaci&oacute;: ".$path."<br>"."Comproveu els permisos d\'escriptura"; exit;}
			fwrite($fp, $str);
			fclose($fp);

			echo "Idioma <b>".$lang."</b> generat correctament (".$i." l&iacute;nies)<br>";

		}

	}
	function convertchars($str) {
//        $str = str_replace("'","\'",htmlentities(utf8_decode($str)));
	$str = str_replace("\n","",$str);
	$str = str_replace("\r","",$str);
//	$str = str_replace("'","\'",$str);

	$str = str_replace('\"','"',$str);
	$str = str_replace('"','\"',$str);
        $str = str_replace("&lt;","<",$str);
        $str = str_replace("&gt;",">",$str);

	if (substr($str, -1) == '\\') {
        // Remove the last character
        $str = substr($str, 0, -1);
   	 }

        return $str;
	}

}
?>
