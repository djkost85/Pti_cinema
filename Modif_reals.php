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

<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films  </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'">| Les réalisateurs </span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'">| Les cinémas </span></div>

<div id="corps" style="display:none;">
<?php if($_SESSION['login'] == 'admin') { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>

<br>
<span id="Formulaire"><form method="post" action="Admin.php"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span>
		
		<?php
Require_once 'Connexion.php';
$Num_real =  mysql_real_escape_string($_GET['Num_real']);

$sql = "SELECT * FROM realisateur WHERE Num_real = ".$Num_real.";";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
while ($donnees = mysql_fetch_assoc($result))
{
?>
	<div class="films">
   			<p>
	        <h3>
	            <?php echo htmlspecialchars($donnees['nom_real']); echo "<br><br>"; ?> 
	        </h3>
	        <?php $nom_real = htmlspecialchars($donnees['nom_real']); $prenom_real = htmlspecialchars($donnees['prenom_real']); $image = htmlspecialchars($donnees['image']);?>
       
	     <?php echo"<form action='Real_modif.php' style='display:block;' method='post' enctype='multipart/form-data'>
	     <input type='hidden' name='Num_real' value='$Num_real'><br>
	       <label style='display: block;width: 150px;float: left;' for='nom_real'><b>Nom:</b></label><input type='text' name='nom_real' size='30px;' id='nom' value='$nom_real'><br>
	        <label style='display: block;width: 150px;float: left;' for='prenom_real'><b>Prénom:</b></label>  <input type='text' name='prenom_real' value='$prenom_real';><br>
    	        <label style='display: block;width: 150px;float: left;' for='photo_real'><b>Photo:</b></label>  <input type='text' name='image' value='$image';><br>
  	      	      <br>  <input style='margin-left:70%;width: 100px;' type='submit' value='Modifier'>
	        	        </form><br>";?>    
               <br>
   <br>
   <?php
   echo "<a href='Suppr_real.php?num_real=$Num_real'> Supprimer le réalisateur </a><br>";
   ?>
          </div>
         <div class="cadre"><?php $connexion = mysql_connect('127.0.0.1', 'root', '');
		mysql_select_db('Films',$connexion); 
		     $Num_real =  mysql_real_escape_string($_GET['Num_real']);
		  $requete = mysql_query("SELECT Num_real, image FROM realisateur WHERE Num_real=$Num_real");
		  while ($row = mysql_fetch_array($requete))
		  {
		?>
	<img src="<?php echo $row['image'];?>">
		<?php
		  }
		mysql_close($connexion); 
		?>
		</div>
<?php
}
 ?>
</div>
</body>
</html>