#!/bin/bash
LOG_PATH=/var/log/kms/cron/isp
LOG=$LOG_PATH/isp_transfer_used.log
VHOSTS_DIR=/var/www/vhosts

mkdir -p $LOG_PATH
rm $LOG

#TODAY_DATE=`date +%d/%b/%Y`
YESTERDAY=$((`date +'%s'` - 86400))
YESTERDAY_DATE=`date -d "1970-01-01 $YESTERDAY sec" +"%d/%b/%Y"`
echo $YESTERDAY_DATE
for i in $(ls $VHOSTS_DIR); do
	#echo -e $i;
# quan aturem PLESK activarem el #CustomLog "|/usr/bin/cronolog logs/%Y-%m-%d/access.log" combined  
# al apache de manera que puguem llegir en aquest script el access_log del dia que ens interessi, augmentant el rendiment del calcul
	TRAFFIC_BYTES=$(cat $VHOSTS_DIR/$i/statistics/logs/access_log* | grep $YESTERDAY_DATE | awk '{SUM+=$10}END{print SUM}')
	ZERO="0"
	if [ '$TRAFFIC_BYTES' != '$ZERO' ]; then
		#echo $i $TRAFFIC_BYTES 
		echo $i $TRAFFIC_BYTES >> $LOG
	fi
done

