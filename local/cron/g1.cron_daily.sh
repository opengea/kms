#!/bin/sh
PHP=/usr/bin/php5

# ERP - Invoices
$PHP /usr/local/kms/mod/erp/invoice_generator_cron.php
$PHP /usr/local/kms/mod/erp/send_invoices.php

# ERP - Contracts
$PHP /usr/local/kms/mod/isp/auto_cancellations.php

# ISP
$PHP /usr/local/kms/mod/isp/transfer_invoices.php # Data syncronization script between ERP and ISP modules
$PHP /usr/local/kms/mod/isp/auto_notifications.php
$PHP /usr/local/kms/mod/isp/client_notification.php #enviament notificacio caducitat dominis
$PHP /usr/local/kms/mod/isp/domains/isp_domains_cron.php

# ERP - Accounting
$PHP /usr/local/kms/mod/erp/journaling.php         # create new journal book entries and create subaccounts if necessari

# Calcul de consums (els servidors web ha de ser els primers perque creen records)
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON HOST a1 ======== "
#ssh root@a1.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON HOST a2 ======== "
#ssh root@a2.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON HOST a3 ======== "
#ssh root@a3.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON HOST xv1 ======== "
#ssh root@xv1.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON HOST xv2 ======== "
#ssh root@xv2.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'

# Calcul consums servidors correu
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON MX1 ======== "
#ssh root@mail1.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'
#echo -e "======== EXEC /usr/local/kms/cron/isp/cron_daily.sh ON MX2 ======== "
#ssh root@mx2.intergridnetwork.net '/usr/local/kms/cron/isp/cron_daily.sh &'

# Totals
echo -e "======== TOTALS /usr/local/kms/cron/isp/hostings_log.php  ======== "
$PHP /usr/local/kms/cron/isp/hostings_log.php

# Stats (es el que triga mes i per tant ho deixem al final)
#echo -e "======== WEBSTATS a1 ========";
#ssh root@a1.intergridnetwork.net '/usr/local/kms/cron/isp/scripts/isp_webstats.sh &'
#echo -e "======== WEBSTATS a2 ========";
#ssh root@a2.intergridnetwork.net '/usr/local/kms/cron/isp/scripts/isp_webstats.sh &'
#echo -e "======== WEBSTATS a3 ========";
#ssh root@a3.intergridnetwork.net '/usr/local/kms/cron/isp/scripts/isp_webstats.sh &'
#echo -e "======== WEBSTATS xv1 ========";
#ssh root@xv1.intergridnetwork.net '/usr/local/kms/cron/isp/scripts/isp_webstats.sh &'
#echo -e "======== WEBSTATS xv2 ========";
#ssh root@xv2.intergridnetwork.net '/usr/local/kms/cron/isp/scripts/isp_webstats.sh &'
