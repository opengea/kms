<?

error_reporting(E_ALL);

function valid_email($email)
{
   // check if email is valid
	if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"
		."@[a-z0-9]+([_\\.-][a-z0-9]+)*"
		."\.[a-z]+([_\\.-][a-z]+)*$",$email, $regs))
	{
/*   	
   if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"
   ."@([a-z0-9]+([\.-][a-z0-9]+))*$",$email, $regs))
   {
*/   
      return false;
//-- el servidor houndline.com no funciona-----?????      
//   } else if( gethostbyname($regs[2]) == $regs[2] )
//   {
//
      // if host is invalid
//      return false;
   } else {
      return true;
   }
}

function valid_userName($name)
{
   // check valid input name
   if(!eregi("^[אבטילםעףשתסחa-z0-9]{3,15}$",$name))
   {
      return false;
   } else {
      return true;
   }
}

function valid_password($pwd)
{
   // check valid password
   if(!eregi("^[a-z0-9]{6,8}$",$pwd))
   {
      return false;
   } else {
      return true;
   }
}

function valid_fecha($fecha)
{
	// check valid data	
	if ( strlen($fecha) == 8) {
		$day = substr($fecha,0,2);
		$month = substr($fecha,2,2);
		$year = substr($fecha,4);
//		echo "dia:".$day." mes:".$month." aסo:".$year."\n";

		if ( !checkdate($month,$day,$year))
		{
    	  return false;
		} else {
    	  return true;
		}
	}else {
    	  return false;
	}
}

function get_unique_id()
{
	$uid = md5(uniqid(microtime(),1)).getmypid();
	return $uid;
}

?>