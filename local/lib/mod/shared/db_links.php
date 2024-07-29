<?
if ($this->dbi) {
	$dblink_cp=$this->dbi->db_connect("cp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
	if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
		$dblink_erp=$dblink_erp_localhost=$this->dbi->db_connect("erp-localhost",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$this->current_extranet="erp";
	} else {
		$dblink_erp=$this->dbi->db_connect("erp",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$this->current_extranet="cp";
	}
} else {
	$dblink_erp=$dblinks['dblink_erp'];
	$dblink_cp =$dblinks['dblink_cp'];
}
?>
