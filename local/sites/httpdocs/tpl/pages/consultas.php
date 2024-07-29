<div class="page white">
  <div class="row container col-12 col-sm-12 col-md-10 col-lg-11 col-xl-8">
    <div class="text col-sm-12 col-md-6" style="margin:auto;text-align:center">
<? echo $ll[$page['body']];?>
<form action="" method="post">

	<div class="item-form">
		<span class="your-name"><input type="text" name="name" value="" size="40" class="bt-name-lm" placeholder="Tu nombre *" ></span>

	</div>
	<div class="item-form item-form-warp">
		<span class="your-email"><input type="email" name="your-email" value="" size="40" class="bt-email-lm" placeholder="Tu email *"></span>
		<span class="your-subject"><input type="text" name="your-subject" value="" size="40" class="bt-subject-lm" placeholder="Asunto *"></span>
	</div>
	
	<div class="item-formi">
		<span class="tipo">
			<select name="tipo" style="color:#999" onchange="$(this).css('color','#111');">
				<option >Tipo de consulta *</option>
				<option value="online">Online</option>
				<option value="presencial">Presencial</option>
			</select>
		</span>
	</div>
	
	<div class="item-form">
		<span class="your-message"><textarea name="your-message" cols="40" rows="10" class="" aria-invalid="false" placeholder="Tu mensaje *"></textarea></span>
	</div>
	
	<div class="item-form bt-submit">
		<input type="submit" value="ENVIAR" class="bt">
		<span class="ajax-loader"></span>
	</div>
	
	<div class="wpcf7-response-output wpcf7-display-none"></div>
</form>

</div>

</div>
</div>

