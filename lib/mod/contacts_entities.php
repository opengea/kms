<?

// ----------------------------------------------
// Class Contacts Entities for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class contacts_entities extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_contacts_entities";
	var $key	= "id";	
	var $fields 	= array("id","creation_date","status","name", "sector", "location", "email", "phone");
	var $orderby 	= "creation_date";
	var $sortdir 	= "desc";


       //*=[ CONSTRUCTOR ]===========================================================*/

        function contacts_entities($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>","pending"=>"<font color=#ffAA00>"._KMS_GL_STATUS_PENDING."</font>"));

		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("uniselect","country");
		$this->setComponent("uniselect","language");
		$this->setComponent("uniselect","location");
		$this->setComponent("uniselect","province");
		$notedit= array("dr_folder","country");
		$this->default_content_type = "entities";
		$this->default_file = "entities.php";
		$export=true;
		$this->validate("email");
		$this->validate("website");
		$this->xlist("Contractes","SELECT * FROM kms_erp_contracts WHERE kms_erp_contracts.sr_client='".$_GET['id']."'","erp_contracts");
		$this->xlist("Factures","SELECT * FROM kms_erp_invoices WHERE kms_erp_invoices.sr_client='".$_GET['id']."'","erp_invoices");
		$this->insert_label = _NEW_ENTITY;
                $this->onUpdate = "onUpdate";
		$this->setValidator("name","notnull");
		$this->setValidator("email","email");
        }

        function onUpdate($post,$id) {
		// if this entity is client, we must update ISP module
		$select="select sr_client from kms_contacts_clients where sr_client=$id";
		$result=$this->dbi->query($select);
		$client=mysqli_fetch_array($result);
		if ($client['sr_client']==$id) {
	                $fields_to_update=array("name","sector","cif","contacts","phone","alt_phone","email","web","address","location","province","zipcode","country","language","newsletter");
			$dblink=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");	
			$update=$this->dbi->make_update($post,"kms_isp_clients","sr_client=".$id,$fields_to_update,$dblink);
	                $this->dbi->query($update);
		} 
        }

}
?>
