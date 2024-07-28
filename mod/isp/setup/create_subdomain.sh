#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING SUBDOMAIN **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "name: $2" >> /var/log/kms/setup.log
echo "login: $3" >> /var/log/kms/setup.log
echo "password: $4" >> /var/log/kms/setup.log
echo "ip: $5" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
        echo "Error: empty domain name. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

if [ "$5" = "" ]; then
        echo "Error: unasigned IP address. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

if [ "$4" = "root" ]; then
        echo "Error: not root allowed"  >> /var/log/kms/setup.log
        exit 0
fi


mkdir -p /var/www/vhosts/$1/subdomains/$2/httpdocs

# create system user
pass=$(perl -e 'print crypt($ARGV[0], "password")' $4)
useradd -p $pass -s /bin/false -g 2524 -d /var/www/vhosts/$1/subdomains/$2 -c 'KMS subdomain user' $3
chown $3:2524 /var/www/vhosts/$1/subdomains/$2 -R
# update httpd.conf in virtual host
sed 's/SUBDOMAIN_NAME/'$2'/g' /usr/local/kms/mod/isp/install/var/www/vhosts/skel/conf/httpd.subdomain.include > /tmp/kms_sdvh$2
sed 's/DOMAIN_NAME/'$1'/g' /tmp/kms_sdvh$2 > /tmp/kms_sdvh$2_1
sed 's/WEBSERVER_IP/'$5'/g' /tmp/kms_sdvh$2_1 >> /var/www/vhosts/$1/conf/httpd.conf
rm /tmp/$1_httpd.conf
rm /tmp/kms_sdvh$2
rm /tmp/kms_sdvh$2_1

# create subdomain php fpm
cp /usr/local/kms/mod/isp/install/var/www/vhosts/skel/conf/php-8.2.5-subdomain.conf /tmp/$2.$1_php.conf

sed 's/DOMAIN_NAME/'$1'/g'  /tmp/$2.$1_php.conf > /tmp/$2.$1_php_.conf 
sed 's/SUBDOMAIN/'$2'/g'  /tmp/$2.$1_php_.conf > /tmp/$2.$1_php.conf
sed 's/USER/'$3'/g' /tmp/$2.$1_php.conf  > /var/www/vhosts/$1/conf/php-8.2.5-$2.conf
rm /tmp/$2.$1_php.conf
rm /tmp/$2.$1_php_.conf

# reload apache
service httpd reload
#service apache2 reload
service php-8.2.5-fpm reload
#php-fpm-DOMAIN_NAME.SUBDOMAIN
echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
