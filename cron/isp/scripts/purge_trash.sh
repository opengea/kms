#!/bin/bash

VHOSTS_DIR=/var/vmail
cd $VHOSTS_DIR
for i in $(ls $VHOSTS_DIR); do

        for j in $(ls $VHOSTS_DIR/$i); do
echo "$j@$i ..."
        if [ -d "$VHOSTS_DIR/$i/$j/Maildir/.Trash" ]; then
        doveadm expunge -u $j@$i mailbox Trash savedbefore 30d
        fi
        if [ -d "$VHOSTS_DIR/$i/$j/Maildir/.Junk" ]; then
        doveadm expunge -u $j@$i mailbox Junk savedbefore 60d
        fi
        if [ -d "$VHOSTS_DIR/$i/$j/Maildir/.Elementos eliminados" ]; then
        doveadm expunge -u $j@$i mailbox "Elementos eliminados" savedbefore 90d
        fi
        if [ -d "$VHOSTS_DIR/$i/$j/Maildir/.Deleted messages" ]; then
        doveadm expunge -u $j@$i mailbox "Deleted messages" savedbefore 90d
        fi
        if [ -d "$VHOSTS_DIR/$i/$j/Maildir/.Correo no deseado" ]; then
        doveadm expunge -u $j@$i mailbox "Correo no deseado" savedbefore 90d
        fi
        done
done

