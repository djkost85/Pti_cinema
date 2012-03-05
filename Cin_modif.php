<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';
//Recuperation du num_film correspondant
$num_cin = (int) mysql_real_escape_string($_POST['num_cin']);

$nom =  mysql_real_escape_string($_POST['nom_cin']);
$adresse = mysql_real_escape_string($_POST['adresse_cin']);
$codepos = mysql_real_escape_string($_POST['codepos_cin']);
$ville = mysql_real_escape_string($_POST['ville']);

$sql = 'UPDATE cinema SET nom_cin="'.$nom.'", adresse_cin="'.$adresse.'", codepos_cin="'.$codepos.'", ville_cin="'.$ville.'" WHERE num_cin="'.$num_cin.'";';

 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
      
    // Redirection vers la page du film
    header('Location: Modif_cin.php?num_cin='.$num_cin.'');
?>