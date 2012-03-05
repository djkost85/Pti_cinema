<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';


//Recuperation du num_film correspondant
if (isset($_GET['num_cin'])){
$Num_cin = (int) mysql_real_escape_string($_GET['num_cin']);
}

$sql = "DELETE FROM cinema WHERE Num_cin=$Num_cin;";
 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
    
?> 
<html> 
<head>
<script type="text/javascript"> alert"Cinéma supprimé!"; </script>
</head>
</html>
<?php
if (!empty($_GET['ret']))
{
    header('Location: admin_cins.php');
}
    // Redirection vers la page du film
    header('Location: Cinemas.php?num_cin='.$Num_cin.'');
?>