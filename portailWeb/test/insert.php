<?php

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetWifi', 'root', 'toor');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$bdd->exec('insert into identifiant(NomId, PassId) values(\'Administrateur\', \'Password1\')');

?>
