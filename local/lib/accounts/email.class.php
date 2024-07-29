<?
class Email{
	
	var $_from;
	var $_to;
	var $_subject;
	var $_message;
	var $_is_html;
	
	var $_rp;
	var $_org;
	var $_mailer;
	
	function Email($from = '', $to, $subject, $message, $is_html) {
		$from = trim($from);

		if (!$from) {
			$from = 'registros@scalextric.es';
		}
		
		$this->_rp    = 'registros@scalextric.es';
		$this->_org    = 'scalextric.es';
//		$this->_mailer = '';
		
		$this->_from = $from;
		$this->_to = $to;
		$this->_subject = $subject;
		$this->_message = $message;
		$this->_is_html = TRUE;

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
//			$head  .= "Content-Type: text/html \n";
			$head  .= "Content-Type: text/html;charset=\"iso-8859-1\"\n";
			$head  .= "Content-Transfer-Encoding: 8bit\n";
		}else {
			$head  .= "Content-Type: text/plain \n";
		}
		
		$head  .= "X-Mailer: intergrid.cat\n";
		
		$this->_message  = str_replace("\n", "\n", $this->_message);
		$this->_message  = str_replace("\n", "\n", $this->_message);
		
		return mail($this->_to, $this->_subject, $this->_message, $head);
		
	}
}
?>
