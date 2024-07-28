#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** DELETING WEBSTATS **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# delete
if [ -f '/etc/webalizer/en/$1' ]; then
	rm /etc/webalizer/en/$1
fi

if [ -f '/etc/webalizer/cat/$1' ]; then
	rm /etc/webalizer/cat/$1
fi

if [ -f '/etc/webalizer/es/$1' ]; then
	rm /etc/webalizer/es/$1
fi

echo "--------------" >> /var/log/kms/setup.log

