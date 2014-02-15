<?php

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetWifi', 'root', 'toor');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$rep_sfr = $bdd->query('select * from sfr');
$rep_free = $bdd->query('select * from free');

# TALBEAU SFR
?>
<br /><a><strong>Contenu Table Sfr</strong></a><br /><br /> 

<style type="text/css">

table
{
    border-collapse: collapse;
}
td, th
{
    border: 2px solid blue;
    padding: 5px;
}
</style>

<table>
    <tr>
        <th>Id</th>
        <th>User</th>
        <th>Password</th>
        <th>Http User Agent</th>
        <th>Http User Language</th>
        <th>User Remote Ip</th>
		<th>Valide</th>
    </tr>

<?php


while ($donnee = $rep_sfr->fetch())
    {
    ?>
        <tr>
            <td><center><?php echo $donnee['IdSfr']; ?></center></td>
            <td><center><?php echo $donnee['IdentSfr']; ?></center></td>
            <td><center><?php echo $donnee['PassSfr']; ?></center></td>
            <td><center><?php echo $donnee['UserAgent']; ?></center></td>
            <td><center><?php echo $donnee['UserLang']; ?></center></td>
            <td><center><?php echo $donnee['RemoteIp']; ?></center></td>
			<td><center><?php 
								$var = $donnee['validite'];
								#echo $var;
								if ($var == 1)
									echo "YES";
								else
									echo "NO"; ?></center></td>
        </tr>
<?php
    }

?></table>

<br /><br /><a><strong>Contenu Table Free</strong></a><br /><br />

<table>
    <tr>
        <th>Id</th>
        <th>User</th>
        <th>Password</th>
        <th>Http User Agent</th>
        <th>Http User Language</th>
        <th>User Remote Ip</th>
		<th>Valide</th>
    </tr>

<?php


while ($donnee = $rep_free->fetch())
    {
    ?>
        <tr>
            <td><center><?php echo $donnee['IdFree']; ?></center></td>
            <td><center><?php echo $donnee['IdentFree']; ?></center></td>
            <td><center><?php echo $donnee['PassFree']; ?></center></td>
            <td><center><?php echo $donnee['UserAgent']; ?></center></td>
            <td><center><?php echo $donnee['UserLang']; ?></center></td>
            <td><center><?php echo $donnee['RemoteIp']; ?></center></td>
			<td><center><?php 
								$var = $donnee['validite'];
								#echo $var;
								if ($var == 1)
									echo "YES";
								else
									echo "NO"; ?></center></td>
        </tr>
<?php
    }

?></table>
