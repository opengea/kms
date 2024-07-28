#!/bin/bash

#------TODAY SPACE USED ------------------------------------------------
LOG_PATH=/var/log/kms/cron/isp
VHOSTS_DIR=/var/www/vhosts
LOG=$LOG_PATH/isp_space_used_vhosts.log

mkdir -p $LOG_PATH
rm $LOG

for i in $(ls $VHOSTS_DIR); do
#echo -e $i;
	if [ -d $VHOSTS_DIR/$i/httpdocs ]; then
		du -bs $VHOSTS_DIR/$i/httpdocs >> $LOG
		du -bs $VHOSTS_DIR/$i/subdomains >> $LOG
		du -bs $VHOSTS_DIR/$i/web_users >> $LOG
		du -bs $VHOSTS_DIR/$i/statistics >> $LOG
	fi

done

