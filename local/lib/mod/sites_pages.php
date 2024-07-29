<?

// ----------------------------------------------
// Class Sites Pages for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_pages extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_pages";
	var $key	= "id";	
	var $fields = array("status", "title", "type", "parent", "menu_id","vr_sample");
	var $hidden = array("sort_order","creation_date");
	var $orderby = "id";

	/*=[ PERMISOS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = false;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_pages ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		// set draggable
		$this->uid=$this-key; 
		$this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
		$this->orderby="sort_order";

		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "web_pages";
		$this->default_php = "variables.php";
		$this->insert_label = _NEW_WEB_PAGE;
		$this->setComponent("checklist","show_title",array("1"=>""));
		$this->setComponent("checklist","private",array("1"=>""));
		$this->setComponent("checklist","nomargin",array("1"=>""));
		$this->setComponent("checklist","remove_website_widgets",array("1"=>""));
		$this->setComponent("checklist","hide_leftcol",array("1"=>""));
		$this->setComponent("checklist","hide_rightcol",array("1"=>""));
		$this->setComponent("select","status",array("0"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "1"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->setComponent("xcombo","type",array("xtable"=>"kms_sites_components","xkey"=>"name","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select id,name from kms_sites_components where type='application' and status='online'"));
		$this->customOptions = Array();
//		$this->customOptions[0] = Array ("label"=>_KMS_GL_PREVIEW,"url"=>"http://www.".$KMS[current_domain]."/[title]&","ico"=>"details.gif","params"=>"&preview","target"=>"new");
//		$this->xcombosql("web_lang_constant", "select SUBSTR(const,2) from kms_sites_lang where const not like \"_KMS_%\"", false, false);
		$this->setComponent("xcombo","web_lang_constant",array("xtable"=>"kms_sites_lang","xkey"=>"","xfield"=>"","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select SUBSTR(const,2) from kms_sites_lang where const not like \"_KMS_%\""));
		$this->defvalue("site_id",1);
		$this->setComponent("xcombo","site_id",array("xtable"=>"kms_sites","xkey"=>"id","xfield"=>"url_base","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$site=$this->dbi->get_record("SELECT * FROM kms_sites limit 1");
		
		if ($site['multilanguage']) {

                        $this->setComponent("ckeditor_multilang","meta_keywords",array("type"=>"richtext"));
			$this->setComponent("multilang","name",array("type"=>"textfield"));
			$this->setComponent("multilang","title",array("type"=>"textfield"));
			$this->setComponent("ckeditor_multilang","meta_description",array("type"=>"richtext"));
			$this->setComponent("ckeditor_multilang","body",array("type"=>"full"));
                } else {
                        $this->setComponent("ckeditor_standard","body",array("type"=>"full"));
		}
		
		$this->addComment("name",_KMS_SITES_NAME_COMMENT);
		$this->addComment("parent",_KMS_SITES_PARENT_COMMENT);
		$this->setComponent("select","target",array("_self"=>_KMS_SITES_PAGES_TARGET_SELF,"_blank"=>_KMS_SITES_PAGES_TARGET_BLANK));
		//will need it for populate
		$extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
		//populate parent
                if ($_GET['id']!="") $sql="select id,name,title,parent from kms_sites_pages where parent=\"0\" and id!=".$_GET['id']." order by sort_order";
                                else $sql="select id,name,title,parent from kms_sites_pages where parent=\"0\"  order by sort_order";
		if ($_GET['v2']!="") {// som dins d'una vista !
				// apliquem where
				$vista=$this->dbi->get_record("SELECT * FROM kms_sys_views WHERE id=".$_GET['v2']);
				$sql=str_replace(" where "," WHERE ".$vista['where']." AND ",$sql);
				// hauriem d'aplicar default values /unic param
				if (!strpos(" ",$vista['where'])) { //nomes unic param
						$param=explode("=",$vista['where']); 
						$this->defvalue($param[0],$param[1]);
				}
				
				
		}
                $myres=mysql_query($sql);
                $myresults=array();$i=0;
                while ($page=mysql_fetch_array($myres)) {
                        $myresults[$i][0]=$page['id'];
                        $myresults[$i][1]=getlang($page['name'],$lang);
                        if ($myresults[$i][1]=="")  $myresults[$i][1]=getlang($page['title'],$lang);
                        if ($myresults[$i][1]=="")  $myresults[$i][1]=getlang($page['name'],$lang_base);
                        if ($myresults[$i][1]=="")  $myresults[$i][1]=getlang($page['title'],$lang_base);
                        if ($page['parent']!=0) $myresults[$i][1]="  > ".$myresults[$i][1]; else $myresults[$i][1]=strtoupper_accents($myresults[$i][1]);
                        $i++;
                }

		$this->setComponent("xcombo","parent",array("results"=>$myresults,"xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"title","readonly"=>false,"linkcreate"=>false,"linkedit"=>false));
		//populate alias_id
		$sql="select id,name,title,parent from kms_sites_pages where alias_id=\"0\"  order by sort_order";
		$myres=mysql_query($sql);
		$myresults=array();$i=0;
		while ($page=mysql_fetch_array($myres)) {
			if ($page['id']!=$_GET['id']) $myresults[$i][0]=$page['id']; else $myresults[$i][0]='';
			$myresults[$i][1]=getlang($page['name'],$lang);
			if ($myresults[$i][1]=="")  $myresults[$i][1]=getlang($page['title'],$lang);
			if ($myresults[$i][1]=="")  $myresults[$i][1]=getlang($page['name'],$lang_base);
			if ($myresults[$i][1]=="")  $myresults[$i][1]=getlang($page['title'],$lang_base);
			if ($page['parent']!=0) $myresults[$i][1]="  > ".$myresults[$i][1]; else $myresults[$i][1]=strtoupper($myresults[$i][1]);
			$i++;
		}
		$this->setComponent("xcombo","alias_id",array("results"=>$myresults,"xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false));
		$this->setComponent("xcombo","menu_id",array("xtable"=>"kms_sites_menus","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select id,name from kms_sites_menus")); 
		$sel="select action from kms_sites_menus where action!=''";$myres=mysql_query($sel);$row=mysql_fetch_array($myres);
                $this->defvalue("status","1");
		$this->humanize("target","Target");
		$this->humanize("permalink","Permalink");
//		$this->addComment("permalink"," Obligatori. Posar el nom de la url de la pàgina");
		$this->onFieldChange("remove_website_widgets","$('#tr_widgets_left_sidebar').toggle();$('#tr_widgets_right_sidebar').toggle();");
		$this->onDocumentReady("if ($('input#remove_website_widgets').val()=='1') { $('#tr_widgets_right_sidebar').hide();$('#tr_widgets_left_sidebar').hide(); } else { $('#tr_widgets_right_sidebar').show();$('#tr_widgets_left_sidebar').show(); } ");
                if ($row['action']!="") {
                        //menu 1.0 old kms
                        $this->rowclick = "";
                        $this->uid="";
                        $this->orderby="id";//sort_order";
                        $this->fields=array("status", "title", "name", "type");
	                $this->defvalue("status","published");
			$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
                } else {
			$this->setGroup("_KMS_SITES_PAGE_OPTIONS",true,array("show_title","nomargin","private","remove_website_widgets","widgets_left_sidebar","widgets_right_sidebar","hide_leftcol","hide_rightcol"));
			$this->setGroup("_KMS_GL_ADV_OPTIONS",true,array("meta_description","meta_keywords","name","target","custom_url"));
		}
		//test crec q surt al databrowser i res mes...
		array_push($this->fields,"vr_sample");
		$this->setComponent("xref","vr_sample",array("id","en","kms_sites_lang"));

		
	}
}
?>
