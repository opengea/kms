#!/bin/bash
DIRECTORY="/var/vmail/$1/$2"

if [ ! -d "$DIRECTORY" ]; then

echo "creating mailbox...$2@$1"

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING MAILBOX **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "username: $2" >> /var/log/kms/setup.log
echo "password: $3" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
        echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# create Maildir structure

mkdir -p /var/vmail/$1/$2/Maildir/cur
mkdir -p /var/vmail/$1/$2/Maildir/new
mkdir -p /var/vmail/$1/$2/Maildir/tmp

chown vmail:vmail /var/vmail/$1/$2/ -R
chown vmail:vmail /var/vmail/$1

fi
