<?php
	/********************************
	 ALL CODE © alessandroPERRONE.com
	 read the LICENSE AGREEMENT in
	 README_FIRST.txt file
	 ********************************/
	
	require_once("connection.php");
	
	$query = "SELECT head_color, row1_color, row2_color, font_normal_color, font_head_color, welcome_text, head_text, logo FROM iwe_gb_settings";
	
	$result = @mysql_query($query) or die("&error=".mysql_error());

	$num_rows = mysql_num_rows($result);
	
	$num_fields = mysql_num_fields($result);
			
	if($num_rows <> 1) echo "&error=Data error: query result does not match application request";
			
	else{
		
		echo "&num_rows=$num_rows&num_fields=$num_fields";
			
		$row = mysql_fetch_assoc($result);
				
		$message = "&head_color=".$row['head_color']."&row1_color=".$row['row1_color']."&row2_color=".$row['row2_color'];
		$message .= "&font_normal_color=".$row['font_normal_color']."&font_head_color=".$row['font_head_color'];
		$message .= "&welcome_text=".$row['welcome_text']."&head_text=".$row['head_text']."&logo=".$row['logo'];
				
		echo "$message";
				
		mysql_free_result($result);
				
	}
?>