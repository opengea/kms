<?
function money($n) {
 $n*=100;$n=round($n);$n/=100;
 return str_replace(".",",",$n);
}
?>
