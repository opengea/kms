#!/bin/bash

for f in /var/vmail/*
do
MYDOMAIN=$(echo "$f" | cut -c12-9999)
./create_dkim.sh $MYDOMAIN
 # do something on $f
done

