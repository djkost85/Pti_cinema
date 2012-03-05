<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';

//Recuperation du num_film correspondant
if (isset($_GET['num_film'])){
$num_film = (int) mysql_real_escape_string($_GET['num_film']);
}

if (isset($_GET['num_commentaire'])){
$num_commentaire = (int) mysql_real_escape_string($_GET['num_commentaire']);
}


$sql = "DELETE FROM commentaire WHERE num_commentaire=$num_commentaire;";
 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
    
?> 
<html> 
<head>
<script type="text/javascript"> alert"RÃƒÂ©alisateur supprimÃƒÂ©!"; </script>
</head>
</html>
<?php
    // Redirection vers la page du film
    header('Location: Films.php?num_film='.$num_film.'');
?>

