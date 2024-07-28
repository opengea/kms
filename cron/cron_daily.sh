#!/bin/bash
# ISP CRON DAILY SCRIPT
# By Jordi Berenguer <j.berenguer@intergrid.cat>
# INTERGRID.CAT
#------------------------------------------------------------------------------
VHOSTS_DIR=/var/www/vhosts
LOG_PATH=/var/log/kms/cron
SCRIPTS_DIR=/usr/local/kms/cron/isp/scripts
KMS_LOG=/var/log/kms/kms.log

echo "[$(date +"%Y-%m-%d %H:%M:%S")] Initating KMS cron daily..." | tee -a $KMS_LOG
# ------------------------- DATABASE DAILY BACKUP --------------------
echo "Performing database backups..." | tee -a $KMS_LOG
. /usr/local/kms/mod/isp/backups/db_backup.sh

# --------------------  DELETE EXPIRED VMAILS  -----------------------
echo "Removing expired mailboxes..." | tee -a $KMS_LOG
find /tmp/deleted/* -type d -mtime +30 -exec rm -f -r {} \;

# ------------------------- LIMITS (SPACE / TRANSFER USAGE -----------
echo -e 'Checking WP installations' | tee -a $KMS_LOG
kmsWPCheck

echo -e 'Purging database records older than 30 days...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/purge_old.php
#fa log
echo -e 'Calculating today used space for vhosts...' | tee -a $KMS_LOG
. $SCRIPTS_DIR/isp_space_used_vhosts.sh
#crea entrades
echo -e 'Initializing ISP db records...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/isp_create_today_records.php
echo -e 'Updating database with updated used space...' | tee -a $KMS_LOG
#update db
php $SCRIPTS_DIR/isp_space_used_vhosts_db.php
echo -e 'Calculating today space used for databases...' | tee -a $KMS_LOG
. $SCRIPTS_DIR/isp_space_used_databases.sh
echo -e 'Updating database with updated used space for databases...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/isp_space_used_databases_db.php
echo -e 'Calculating yesterday transfer for vhosts...' | tee -a $KMS_LOG
. $SCRIPTS_DIR/isp_transfer_used_vhosts.sh
echo -e 'Updating transfer for vhosts...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/isp_transfer_used_vhosts_db.php
echo -e 'Updating space used for mailboxes...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/isp_used_mailboxes.php
#echo -e 'calculating space used for mailboxes...'
#. $SCRIPTS_DIR/isp_space_used_mailboxes.sh
#echo -e 'updating space used for mailboxes on database...'
#php $SCRIPTS_DIR/isp_space_used_mailboxes_db.php
#echo -e 'calculating transfer used for mailboxes (yesterday)...'
#. $SCRIPTS_DIR/isp_transfer_used_mailboxes.sh
#echo -e 'updating transfer used for mailboxes on database...'
#php $SCRIPTS_DIR/isp_transfer_used_mailboxes_db.php
echo -e 'Updating backup totals...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/isp_space_used_backups_db.php
echo -e 'Updating totals...' | tee -a $KMS_LOG
php $SCRIPTS_DIR/isp_update_totals.php
echo -e 'Generating webalizer webstats...' | tee -a $KMS_LOG
. $SCRIPTS_DIR/isp_webstats.sh
echo -e "[$(date +"%Y-%m-%d %H:%M:%S")] All jobs have been completed successfully." | tee -a $KMS_LOG
