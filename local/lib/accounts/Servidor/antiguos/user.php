<?
set_time_limit(0);
require_once('conf.inc.php');
require_once('functions.php');
include("cmailer.php");
// ---
// register new user
// ---
function register($username,$pass,$email)
{
   GLOBAL $db, $table;
   $username = trim($username);
   $pass = trim($pass);
   $email = trim($email);
//Comprobamos que el userneame no esté repetido
   $validName = valid_userName($username);
   $usernameRepetido = mysql_query("SELECT * FROM $table WHERE userName = '$username'");
   if (mysql_num_rows($usernameRepetido) == 1)
   {
   	return "ko&at=username&error=Por favor, eliga otro nombre de usuario";
   }
//Comprobamos que el e-mail no esté repetido
   $validEmail = valid_email($email);
   $emailRepetido = mysql_query("SELECT * FROM $table WHERE userMail = '$email'");
   if (mysql_num_rows($emailRepetido) == 1)
   {
   	return "ko&at=email&error=El email introducido no es correcto1";
   }      
//   
   $validPass = valid_password($pass);
//-----------------------   
//   if(!$validName) return "error=invalid name";
   if(!$validName) return "El username introducido no es correcto";
   if(!$validPass) return "El password introducido no es correcto";
   if(!$validEmail) return "ko&at=email&error=El email introducido no es correcto";
//   $pass = md5(trim($pass));
   // all checks ok
//   $query = @mysql_query("INSERT INTO $table (userName,userPassword,userMail,userQuestion,userAnswer) VALUES "
//   ."('$username','$pass','$email','$question','$answer')");
   $query = mysql_query("INSERT INTO $table (userName,userPassword,userMail) VALUES "
   ."('$username','$pass','$email')");
   if(!$query)
   {
//      return "error=" . mysql_error();
	return mysql_error();
   } else {
//      $envioEmailOK = enviarEmail($email,$username);
//      enviarEmail($email,$username);
	
	$m = new cMailer();
	$m->AddAddress($email);
//$m->AddAddress("dir2@dominio.com");

	$m->AddSender("dserver@dserver.net");
	$m->AddSubject("Bienvenid@ a Dserver.net");
	$m->AddMessage("Hola " . $username . ",\r\n"
	."\r\n"
	."     Gracias por utilizar nuestros servicios web's....\r\n");	
	$m->AddHost("dserver.net");
	$m->Send();
	
      return "ok";
   }
}

// ---
// login, check user
// ---
function login($username,$pass)
{
   GLOBAL $db,$table;
   $username = trim($username);
//   $pass = md5(trim($pass));
   $pass = trim($pass);
//   $query = mysql_query("SELECT * FROM $table WHERE userName = '$username' AND userPassword = '$pass'");
   $query = mysql_query("SELECT userPassword FROM $table WHERE userName = '$username'");

   if (mysql_result($query,0) == $pass)
   {
   	return "ok";
   }else
   {
   	return "ko";
   }
   	
//   return mysql_num_rows($query);
}

// ---
// forget password
// ---
function forget($email)
{
   GLOBAL $db,$table;
   $email = trim($email);
   $query = mysql_query("SELECT userName, userQuestion from $table WHERE userMail = '$email'");
   if(mysql_num_rows($query)<1)
   {
      return "error=email not present into database";
   }
   $row = mysql_fetch_array($query);
   return "userName=$row[userName]&userQuestion=" . stripslashes($row['userQuestion']);
}

// ---
// generate new password
// ---
function new_password($username,$email,$answer)
{
   GLOBAL $db,$table;
   $username = trim($username);
   $email = trim($email);
   $answer = addslashes(trim($answer));
   $query = mysql_query("SELECT * FROM $table WHERE userName = '$username' AND userMail = '$email' AND userAnswer = '$answer'");
   if(mysql_num_rows($query) < 1)
   {
      return "error=wrong answer";
   }
   $rand_string = '';
   // ---
   // generating a random 8 chars lenght password
   // ---
   for($a=0;$a<7;$a++)
   {
      do
      {
         $newrand = chr(rand(0,256));
      } while(!eregi("^[a-z0-9]$",$newrand));
      $rand_string .= $newrand;
   }
   $pwd_to_insert = md5($rand_string);
   $new_query = mysql_query("UPDATE $table SET userPassword = '$pwd_to_insert' WHERE userName = '$username' AND userMail = '$email'");
   if(!$new_query)
   {
      return "error=unable to update value";
   }
   return "userName=$username&new_pass=$rand_string";
}

// ---
// decisional switch
// ---
if(isset($HTTP_POST_VARS["action"]))
{
   switch($HTTP_POST_VARS["action"])
   {
      case "register":
//         $result = register($HTTP_POST_VARS['username'],$HTTP_POST_VARS['pass'],$HTTP_POST_VARS['email'],$HTTP_POST_VARS['question'],$HTTP_POST_VARS['answer']);
	 $result = register($HTTP_POST_VARS['username'],$HTTP_POST_VARS['pass'],$HTTP_POST_VARS['email']);
         print "user=" . $result;
         break;
      case "login":
         $result = login($HTTP_POST_VARS['username'],$HTTP_POST_VARS['pass']);
         print "user=" . $result;
         break;
      case "forget":
         $result = forget($HTTP_POST_VARS['email']);
         print $result;
         break;
      case "new_password":
         $result = new_password($HTTP_POST_VARS['username'],$HTTP_POST_VARS['email'],$HTTP_POST_VARS['answer']);
         print $result;
         break;
   }
}
?>