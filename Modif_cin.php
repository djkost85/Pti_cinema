<?php
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Base de données de films</title>
<meta name="description" content="Sorties Cinema" >
<meta name="keywords" content="Sorties, cinema, films, affiche" >
<link href="../Pti_Cinema/Css/Films.css" rel="stylesheet" type="text/css">
<script src="../Pti_Cinema/Script/jquery.js"></script>
<script type="text/javascript" src="../Pti_Cinema/Script/jquery.color.js"></script>
<script type="text/javascript"> 
    $('#corps').ready(function(){
           $('#corps').fadeIn(2000);
   });
</script>
<script src="Script/script.js"></script>
</head>
<body>	
<?php ?>
<div id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
<span id="c" onclick="location.href='Index.php'" style="cursor:pointer;" >Films à </span><span class="v" onclick="location.href='Index.php'" style="cursor:pointer;">l'affiche</span>
</div>
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinémas </span></div>

<div id="corps" style="display:none;">
<?php if($_SESSION['login'] == 'admin') { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo htmlspecialchars($_SESSION['login']);?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>

<br>
<span id="Formulaire"><form method="post" action="Admin.php"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span>
		
		<?php
Require_once 'Connexion.php';
$Num_cin = (int) mysql_real_escape_string($_GET['num_cin']);

$sql = "SELECT * FROM cinema WHERE Num_cin = ".$Num_cin.";";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
while ($donnees = mysql_fetch_assoc($result))
{
?>
	<div class="films">
   			<p>
	        <h3>
	            <?php echo htmlspecialchars($donnees['nom_cin']); ?> 
	        </h3>
	        <?php $nom_cin = htmlspecialchars($donnees['nom_cin']); $adresse_cin = htmlspecialchars($donnees['adresse_cin']); $codepos = htmlspecialchars($donnees['codepos_cin']); $ville = htmlspecialchars($donnees['ville_cin']);?>
       
	     <?php echo"<form action='Cin_modif.php' style='display:block;' method='post' enctype='multipart/form-data'>
	     <input type='hidden' name='num_cin' value='$Num_cin'>
	        <label style='display: block;width: 120px;float: left;' for='nom_cin'><b>Nom:</b></label><input type='text' name='nom_cin' size='30px;' id='nom' value='$nom_cin'><br>
	        <label style='display: block;width: 150px;float: left;' for='adrese_cin'><b>Adresse:</b></label>  <input type='text' name='adresse_cin' value='$adresse_cin';><br>
    	        <label style='display: block;width: 150px;float: left;' for='photo_real'><b>Code Postal:</b></label>  <input type='text' name='codepos_cin' value='$codepos';><br>
    	         <label style='display: block;width: 150px;float: left;' for='photo_real'><b>Ville:</b></label>  <input type='text' name='ville' value='$ville';><br>
  	      	      <br>  <input style='margin-left:70%;width: 100px;' type='submit' value='Modifier'>
	        	        </form><br>";?>    
               <br>
   <br>
   <?php
   echo "<a href='Suppr_cin.php?num_cin=$Num_cin'> Supprimer le cinéma </a><br>";
   ?>
          </div>
         <?php
}
 ?>
</div>
</body>
</html>