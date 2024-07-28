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
	var $_table_users_preusers = array('id_uniq_users','email','data_preAlta');
	var $_table_users = array('id_users','nom','cognoms','direccio','poblacio','provincia','cp','telefon','data_naixement','password','email','data_alta');
	var $_table_users_profiles = array('id_users','newsletter','password_expired');
	var $_table_mailing_enviats = array('id_mailing_enviats','comentario','para','de','copia','cuerpo','fecha');
	var $_table_mailing_errores = array('id_errores','id_users','tabla','comentario','fecha');
	var $_table_mailing_grups = array('id_mailing_grups','comentario','sentencia_sql');
	var $_table_users_unsubscribe = array('id_users','id_unsubscribe');
	var $_table_mailing_admin = array('id_mailing_admin','username','password');

	function Conexion(){

		
		$this->_host = 'localhost';
		$this->_dbuser = 'tecnitoys';
		$this->_dbpass = 'tecniweb';
		$this->_dbname = 'tecnitoys';

		if ($this->_connect == 0){
			$this->_connect = mysql_connect($this->_host,$this->_dbuser,$this->_dbpass) or die(false);
			$this->_connect = mysql_select_db($this->_dbname);			
		}
	}
	
	function connect_database(){
//		if (mysql_ping($this->_connect) || $this->_connect){
//		}else{
			$this->_connect = mysql_connect($this->_host,$this->_dbuser,$this->_dbpass) or die(false);
			$this->_connect = mysql_select_db($this->_dbname);
			if(!$this->_connect)
			{
//				$this->_error = mysql_error();
				return FALSE;
				exit;
			}
//		}
	}
	
//-- Funciones en la tabla users_preusers:------------------------
	
	function insert_preUser($params){
		$this->connect_database();
		$query = "INSERT INTO users_preusers (";
		$numColumns = count($this->_table_users_preusers);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_users_preusers[$i].",";
			}else {
				$query = $query.$this->_table_users_preusers[$i];
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
		$query = mysql_query("SELECT * FROM users_preusers WHERE ".$this->_table_users_preusers[0]." = '$id_preuser'");
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
		$query = mysql_query("DELETE FROM users_preusers where ".$this->_table_users_preusers[0]." = '$id_preuser' LIMIT 1");
		return $this->check_query($query);	
	}
		
//-- Funciones en la tabla users: ---------------------------------
	
	function insert_user_TUsers($params){
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
			$string = $params[$j];
			if ($j == 8 && $string == "NULL") {
				$query = $query."00000000,";
			}else {
				if ($j != ($numParams-1)) {				
					if ( $string == "NULL") {
						$query = $query."NULL,";
					}else {
						$query = $query."'".$string."',";
					}
				}else {				
					if ( $string == "NULL") {
						$query = $query."NULL)";
					}else {
						$query = $query."'".$string."')";
					}				
				}
			}
		}
//		echo "".$query."\n";
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
	
	function select_user_PEmail($email){
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users WHERE ".$this->_table_users[10]."= '$email'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}
	}

	function update_user_TUsers($params){		
		$this->connect_database();
		$query = "UPDATE users SET ";
		$numColumns = count($this->_table_users);
		for ($i=1 ; $i < $numColumns; $i++) {
			$string = $params[$i];
			if ($i == 8 && $string == "") {
//			if ($this->_table_users[$i] == "fecha_nacimiento" && $string == "NULL") {
				$query = $query.$this->_table_users[$i]." = '00000000', ";			
			}else {				
				if ( $string == "" ) {
					if ($i == ($numColumns-1)) {
						$query = substr($query,0,(strlen($query)-2));
					}
				}else {
					if ($i == ($numColumns-1)) {						
						$query = $query.$this->_table_users[$i]." = '".$string."' ";
					}else {
						$query = $query.$this->_table_users[$i]." = '".$string."', ";
					}
				}
			}			
		}
		$query = $query."WHERE ".$this->_table_users[0]."= ".$params[0].";";
//		echo "query1: ".$query."\n";
		$query = mysql_query($query);		
		return $this->check_query($query);
	}	
	
