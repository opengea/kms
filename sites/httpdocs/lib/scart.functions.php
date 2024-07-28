<?
function add_shopping_cart($order_id,$format) {
		global $ll,$dblink,$url_base,$url_base_lang,$scart;
		$return="";

                $sel="select * from kms_cat_sales where operation=".$order_id; 
                $res=mysqli_query($dblink,$sel);
                $num_articles=mysqli_num_rows($res);
                if ($num_articles==0) return $ll['empty_cart']."<br><br>"; else {
		if ($format=="email") {
//		$return="<strong>".$ll['order_detail']."</strong><br><br><table style='font-family:monospace;font-size:12px;border:1px solid #ccc;width:100%;max-width:600px;border-collapse:collapse' cellpadding='0' cellspacing='0'><tr><td>".$ll['article']."</td><td>".$ll['quantitat']."</td><td>".$ll['total']."</td></tr>";
		if ($ll['order_detail']=="") $ll['order_detail']="DETALLE DE LA COMPRA";
		$return="<strong>".$ll['order_detail']."</strong><br><br>";
		} else { 
                $return="
                <div class=\"row no-gutters scart_header\">
                         <div class=\"col-1 col-sm-1 col-md-1 col-lg-1\"></div>
                        <div class=\"col-6 col-sm-6 col-md-7 col-lg-7\">".$ll['article']."</div>
                        <div class=\"col-2 col-sm-2 col-md-2 col-lg-2\">".$ll['quantitat']."</div>
                        <div class=\"col-3 col-sm-3 col-md-2 col-lg-2 price\">".$ll['total']."</div>
                </div>";
		}

                $total=0;$i=1;
                while ($row=mysqli_fetch_assoc($res)) {
                        //select product
                        $sel="select * from kms_cat_productes where id=".$row['item'];
                        $res2=mysqli_query($dblink,$sel);
                        $product=mysqli_fetch_assoc($res2);
                        $base=$product['preu']*$row['quantity'];
                        $row['price']=$product['preu']*$row['quantity'];

			if ($format=="email") {
	//		$return.="<tr><td>".$product['title']."<br>".$ll['descompte']."</td><td>".$row['quantity']."</td><td>".$product['preu']." &euro;</td></tr>";
			$return.=$row['quantity']." x <a href='".$url_base_lang."/cataleg/".urlize($product['title'])."' target='_new'>".$product['title']."</a>";
			} else {
                        $return.="
                        <div class=\"row no-gutters scart_row\">
                        <div class=\"col-1 col-sm-1 col-md-1 col-lg-1\" style=\"text-align:center\"><form method=\"POST\" action=\"".$url_base_lang."/shopping_cart/remove\"><input type=\"hidden\" name=\"action\" value=\"scart_remove\"><input title=\"Eliminar\" type=\"hidden\" name=\"id\" value=\"".$row['id']."\"><input type=\"submit\" class=\"del\" value=\"x\"></form></div>
                        <div class=\"col-6 col-sm-6 col-md-7 col-lg-7\">".$product['title']."<br>".$ll['descompte']."</div>
                        <div class=\"col-2 col-sm-1 col-md-2 col-lg-2\"><input type=\"text\" id=\"q".$i."\" name=\"q".$row['id']."\" value=\"".$row['quantity']."\" size=\"1\" maxlength=\"4\" style=\"text-align:center\" onchange=\"update_quantity(".$i.",".$row['id'].",this.value,".$product['preu'].",scart)\"/></div>
                        <div id=\"preu".$row['id']."\" class=\"col-3 col-sm-4 col-md-2 col-lg-2 price\">".$row['price']." &euro;</div>
                        </div>";
			}
                        $total+=$row['price'];
                        $i++;
                }
                $base=$total;
                $iva=round((($base*$scart['iva_pc'])/100)*100)/100;
                $total=round(($base+$iva)*100)/100;

                $update="update kms_cat_comandes set base='{$base}',iva='{$iva}',total='{$total}' where id=".$order_id;
                $res3=mysqli_query($dblink,$update);

                if (isset($_SESSION['total'])) $_SESSION['total']=$total;
		if ($format=="email") {
//		$return.="<tr><td>".$ll['iva']."</td><td>".$iva." &euro;</td></tr><tr><td>".$ll['despeses_enviament']."</td><td>0 &euro;</td></tr><tr><td>".$ll['total']."</td><td><b>".$total."</b></td></tr></table>";	
		$return.="<br>";
		
		} else {
		$return.="
                <div class=\"row no-gutters scart_row\">
                         <div class=\"col-7 col-sm-7 col-md-10 col-lg-10\">".$ll['iva']."</div>
                        <div id=\"iva\" class=\"col-5 col-sm-5 col-md-2 col-lg-2 price\">".$iva." &euro;</div>
                </div>
                <div class=\"row no-gutters scart_row\">
                         <div class=\"col-7 col-sm-7 col-md-10 col-lg-10\">".$ll['despeses_enviament']."</div>
                        <div id=\"shipping_price\" class=\"col-5 col-sm-5 col-md-2 col-lg-2 price\">0 &euro;</div>
                </div>
                <div class=\"row no-gutters scart_row\">
                         <div class=\"col-7 col-sm-10 col-md-10 col-lg-10\"><b>".$ll['total']."</b></div>
                        <div id=\"total\" class=\"col-5 col-sm-2 col-md-2 col-lg-2 price\"><b>".$total." &euro;</b></div>
                </div>
		";
		}

		}
		return $return;
}
?>
