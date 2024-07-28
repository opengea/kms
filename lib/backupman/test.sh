#!/bin/bash
# DB server (mysql) backup script. It includes ALL databases provided by database server

cd /usr/local/kms/lib/backupman/;
. /usr/local/kms/lib/backupman/backupman.conf;

TIME=$(date +%Y%m --date '-30 days')

echo !=$TIME*

