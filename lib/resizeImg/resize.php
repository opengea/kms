
<?
$img="DSCF9454.JPG";
   include('/usr/local/kms/lib/resizeImg/SimpleImage.php');
   $image = new SimpleImage();
   $image->load($img);

$mysock = getimagesize($img);

$width= $mysock[0];
$height = $mysock[1];
$resizeTo = 300;

if ($width > $height) {
$percentage = ($resizeTo / $width);
} else {
$percentage = ($resizeTo / $height);
}

$width = round($width * $percentage);
$height = round($height * $percentage); 

   $image->resize($width,$height);
   $image->save($img);


?>
