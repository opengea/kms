#!/bin/bash

echo "removing kms vhost..."

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** REMOVING KMS VHOST **" >> /var/log/kms/setup.log
echo "$0" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "user: $2" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

#ftp remove
sed '/'$1'/,+0 d' /etc/proftpd/proftpd.includes  > /tmp/proftpd.includes.tmp
cp /tmp/proftpd.includes.tmp > /etc/proftpd/proftpd.includes
service proftpd reload
echo "deleting user $2 and ftp account" >> /var/log/kms/setup.log

#vhost remove
sed '/'$1'/,+0 d' /etc/httpd/conf.d/zz_vhosts.conf > /tmp/zz_vhosts.conf.tmp
cp /tmp/zz_vhosts.conf.tmp /etc/httpd/conf.d/zz_vhosts.conf
echo "removing $1 from apache" >> /var/log/kms/setup.log
echo "reloading apache" >> /var/log/kms/setup.log
service httpd reload

# get current phpfpm version
phpfpm_ver=$(find /var/www/vhosts/$1/conf/ -type f -name 'php-*.conf' -exec basename {} \;)
phpfpm_ver="${phpfpm_ver%.conf}"

echo "deleting vhost physical directory $1" >> /var/log/kms/setup.log
rm -f -r /var/www/vhosts/$1

echo "reloading php-fpm $1" >> /var/log/kms/setup.log
service $phpfpm_ver-fpm reload

echo "removing system users $1 and $2" >> /var/log/kms/setup.log
userdel -f $2
userdel -f $1

#certificates
echo 'yes' | certbot delete --cert-name $1

#webalizer
echo "deleting webstats for $1" >> /var/log/kms/setup.log
rm -f /etc/webalizer/en/$1
rm -f /etc/webalizer/es/$1
rm -f /etc/webalizer/ca/$1

echo "--------------" >> /var/log/kms/setup.log
