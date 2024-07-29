#!/bin/bash
# KMS BACKUPMAN v.1.0
# By Jordi Berenguer 
#------------------------------------------------------------------------------
#  Script to enable easy backup of all important Server files
#  and also creates a customized backup for each virtual host
#------------------------------------------------------------------------------
#  The backup is sended via SSH to the remote backup server
#  minimizing at maximum the required disk space for backups

cd /usr/local/kms/mod/isp/backups/
. /usr/local/kms/mod/isp/backups/backupman.conf
mkdir -p $LOCAL_BACKUP_DIR
mkdir -p $LOG_DIR
rm $LOG_DIR/backup.log

. /usr/local/kms/mod/isp/backups/vhosts_backup.sh
#/usr/local/kms/mod/isp/backups/db_backup.sh
echo "Backup finished.";
