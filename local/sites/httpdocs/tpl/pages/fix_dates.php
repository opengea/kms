<?

$conf= array (
        "db_user"=>"marbotediciones_",
        "db_name"=>"marbotediciones_kms",
        "db_pass"=>"dj9fvMBa29",
        "db_host"=>"localhost",
);

include "/var/www/vhosts/marbotediciones.com/httpdocs/lib/dbconnect.php";

$mesos=array("gener"=>"01","febrer"=>"02","març"=>"03","abril"=>"04","maig"=>"05","juny"=>"06","juliol"=>"07","agost"=>"08","setembre"=>"09","octubre"=>"10","novembre"=>"11","desembre"=>"12","enero"=>"01","febrero"=>"02","marzo"=>"03","abril"=>"04","mayo"=>"05","junio"=>"06","julio"=>"07","agosto"=>"08","setiembre"=>"09","octubre"=>"10","noviembre"=>"11","diciembre"=>"12","septiembre"=>"09");

$sel="select * from kms_cat_productes";
$res=mysqli_query($dblink,$sel);
while ($row=mysqli_fetch_assoc($res)) {
	$row['publicationdate']=trim($row['publicationdate']);
	$mes=substr($row['publicationdate'],0,strpos($row['publicationdate']," "));
	$any=trim(str_replace("de ","",substr($row['publicationdate'],strpos($row['publicationdate']," "))));
	$data=$any."-".$mesos[$mes]."-01";

	$update="update kms_cat_productes set creation_date='".$data."' where id=".$row['id'];
	echo $update."\n";
	$res2=mysqli_query($dblink,$update);

}
mysqli_close($dblink);
