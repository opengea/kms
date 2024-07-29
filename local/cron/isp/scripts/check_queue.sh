#!/bin/sh
#postfix
#A=$(mailq | tail -n1 | awk '{ print $5 }')
#sendmail
A=$(mailq | tail -n1 | awk '{ print $3 }')

if [ "$A" -gt "100" ]; then

        MSG="A A3 hi ha $A missatges en cua!"
        SUBJECT="Possible SPAM a $HOSTNAME"
        TO="abuse@intergrid.cat"
        echo -e "$MSG"
        echo "$MSG" | mail -s "$SUBJECT" "$TO"
else
        echo -e "Tot correcte. Hi ha $A missatges en cua."
fi
