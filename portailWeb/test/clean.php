<?php

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetWifi', 'root', 'toor');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$bdd->exec('delete from sfr');
$bdd->exec('alter table sfr AUTO_INCREMENT=0');
$bdd->exec('delete from free');
$bdd->exec('alter table free AUTO_INCREMENT=0');
?>
