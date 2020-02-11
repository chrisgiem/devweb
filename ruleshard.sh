#!/bin/bash
#https://bytefish.de/blog/iptables/
# chmod +x ruleshard.sh
# bash ruleshard.sh
# forget old rules
iptables -F
iptables -X
iptables -Z

# set default policy to drop
iptables -P INPUT DROP
iptables -P OUTPUT DROP
iptables -P FORWARD DROP

# allow loopback
iptables -A INPUT -i lo -j ACCEPT
iptables -A OUTPUT -o lo -j ACCEPT

# drop invalid packets
iptables -A INPUT  -m state --state INVALID -j DROP
iptables -A OUTPUT -m state --state INVALID -j DROP
iptables -A FORWARD -m state --state INVALID -j DROP

# allow established, related packets we've already seen
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A OUTPUT -m state --state ESTABLISHED,RELATED -j ACCEPT

# output chain
iptables -A OUTPUT -p tcp -m tcp --dport 22 -m comment --comment "SSH" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 53 -m comment --comment "DNS-TCP" -j ACCEPT
iptables -A OUTPUT -p udp -m udp --dport 53 -m comment --comment "DNS-UDP" -j ACCEPT
iptables -A OUTPUT -p udp -m udp --dport 67:68 -m comment --comment "DHCP" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 80 -m comment --comment "HTTP" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 443 -m comment --comment "HTTPS" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 465 -m comment --comment "SMTPS" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 587 -m comment --comment "SMTPS" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 993 -m comment --comment "IMAPS" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 995 -m comment --comment "POP3S" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 5222 -m comment --comment "JABBER" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 8001 -m comment --comment "IRC" -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 8010 -m comment --comment "JABBER FT" -j ACCEPT

# allow icmp packets (e.g. ping...)
iptables -A INPUT -p icmp -m state --state NEW -j ACCEPT
