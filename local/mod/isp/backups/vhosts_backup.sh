#!/bin/bash

cd /usr/local/kms/mod/isp/backups/
IP_ADDR=$(getent hosts `hostname`)

if [ ! -f /etc/kms/backup.conf ]; then
echo "Error en fitxer de configuracio del backup, revisar servidor $IP_ADDR" | mail -s "Error fitxer configuracio backups" sistemes@intergrid.cat
exit
fi

. /etc/kms/backup.conf
mkdir -p $LOCAL_BACKUP_DIR/vhosts

CERT="true"
BACKUP="true"
TIME=$(date +%Y%m%d)
OLD=$(date +%Y%m --date '-60 days')

echo -e "Starting vhosts backup \n"
echo -e "Starting vhosts backup\n" >> $LOG_DIR/backup.log 2>&1

# -------------- cleaning previous backup files --------------------------
echo "Cleaning previous vhosts backup remote files from backup server...";
ssh -p $BACKUPSERVER_SSH_PORT $BACKUPSERVER_HOSTNAME "rm -r $BACKUPSERVER_DIR/vhosts/$OLD*"
php /usr/local/kms/mod/isp/backups/isp_backups.php purge

# --- prepare backup
ssh -p $BACKUPSERVER_SSH_PORT $BACKUPSERVER_HOSTNAME "mkdir -p $BACKUPSERVER_DIR/vhosts/$TIME"
rm $LOG_DIR/exclude.log 2>/dev/null

if [ "$#" -eq 0 ]; then
   single=false;
   echo -e "backing up all vhosts..."
else
   echo -e "backing up only $1"
   single=$1
fi



for i in $(ls $VHOSTS_DIR); do
	#echo -e $i

	if [ -z "$single" ]; then

       if [ $i = $single ]; then
        BACKUP="true"
       else
	BACKUP="false"
	fi

	fi

if [ $BACKUP = "true" ]; then
	echo -e "backing up "$i
	echo -e "backing up "$i >> $LOG_DIR/backup.log 2>&1
	# ---------------- Exclude rules -------------------------- 
	echo -e "Applying exclude & include rules..."
	# Futur: podriem llegir regles del backup personalitzables per client del fitxer /conf/backup.conf
	# Fitxers mes grans de 10M excluits per defecte del tipus que siguin
        #find $VHOSTS_DIR/$i -size +10000k > $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
	touch $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
	find $VHOSTS_DIR/$i/statistics/* >> $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
	cd $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/
	# Afegim a la llista d'exclosos els fitxers mes grans de 5 M 
	#find $VHOSTS_DIR/$i ! -name '*.pdf' ! -name '*.mp3' ! -name '*.ppt' -name '*.vob' -name '*.zip' -name '*.tgz' -name '*.tar.gz' -name '*.iso' -name '*.deb' -name '*.rpm' -size +5000k >> $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
	find $VHOSTS_DIR/$i   -type f -size +5G >> $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
        echo -e "Creating tgz for "$i" ...."
#        nice -n 20 tar -cvzpf  $LOCAL_BACKUP_DIR/vhosts/$i.tgz --exclude-ignore=$VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst --directory=$VHOSTS_DIR/$i --include='./conf' --include='./httpdocs' --include='./subdomains' --include='./webusers' --include='./statistics' --include='./error_docs' > /dev/null 
	#find $VHOSTS_DIR/$i -type d \( -name 'conf' -o -name 'httpdocs' -o -name 'subdomains' -o -name 'webusers' -o -name 'statistics' \) -exec tar cvzpf $LOCAL_BACKUP_DIR/vhosts/$i.tgz --exclude-ignore=$VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst --directory=$VHOSTS_DIR/$i {} +
	find $VHOSTS_DIR/$i -type d \( -name 'conf' -o -name 'httpdocs' -o -name 'subdomains' -o -name 'webusers' -o -name 'statistics' \) -exec tar cvzpf $LOCAL_BACKUP_DIR/vhosts/$i.tgz --exclude-ignore=$VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst --directory=$VHOSTS_DIR/$i {} + > /dev/null 2>&1


	
	cat $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst >> $LOG_DIR/exclude.log;
        if [ $? != 0 ]; then
	        echo "Error "$LOCAL_BACKUP_DIR/vhosts/$i  >> $LOCAL_BACKUP_DIR/vhosts/error.log 2>&1
	        echo "Error "$LOCAL_BACKUP_DIR/vhosts/$i  
        fi
	echo -e "Transfering $i.tgz file to backup server..."	
	nice -n 20 scp -i /root/.ssh/id_rsa -P $BACKUPSERVER_SSH_PORT $LOCAL_BACKUP_DIR/vhosts/$i.tgz $BACKUPSERVER_USERNAME@$BACKUPSERVER_HOSTNAME:$BACKUPSERVER_DIR/vhosts/$TIME
	echo "Removing local $i.tgz file"
	BYTES=$(du -sb $LOCAL_BACKUP_DIR/vhosts/$i.tgz);
	rm $LOCAL_BACKUP_DIR/vhosts/$i.tgz

	echo -e "php /usr/local/kms/mod/isp/backups/isp_backups.php vhosts full $i $BYTES $BACKUPSERVER_HOSTNAME" >> $LOG_DIR/backup.log 2>&1

	php /usr/local/kms/mod/isp/backups/isp_backups.php vhosts full $i $BYTES $BACKUPSERVER_HOSTNAME

fi

done
#clean
rm  $LOCAL_BACKUP_DIR/vhosts/*; 2>/dev/null
echo "Vhosts Backup finished!";
echo -e "Vhosts Backup finished\n" >> $LOG_DIR/backup.log 2>&1

