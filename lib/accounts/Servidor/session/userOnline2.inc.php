<?
class UserOnline
{
	var $_count;
	
	function UserOnline($username){
		
		$this->_count = 0;
	}
	function get_count(){
		return $this->_count;
	}
	
//--Functions privates of this class:
	
	function set_count(){
		$this->_count = $this->_count+1;
	}
//-- End. 	
}
?>