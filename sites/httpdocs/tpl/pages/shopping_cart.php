<? 
include "config/scart.php";
include "lib/scart.functions.php";

if ($_GET['p']=="checkout"&&$_SESSION['operation']!="") {

	$insert="insert into kms_cat_clients (creation_date,name,email,phone,address,location,postalcode,country,comments,idioma) VALUES (
			\"".date('Y-m-d H:i:s')."\",
			\"".mysqli_real_escape_string($dblink,$_POST['name'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['email'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['email'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['address'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['location'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['postalcode'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['country'])."\",
			\"".mysqli_real_escape_string($dblink,$_POST['comments'])."\",
			\"".strtolower($_GET['l'])."\")";
	$res=mysqli_query($dblink,$insert);
	$customer_id=mysqli_insert_id($dblink);
	if ($customer_id=="") die("Can't insert client into database<br>".$insert);

	$pm=$_POST['pm'];
	$update="update kms_cat_sales set customer=".$customer_id." where operation=".$_SESSION['operation'];
	$res=mysqli_query($dblink,$update);
	$update="update kms_cat_comandes set payment_method='{$pm}',status='processing',customer=".$customer_id." where id=".$_SESSION['operation'];
        $res=mysqli_query($dblink,$update);

	$sel="select * from kms_cat_comandes where id=".$_SESSION['operation']." and customer=".$customer_id;
	$res=mysqli_query($dblink,$sel);
	$order=mysqli_fetch_assoc($res);

	$sel="select * from kms_cat_clients where id=".$customer_id;
	$res=mysqli_query($dblink,$sel);
        $client=mysqli_fetch_assoc($res);

	echo "<br>";
	//echo "total=".$order['total'];
	include "lib/".$_POST['pm'].".checkout.php";

} else if ($_GET['p']=="success") { 
	// ------------------ success page -------------------------
	  $_SESSION['operation']=""; // empty cart
?>
<div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
        <div class="col-12 col-sm-12 col-md-9 col-lg-9">

	<h2><?=$ll['thanks_purchase']?></h2>
	<br>
	<?=$ll['we_will_contact_shorty']?>
	<br><br><br><br><br><br><br><br>
	</div>
</div>

<?	

} else {  
	// ------------------ Shopping cart page -----------------------
?>
<div class="row">
	<div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
	<div class="col-12 col-sm-12 col-md-9 col-lg-9">
		<h4><?=$ll['shopping_cart']?></h4><hr><br>
		<? echo add_shopping_cart($_SESSION['operation'],"screen");?>
		<br>

<? if ($num_articles>0) { 
		// -------------------- shippment form -----------------------------
		?>

		<h4><?=$ll['contact_shipment_data']?></h4>
		<hr>
                <form method="POST" action="<?=$url_base_lang?>/shopping_cart/checkout">
                <div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['fullname']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><input required type="text" name="name" size="30" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['email']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><input required type="email" name="email" size="30" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['phone']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><input required type="text" name="phone" size="30" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['address']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><input required type="text" name="address" size="30" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['location']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><input required type="text" name="location" size="30" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['postalcode']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><input required type="text" name="postalcode" size="30" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['country']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><select required type="text" name="country" onchange="update_shipping(this.value,scart)" oninvalid="this.setCustomValidity('<?=$ll['fill_required_field']?>')"><? foreach ($scart['shipping_countries'] as $country) { ?> <option name='<?=$country?>'><?=$ll[$country]?></option> <? } ?></select></div>
                </div>
		<div class="row form">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"><b><?=$ll['comments']?></b></div>
                         <div class="col-12 col-sm-12 col-md-9 col-lg-9"><textarea name="comments" rows="4" cols="50"></textarea></div>
                </div>
		<br>
		<input type="hidden" name="comanda" value="<?=$_SESSION['operation']?>" readonly>
<?              $sel="select * from kms_cat_sales where operation=".$_SESSION['operation'];
                $res=mysqli_query($dblink,$sel);
		$num_items=1;
                while ($row=mysqli_fetch_assoc($res)) {
		//select product
                        $sel="select * from kms_cat_productes where id=".$row['item'];
                        $res2=mysqli_query($dblink,$sel);
                        $product=mysqli_fetch_assoc($res2);
			
 ?>
                <input id="op<?=$num_items?>" type="hidden" value="<?=$product['preu']?>" readonly>
<?
		$num_items++;
		 } //while ?>
		<input id="total_form" type="hidden" name="total" value="<?=$total?>" readonly>
		<input id="shipping" type="hidden" name="shipping" value="<?=$shipping?>" readonly>

                <h4><?=$ll['payment_method']?></h4>
                <hr>

		<div class="row scart_row">
                         <div class="col-12 col-sm-12 col-md-3 col-lg-3"></div>
                        <div class="col-12 col-sm-12 col-md-9 col-lg-9">

		<select name="pm" style="max-width:400px">
		<?
		foreach ($scart['payment_methods'] as $pm) {
			?>
			<option value="<?=$pm?>"><?=$ll[$pm]?></option>
			<?
		}
		?>
		</select>
		<br><br><br>

                        </div>
                </div>

		<?//submit ?>
                <button class="btn"><?=$ll['submit_order']?></button>
		</form>
                </div>

		<?  } //num_articles>0?>
</div>
		<?
		}
?>

<script type="text/javascript" src="/lib/scart.js"></script>
<script>
scart = { 
	shipping:<?=$scart['shipping']?>,
	shipping_international:<?=$scart['shipping_international']?>,
	url_base:'<?=$url_base?>',
	order_id:'<?=$_SESSION['operation']?>',
	iva_pc:<?=$scart['iva_pc']?>,
	num_items:<?=$num_items?>,
}
update_shipping("spain",scart);
</script>

