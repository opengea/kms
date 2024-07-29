<?

error_reporting(E_ALL);

function valid_email($email)
{
   // check if email is valid

   if( !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"
   ."@([a-z0-9]+([\.-][a-z0-9]+))*$",$email, $regs))
   {
      return false;
//-- el servidor houndline.com no funciona-----?????      
   } else if( gethostbyname($regs[2]) == $regs[2] )
   {
      // if host is invalid
      return false;
   } else {
      return true;
   }
}

function valid_userName($name)
{
   // check valid input name
   if(!eregi("^[a-z0-9]{6,15}$",$name))
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

function get_unique_id()
{
	$uid = md5(uniqid(microtime(),1)).getmypid();
	return $uid;
}

?>