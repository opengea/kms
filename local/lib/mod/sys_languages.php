<?

// ----------------------------------------------
// Class System Applications KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_languages extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table		= "kms_sys_languages";
	var $key		= "id";
	var $fields		= array("id","name","code","default");
	var $title		= _KMS_TY_APPS;
        var $hidden = array("sort_order");
	var $orderby		= "id";
	var $sortdir		= "desc";
	var $insert_label 	= _NEW_CONTACT;

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_import 	= false;
	var $can_export 	= false;
	var $can_duplicate  	= true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_languages($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                // set draggable
                $this->uid=$this-key;
                $this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
                $this->orderby="sort_order";

		$this->defvalue("status","active");
		$this->defvalue("newsletter","1");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);

		$this->subtitle = "Contacts";
		$this->humanize ("const","Constant (maj&uacute;scules)");
		$this->defvalue("const","_KMS_");	
		$this->setComponent("checklist","default",array("1"=>""));
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
		$this->onUpdate="updateFiles";
		$this->onInsert="updateFiles";
		$this->onDelete="updateFiles";
		}
	}

	function updateFiles() {
		$path = "/usr/local/kms/lang/";
  		// Generem fitxer LANG a partir dels records de la base de dades
		$idiomes=array("ca","en","es","eu");
		foreach ($idiomes as $lang) {
	  		$select = "SELECT ".$lang.",const FROM kms_sys_languages";
		        $result = mysqli_query($this->dblinks['client'],$select);
			if (!$result){ echo "La conexi&oacute; a la BBDD es correcte per&ograve; hi ha un error en alg&uacute;n par&agrave;metre introduit.<br>&Eacute;s provable que l'idioma ".$lang." no existeixi a la taula.<br>";exit;}
			$str = "<?\n";
			$i =0;
			$entities1="html_entities("; $entities2=")";
			while ($row=mysqli_fetch_array($result)) {
				         $str .= "define('".$row['const']."','".$this->convertchars($row[$lang])."',\$case);\n";
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
	$str = str_replace("'","\'",$str);
        $str = str_replace("&lt;","<",$str);
        $str = str_replace("&gt;",">",$str);
        return $str;
	}

}
?>
