#!/bin/bash
rsync -vaz --rsh="ssh -l root" * customers-206.intergridnetwork.net:/usr/share/kms/mod/emailing/
