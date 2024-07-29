<?

class cMailer{

	var $_Addresses;
	var $_countAdd = 0;
	var $_ConexionSMTP;
	var $_Sender;
	var $_server;
	var $_Subject = "";

	function cMailer(){
	}

	function AddAddress($address){
		$this->_Addresses[$this->_countAdd] = $address;
		$this->_countAdd++;
	}

	function AddSender($sender){
		$this->_Sender = $sender;
	}

	function AddMessage($message){
		$this->_Message = $message;
	}

	function AddSubject($subject){
		$this->_Subject = $subject;
	}

	function Send(){
		
//		$strEHLO = "HELO ".$this->_server."\r\n";		
		$strEHLO = "EHLO 64.87.104.135\r\n";
		fputs($this->_ConexionSMTP,$strEHLO);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);
		fgets($this->_ConexionSMTP,512);

		$strMAIL = "MAIL FROM: ".$this->_Sender."\r\n";
		fputs($this->_ConexionSMTP,$strMAIL);
		fgets($this->_ConexionSMTP,512);
		$strRCPT = "";
		for($i=0;$i<$this->_countAdd;$i++){
			$strRCPT .= "RCPT TO: ".$this->_Addresses[$i]."\r\n";
		}

//		$strRCPT .= "\r\n";
		fputs($this->_ConexionSMTP,$strRCPT);
		fgets($this->_ConexionSMTP,512);

		$strDATA1 = "DATA\r\n";
		fputs($this->_ConexionSMTP,$strDATA1);
		fgets($this->_ConexionSMTP,512);
		
		fputs($this->_ConexionSMTP,"From: ".$this->_Sender."\r\n");
		fputs($this->_ConexionSMTP,"To: ".$this->_Addresses[0]."\r\n");
		fputs($this->_ConexionSMTP,"Subject: ".$this->_Subject."\r\n");

//		if($this->_Subject != ""){
//
//			$strS = "Subject: ".$this->_Subject."\r\n\r\n";
//			fputs($this->_ConexionSMTP,$strS);
//		}

		$strDATA2 = $this->_Message."\r\n.\r\n";
		fputs($this->_ConexionSMTP,$strDATA2);
		fgets($this->_ConexionSMTP,512);
		
		fputs($this->_ConexionSMTP,"QUIT\r\n");
		fgets($this->_ConexionSMTP,512);

		fclose($this->_ConexionSMTP);
		return true;
	}

	function AddHost($host,$port=25){
//		fsockopen("$host","$port",$e,$em,5) or die("no puedorl");
//		$fp=fsockopen("dserver.net",25);
		$this->_ConexionSMTP = fsockopen("64.87.104.135",25);
//		echo fgets($this->_ConexionSMTP,4096);
//		fgets($this->_ConexionSMTP,4096);
		$this->_server = $host;
	}

}

?>