<?php
//date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
//connexion a la base de donnees
Require_once 'Connexion.php';
//Recuperation du num_film correspondant
if (isset($_GET['Num_real'])){
$Num_real = (int) mysql_real_escape_string($_GET['Num_real']);
}

$sql = "DELETE FROM realisateur WHERE Num_real=$Num_real;";
 
      mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
    
?> 
<html> 
<head>
<script type="text/javascript"> alert"RÃ©alisateur supprimÃ©!"; </script>
</head>
</html>
<?php
    header('Location: admin_reals.php');
?>