#!/bin/sh
# Intergrid KMS Server Firewall

echo "Flushing iptables and allowing everything..."
iptables -F
iptables -X
iptables -t nat -F
iptables -t nat -X
iptables -t mangle -F
iptables -t mangle -X
iptables -P INPUT ACCEPT
iptables -P FORWARD ACCEPT
iptables -P OUTPUT ACCEPT

echo "Applying iptables baseline rules..."
# Deny everything on the default INPUT chain
iptables -P INPUT DROP

# Allow connections that are already connected to the server.
iptables -A INPUT -i eth0 -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A INPUT -i eth1 -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A INPUT -i lo -j ACCEPT

# #########################
# Outbound UDP Flood protection in a user defined chain.
iptables -A INPUT -p udp --dport 53 -j ACCEPT
iptables -A OUTPUT -p udp --dport 53 -j ACCEPT

iptables -N udp-flood
iptables -A OUTPUT -p udp -j udp-flood
iptables -A udp-flood -p udp -m limit --limit 200/s -j RETURN
iptables -A udp-flood -j LOG --log-level 4 --log-prefix 'UDP-flood attempt: '

iptables -A INPUT -p udp --dport 53 -j ACCEPT
iptables -A OUTPUT -p udp --dport 53 -j ACCEPT

iptables -A udp-flood -j DROP

iptables -A INPUT -p udp --dport 53 -j ACCEPT
iptables -A OUTPUT -p udp --dport 53 -j ACCEPT

# #########################
# SYN-Flood protection in a user defined chain
iptables -N syn-flood
iptables -A INPUT -p tcp --syn -j syn-flood
iptables -A syn-flood -m limit --limit 30/s --limit-burst 60 -j RETURN
iptables -A syn-flood -j LOG --log-level 4 --log-prefix 'SYN-flood attempt: '
iptables -A syn-flood -j DROP

# #########################
# SSH
# Rate limit SSH on 22
iptables -A INPUT -p tcp --dport 22 -m state --state NEW -m recent --set --name SSH-LIMIT
iptables -A INPUT -p tcp --dport 22 -m state --state NEW -m recent --update --rttl --seconds 60 --hitcount 20 -j REJECT --reject-with tcp-reset --name SSH-LIMIT
iptables -A INPUT -p tcp --dport 22 -j ACCEPT

# #########################
# HTTP
# Allow HTTP and HTTPS
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 443 -j ACCEPT
# Limit trafic for new connections
iptables -A INPUT -p tcp --dport 80 -m state --state NEW -m limit --limit 50/minute --limit-burst 200 -j ACCEPT
# Limit trafic for entablished connections
iptables -A INPUT -p tcp --syn --dport 80 -m connlimit --connlimit-above 30 -j REJECT --reject-with tcp-reset
# Except 1.2.3.4
#iptables -A INPUT -p tcp --syn --dport 80 -d ! 1.2.3.4 -m connlimit --connlimit-above 20 -j REJECT --reject-with tcp-reset

# ############################
# PORT 7475 Intergrid API v1 #
# ############################
iptables -A INPUT -p tcp --dport 7475 -j ACCEPT

# #########################
# IMAP / SMTP (Webmail)
#
iptables -A INPUT -p tcp --dport 143 -j ACCEPT
iptables -A INPUT -p tcp --dport 110 -j ACCEPT
iptables -A INPUT -p tcp --dport 995 -j ACCEPT
iptables -A INPUT -p tcp --dport 993 -j ACCEPT
iptables -A INPUT -p tcp --dport 25 -j ACCEPT
iptables -A INPUT -p tcp --dport 25025 -j ACCEPT
# Sieve
iptables -A INPUT -p tcp --dport 4190 -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 4190 -j ACCEPT

# #########################
# FTP
# Rate limit FTP on 21
#iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A FORWARD -i eth1 -o eth0 -p tcp --dport 21 -j ACCEPT
iptables -A INPUT -p TCP -i eth0 --sport 21 -m state --state NEW -j ACCEPT
iptables -A INPUT -p TCP -i eth0 --sport 20 -m state --state NEW -j ACCEPT
iptables -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT

iptables -A INPUT -p tcp --dport 21 -j ACCEPT
iptables -A INPUT -p tcp --dport 20 -j ACCEPT
iptables -A OUTPUT -p tcp --dport 21 -m state --state ESTABLISHED,NEW -j ACCEPT
iptables -A OUTPUT -p tcp --dport 20 -m state --state ESTABLISHED -j ACCEPT
iptables -A OUTPUT -p tcp --dport 49152:65534 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
iptables -A OUTPUT -p udp --dport 49152:65534 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
iptables -A INPUT -p tcp --dport 49152:65534 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT
iptables -A INPUT -p udp --dport 49152:65534 -m state --state NEW,RELATED,ESTABLISHED -j ACCEPT

# #########################
# MYSQL
# Allow network MYSQL connections
iptables -A INPUT -p tcp --dport 3306 -j ACCEPT
iptables -A INPUT -p udp --dport 3306 -j ACCEPT

# #########################
# Allow PING
iptables -A INPUT -p ICMP --icmp-type 8 -j ACCEPT

# #########################
# Allow resolv DNS servers
iptables -A INPUT -p udp --dport 53 -j ACCEPT
iptables -A udp-flood -p udp --dport 53 -j ACCEPT

# If we made it this far the packet will be dropped - so log it as denied.
#iptables -A INPUT -j LOG --log-level 4 --log-prefix 'Denied: '

# motherfuckers
iptables -A INPUT -s 201.186.118.126 -j DROP
iptables -A INPUT -s 83.47.165.141 -j DROP
