#!/bin/sh
PHP=/usr/bin/php5

# ERP - Invoices
logger -s "KMS: invoice_generator_cron"
$PHP /usr/local/kms/mod/erp/invoice_generator_cron.php
logger -s "KMS: send_invoices"
$PHP /usr/local/kms/mod/erp/send_invoices.php

