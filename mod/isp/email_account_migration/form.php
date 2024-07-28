<? 
// KMS GET_CLIENT_CONFIG
// Mostra la configuració de serveis d'un client
require "/usr/local/kms/mod/isp/session_check.php"; 
//if ($check!="ok") { echo $check." invalid session";exit; } /fà falta aquest xequeix? ja ho fà a session_check.php
?>
<script language="JavaScript">
function checkAll(theForm, cName, status) {
	for (i=0,n=theForm.elements.length;i<n;i++)
		if (theForm.elements[i].className.indexOf(cName) !=-1) {
			theForm.elements[i].checked = status;
		}
	}
</script>

<div style='padding-left:20px'><h2>Generador de configuraci&oacute; de client</h2>
<form id="config_gen_form" method="GET" action="http://intranet.intergrid.cat/?app=sysadmin&mod=isp_client_config&menu=1&view=">
        <input type="hidden" name="app" value="<?=$_GET['app']?>">
        <input type="hidden" name="mod" value="isp_client_config">
        <input type="hidden" name="menu" value="1">

        <table>
        <tr><td><label><b>Control Panel:</b></label></td><td><select name="cp">
	<option value="control.intergridnetwork.net">control.intergridnetwork.net</option>
	</select></td></tr>
	<? include "/usr/local/kms/lib/dbi/kms_erp_dbconnect.php"; ?>
	<tr><td><label><b>Client&nbsp;</b></label></td><td><select name="cli"><option value=''></option><?
                // recuperem llistat de dominis
                $select = "select name,sr_client from kms_isp_clients order by name asc";
                $result = mysqli_query($select);
                if (!$result) {echo "error:".mysqli_error();exit;}
                while($row = mysqli_fetch_array($result)){
                        echo "<option value=\"".$row['sr_client']."\">".$row['name']."</option>";
                }
                ?>
        </select></td></tr>
        <tr><td><label><b>Domini&nbsp;</b></label></td><td><select name="dom"><option value=''></option><?
		
		// recuperem llistat de dominis
		$select = "select name from kms_isp_hostings_vhosts order by name asc";
		$result = mysqli_query($select);
		if (!$result) {echo "error:".mysqli_error();exit;}
		while($row = mysqli_fetch_array($result)){
			echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
		}
		mysqli_close();
		?>
	</select></td></tr>
        <tr><td><label><br><b>Idioma&nbsp;</b></label></td>

        <tr><td><label></label></td><td><input type="radio" name="l" value="ct" checked> Catal&agrave;</td></tr>
        <tr><td><label></label></td><td><input type="radio" name="l" value="en"> English</td></tr>
	<tr><td><label></label></td><td><input type="radio" name="l" value="es"> Espa&ntilde;ol</td></tr>
        <tr><td><label></label></td><td><input type="radio" name="l" value="eu"> Euskar</td></tr>
	<tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
	<tr>
	  <td><input type="checkbox" checked onclick="checkAll(document.getElementById('config_gen_form'), 'blocs_dades', this.checked);" /></td><td><b>Seleccionar / deseleccionar tot</b></td>
	<tr>
	<tr>
          <td><input type="checkbox" name="client_data_check" id="client_data" class="blocs_dades" checked></td>
          <td>Dades del client</td>
        </tr>
	 <tr>
          <td><input type="checkbox" name="control_panel_check" id="control_panel" class="blocs_dades" checked></td>
          <td>Panell de control</td>
        </tr>
         <tr>
          <td><input type="checkbox" name="extranet_check" id="extranet" class="blocs_dades" checked></td>
          <td>Extranet</td>
        </tr>
	 <tr>
          <td><input type="checkbox" name="ftp_check" id="ftp_check" class="blocs_dades"></td>
          <td>Acces FTP</td>
        </tr>
	 <tr>
          <td><input type="checkbox" name="email_accounts_check" id="email_accounts" class="blocs_dades" checked></td>
          <td>Comptes de correu</td>
        </tr>
        <tr>
          <td><input type="checkbox" name="email_accounts_password_check" id="email_accounts_password" class="blocs_dades"></td>
          <td><font color="red">Mostrar contrasenyes correu</font></td>
	 <tr>
          <td><input type="checkbox" name="databases_check" id="databases" class="blocs_dades"></td>
          <td>Bases de dades</td>
        </tr>
	 <tr>
          <td><input type="checkbox" name="statistics_check" id="statistics" class="blocs_dades"></td>
          <td>Estad&iacute;stiques Web</td>
        </tr>
        </tr>
        <!-- <tr><td><label>.. altres (dues lletres) </label></td><td><input name="l"></td></tr>-->
        </table>
        <br>
        <input type="submit" value="generar">
</form>
