#!/bin/bash
#  backup

Backup_Dirs="/home /etc /usr/local /opt /var /root /boot"
Backup_Dest_Dir=/tmp/backup
Backup_Date=`date +%b%d%Y`
Image_File=/tmp/backup.iso
declare -i Size

# Create tar file with todays Month Day Year prepended for easy identification
tar cvzf $Backup_Dest_Dir/$Backup_Date.tar.gz $Backup_Dirs &> /dev/null

# Start backup process to local CD-RW drive
echo "Backing up $Backup_Dest_Dir to CD-RW Drive - $Backup_Date"
echo "Creating ISO9660 file system image ($Image_File)."

mkisofs -b toms288.img -c boot.cat -r \
        -o $Image_File $Backup_Dest_Dir  &> /dev/nul

# Check size of directory to burn in MB
Size=`du -m $Image_File | cut -c 1-3`
if [ $Size -lt 650 ]
then
   echo "Size of ISO Image $Size MB, OK to Burn"
else
   echo "Size of ISO Backup Image too Large to burn"
   rm $Backup_Dest_Dir/$Backup_Date.tar.gz # Remove dated tar file
   rm $Image_File   # ISO is overwritten next backup but cleanup anyway
   exit 1
fi

# Burn the CD-RW
Speed=4                 # Use best speed for CD-RW disks on YOUR system
echo "Burning the disk."
                              # Set dev=x,x,x from cdrecord -scanbus
cdrecord -v speed=$Speed blank=fast dev=1,0,0 $Image_File &> /dev/null
Md5sum_Iso=`md5sum $Image_File`
echo "The md5sum of the created ISO is $Md5sum_Iso"

# Could TEST here using Md5sum_Iso to verify md5sums but problem is tricky.
echo "To verify use script md5scd, this will produce the burned CD's md5sum"
echo "run this as User with backup CD in drive to be used for recovery."
echo "This verifies not only the md5sum but that disk will read OK when needed."

# Remove image file and tar file
echo "Removing $Image_File"
rm $Image_File
echo "Removing : $Backup_Dest_Dir/$Backup_Date.tar.gz"
rm $Backup_Dest_Dir/$Backup_Date.tar.gz
echo "END BACKUP $Backup_Date"
echo "Be sure to place this backup in the RED CD case and previous CD in GREEN"
echo "------------------------------------------------------------------------"
exit 0

