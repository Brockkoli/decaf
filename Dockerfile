FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    openssh-server \
    vsftpd \
    apache2 \
    php \
    php-sqlite3 \
    sqlite3 \
    sudo \
    net-tools \
    strace \
    ftp \
    nano \
    && apt-get clean

RUN rm -f /var/www/html/index.html

# Set password and home directory for ssh user
RUN useradd -m -s /bin/bash -g ssh ssh && echo "ssh:ssh" | chpasswd
COPY home/ssh/.bash_history /home/ssh/.bash_history
RUN chown ssh:ssh /home/ssh/.bash_history

# Create luna user with sudo permission for strace
RUN useradd -m luna && echo "luna:cappuccino" | chpasswd && \
    echo "luna ALL=(ALL) NOPASSWD: /usr/bin/strace" >> /etc/sudoers


# Set up SSH
RUN mkdir /var/run/sshd

# Enable password auth in SSH
RUN sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config && \
    sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin no/' /etc/ssh/sshd_config

# Add SSH login banner
COPY ssh_banner.txt /etc/issue.net
RUN echo 'Banner /etc/issue.net' >> /etc/ssh/sshd_config

# Configure FTP
RUN mkdir -p /var/run/vsftpd/empty
COPY vsftpd.conf /etc/vsftpd.conf

# Setup fake webapp
COPY www/ /var/www/html/

# Create SQLite DB with a single admin user
RUN sqlite3 /var/www/html/database.sqlite "CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password TEXT);" \
 && sqlite3 /var/www/html/database.sqlite "INSERT INTO users (email, password) VALUES ('admin', 'irrelevant');"

# Setup the writable /mnt/backup/etc with passwd & shadow copies
COPY mnt/ /mnt/
RUN chmod -R a+w /mnt/backup/etc

# Flags
COPY flags/local.txt /home/luna/local.txt
COPY flags/proof.txt /root/proof.txt

# Set ownership
RUN chown luna:luna /home/luna/local.txt
RUN chown root:root /root/proof.txt

# Set permissions
RUN chmod 755 /home/luna                # Allow ssh to ls and cat local.txt
RUN chmod 644 /home/luna/local.txt      # World-readable
RUN chmod 600 /root/proof.txt           # Root-only readable


# Entrypoint to start all services
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 21 22 80

CMD ["/entrypoint.sh"]
