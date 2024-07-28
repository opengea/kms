#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** DELETING SUBDOMAIN **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "subdomain: $2" >> /var/log/kms/setup.log
echo "user: $3" >> /var/log/kms/setup.log

if [ "$2" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

#if [ "$4" = "native" ]; then
	# delete system user
	userdel $3
#fi

# update httpd.conf to remove subdomain virtual host
sed '/^# '${2}' subdomain/,/<\/VirtualHost>/d' /var/www/vhosts/$1/conf/httpd.conf > /tmp/kms_vhr_$2

mv /tmp/kms_vhr_$2 /var/www/vhosts/$1/conf/httpd.conf

rm /var/www/vhosts/$1/conf/php-8.2.5-$2.conf

service php-8.2.5-fpm reload
# reload apache
service httpd reload

# delete directory structure
rm /var/www/vhosts/$1/subdomains/$2 -R

echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
