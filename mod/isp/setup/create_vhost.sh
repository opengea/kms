#!/bin/bash

echo "creating kms vhost $1 ($2) $3:$4..."

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log
echo "** CREATING KMS VHOST **" >> /var/log/kms/setup.log
echo "domain: $1" >> /var/log/kms/setup.log
echo "ip: $2" >> /var/log/kms/setup.log
echo "user: $3" >> /var/log/kms/setup.log
echo "password: $4" >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
	echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

# create directory structure

mkdir -p /var/www/vhosts/$1/httpdocs
mkdir -p /var/www/vhosts/$1/conf
mkdir -p /var/www/vhosts/$1/error_docs
mkdir -p /var/www/vhosts/$1/pd
mkdir -p /var/www/vhosts/$1/private
mkdir -p /var/www/vhosts/$1/statistics/logs
mkdir -p /var/www/vhosts/$1/statistics/webstat
mkdir -p /var/www/vhosts/$1/subdomains
mkdir -p /var/www/vhosts/$1/web_users

mkdir -p /var/www/vhosts/$1/subdomains/data
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/tmp
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/tmp
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/logs
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/pictures
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/pictures/thumbs
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/contacts
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/contacts/photos
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/web
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/calendar
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/catalog
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/catalog/download
mkdir -p /var/www/vhosts/$1/subdomains/data/httpdocs/files/videos
chmod 777 /var//www/vhosts/$1/subdomains/data/httpdocs/files/ -R

# copy httpdocs skel
cp /usr/local/kms/mod/isp/install/var/www/vhosts/skel/httpdocs/* /var/www/vhosts/$1/httpdocs -R

# create system user 
pass=$(perl -e 'print crypt($ARGV[0], "password")' $4)
useradd -M -p $pass -s /bin/false -g 2524 -d /var/www/vhosts/$1 -c 'KMS vhost user' $3

cp /usr/local/kms/mod/isp/install/var/www/vhosts/skel/conf/ftp.kms.include /var/www/vhosts/$1/conf/ftp.conf
find /var/www/vhosts/$1/conf/ftp.conf -type f | xargs sed -i 's/DOMAIN/'$1'/g'
echo "Include /var/www/vhosts/$1/conf/ftp.conf" >> /etc/proftpd/proftpd.includes
service proftpd reload

# create httpd.conf in virtual host
sed 's/WEBSERVER_IP/'$2'/g' /usr/local/kms/mod/isp/install/var/www/vhosts/skel/conf/httpd.kms.include > /tmp/$1_httpd.conf
sed 's/WEBSERVER_IP/'$2'/g' /usr/local/kms/mod/isp/install/var/www/vhosts/skel/conf/httpd.kms.ssl.include > /tmp/$1_httpd_ssl.conf
sed 's/DOMAIN_NAME/'$1'/g' /tmp/$1_httpd.conf > /var/www/vhosts/$1/conf/httpd.conf
sed 's/DOMAIN_NAME/'$1'/g' /tmp/$1_httpd.conf > /var/www/vhosts/$1/conf/httpd.conf.ssl
cp /usr/local/kms/mod/isp/install/var/www/vhosts/skel/conf/php-8.2.5.conf /tmp/$1_php.conf
sed 's/DOMAIN_NAME/'$1'/g'  /tmp/$1_php.conf > /var/www/vhosts/$1/conf/php-8.2.5.conf
rm /tmp/$1_httpd.conf
rm /tmp/$1_php.conf

# we now add include to httpd.kms.conf of virtual host into zz_httpd.conf
echo -e "Include /var/www/vhosts/$1/conf/httpd.conf" >> /etc/httpd/conf.d/zz_vhosts.conf

touch /var/www/vhosts/$1/conf/vhost.conf

chown  $3:2524 /var/www/vhosts/$1 -R
chown  $3:2524 /var/www/vhosts/$1/httpdocs -R
chown root:2524 /var/www/vhosts/$1
chown root:2524 /var/www/vhosts/$1/conf
chown root:2524 /var/www/vhosts/$1/pd
chmod 775 /var/www/vhosts/$1/httpdocs -R
#create webalizer vhost config file
#cat  /etc/webalizer/template.conf | sed "s@DOMAIN@inh.cat@" | sed "s@REPORT_TITLE@Estad\&iacute;stiques per @" > /etc/webalizer/cat/$1.conf
#cat  /etc/webalizer/template.conf | sed "s@DOMAIN@inh.cat@" | sed "s@REPORT_TITLE@Estad\&iacute;sticas Web para @" > /etc/webalizer/cat/$1.conf
cat  /usr/local/kms/mod/isp/setup/webalizer_template.conf | sed "s@DOMAIN@$1@g" | sed "s@WEBSTATS_PASSWORD@$4@g" > /etc/webalizer/en/$1
htpasswd -cb /var/www/vhosts/$1/pd/.webstats $1 $4
#cat << EOF | /usr/bin/expect
#spawn /usr/bin/htpasswd -c /var/www/vhosts/$1/pd/.webstats $1
#expect "assword:"
#send "$4\r"
#expect "assword:"
#send "$4\r"
#EOF

# reload apache
service httpd reload
#service apache2 reload
service php-8.2.5-fpm reload


echo "--------------" >> /var/log/kms/setup.log

# enviem email de confirmacio
#echo "domain: $1" >> $MSG
#SUBJECT="Kms vhost created"
#EMAIL="sistemes@intergrid.cat"
#/bin/mail -s "$SUBJECT" "$EMAIL" < $MSG
