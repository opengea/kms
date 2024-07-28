require "vacation";
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

