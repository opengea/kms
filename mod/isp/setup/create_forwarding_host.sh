#!/bin/bash

/bin/date >> /var/log/kms/setup.log
if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi
echo "** ENABLE FORWARDING VHOST **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "type: $2" >> /var/log/kms/setup.log
echo "url: $3" >> /var/log/kms/setup.log

# delete any possible previous standard redirect
sed '/# '${1}' redirect/,+7 d' /etc/httpd/conf.d/zz_vhosts_redirects.conf > /tmp/kms_vhred
mv /tmp/kms_vhred /etc/httpd/conf.d/zz_vhosts_redirects.conf
# delete any possible previous frame redirect
sed '/'${1}'/d' /etc/httpd/conf.d/zz_vhosts.conf > /tmp/zz_vhosts.conf
mv /tmp/zz_vhosts.conf /etc/httpd/conf.d/zz_vhosts.conf


if [ "$2" = "frm" ]; then
	# vhost iframe forwarding

	# create file directory structure if necessary
	mkdir -p /var/www/vhosts/$1/conf
	mkdir -p /var/www/vhosts/$1/httpdocs_fwd
	echo '<html><body style="margin:0px"><iframe src="'$3'" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></body></html>' > /var/www/vhosts/$1/httpdocs_fwd/index.html

	#create httpd.conf
	echo '<VirtualHost '$1':80>
	ServerName   '$1':80
	ServerAlias  www.'$1'
	UseCanonicalName Off
	ServerAdmin  "suport@intergrid.cat"
	DocumentRoot /var/www/vhosts/'$1'/httpdocs_fwd
</VirtualHost>

<VirtualHost '$1':443>
        ServerName '$1'
        ServerAlias www.'$1'
        Redirect '$2' / '$3'
</VirtualHost>
' > /var/www/vhosts/$1/conf/httpd.conf

	#add vhost in zz_vhosts
 	echo -e "\nInclude /var/www/vhosts/$1/conf/httpd.conf" >> /etc/httpd/conf.d/zz_vhosts.conf	

else 
	# create new redirect
	echo '
# '$1' redirect standard
<VirtualHost '$1':80>
	ServerName '$1'
	ServerAlias www.'$1'
	Redirect '$2' / '$3'
</VirtualHost>
' >> /etc/httpd/conf.d/zz_vhosts_redirects.conf
fi

service httpd reload

echo "--------------" >> /var/log/kms/setup.log

