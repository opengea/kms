</td></tr></table> <!--- menu i body-->

</td></tr></table>
<div class="BOT<? if ($_GET['_']=='b'&&$_GET['app']!="") echo " BROWSE"?>" align="<?=$footer_align?>" style="padding:10px"><a href="http://www.intergrid.
<? if ($client_account['default_lang']=='es') {?>es<? }
   else { ?>cat<? } ?>">KMS <?=$kms->version?></a>&nbsp;
</div>

</div>


<div id="loading-message">
<img src="/kms/css/img/icons/loading.gif">
</div>

</body>
</html>
<?php if ($debug) { ?>
<pre>
<?php
var_dump($_SESSION);
var_dump($_POST);
var_dump($_GET);
?>
</pre>
<? } ?>
