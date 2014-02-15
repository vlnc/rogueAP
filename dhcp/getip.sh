#!/bin/sh

# Ce script verifie si les adresses attribuees par le DHCP a l'aide du fichier /var/log/dhcpd.log en cherchant les DHCPOFFER
# Il les placent ensuite dans un fichier et cree une regle de redirection spécifique a cette IP vers le portail local ecoutant sur le port 8080
# S'il detecte un DHCPRELEASE dans le fichier /var/log/dhcpd.log, il supprime la regle nat de l'ip qui vient d etre release et la supprime du fichier $logFile

#############
# Variables #
#############

nbClient=0
test1=0
core="/root/Desktop/projetWifi"
logFile="$core/dhcp/log"
dhcpLogFile="/var/log/dhcpd.log"
logTemp="$core/dhcp/logTemp"
clientLst="$core/dhcp/client.lst"

#########
# BEGIN #
#########


touch $logFile
rm $dhcpLogFile
touch $dhcpLogFile
chown syslog $dhcpLogFile
chmod 0600 $dhcpLogFile

service rsyslog restart > /dev/null

while [ -z "$dhcpdPID" ]; do
	dhcpdPID=`pidof dhcpd3`
	echo "[+] INFO: Waiting for dhcpd3 to start ..."
	sleep 2
done

echo -e "[+] INFO: dhcp3 started ($dhcpdPID)"

tail -n 1 -f $dhcpLogFile >> $logTemp & log2=$!

xterm -geometry 75x20+1+375 -T "DHCP - Clients" -e watch -n 1 --no-title "cat $clientLst" & dhcpClient=$!

while true; do
	listIp=`cat $logFile`
	echo -e "####################\n## List of client ##\n####################\n\nNombre de client : $nbClient\n\nList of ip : $listIp" > $clientLst

	#if [ $test1 -eq 1 ]; then
	#	rm $logTemp
	#	tail -n 1 -f $dhcpLogFile >> $logTemp & log2=$!
	#	test1=0
	#fi

	getDate=`date '+[%d/%m/%Y][%H:%M:%S]'`
	checkIpOffer=`egrep "DHCPOFFER on|DHCPREQUEST for" $dhcpLogFile | awk '{print $8}' | uniq | tail -n 1`

	if [ ! -z "$checkIpOffer" ]; then 
		comparIp=`grep $checkIpOffer $logFile`
			if [ $? -eq 1 ]; then
				echo "[+] INFO: Host $checkIpOffer trapped"
			    echo $checkIpOffer >> $logFile
			    iptables -t nat -A PREROUTING -p tcp --source $checkIpOffer --destination-port 80 -j REDIRECT --to-ports 8080
				iptables -t nat -A PREROUTING -p tcp --source $checkIpOffer --destination-port 443 -j REDIRECT --to-ports 8080
				nbClient=$(( nbClient + 1 ))
				#kill ${log2}
				#test1=1
				#sed -i "/DHCPOFFER/d" dhcp/log.2
			fi
	fi

	
	checkIpRelease=`grep "DHCPRELEASE of 10" $logTemp | awk '{print $8}' | uniq`

	if [ ! -z "$checkIpRelease" ]; then
			removeNatRule=`iptables -t nat -vnL --line-numbers | grep $checkIpRelease | awk '{print $1}' | uniq`				
			for line in $removeNatRule; do
				iptables -t nat -D PREROUTING 1
			done
			sed -i "s/$checkIpRelease//" $logTemp
			#sed -i "s/$checkIpRelease//" $logFile
			#sed -i "/DHCPRELEASE/d" $dhcpLogFile
			echo "[+] INFO: $checkIpRelease released"
			# Nettoyer le fichier avec l'ip
			nbClient=$(( nbClient - 1 ))
			#kill ${log2}
			#test1=1
	fi

echo -e "$getDate [+] INFO: Waiting for host ..."

#if [ ! $nbClient -eq 0 ]; then
#	echo "$getDate [+] INFO: nbClient = $nbClient"
#fi

sleep 1
done

kill ${dhcpClient}
