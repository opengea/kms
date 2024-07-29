#!/bin/bash

JAILS=`fail2ban-client status | grep "Jail list" | sed -E 's/^[^:]+:[ \t]+//' | sed 's/,//g'`

if [ $2 = "notunban" ]
then
        #just checking, not echoing

        for JAIL in $JAILS
        do
            fail2ban-client status $JAIL | sed -E '/.*File list.*/d' | egrep -i "Status|Banned IP" | grep $1
        done

else

        #unban 
        echo "$HOSTNAME: unblocking IP";

        for JAIL in $JAILS
        do
            fail2ban-client set $JAIL unbanip $1
        done

fi

