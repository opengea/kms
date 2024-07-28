#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING WEBUSER **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "web user: $2" >> /var/log/kms/setup.log
echo "uid: $3" >> /var/log/kms/setup.log
echo "password: $4" >> /var/log/kms/setup.log
echo "php: $5" >> /var/log/kms/setup.log
echo "perl: $6" >> /var/log/kms/setup.log
echo "diskquota: $7" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# create system user
pass=$(perl -e 'print crypt($ARGV[0], "password")' $4)
useradd -u $3 -p $pass -s /bin/false -g 2524 -d /var/www/vhosts/$1/web_users/$2 -c 'KMS ftp user (webuser)' $2

# reload apache
service httpd reload

echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
