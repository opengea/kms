#!/bin/bash

echo "deleting mailbox...$2@$1"

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** REMOVING MAILBOX **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "username: $2" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
        echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

if [ "$2" = "" ]; then
        echo "Error: empty mailbox. aborted"  >> /var/log/kms/setup.log
        exit 0
fi


# delete Maildir structure
mkdir /tmp/deleted
mv /var/vmail/$1/$2 /tmp/deleted
#rm /var/vmail/$1/$2 -R
