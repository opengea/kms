#!/bin/bash
# KMS BACKUPMAN v.1.0
# By Jordi Berenguer 
#------------------------------------------------------------------------------
#  Script to enable easy backup of all important Server files
#  and also creates a customized backup for each virtual host
#------------------------------------------------------------------------------
#  The backup is sended via SSH to the remote backup server
#  minimizing at maximum the required disk space for backups

cd /usr/local/kms/lib/backupman/;
. /usr/local/kms/lib/backupman/backupman.conf

echo -e "Starting vhosts backup \n"

# -------------- cleaning previous backup files --------------------------
echo "Cleaning previous vhosts backup remote files from backup server...";
#ssh -p  $BACKUPSERVER_SSH_PORT $BACKUPSERVER_USERNAME@$BACKUPSERVER_HOSTNAME "rm "$BACKUPSERVER_DIR"/*.tgz > /dev/null";
#echo "Cleaning previous local backup files ...";
#echo "Press any key to continue, or wait 10 seconds."
#read -n1 -t10 any_key
CERT="true"
BACKUP="true"
TIME=$(date +%Y%m%d)
TIME=""

#ssh -p $BACKUPSERVER_SSH_PORT $BACKUPSERVER_HOSTNAME "mkdir $BACKUPSERVER_DIR/vhosts/$TIME"
ssh -p $BACKUPSERVER_SSH_PORT $BACKUPSERVER_HOSTNAME "mv $BACKUPSERVER_DIR/vhosts/*.tgz $BACKUPSERVER_DIR/vhosts/old"
for i in $(ls $VHOSTS_DIR); do
echo -e $i
#       if [ $i = cas-da.cat ]; then
#        BACKUP="true"
#       fi
if [ $BACKUP = "true" ]; then
	echo -e "backing up "$i
	# ---------------- Exclude rules -------------------------- 
	echo -e "Applying exclude & include rules..."
	# Futur: podriem llegir regles del backup personalitzables per client del fitxer /conf/backup.conf
	# Fitxers mes grans de 10M excluits per defecte del tipus que siguin
        find $VHOSTS_DIR/$i -size +1000k > $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
	find $VHOSTS_DIR/statistics/* > $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
	# Afegim a la llista d'exclosos els fitxers mes grans de 5 M i mes petits que 10M 
	find $VHOSTS_DIR/$i ! -name '*.pdf' ! -name '*.mp3' ! -name '*.ppt' -name '*.vob' -name '*.zip' -name '*.tgz' -name '*.tar.gz' -name '*.iso' -name '*.deb' -name '*.rpm' -size +5000k -size -1000k >> $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
        echo -e "Creating tgz for "$i" ...."
	touch $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst
        tar -cvzpf $LOCAL_BACKUP_DIR/vhosts/$i.tgz $VHOSTS_DIR/$i -R -X $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst > /dev/null 
	cat $VHOSTS_DIR/$i/$VHOST_LOG_FILES_DIR/backup_exclude.lst >> $LOCAL_BACKUP_DIR/vhosts/exclude.log;
        if [ $? != 0 ]; then
	        echo "Error "$LOCAL_BACKUP_DIR/vhosts/$i  >> $LOCAL_BACKUP_DIR/vhosts/error.log 2>&1
	        echo "Error "$LOCAL_BACKUP_DIR/vhosts/$i  
        fi
	#echo "Transfering $i.tgz file to backup server..."	
	scp -P $BACKUPSERVER_SSH_PORT $LOCAL_BACKUP_DIR/vhosts/$i.tgz $BACKUPSERVER_USERNAME@$BACKUPSERVER_HOSTNAME:$BACKUPSERVER_DIR/vhosts/$TIME
	#echo "Removing local $i.tgz file"
	rm $LOCAL_BACKUP_DIR/vhosts/$i.tgz
fi

done
#clean
rm  $LOCAL_BACKUP_DIR/vhosts/*; > /dev/null
echo "Vhosts Backup finished!";



