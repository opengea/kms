#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** UPDATE SUBDOMAIN **" >> /var/log/kms/setup.log
echo "old subdomain: $1" >> /var/log/kms/setup.log
echo "new subdomain: $2" >> /var/log/kms/setup.log
echo "domain: $3" >> /var/log/kms/setup.log
echo "old user type: $4" >> /var/log/kms/setup.log
echo "new user type: $5" >> /var/log/kms/setup.log
echo "old user: $6" >> /var/log/kms/setup.log
echo "new user: $7" >> /var/log/kms/setup.log
echo "new uid: $8" >> /var/log/kms/setup.log
echo "password: $9" >> /var/log/kms/setup.log
echo "php: ${11}" >> /var/log/kms/setup.log
echo "perl: ${12}" >> /var/log/kms/setup.log
echo "diskquota: ${13}" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

if [ "$4" = "native" ]; then
	# delete system user
	userdel $6
fi

# delete subdomain from httpd.conf
sed '/^# '${1}' subdomain/,+24 d' /var/www/vhosts/$3/conf/httpd.conf > /tmp/kms_vhr_$1
mv /tmp/kms_vhr_$1 /var/www/vhosts/$3/conf/httpd.conf

if [ "$5" = "native" ]; then
        # create system user
        pass=$(perl -e 'print crypt($ARGV[0], "password")' $9)
        useradd -u $8 -p $pass -s /bin/false -g 2524 -d /var/www/vhosts/$3/subdomains/$2 -c 'KMS subdomain user' $7
fi
# update httpd.conf in virtual host

sed 's/SUBDOMAIN_NAME/'$2'/g' /usr/local/kms/install/var/www/vhosts/sampledomain/conf/httpd.subdomain.include > /tmp/kms_sdvh$2
sed 's/DOMAIN_NAME/'$3'/g' /tmp/kms_sdvh$2 > /tmp/kms_sdvh$2_1
rm /tmp/kms_sdvh$2
cat /tmp/kms_sdvh$2_1 >> /var/www/vhosts/$3/conf/httpd.conf
rm /tmp/kms_sdvh$2_1

# purge plesk's include
rm /var/www/vhosts/$3/conf/httpd.include

# reload apache
service httpd reload

echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG

