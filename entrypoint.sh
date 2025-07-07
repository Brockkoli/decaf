#!/bin/bash

# Start Apache
service apache2 start

# Start SSH
service ssh start

# Start FTP
vsftpd /etc/vsftpd.conf &

# Keep the container running
tail -f /dev/null
