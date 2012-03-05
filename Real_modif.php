<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';

//Recuperation du num_film correspondant
$num_real = (int) mysql_real_escape_string($_POST['Num_real']);

$nom = mysql_real_escape_string($_POST['nom_real']);
$prenom = mysql_real_escape_string($_POST['prenom_real']);
$photo = mysql_real_escape_string($_POST['image']);
$ville = mysql_real_escape_string($_POST['ville']);

$sql = 'UPDATE realisateur SET nom_real="'.$nom.'", prenom_real="'.$prenom.'", image="'.$photo.'" WHERE Num_real = "'.$num_real.'";';

 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
      
    // Redirection vers la page du film
    header('Location: Modif_reals.php?Num_real='.$num_real.'');
?>