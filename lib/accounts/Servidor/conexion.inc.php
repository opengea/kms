<?
class Conexion
{
	var $_host;
	var $_dbuser;
	var $_dbpass;
	var $_dbname;
	var $_connect = 0;
	var $_error = "";
	
//-- tables:
	var $_table_preUser = array('username','pass','email','id_preuser','avisar');
	var $_table_users = array('username','pass','name','apellido','direccion','codigoPostal','telefono','email','id_user');
	var $_table_usersProfiles = array('id_user','change_pass','avisar');

	function Conexion(){
		$this->_host = 'batenkaitos.com';
		$this->_dbuser = 'dserver';
		$this->_dbpass = 'gr8raf';
		$this->_dbname = 'dserver';
		if ($this->_connect == 0){
			$this->_connect = @mysql_pconnect($this->_host,$this->_dbuser,$this->_dbpass) or die(false);
			$this->_connect = mysql_select_db($this->_dbname);			
		}
	}
	
	function connect_database(){
//		if (mysql_ping($this->_connect) || $this->_connect){
//		}else{
			$this->_connect = @mysql_pconnect($this->_host,$this->_dbuser,$this->_dbpass) or die(false);
			$this->_connect = mysql_select_db($this->_dbname);
			if(!$this->_connect)
			{
//				$this->_error = mysql_error();
				return FALSE;
				exit;
			}
//		}
	}
	
	function insert_preUser($params){
		$this->connect_database();
		$query = "INSERT INTO preUser (";
		$numColumns = count($this->_table_preUser);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_preUser[$i].",";
			}else {
				$query = $query.$this->_table_preUser[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			if ($j != ($numParams-1)) {
				$query = $query."'".$params[$j]."',";
			}else {
				$query = $query."'".$params[$j]."')";
			}
		}		
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
	function select_preUser($id_preuser){
		$this->connect_database();
		$query = mysql_query("SELECT * FROM preUser WHERE ".$this->_table_preUser[3]." = '$id_preuser'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == true)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}		
	}

	function delete_preUser($id_preuser){
		$query = mysql_query("DELETE FROM preUser where ".$this->_table_preUser[3]." = '$id_preuser' LIMIT 1");
		return $this->check_query($query);	
	}
	
//	function insert_user($username,$pass,$name,$apellido,$direccion,$codigoPostal,$telefono,$email,$id_user){
	function insert_user($params){
		$this->connect_database();
		$query = "INSERT INTO users (";
		$numColumns = count($this->_table_users);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_users[$i].",";
			}else {
				$query = $query.$this->_table_users[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			if ($j != ($numParams-1)) {
				if ($params[$j] == ""){
					$query = $query."null,";
				}else{
					$query = $query."'".$params[$j]."',";
				}
			}else {
				if ($params[$j] == ""){
					$query = $query."null)";
				}else{
					$query = $query."'".$params[$j]."')";
				}				
			}
		}		
		$insert = mysql_query($query);
		return $this->check_query($insert);
		
//		$query = mysql_query("INSERT INTO users (username, pass, name, apellido, direccion, codigoPostal, telefono, email)"//, id_user) "
//				."VALUES ('$username', '$pass', '$name', '$apellido', '$direccion', '$codigoPostal', '$telefono', '$email')");//, '$id_user')");
//		return $this->check_query($query);
	}
	function insert_userProfile($params){
		$this->connect_database();
		$query = "INSERT INTO usersProfiles (";
		$numColumns = count($this->_table_usersProfiles);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_usersProfiles[$i].",";
			}else {
				$query = $query.$this->_table_usersProfiles[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			if ($j != ($numParams-1)) {
				if ($params[$j] == ""){
					$query = $query."null,";
				}else{
					$query = $query."'".$params[$j]."',";
				}
			}else {
				if ($params[$j] == ""){
					$query = $query."null)";
				}else{
					$query = $query."'".$params[$j]."')";
				}				
			}
		}		
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
/*	function select_username_pass($email){
		$query = mysql_query("SELECT username,pass FROM users WHERE email= '$email'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
//			return $query;
		}else {
			return FALSE;
		}		
	}
*/	
	function update_pass_in_users($email, $pass){		
		$query = mysql_query("UPDATE users SET pass = '$pass' WHERE ".$this->_table_users[7]." = '$email'");
		return $this->check_query($query);
	}
	function select_user_from_users($username, $email){		
		$query = mysql_query("SELECT * FROM users WHERE ".$this->_table_users[0]."= '$username'"
								 ." OR ".$this->_table_users[7]."= '$email'");								 							
		$resultOK = $this->check_query($query);		
		if ( $resultOK == TRUE)
		{
			$this->_error = "El username o el email";
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			echo "false";
			return FALSE;
		}
	}
	
	function select_id_user_from_users_PEmail($email){
		$query = mysql_query("SELECT ".$this->_table_users[8]." FROM users WHERE ".$this->_table_users[7]."= '$email'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}
	}
	function select_id_user_from_users_PUsername($username){
		$query = mysql_query("SELECT ".$this->_table_users[8]." FROM users WHERE ".$this->_table_users[0]."= '$username'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}
	}
	
	function select_userPass_users($username, $pass){
		$query = mysql_query("SELECT * FROM users WHERE ".$this->_table_users[0]."= '$username' AND"
								." ".$this->_table_users[1]."= '$pass' LIMIT 1");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
//			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	function update_change_pass_in_usersProfiles($id_user, $change_pass){		
		$query = mysql_query("UPDATE usersProfiles SET change_pass = '$change_pass' WHERE id_user = '$id_user'");
		return $this->check_query($query);
	}
	
	function select_user($id_user){
		$query = mysql_query("SELECT * FROM users WHERE id_user= '$id_user'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			return FALSE;
		}
	}
	
	function select_user_by_email($email){
		$query = mysql_query("SELECT * FROM users WHERE ".$this->_table_users[7]."= '$email'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			return FALSE;
		}
	}
	
	function get_db_errno(){
		return mysql_errno();
	}

	function get_db_error(){
		return $this->_error;
//		$this->_error ="";
	}
	function check_query($query){
		if(!$query)
   		{
   			$this->_error = mysql_error();
   			
   			$errno = mysql_errno();
//   			echo "errno: ".$errno."-----string: ".mysql_error()."------";
   			if ($errno == 1062) {
					$pos = strpos ($this->_error, "'");
					$error = substr($this->_error, $pos +1);					
					$error = substr($error, 0, strpos($error, "'"));					
					$this->_error = $error;
   			}else {
   			}		
			return FALSE;
   		} else {
   			return TRUE;
   		}
	}
}
?>