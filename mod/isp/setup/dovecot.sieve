# rule:[SPAM]
require "fileinto";
  if exists "X-Spam-Flag" {
          if header :contains "X-Spam-Flag" "NO" {
          } else {
          fileinto "Junk";
          stop;
          }
}
  
if header :contains "subject" ["SPAM"] {
    fileinto "Junk";
    stop;
}

require ["vacation"];
# rule:[AUTO RESPUESTA]
if false # true
{
	vacation :days 1 :subject "Fuera de la oficina" "Mensaje de autorespuesta";
}
# rule:[REDIRECCIÓN]
if false # true
{
	redirect "email@redireccion.com";
}
# rule:[CUSTOM1]
if false # true
{
        stop;
}
# rule:[CUSTOM2]
if false # true
{
        stop;
}
# rule:[CUSTOM3]
if false # true
{
        stop;
}
# rule:[CUSTOM4]
if false # true
{
        stop;
}
# rule:[CUSTOM5]
if false # true
{
        stop;
}
# rule:[CUSTOM6]
if false # true
{
        stop;
}
# rule:[CUSTOM7]
if false # true
{
        stop;
}
# rule:[CUSTOM8]
if false # true
{
        stop;
}


