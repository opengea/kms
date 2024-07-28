#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING WEBUSER **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "old web user: $2" >> /var/log/kms/setup.log
echo "new web user: $3" >> /var/log/kms/setup.log
echo "old uid: $4" >> /var/log/kms/setup.log
echo "new uid: $5" >> /var/log/kms/setup.log
echo "password: $6" >> /var/log/kms/setup.log
echo "php: $7" >> /var/log/kms/setup.log
echo "perl: $8" >> /var/log/kms/setup.log
echo "diskquota: $9" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# delete existing user
userdel $2

# create system user
pass=$(perl -e 'print crypt($ARGV[0], "password")' $6)
useradd -u $5 -p $pass -s /bin/false -g 2524 -d /var/www/vhosts/$1/web_users/$3 -c 'KMS subdomain user' $3

# reload apache
service httpd reload

echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