//-- Funciones en la tabla users_profiles: ---------------------------------
	
	function insert_profile_TUsersProfiles($params) {
		$this->connect_database();
		$query = "INSERT INTO users_profiles (";
		$numColumns = count($this->_table_users_profiles);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_users_profiles[$i].",";
			}else {
				$query = $query.$this->_table_users_profiles[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			$string = $params[$j];		
			if ($j != ($numParams-1)) {				
				if ( $string == "NULL") {
					$query = $query."NULL,";
				}else {
					$query = $query."'".$string."',";
				}
			}else {				
				if ( $string == "NULL") {
					$query = $query."NULL)";
				}else {
					$query = $query."'".$string."')";
				}				
			}
		}
//		echo "".$query."\n";

		$query = "INSERT INTO users_profiles (".$this->_table_users_profiles[0].",".$this->_table_users_profiles[1].",".$this->_table_users_profiles[2].") VALUES ('".$params[0]."','".$params[1]."','".$params[2]."')";
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}

	function select_profile_TUsersProfiles($id_user) {
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users_profiles WHERE ".$this->_table_users_profiles[0]."= '$id_user'"
								."LIMIT 1");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}
	}

	function update_profile_TUsersProfiles($params) {
		$this->connect_database();
		$query = "UPDATE users_profiles SET ";
		$numColumns = count($this->_table_users_profiles);
		for ($i=1 ; $i < $numColumns-1; $i++) {
			$string = $params[$i];
			if ( $string == "NULL") {
//				$query = $query.$this->_table_users[$i]." = ".$string.", ";	
			}else {
				$query = $query.$this->_table_users_profiles[$i]." = '".$string."', ";	
			}
		}
		$query = $query.$this->_table_users_profiles[$numColumns-1]." = ".$params[$numColumns-1]." ";
		$query = $query."WHERE ".$this->_table_users_profiles[0]."= '".$params[0]."';";
//		echo "query: ".$query."\n";
		$query = mysql_query($query);		
		return $this->check_query($query);
	}
	
	function update_users_profiles($params) {
		$this->connect_database();
		$query = "UPDATE users_profiles SET ";
		$numColumns = count($this->_table_users_profiles);
		for ($i=1 ; $i < $numColumns-1; $i++) {
			$string = $params[$i];
			if ( $string == "NULL") {
//				$query = $query.$this->_table_users[$i]." = ".$string.", ";	
			}else {
				$query = $query.$this->_table_users_profiles[$i]." = '".$string."', ";	
			}
		}
		$query = $query.$this->_table_users_profiles[$numColumns-1]." = ".$params[$numColumns-1]." ";
		$query = $query."WHERE ".$this->_table_users_profiles[0]."= '".$params[0]."';";
//		echo "query: ".$query."\n";
		$query = mysql_query($query);		
		return $this->check_query($query);
	}

// ---------------------------------------------------	
	function select_user($id_user){
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users WHERE ".$this->_table_users[0]." = '$id_user'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == true)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}		
	}
	
	function select_user_TAdminsMailing_PNombre_PPass($nombre, $pass) {
		$this->connect_database();
		$query = mysql_query("SELECT * FROM mailing_admin WHERE ".$this->_table_mailing_admin[1]."= '$nombre' AND"
								." ".$this->_table_mailing_admin[2]."= '$pass' LIMIT 1");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}
	}
	function select_user_PEmail_PPass($email, $pass){
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users WHERE ".$this->_table_users[9]."= '$email' AND"
								." ".$this->_table_users[8]."= '$pass' LIMIT 1");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;
		}else {
			return FALSE;
		}
	}	
		
	function select_all_users_from_users(){
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users");
		$resultOK = $this->check_query($query);
		if ( $resultOK == true)
		{			
			return $query;
		}else {
			return FALSE;
		}		
	}
	
	function delete_user($id_user){
		$this->connect_database();
		$query = mysql_query("DELETE FROM users where ".$this->_table_users[0]." = '$id_user' LIMIT 1");
		return $this->check_query($query);	
	}
		
	function update_user($id_user, $params){		
		$this->connect_database();
		$query = "UPDATE users SET ";
		$numColumns = count($this->_table_users);
		for ($i=1 ; $i < $numColumns-1; $i++) {
			$string = $params[$i];
			if ($i == 7 && $string == "NULL") {
				$query = $query.$this->_table_users[$i]." = '00000000', ";
			}else {
				if ( $string == "NULL") {
//					$query = $query.$this->_table_users[$i]." = ".$string.", ";	
				}else {
					$query = $query.$this->_table_users[$i]." = '".$string."', ";	
				}
			}
		}
		$query = $query.$this->_table_users[$numColumns-1]." = ".$params[$numColumns-1]." ";
		$query = $query."WHERE ".$this->_table_users[0]."= '$id_user';";
//		echo "query: ".$query."\n";
		$query = mysql_query($query);		
		return $this->check_query($query);
	}
	
	function insert_users_unsubscribe($id_users,$unique_id){
		$this->connect_database();
		$query = "INSERT INTO users_unsubscribe (";
		$numColumns = count($this->_table_users_unsubscribe);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_users_unsubscribe[$i].",";
			}else {
				$query = $query.$this->_table_users_unsubscribe[$i];
			}
		}
		$query = $query.") VALUES(";
		$query .="'$id_users','$unique_id')";
