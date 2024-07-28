<?

function get_pass_aleatorio(){

	$pass_length=6; /// this is the minimum length of the password 
	
	$p1=array('b','c','d','f','g','h','j','k','l','m','n','p','r','s','t','v','w','x','z'); // I hate the 'Q' 
	$p3=array('a','e','i','o','u'); // I hate 'Y' 
	$p2=array('1','2','3','4','5','6','7','8','9');        // 0 is not inside not to confuse people 
	$p4=array('ç','&','è',';','%');    // if you need real strong stuff 

// how much elements in the array 
// can be done with a array count but counting once here is faster 

	$s1=19;// this is the count of $p1    
	$s3=5; // this is the count of $p3
	$s2=9; // this is the count of $p2 
	$s4=5; // this is the count of $p4 
	
// possible readable combinations 
	
	$c1='121';    // will be like 'bab' 
	$c2='212';      // will be like 'aba' 
	$c3='12';      // will be like 'ab' 
	$c4='3';        // will be just a number '1 to 9'  if you dont like number delete the 3 
	// $c5='4';        // uncomment to active the strong stuff 
	
	$comb='4'; // the amount of combinations you made above (and did not comment out) 
	
	
	$previous = ""; //-----MIO
	$pass_structure = ""; //-----MIO
	
	for ($p=0;$p<$pass_length;) { 
	
		mt_srand((double)microtime()*1000000); 
		
		$strpart=mt_rand(1,$comb); 
		
		// checking if the stringpart is not the same as the previous one 
		if($strpart<>$previous) { 
			$pass_structure.=${'c'.$strpart}; 
			
			// shortcutting the loop a bit 
			$p=$p+strlen(${'c'.$strpart}); 
		} 
	
	$previous=$strpart; 
	} 
		
// generating the password from the structure defined in $pass_structure 
	$pass = ""; //-----MIO
	for ($g=0;$g<strlen($pass_structure);$g++) { 
		mt_srand((double)microtime()*1000000); 
	
		$sel=substr($pass_structure,$g,1);
		$pass.=${'p'.$sel}[mt_rand(0,-1+${'s'.$sel})]; 
	}
	
	return $pass; 
}
?>