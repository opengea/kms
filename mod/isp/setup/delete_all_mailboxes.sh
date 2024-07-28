#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** DELETING MAILBOXES OF DOMAIN $1 **" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

rm /var/vmail/$1 -R
#mail1
rm /var/qmail/mailnames/$1 -R

echo "--------------" >> /var/log/kms/setup.log

