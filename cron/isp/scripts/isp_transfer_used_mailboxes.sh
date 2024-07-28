#!/bin/bash

DIR=/var/qmail/mailnames
LOG_PATH=/var/log/kms/cron
LOG=$LOG_PATH/isp_transfer_used.log

#yesterday mail transfer

pflogsumm -d yesterday -i --iso_date_time --no_bounce_detail --no_deferral_detail --no_reject_detail --no_no_msg_size --no_smtpd_warnings --zero_fill /var/log/maillog | less > $LOG 
