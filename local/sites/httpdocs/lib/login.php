<div id="wrap-login">
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-sm-4 black-bg h100 nopadding">
                <img class="logo" src="/images/logo.png" name="elBulli">
            </div>
            <div class="col-12 col-sm-8 gray-bg h100">
		<div class="wrapper">
		    <form method="post" class="form-signin">       
			<h2 class="form-signin-heading"><?=$ll['meta_title']?><br><span class="gray"><?=$ll['meta_subtitle']?></span></h2><br>
			<? if (!$_SESSION['user_logged']) echo "<span class='error'>".$ll['invalid_login']."</span><br>";?>
			<span class="text"><?=$ll['si_estas_registrado']?></span><br><br>
			<input type="hidden" name="action" value="login">
			<input type="text" class="form-control" name="username" placeholder="<?=$ll['email']?>" required="" autofocus="" />
			<input type="password" class="form-control" name="password" placeholder="<?=$ll['password']?>" required=""/>      
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?=$ll['login']?></button>   
			<a href=""><?=$ll['has_olvidado_la_contrasenya']?></a><br>
			<a href=""><?=$ll['como_acceder']?></a><br>
		    </form>
		</div>
            </div>

        </div>
    </div>
</div>
