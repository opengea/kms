#!/bin/bash

MYDOMAIN=$1

mkdir -p /etc/opendkim/keys/$MYDOMAIN
cd /etc/opendkim/keys/$MYDOMAIN
opendkim-genkey -r -d $MYDOMAIN
chown -R opendkim:opendkim /etc/opendkim/keys/$MYDOMAIN
chmod go-rw /etc/opendkim/keys/$MYDOMAIN


echo "default._domainkey.$MYDOMAIN $MYDOMAIN:default:/etc/opendkim/keys/$MYDOMAIN/default.private" >> /etc/opendkim/KeyTable
echo "*@$MYDOMAIN default._domainkey.$MYDOMAIN" >> /etc/opendkim/SigningTable
echo "$MYDOMAIN" >> /etc/opendkim/TrustedHosts


DKIM_KEY=$(cat /etc/opendkim/keys/$MYDOMAIN/default.txt | tail -1 | cut -c7-222)

echo "default._domainkey      IN      TXT     ( \"v=DKIM1; k=rsa; s=email; p=$DKIM_KEY\")"


