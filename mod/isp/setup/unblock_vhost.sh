#!/bin/bash

if [ "$1" = "" ]; then
        echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

file_path="/var/www/vhosts/$1/conf/"

if [ -f "$file_path"/httpd.conf.orig ]; then

mv $file_path/httpd.conf.orig $file_path/httpd.conf

/bin/date >> /var/log/kms/setup.log
echo "** UNBLOCKING VHOST **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log

service httpd reload

fi
