<?

function group_exists($grup,$grups) {  

  if (($grup==$grups)||
      (strpos("--".$grups,"-".$grup."|"))||
      (strpos($grups."-","|".$grup."-"))||
      (strpos($grups,"|".$grup."|"))
     ) return true; else return false;

}

function treu_grup($grup,$grups) {
  if ($grup==$grups) $grups=str_replace($grup,"",$grups);
  $grups=str_replace("|".$grup."|","|",$grups);
  if (strpos("--".$grups,"-".$grup."|")) $grups=str_replace("-".$grup."|","","-".$grups);
  if (strpos($grups."-","|".$grup."-")) $grups=str_replace("|".$grup."-","",$grups."-");
  return $grups;
}
function add_group($grup,$grups) {
  if ($grups=="") return $grup;
  else return $grups."|".$grup;
} 

echo add_group("aaa","");
/*
$grup="1";
$grups="1|2";
echo strpos("-".$grup."|","--".$grups);
*/
