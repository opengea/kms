<?
class UserOnline
{
	var $_row;
	
	function UserOnline($row){
		$this->_conexion = new Conexion();
		//$this->_username = $username;
		$this->_row = $row;
		//$this->set_id_user();
	}
	
	function set_row($row){
		$this->_row = $row;
	}
	
	function get_row(){
		return $this->_row;
	}
	
//--Functions privates of this class:

//-- End. 	
}
?>