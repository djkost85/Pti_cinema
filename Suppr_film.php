<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';
//Recuperation du num_film correspondant
if (isset($_GET['num_film'])){
$num_film = (int) mysql_real_escape_string($_GET['num_film']);
}

$sql = "DELETE FROM film WHERE num_film=$num_film;";
 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
    
?> 
<html> 
<head>
<script type="text/javascript"> alert"Film supprimé!"; </script>
</head>
</html>
<?php
if (!empty($_GET['ret']))
{
    header('Location: admin_films.php');
}
else{
    // Redirection vers la page du film
    header('Location: index.php');
}
?>