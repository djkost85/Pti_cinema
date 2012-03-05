<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';

//Recuperation du num_film correspondant
$num_film = (int) mysql_real_escape_string($_POST['num_film']);
$titre = mysql_real_escape_string($_POST['titre']);
$resume = mysql_real_escape_string($_POST['resume']);
$duree = mysql_real_escape_string($_POST['duree']);
$video = str_replace("'", "\"", mysql_real_escape_string($_POST['video']));
$affiche = mysql_real_escape_string($_POST['affiche']);
$Num_real = mysql_real_escape_string($_POST['Num_real']);
$Num_genre = mysql_real_escape_string($_POST['Num_genre']);
$annee = mysql_real_escape_string($_POST['annee']);

$sql = 'UPDATE film SET titre="'.$titre.'", duree="'.$duree.'", resume="'.$resume.'", affiche="'.$affiche.'", Num_genre="'.$_POST['Num_genre'].'", Num_real="'.$_POST['Num_real'].'", Annee="'.$annee.'", video="'.$video.'" WHERE num_film="'.$_POST['num_film'].'";';

 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
      
$sql = "UPDATE film SET video='".$video."' WHERE num_film='".$num_film."';";

      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 

    // Redirection vers la page de modification du film
    header('Location: Modif_films.php?num_film='.$num_film.'');
?>