<?php
	/********************************
	 ALL CODE © alessandroPERRONE.com
	 read the LICENSE AGREEMENT in
	 README_FIRST.txt file
	 ********************************/

	// NOTE: this code respects IWEDataManager FlashMX component requirements

	require_once("connection.php");
	
	$query = "SELECT * FROM iwe_gb_entries ORDER BY entrydate DESC";
	
	$result = @mysql_query($query) or die("&error=".mysql_error());
	
	$num_rows = mysql_num_rows($result);
	
	$num_fields = mysql_num_fields($result);
	
	echo "&num_rows=$num_rows&num_fields=$num_fields";
	
	if($num_rows > 0){
	
		for($i = 0; $i < $num_rows; $i++){
	
			$row = mysql_fetch_array($result);
			
			$id = $row['id'];
			$name = $row['name'];
			$email = $row['email'];
			if($email == "" || $email == " ") $email = NULL;
			$homepage = $row['homepage'];
			if($homepage == "" || $homepage == " ") $homepage = NULL;			
			$location = $row['location'];
			if($location == "" || $location == "\r\n\t\t\t\t  ") $location = NULL;			
			$entry = $row['entry'];
			$ipaddress = $row['ipaddress'];
			$hostname = $row['hostname'];
			$entrydate = $row['entrydate'];
			
			echo("&id$i=$id&name$i=$name&email$i=$email&homepage$i=$homepage&location$i=$location
				  &entry$i=$entry&ipaddress$i=$ipaddress&hostname$i=$hostname&entrydate$i=$entrydate");			
		}
		
	}else{
	
		echo "&error=No entries saved in the database";
		
	}
?>