#!/bin/bash
# full backup
#------------------------------------------------------------------------------

echo "Backing up databases..."
. /root/scripts/backupman/bd_backup.sh

echo "Backing up virtualhosts..."
. /root/scripts/backupman/vhosts_backup.sh

echo "Full Backup finished!"



