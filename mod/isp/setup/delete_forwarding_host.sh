#!/bin/bash

/bin/date >> /var/log/kms/setup.log
echo "** DELETE FORWARDING HOST **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# delete any possible previous standard redirect
sed '/# '${1}' redirect/,+12 d' /etc/httpd/conf.d/zz_vhosts_redirects.conf > /tmp/kms_vhred
mv /tmp/kms_vhred /etc/httpd/conf.d/zz_vhosts_redirects.conf
# delete any possible previous frame redirect
sed '/'${1}'/d' /etc/httpd/conf.d/zz_vhosts.conf > /tmp/zz_vhosts.conf
mv /tmp/zz_vhosts.conf /etc/httpd/conf.d/zz_vhosts.conf

service httpd reload

echo "--------------" >> /var/log/kms/setup.log

