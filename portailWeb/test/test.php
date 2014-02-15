<?php

$login = $_POST['username'];
$password = $_POST['password'];

if (isset($login) AND isset($password))
    {
        ?> <a>Valeur Recu :</a><br /><br />
        <a>Utilisateur : </a> <?php echo $login; ?> <br /> <?php
        ?> <a>Mot de passe : </a> <?php echo $password; ?> <br /><br /> <?php
    }

try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=projetWifi', 'root', 'toor');
    }
catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

$req = $bdd->prepare('insert into identifiant(NomId, PassId) values(:NomId, :PassId)');
$req->execute(array(
    'NomId' => $login,
    'PassId' => $password
    ));

$reponse = $bdd->query('select * from identifiant');
echo 'Contenu Base ProjetWifi';?> <br /><br /> 

<style type="text/css">

table
{
    border-collapse: collapse;
}
td, th
{
    border: 1px solid black;
}
</style>

<table>
    <tr>
        <th>Id</th>
        <th>User</th>
        <th>Password</th>
    </tr>

<?php


while ($donnee = $reponse->fetch())
    {
    ?>
        <tr>
            <td><center><?php echo $donnee['IdIdentifiant']; ?></center></td>
            <td><center><?php echo $donnee['NomId']; ?></center></td>
            <td><center><?php echo $donnee['PassId']; ?></center></td>
        </tr>
<?php
    }

?></table>
