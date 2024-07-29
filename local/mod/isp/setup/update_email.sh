#!/bin/bash

/bin/date >> /var/log/kms/setup.log
#/usr/bin/id >> /var/log/kms/setup.log

if [ "$1" = "" ]; then
        echo "Error: empty values. aborted"  >> /var/log/kms/setup.log
        exit 0
fi

#if [[ $# -eq 5 ]] && [[ "$2" = "-nAuto" ]] ; then
if [[ $# -eq 5 ]] && [[ "$4" = "-nAuto" ]] ; then

	if [[ "$3" = "false" ]] && [[ "$5" = "false" ]] ; then
	# delete autoresponder
	echo "** DELETE EMAIL AUTORESPONDER **" >> /var/log/kms/setup.log
	echo "email: ${1}" >> /var/log/kms/setup.log
	php /usr/local/kms/mod/isp/setup/delete_autoresponder.php ${1}
	else
	#update autoresponder
	echo "** UPDATE EMAIL AUTORESPONDER **" >> /var/log/kms/setup.log
	echo "email: ${1}" >> /var/log/kms/setup.log
	php /usr/local/kms/mod/isp/setup/create_autoresponder.php ${1} 
	#{NEW_MAILNAME}
	fi

else 
	#if [[ $# -eq 5 ]] && [[ "$3" -ne "$4" ]] ; then
        if [ $# -eq 5 ]; then
	        echo "** UPDATE EMAIL REDIRECT **" >> /var/log/kms/setup.log
	        echo "email: ${1}" >> /var/log/kms/setup.log
		echo "email redirect: ${4}" >> /var/log/kms/setup.log
#	        php /usr/local/kms/mod/isp/setup/create_redirect.php ${4}
	else 
		echo "** UPDATE EMAIL ACCOUNT **" >> /var/log/kms/setup.log
		echo "old email: ${1}" >> /var/log/kms/setup.log
		echo "new email: ${2}" >> /var/log/kms/setup.log
		echo "old mailbox: ${3}"  >> /var/log/kms/setup.log
		echo "new mailbox: ${4}"  >> /var/log/kms/setup.log
		echo "old password: ${5}"  >> /var/log/kms/setup.log
		echo "new password: ${6}"  >> /var/log/kms/setup.log
		echo "old mailbox quota: ${7}"  >> /var/log/kms/setup.log
		echo "new mailbox quota: ${8}"  >> /var/log/kms/setup.log
		echo "old redirect: ${9}"  >> /var/log/kms/setup.log
		echo "new redirect: ${10}"  >> /var/log/kms/setup.log
		echo "old redirect address: ${11}"  >> /var/log/kms/setup.log
		echo "new redirect address: ${12}"  >> /var/log/kms/setup.log
		echo "old mail group: ${13}" >> /var/log/kms/setup.log
		echo "new mail group: ${14}" >> /var/log/kms/setup.log
		echo "old autoresponder: ${15}" >> /var/log/kms/setup.log
		echo "new autoresponder: ${16}" >> /var/log/kms/setup.log
		echo "old cp access: ${17}" >> /var/log/kms/setup.log
		echo "new cp access: ${18}" >> /var/log/kms/setup.log
	fi

fi

# nothing. It does all setup.


# echo '
# '$1' redirect
#<VirtualHost 46.4.126.102:80>
#        ServerName   '$1'
#        ServerAlias  www.'$1'
#        ServerAdmin  "registres@intergrid.cat"
#        DocumentRoot /var/www/vhosts/'$1'/httpdocs
#        <IfModule mod_ssl.c>
#                SSLEngine off
#        </IfModule>
#</VirtualHost>
#' >> /etc/httpd/conf.d/zz_vhosts_redirects.conf

echo "--------------" >> /var/log/kms/setup.log

