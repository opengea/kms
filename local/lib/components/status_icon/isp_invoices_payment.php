<?
        $sel = "SELECT * from kms_isp_invoices where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $invoice=mysqli_fetch_array($res);

	$invoice_states=array("pendent"=>"<font color=#ff0000>"._KMS_GL_PENDING."</font>","remesa"=>"<font color=#5f3bef><b>"._KMS_ERP_REMESA."</b></font>","cobrat"=>"<font color=#00AA00><b>"._KMS_WEB_ECOM_STATUS_PAYED."</b></font>","retornat"=>"<font color=#ff0000><b>"._KMS_ERP_STATUS_RETORNAT."</b></font>","anulat"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT."</b></font>","impagada"=>"<font color=#ff0000><b>"._KMS_GL_STATUS_IMPAGADA."</b></font>");

        if ($invoice['status']=="impagada"||$invoice['status']=="retornat"||($invoice['status']=="pendent"&&$invoice['sr_remittance']==0&&$invoice['payment_method']!=3)) {
		$title=_KMS_ISP_INVOICES_PAY;
		$base_call="/?app=".$_GET['app']."&mod=".$_GET['mod']."&from=".$_GET['from']."&xid=".$_GET['xid']."&_=f&id=$id";
		$msg="<div style='float:left;padding-top:-5px'>".$invoice_states[$invoice['status']]."</div><div style='float:left;padding-left:5px;margin-top:-3px'><a href=\"$base_call&action=invoice_payment\" title=\"".$title." (TPV)\"><img src=\"/kms/css/aqua/img/small/visa-icon.png\"></a></div>";
		$msg.="<div style='float:left;padding-left:5px;margin-top:0px'><a href=\"$base_call&action=invoice_payment_paypal\" title=\"".$title." (PayPal)\"><img src=\"/kms/css/aqua/img/small/paypal.gif\"></a></div>";

	} else {
		$msg=$invoice_states[$invoice['status']];
	}


        $out="<div style='float:left'>".$msg."</div><div style='float:left;padding-left:5px;padding-top:2px;'>";
        if ($this->show_label) $out.=$label;
        $out.="</div>";
?>
