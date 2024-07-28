#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING WEBUSER **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "old web user: $2" >> /var/log/kms/setup.log
echo "old uid: $3" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# delete existing user
userdel $2

# reload apache
service httpd reload

echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
