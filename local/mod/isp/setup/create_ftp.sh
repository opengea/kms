#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING FTP **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "login: $2" >> /var/log/kms/setup.log
echo "password: $3" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

if [ "$2" = "root" ]; then
        echo "Error: not root allowed"  >> /var/log/kms/setup.log
        exit 0
fi

# create system user
pass=$(perl -e 'print crypt($ARGV[0], "password")' $3)
mkdir -p /var/www/vhosts/$1/web_users/
useradd -p $pass -s /bin/false -g 2524 -d /var/www/vhosts/$1/web_users/$2 -m -c 'KMS ftp user (webuser)' $2
chmod 711 /var/www/vhosts/$1/web_users/$2
chmod 755 /var/www/vhosts/$1/web_users/$2/*
echo "#Options +Indexes" > /var/www/vhosts/$1/web_users/$2/.htaccess
echo "#Satisfy Any" >> /var/www/vhosts/$1/web_users/$2/.htaccess
chmod 755 /var/www/vhosts/$1/web_users/$2/.*

# reload apache
service httpd reload

echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
