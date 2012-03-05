<?php

//date en francais
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
//connexion a la base de donnees

Require_once 'Connexion.php';
//Recuperation du num_film correspondant
$num_film = (int) mysql_real_escape_string($_POST['num_film']);
extract($_POST);
$pseudo = mysql_real_escape_string($_POST['pseudo']);
$commentaire = mysql_real_escape_string($_POST['commentaire']);
$date = getdate();
$date_c = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'];
$heure = date("H:i");
$date_complete = date("Y-m-d H:i:s");

$sql = 'INSERT INTO commentaire VALUES("NULL", "' . $date_complete . '", "' . $num_film . '", "' . $pseudo . '", "' . $commentaire . '")';

mysql_query($sql) or die('Erreur SQL !' . $sql . '<br />' . mysql_error());

// Redirection vers la page du film
header('Location: Films.php?num_film=' . $num_film . '');
?>