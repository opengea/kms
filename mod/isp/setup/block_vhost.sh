#!/bin/bash

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi



file_path="/var/www/vhosts/$1/conf/"
insert_after="DocumentRoot"
code_to_insert="
         #Start Blocked site
        <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteRule ^(.*)$ /usr/local/kms/mod/isp/install/var/www/vhosts/block_domain/httpdocs/index.html [QSA,L]
        </IfModule>
        #End Blocked Site
	"

if [ ! -f "$file_path"/httpd.conf.orig ]; then

awk -v search="$insert_after" -v code="$code_to_insert" '$0 ~ search {print; print code; next} 1' "$file_path"/httpd.conf > $file_path/httpd.conf.block

mv $file_path/httpd.conf $file_path/httpd.conf.orig
mv $file_path/httpd.conf.block $file_path/httpd.conf

/bin/date >> /var/log/kms/setup.log
echo "** BLOCKING VHOST **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log

service httpd reload

fi
