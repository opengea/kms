#!/bin/bash

echo "creating dns zone..." >> $MSG
echo "creating dns zone..."

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING DNS ZONE **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "ip: $2" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# 

php /usr/local/kms/mod/isp/setup/create_dnszone.php

# reload apache
service named reload


echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
