<?
if (!isset($_GET['dom'])) {

        //echo "falta variable dom";exit;
?>
       <div style='padding-left:20px'><h2>Cercar constants d'idioma indefinides</h2>
       <form method="GET" action="">
        <table>
        <tr><td width="200"><label>host </label></td><td><input name="host"></td></tr>
        <tr><td width="200"><label>domini </label></td><td><input name="dom"></td></tr>
        </table>
        <br>
        <input type="submit" value="cercar">
        </form></div>
<?

} else {
        exec("tail -114000 /var/www/vhosts/".$_GET['dom']."/log/error_log | grep 'undefined constant' | awk '{ print $18\" \"$20}' | sort -nr | uniq ",$out);
        $carro ="";
        foreach ($out as $i => $linia) {
         $carro.=$linia."<br>";
        }

        ?>
        <body>
        <font face="Lucida Sans" style="font-size:14px;line-height:17px;">
        <?=$carro;?>
        </font>
        </body>
<? } ?>

