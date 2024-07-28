<?
require_once('conexion.inc.php');

class UserOnline
{
	var $_conexion;
	var $_id_user;
	var $_username;
	
	function UserOnline($username){
		$this->_conexion = new Conexion();
		$this->_username = $username;
		$this->set_id_user();
	}
	function get_id_user(){
		return $this->_id_user;
	}
	
	function get_username(){
		return $this->_username;
	}
	
//--Functions privates of this class:

	function set_id_user(){
		$row = $this->_conexion->select_id_user_from_users_PUsername($this->_username);
		if ($row == FALSE){
			//
			echo "ERROR en UserOnline.set_id_user(): ".$this->_conexion->get_db_error();
		}else {
			$this->_id_user = $row[0];
		}
	}
//-- End. 	
}
?>