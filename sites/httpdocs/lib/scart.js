function update_shipping(pais,scart) {
        var preu=0;
        var total=$('#total_form').val()-$('#shipping').val();
        if (pais.toLowerCase()=='espanya'||pais.toLowerCase()=='españa'||pais.toLowerCase()=='spain') preu=scart.shipping; else preu=scart.shipping_international;
        total+=preu;
        total=Math.round(total*100)/100;
        $('#shipping_price').html(preu+" &euro;");
        $('#shipping').val(preu);
        if ($('#total_form').val().length-$('#total_form').val().indexOf(".")==2) $('#total').html("<strong>"+total+"0 &euro;</strong>"); else $('#total').html("<strong>"+total+" &euro;</strong>");
        $('#total_form').val(total);
        //update database

        $.ajax({
                        url: scart.url_base+"/lib/scart_shipping_update.php",
                        type: "POST",
                        data: 'order_id='+scart.order_id+'&shipping='+preu,
                        cache: false,
                        global: true,
                        dataType: "html",
                        success: function(msg){ 
                         },
                        error: function (xhr, ajaxOptions, thrownError){
                                 console.log('failed call to scart_update');
                        }
        });
}

function update_quantity(q,field,newvalue,price,scart) {
        if (newvalue<1) { $('#q'+q).val("1"); update_quantity(q,field,1,price,scart); return; }
        var total=0;
        var pc_iva=scart.iva_pc;
        var price = Math.round(price*newvalue*100)/100;
        $('#preu'+field).html(price+" &euro;");
        var total=0;
        for (i=1;i<scart.num_items;i++) {
                total+=parseFloat(parseFloat($('#op'+i).val())*parseFloat($('#q'+i).val()));
		console.log("item "+i);
		console.log("price="+parseFloat($('#op'+i).val()));
		console.log("quantity="+parseFloat($('#q'+i).val()));
        }
	console.log(total);
        iva=Math.round(((parseFloat(total)*parseFloat(pc_iva))/100)*100)/100;
	console.log("IVA="+iva);
        $('#iva').html(iva+" &euro;");
        total+=iva;
        total+=parseFloat($('#shipping').val());
        total=Math.round(total*100)/100;
	console.log("TOTAL="+total);
        $('#total_form').val(total);    
        if ($('#total_form').val().length-$('#total_form').val().indexOf(".")==2) $('#total').html("<strong>"+total+"0 &euro;</strong>"); else $('#total').html("<strong>"+total+" &euro;</strong>");

        //update database
        $.ajax({
                        url: scart.url_base+"/lib/scart_item_update.php",
                        type: "POST",
                        data: 'order_id='+scart.order_id+'&item_id='+field+'&quantity='+newvalue,
                        cache: false,
                        global: true,
                        dataType: "html",
                        success: function(msg){ 
                         },
                        error: function (xhr, ajaxOptions, thrownError){
                                 console.log('failed call to scart_update');
                        }
        });
}
