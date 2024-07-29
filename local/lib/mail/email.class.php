<?php
/* Send Email PHP Class 
/* By Jordi Berenguer <j.berenguer@intergrid.cat>
   15-06-2003

   USAGE:
   
   $subject = "hi";
   $body = "hello";
   $email = new Email("from@email.com", "to@email.com", $subject, $body, 1);
   $goodemail = $email->send();
   if ($goodemail) echo "success!"; else echo "fail!";
*/

class Email{
	
	var $_from;
	var $_to;
	var $_subject;
	var $_message;
	var $_is_html;
	
	var $_rp;
	var $_org;
	var $_mailer;
	
	function Email($from, $to, $subject, $message, $is_html) {
		$from = trim($from);

//		$this->_mailer = '';
		$this->_from = $from;
		$this->_to = $to;
		$this->_subject = $subject;
		$this->_message = $message;
		if ($is_html == 1){
			$this->_is_html = TRUE;
		}else{
			$this->_is_html = FALSE;
		}
	}
			
   function send() {
                $head  = '';
                $head  .= "Date: ". date('r'). " \n";
                $head  .= "Return-Path: $this->_rp \n";
                $head  .= "From: $this->_from \n";
                $head  .= "Sender: $this->_from \n";
                $head  .= "Reply-To: $this->_from \n";
                $head  .= "Organization: $this->_org \n";
                $head  .= "X-Sender: $this->_from \n";
                $head  .= "X-Priority: 3 \n";
                $head  .= "MIME-Version: 1.0\n";

                if ( $this->_is_html == true ) {
//                      $head  .= "Content-Type: text/html \n";
                        $head  .= "Content-Type: text/html;charset=\"UTF-8\"\n";
                        $head  .= "Content-Transfer-Encoding: 8bit\n";
                }else {
                        $head  .= "Content-Type: text/html;charset=\"UTF-8\"\n";
                        $head  .= "Content-Transfer-Encoding: 8bit\n";
                        $head  .= "Content-Type: text/plain \n";
                }
/*
                $head  .= "X-Mailer: intergrid.cat\n";
                //$this->_message  = str_replace("\n", "\n", $this->_message);
                //$this->_message  = str_replace("\n", "\n", $this->_message);
//include "/usr/share/kms/lib/pear/Mail/mime.php";
                $message = new Mail_mime();
                $message->setHTMLBody($this->_message);
                $body = $message->get();
                $host = "g1.intergridnetwork.net";
                $port = "25";
                $username = "suport@intergrid.cat";
                $password = "CrunC0ptsuin";
                $extraheaders = array(
                  'From' => $this->_fromname." <".$username.">",
                  'Reply-to' => $this->_from,
                  'To' => $this->_to,
                  'Date' => date('D, d M Y H:i:s O'),
                  'Subject' => $this->_subject,
                  'X-Mailer' => 'Intergrid KMS',
                  'X-Priority' => '1');
                $headers = $message->headers($extraheaders);
                $smtp = Mail::factory('smtp',
                  array ('host' => $host,
                    'port' => $port,
                    'auth' => false,
                    'username' => $username,
                    'password' => $password,
                    'localhost' => 'g1.intergridnetwork.net'));
        //      $message = Mail::compose($headers, $body);
        //      $message->setFrom($this->_from, $this->_fromName);
//              $mail = $smtp->send($this->_to,$message);

                $mail = $smtp->send($this->_to, $headers, $body);
                if (PEAR::isError($mail)) {
                  $resultmail  = "ERROR " . $mail->getMessage();
                 } else {
                  $resultmail = "OK";
                 }
                return $resultmail;
//              return mail($this->_to, $this->_subject, $this->_message, $head);
*/
        }
}
?>
