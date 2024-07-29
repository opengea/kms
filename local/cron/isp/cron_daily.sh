#!/bin/bash
# ISP CRON DAILY SCRIPT
# By Jordi Berenguer <j.berenguer@intergrid.cat>
# INTERGRID.CAT
#------------------------------------------------------------------------------
VHOSTS_DIR=/var/www/vhosts
LOG_PATH=/var/log/kms/cron
SCRIPTS_DIR=/usr/local/kms/cron/isp/scripts

# ------------------------- DATABASE DAILY BACKUP --------------------
. /usr/local/kms/mod/isp/backups/db_backup.sh

# --------------------  DELETE EXPIRED VMAILS  -----------------------
find /tmp/deleted/* -type d -mtime +30 -exec rm -f -r {} \;



# ------------------------- LIMITS (SPACE / TRANSFER USAGE -----------


echo -e 'purge records older than 30 days...'
php $SCRIPTS_DIR/purge_old.php
#fa log
echo -e 'calculating today space for vhosts...'
. $SCRIPTS_DIR/isp_space_used_vhosts.sh
#crea entrades
echo -e 'initializing db records...'
php $SCRIPTS_DIR/isp_create_today_records.php
echo -e 'updating database for space used...'
#update db
php $SCRIPTS_DIR/isp_space_used_vhosts_db.php
echo -e 'calculating today space for databases...'
. $SCRIPTS_DIR/isp_space_used_databases.sh
echo -e 'updating database for space used in databases...'
php $SCRIPTS_DIR/isp_space_used_databases_db.php
echo -e 'calculating yesterday transfer for vhosts...'
. $SCRIPTS_DIR/isp_transfer_used_vhosts.sh
echo -e 'updating transfer for vhosts...'
php $SCRIPTS_DIR/isp_transfer_used_vhosts_db.php
echo -e 'updating used mailboxes...'
php $SCRIPTS_DIR/isp_used_mailboxes.php
#echo -e 'calculating space used for mailboxes...'
#. $SCRIPTS_DIR/isp_space_used_mailboxes.sh
#echo -e 'updating space used for mailboxes on database...'
#php $SCRIPTS_DIR/isp_space_used_mailboxes_db.php
#echo -e 'calculating transfer used for mailboxes (yesterday)...'
#. $SCRIPTS_DIR/isp_transfer_used_mailboxes.sh
#echo -e 'updating transfer used for mailboxes on database...'
#php $SCRIPTS_DIR/isp_transfer_used_mailboxes_db.php
echo -e 'update backup totals...'
php $SCRIPTS_DIR/isp_space_used_backups_db.php
echo -e 'update totals...'
php $SCRIPTS_DIR/isp_update_totals.php
echo -e 'generating webalizer webstats...'
. $SCRIPTS_DIR/isp_webstats.sh
echo -e 'finished.'
