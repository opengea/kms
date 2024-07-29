#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** UPDATE FRAME FORWARDING HOST **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "type: $2" >> /var/log/kms/setup.log
echo "url: $3" >> /var/log/kms/setup.log
echo "ip: $4" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

if [ "$2" = "frm_fwd" ]; then
	# vhost iframe forwarding
	# its not necessary to create httpd structure because plesk does it.
	# Only add the virtual host in /etc/httpd/conf.d/zz_vhosts.conf
	echo "do nothing"
else 
	echo "** UPDATING STANDARD FORWARDING VHOST **" >> /var/log/kms/setup.log
	echo "domain: $1" >> /var/log/kms/setup.log
	echo "type: $2" >> /var/log/kms/setup.log
	echo "url: $3" >> /var/log/kms/setup.log
	
	# delete previous redirect
	sed '/^# '${1}' redirect/,+9 d' /etc/httpd/conf.d/zz_vhosts_redirects.conf > /tmp/kms_vhr_$1
	
	# create new redirect
	echo '
	# '$1' redirect standard
	<VirtualHost '$4':80>
	  ServerName '$1'
	  ServerAlias www.'$1'
	  Redirect 301 / '$3'/
	</VirtualHost>
	' >> /etc/httpd/conf.d/zz_vhosts_redirects.conf
fi

service httpd reload

echo "--------------" >> /var/log/kms/setup.log

