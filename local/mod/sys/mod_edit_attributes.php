<?
$sel="select * from kms_sys_mod where id=".$_GET['id'];
$obj=$this->dbi->get_record($sel);
//print_r($obj);
?>
<script language="javascript">
document.location="/?app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=<?=$obj['name']?>&queryfield=mod_id";
</script>
