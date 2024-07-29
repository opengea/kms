<?

	$res = array();
	//            $result = $this->dm->dbi->query($this->dm->dblinks['client'],$sql);
        //$fields  = $this->dm->dbi->fetch_array($result);
	//$fields = $this->_get_fieldnames();
//	print_r ($dm);exit;
//	echo $dm->fields['sr_invoice'];
	$check_sent=0;
        $sel = "SELECT $field FROM kms_erp_invoices_sending_log where sr_invoice=".$fields['sr_invoice']." and type=1 order by id desc";
	if (mysqli_num_rows($sel)>0) { $res['sent']=1; $check_sent=1; }
        $sel = "SELECT $field FROM kms_erp_invoices_sending_log where sr_invoice=".$fields['sr_invoice']." and type=2 order by id desc";
        if (mysqli_num_rows($sel)>0) $res['t1']=1;
        $sel = "SELECT $field FROM kms_erp_invoices_sending_log where sr_invoice=".$fields['sr_invoice']." and type=3 order by id desc";
        if (mysqli_num_rows($sel)>0) $res['t2']=1;

$t=0;
	//enviades
        $sel = "SELECT type,sent_date,sent_to FROM kms_erp_invoices_sending_log where sr_invoice=".$id." and type=1 order by id desc";
	$res=mysqli_query($this->dm->dblinks['client'],$sel);$data=mysqli_fetch_array($res);
        if (mysqli_num_rows($res)>0) { $check_sent=1; $out="<span style='color:#090;font-family:verdana' onmouseover='this.style.cursor=\"pointer\"' title='Enviada&#13\r\n".$data['sent_date']."&#13;\r\n".$data['sent_to']."'>*</span>"; }

	//t1
        $sel = "SELECT type,sent_date,sent_to FROM kms_erp_invoices_sending_log where sr_invoice=".$id." and type=2 order by id desc";
	$res=mysqli_query($this->dm->dblinks['client'],$sel);$data=mysqli_fetch_array($res);
        if (mysqli_num_rows($res)>0) {$t=1; $out.="<span style='color:#f00;font-family:verdana' onmouseover='this.style.cursor=\"pointer\"' title='Terminator 1&#13\r\n".$data['sent_date']."&#13\r\n".$data['sent_to']."'>*</span>";}

	//t2
        $sel = "SELECT type,sent_date,sent_to FROM kms_erp_invoices_sending_log where sr_invoice=".$id." and type=3 order by id desc";
//echo $sel."<br>";
	$res=mysqli_query($this->dm->dblinks['client'],$sel);$data=mysqli_fetch_array($res);
        if (mysqli_num_rows($res)>0) {$t=2; $out.="<span style='color:#f00;font-family:verdana' onmouseover='this.style.cursor=\"pointer\"' title='Terminator 2&#13\r\n".$data['sent_date']."&#13\r\n".$data['sent_to']."'>*</span>"; }

if ($check_sent==1) $update_status="update kms_erp_invoices set check_sent=$check_sent,status_terminator=".$t." where id=".$id; 
else $update_status="update kms_erp_invoices set  status_terminator=".$t." where id=".$id;

$res=mysqli_query($this->dm->dblinks['client'],$update_status);

		
?>
