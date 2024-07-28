<?

// ----------------------------------------------
// Class ERP Paysheets for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_paysheets extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_paysheets";
	var $key	= "id";	
	var $fields 	= array("periode", "staff_id", "base_irpf","irpf_pc","total_meritat","total_a_deduir","total_a_percebre","cost_empresa","file");
	var $hidden 	= array("incidence_gratification","incidence_extraHours","incidence_commissions","incidence_incentives");
	var $orderby 	= "periode";
	var $sortdir 	= "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view 	= true;
        var $can_edit 	= true;
        var $can_delete = true;
	var $can_duplicate = true;
        var $can_add  	= true;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_paysheets($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		if ($_GET['_']=="e") {
			//$this->readonly = array("total_a_deduir","base_irpf","total_meritat","preu");
		}
		$this->setComponent("file","file",array($this->kms_datapath."files/files","http://data.".$this->current_domain."/files/files"));

		$this->defvalue("creation_date",date('Y-m-d'));
		$this->humanize("staff_id","Treballador/a");
		$this->humanize("regim","Contracte (r&egrave;gim)");
		$this->humanize("base_irpf","Base IRPF");
		$this->humanize("incidence_unjustifiedAbsenteeism_days","Faltes injustificades (dies)");
		$this->humanize("incidence_gasoil","Gasolina");
		$this->humanize("incidence_bonus","Bonus");
		$this->humanize("incidence_diets","Dietes");
		$this->addComment("irpf_pc"," <a href='https://www2.agenciatributaria.gob.es/wcl/PRET-RW00/index.zul' target='blank'>Calcular</a>");
		$this->addComment("total_a_percebre"," &euro;   (= Meritat - Deduir)");
		$this->addComment("total_a_deduir"," &euro;");
		$this->addComment("total_meritat"," &euro;");
		$this->addComment("base_irpf"," &euro; (utilitzar per calcular el tipus de retenci&oacute;)");
		$this->addComment("incidence_gasoil"," &euro;");
		$this->addComment("incidence_diets"," &euro;");
		$this->defvalue("incidence_diets","0");
		$this->defvalue("incidence_gasoil","0");
		$this->humanize("irpf_pc","Tipus retenci&oacute; aplicable (%)");
		$this->humanize("total_meritat","Total Meritat (Devengado)");
		$this->humanize("total_a_deduir","Total a deduir");
		$this->humanize("total_a_percebre","TOTAL A PERCEBRE");
		$this->humanize("total_dies","Total dies (Quantia)");
		$this->humanize("preu","Preu/dia");
		$this->defvalue("total_dies","30");
		$this->setComponent("select","regim",array("general"=>"general"));
		$this->setComponent("xcombo","staff_id",array("xtable"=>"kms_ent_staff","xkey"=>"id","xfield"=>"fullname","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setStyle("total_a_percebre","width:100px;background-color:#dfd","e");
		$this->setStyle("irpf_pc","width:40px;background-color:#fee","e");
		$this->setStyle("base_irpf","width:100px;background-color:#eee","e");
		$this->setStyle("total_meritat","width:100px;background-color:#eee","e");
		$this->setStyle("total_a_deduir","width:100px;background-color:#fee","e");
		$this->setStyle("total_dies","width:40px","e");
		$this->setStyle("preu","width:40px","e");
		$this->setStyle("incidence_unjustifiedAbsenteeism_days","width:40px","e");
		$this->setStyle("incidence_gasoil","width:100px","e");
		$this->setStyle("incidence_diets","width:100px","e");
		$this->onFieldChange("total_a_percebre","base=Math.round((this.value/(1-$('#irpf_pc').val()/100))*100)/100;$('#base_irpf').val(base);$('#total_meritat').val(base);deduir=Math.round((base*$('#irpf_pc').val()/100)*100)/100; $('#total_a_deduir').val(deduir);$('#preu').val(base/$('#total_dies').val());base_calcul=Math.round(base*12*100)/100;$('#comment_irpf_pc a').html('Calcular (Base anual (mitjana) per calcular tipus de retenci&oacute;: '+base_calcul+')')");
		$this->onFieldChange("irpf_pc","$('#total_a_percebre').change()");
		$this->action("rpt_model_111","/usr/share/kms/lib/reports/rpt_model_111.php");
		$this->sum = array("base_irpf","irpf_pc","total_meritat","total_a_deduir","total_a_percebre","incidence_bonus");
	}

}
?>
