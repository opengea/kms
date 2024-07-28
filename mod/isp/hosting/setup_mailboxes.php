<input type="button">Limites (?) sin limite / 2G ...<br>
<input type="button">Opciones de archivaci&oacute;n<br>
<input type="button">Gesti&oacute;n de cola<br>
<input type="button">Lista blanca<br>
<input type="button">Lista negra<br>
<input type="button">Estado del servidor<br>

<h3>Opciones de archivaci&oacute;n</h3>

Las opciones de archivaci&oacute;n permiten ahorrar espacio en el servidor eliminando los correos antiguos y permitiendo descargar una copia de seguridad de estos correos.<br><br>

<input type="checkbox" name="option" value="delarch">Eliminar autom&aacute;ticamente del servidor el correo m&aacute;s antiguo de <input size="2" name=days value="2" onchange="if (this.value<2) $('#downloads').attr('disabled',true); else $('#downloads').attr('disabled',false);">a&ntilde;os<br>
<input id="downloads" type="checkbox" name="option" value="delarch">Enviar por correo enlace de descarga de copias anuales de los correos (fichero comprimido .zip anual)<br>

<?


