<? 
include "config/scart.php";

if ($_POST['action']=="scart_remove"&&$_SESSION['operation']!="") { 

		

		$sel="delete from kms_cat_sales where id=".$_POST['id']." and operation=".$_SESSION['operation'];
		$res=mysqli_query($dblink,$sel);
		$_GET['s']="shopping_cart";

		//if there are no more sales, delete order too
		$sel="select * from kms_cat_comandes where id=".$_SESSION['operation'];
		$res=mysqli_query($dblink,$sel);
		$num_items=mysqli_num_rows($res);
		if ($num_items==0) {
			$sel="delete from kms_cat_comandes where id=".$_SESSION['operation'];
	                $res=mysqli_query($dblink,$sel);
		}

} else if ($_POST['action']=="scart_add") {

		if ($_SESSION['total']=="") $_SESSION['total']=0;
		if ($_SESSION['customer']=="") $_SESSION['customer']=0;	

		//read item
		$sel="select * from kms_cat_productes where id=".$_POST['item'];	
		$res=mysqli_query($dblink,$sel);
		$product=mysqli_fetch_array($res);

		//insert order	
		if ($_SESSION['operation']!="") { //read order
			$sel="select * from kms_cat_comandes where id=".$_SESSION['operation'];
                        $res=mysqli_query($dblink,$sel);
			$comanda=mysqli_fetch_assoc($res);
			if ($comanda['id']=="") $_SESSION['operation']="";
		}
		if ($_SESSION['operation']=="") { 

		$base=$_SESSION['total'];
		$iva=($base*$scart['iva_pc'])/100;
		$_SESSION['total']=$base+$iva;

			$insert="insert into kms_cat_comandes (creation_date,status,customer,currency,base,iva,shipping,total,ipaddress) values ('".date('Y-m-d H:i:s')."','pending','".$_SESSION['customer']."','{$scart['currency']}','{$base}','{$iva}','{$scart['shipping']}','".$_SESSION['total']."','".$_SERVER['REMOTE_ADDR']."')";
			$res=mysqli_query($dblink,$insert);
			$_SESSION['operation']=mysqli_insert_id($dblink);
		}

		//insert item
		if ($product['id']=="") die('Product unavailable');
                $_SESSION['total']+=$product['preu'];

		//mirem si ja existeix l'article, i si existeix augmentem la quantitat, sinó afegim
		$sel="select * from kms_cat_sales where operation='".$_SESSION['operation']."' and customer='".$_SESSION['customer']."' and item='".$product['id']."'";
		$res=mysqli_query($dblink,$sel);
		$row=mysqli_fetch_assoc($res);
		if ($row['id']=="") {
			$quantity=1;
			$subtotal=$product['preu']*$quantity;
			$insert="insert into kms_cat_sales (creation_date,operation,customer,item,quantity,price,subtotal,ipaddress) values ('".date('Y-m-d H:i:s')."',".$_SESSION['operation'].",".$_SESSION['customer'].",".$product['id'].",".$quantity.",'".$product['preu']."','".$subtotal."','".$_SERVER['REMOTE_ADDR']."')";
                	$res=mysqli_query($dblink,$insert);

		} else {
			$quantity=$row['quantity']+1;
			$subtotal=$row['price']+$product['preu'];
			$update="update kms_cat_sales set quantity='{$quantity}',subtotal='{$subtotal}' where operation='".$_SESSION['operation']."' and customer='".$_SESSION['customer']."' and item='".$product['id']."'";
			$res=mysqli_query($dblink,$update);
		}


                $_GET['s']="shopping_cart";	
 }


//read items
                $sel="select * from kms_cat_sales where operation=".$_SESSION['operation'];
                $res=mysqli_query($dblink,$sel);
		$total=0;
		$num_articles=0;
                while ($row=mysqli_fetch_assoc($res)) {
                        //select product
                        $sel="select * from kms_cat_productes where id=".$row['item'];
                        $res2=mysqli_query($dblink,$sel);
                        $product=mysqli_fetch_assoc($res2);
                        //echo $product['title']." ".$product['preu']." €<br>";
			$total=$total+$row['price'];//+$product['preu'];
			$num_articles+=$row['quantity'];

                }
		echo "<b>".$num_articles."</b> ".$ll['articles']."<br><hr>";
		//echo "Total:<b> ".$total."</b>€ <br>";  //ocultem perque no esta comptat l'iva
                //echo "<hr>";
		echo "<a href=\"".$url_base_lang."/shopping_cart\">".$ll['open_shopping_cart']."</a>";


if ($_SESSION['scart']=="1") {


}
?>