//		echo "".$query."\n";
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
	
	function select_all_darseDeBaja_Punique_id($unique_id) {
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users_unsubscribe WHERE ".$this->_table_users_unsubscribe[1]."= '$unique_id'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			return FALSE;
		}
	}
	
	function select_all_darseDeBaja_Pid_users($id_users) {
		$this->connect_database();
		$query = mysql_query("SELECT * FROM users_unsubscribe WHERE ".$this->_table_users_unsubscribe[0]."= '$id_users'");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			return FALSE;
		}
	}
	
	function delete_users_unsubscribe($id_user) {
		$this->connect_database();
		$query = mysql_query("DELETE FROM users_unsubscribe WHERE ".$this->_table_users_unsubscribe[0]." = '$id_user' LIMIT 1");
		return $this->check_query($query);	
	}
	
	function execute_select_query($query2) {
		$this->connect_database();
		$query = mysql_query($query2);
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			return $query;
		}else {
			return FALSE;
		}
	}
	function insert_emailsEnviados($params){
		$this->connect_database();
		$query = "INSERT INTO mailing_enviats (";
		$numColumns = count($this->_table_mailing_enviats);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_mailing_enviats[$i].",";
			}else {
				$query = $query.$this->_table_mailing_enviats[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			$string = $params[$j];
			if ($j == 4 && $string == "NULL") {
				$query = $query."00000000,";
			}else {
				if ($j != ($numParams-1)) {				
					if ( $string == "NULL") {
						$query = $query."NULL,";
					}else {
						$query = $query."'".$string."',";
					}
				}else {				
					if ( $string == "NULL") {
						$query = $query."NULL)";
					}else {
						$query = $query."'".$string."')";
					}				
				}
			}
		}
//		echo "".$query."\n";
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
	function select_all_emailsEnviados(){
		$this->connect_database();
		$query = mysql_query("SELECT ".$this->_table_mailing_enviats[1].",".$this->_table_mailing_enviats[2].","
							.$this->_table_mailing_enviats[6]." FROM mailing_enviats");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			return $query;
		}else {
			return FALSE;
		}
	}
	
	function select_all_from_emailsEnviados_PComentario($comentario) {
		$this->connect_database();
		$query = mysql_query("SELECT * FROM mailing_enviats WHERE ".$this->_table_mailing_enviats[1]." = '$comentario' LIMIT 1");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			return FALSE;
		}		
		
	}
	
	function delete_emailsEnviados_PComentario($comentario){
		$this->connect_database();
		$query = mysql_query("DELETE FROM mailing_enviats WHERE ".$this->_table_mailing_enviats[1]." = '$comentario' LIMIT 1");
		return $this->check_query($query);
	}
	
	function insert_gruposEnvios($nombre, $sentencia_sql){
		$params[0] = "NULL";
		$params[1] = $nombre;
		$params[2] = $sentencia_sql;
		
		$query = "INSERT INTO mailing_grups (";
		$numColumns = count($this->_table_mailing_grups);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_mailing_grups[$i].",";
			}else {
				$query = $query.$this->_table_mailing_grups[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			$string = $params[$j];			
			if ($j != ($numParams-1)) {				
				if ( $string == "NULL") {
					$query = $query."NULL,";
				}else {
					$query = $query."'".$string."',";
				}
			}else {				
				if ( $string == "NULL") {
					$query = $query."NULL)";
				}else {
					$query = $query."'".$string."')";
				}				
			}
		}
		
//		echo "".$query."\n";
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
	function select_all_nombre_gruposEnvios(){
		$this->connect_database();
		$query = mysql_query("SELECT nombre FROM mailing_grups");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			return $query;
		}else {
			return FALSE;
		}
	}
	
	function select_sqlQuery_gruposEnvios($grupo) {
		$this->connect_database();
		$query = mysql_query("SELECT * FROM mailing_grups WHERE ".$this->_table_mailing_grups[1]." = '$grupo' LIMIT 1");
		$resultOK = $this->check_query($query);
		if ( $resultOK == TRUE)
		{
			$row = mysql_fetch_array($query);
			return $row;			
		}else {
			return FALSE;
		}		
	}
	
	function delete_gruposEnvios($nombre){
		$this->connect_database();
		$query = mysql_query("DELETE FROM mailing_grups WHERE ".$this->_table_mailing_grups[1]." = '$nombre' LIMIT 1");
		return $this->check_query($query);
	}
	
	function insert_errores($params){
		$this->connect_database();
		$query = "INSERT INTO errores (";
		$numColumns = count($this->_table_mailing_errores);
		for ($i=0 ; $i < $numColumns; $i++) {
			if ($i != ($numColumns-1)) {
				$query = $query.$this->_table_mailing_errores[$i].",";
			}else {
				$query = $query.$this->_table_mailing_errores[$i];
			}
		}
		$query = $query.") VALUES(";
		$numParams = count($params); // == $numColumns
		for ($j=0 ; $j < $numParams ; $j++) {
			$string = $params[$j];			
			if ($j != ($numParams-1)) {				
				if ( $string == "NULL") {
					$query = $query."NULL,";
				}else {
					$query = $query."'".$string."',";
				}
//--			$query = $query."'".$params[$j]."',";
			}else {				
				if ( $string == "NULL") {
					$query = $query."NULL)";
				}else {
					$query = $query."'".$string."')";
				}				
//--			$query = $query."'".$params[$j]."')";
			}
		}
		
//		echo "".$query."\n";
		$insert = mysql_query($query);
		return $this->check_query($insert);
	}
	function select_all_errores(){
	}
	function delete_errores($id_errores){
	}
//--------------------------------
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
