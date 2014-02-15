#!/bin/sh

dhcpLogFile='/var/log/dhcpd.log'
logFile='/root/Desktop/projetWifi/dhcp/log'

while true; do
	checkRelease=`grep "DHCPRELEASE of" $dhcpLogFile | awk '{print $8}' | uniq`
	if [ ! -z "$checkRelease" ]; then
			removeNatRule=`iptables -t nat -vnL --line-numbers | grep $checkRelease | awk '{print $1}'`
				for line in $removeNatRule; do
					echo "[+] INFO: Host $checkRelease released"
					iptables -t nat -D PREROUTING $line
				done
	fi
echo -n "!"
sleep 1
done
