#!/bin/bash
LOG_PATH=/var/log/kms/cron/isp
LOG=$LOG_PATH/isp_webstats.log
# -------------------------- WEBSTATS --------------------------------
echo -e "$(date) generating webalizer webstats..." >> $LOG

rm $LOG

for vhost in $(ls /etc/webalizer/cat); do
	echo $vhost'...' >> $LOG
        if [ -s /var/www/vhosts/$vhost/statistics/logs/access_log ]; then
           /usr/local/bin/webalizer-cat -Q -c /etc/webalizer/cat/$vhost >> $LOG
        fi
done

for vhost in $(ls /etc/webalizer/es); do
        if [ -s /var/www/vhosts/$vhost/statistics/logs/access_log ]; then
	echo $vhost'...' >> $LOG
           /usr/local/bin/webalizer-es -Q -c /etc/webalizer/es/$vhost >> $LOG
        fi
done

for vhost in $(ls /etc/webalizer/en); do
        if [ -s /var/www/vhosts/$vhost/statistics/logs/access_log ]; then
		echo $vhost'...' >> $LOG
           /usr/local/bin/webalizer-en -Q -c /etc/webalizer/en/$vhost >> $LOG
        fi
done

echo "done";
