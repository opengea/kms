<div style="width:600px;padding:20px;padding-top:0px;">

<h2>Extranet</h2>
<br><span style="font-size:13px"><?=_KMS_EXTRANET_EXPLAIN?></span><br><br><br>
<? $vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['id']);?>
<?=_KMS_GL_ADDRESS?> :<br><br><b><a style="font-size:13px" href="http://extranet.<?=$vhost['name']?>">http://extranet.<?=$vhost['name']?></a></b>

</div>                 
