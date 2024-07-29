<?
 function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
    return;
}

function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}

function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
return;
} 


if ($_GET['pw']=="834hofw39832ZXvDBiF9832") {


$filename="comandes";

 // Send Header
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=$filename.xls ");
    header("Content-Transfer-Encoding: binary ");


    include("../conf/db.php");

        $result = mysql_query("SELECT * FROM kms_shoppingcart WHERE id>".$_GET['lastid']." AND status='enproceso'");
        if (!$result) {    echo mysql_error();    exit;         }

                xlsBOF();
                xlsWriteLabel(0,1,"User type");
                xlsWriteLabel(0,2,"Full name");
                xlsWriteLabel(0,3,"Address");
                xlsWriteLabel(0,4,"Province");
                xlsWriteLabel(0,5,"Zipcode");
                xlsWriteLabel(0,6,"Location");
                xlsWriteLabel(0,7,"DNI");
                xlsWriteLabel(0,8,"Phone");
                xlsWriteLabel(0,9,"Cellphone");
                xlsWriteLabel(0,10,"Email");
                xlsWriteLabel(0,11,"Date");	
                xlsWriteLabel(0,12,"Id");
                xlsWriteLabel(0,13,"Reference");
                xlsWriteLabel(0,14,"Quantity");
                xlsWriteLabel(0,15,"Price unit");
                xlsWriteLabel(0,16,"Total import (iva included)");

		$i=0;

        while($rowCart = mysql_fetch_array($result)){
		$i++;
                $result2 = mysql_query("SELECT * FROM kms_sys_users where email='".$rowCart['id_user']."'");
                if (!$result) {    echo mysql_error();    exit;         }
                $rowUser = mysql_fetch_array($result2);
                $usertype = "usuario";
		    // XLS Data Cell

                xlsWriteLabel($i,1,$usertype);
                xlsWriteLabel($i,2,$rowUser['name']);
                xlsWriteLabel($i,3,$rowUser['address']);
                xlsWriteLabel($i,4,$rowUser['province']);
                xlsWriteLabel($i,5,$rowUser['zipcode']);
                xlsWriteLabel($i,6,$rowUser['location']);
                xlsWriteLabel($i,7,$rowUser['nif']);
                xlsWriteLabel($i,8,$rowUser['phone']);
                xlsWriteLabel($i,9,$rowUser['cellphone']);
                xlsWriteLabel($i,10,$rowUser['email']);
                xlsWriteLabel($i,11,$rowCart['creation_date']);
                xlsWriteLabel($i,12,$rowCart['id']);
		xlsWriteLabel($i,13,$rowCart['ref']);
		xlsWriteLabel($i,14,$rowCart['quantity']);
		xlsWriteLabel($i,15,$rowCart['priceunit']);
		xlsWriteLabel($i,16,$rowCart['totalimport']);
//		xlsWriteNumber($xlsRow,0,"$i");

		}

                xlsEOF();

                 exit();


} else { echo "KO, acc&eacute;s denegat"; }


?>

