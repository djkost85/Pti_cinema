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
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films - </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs </span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinemas </span></div>

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
if(isset($_GET['num_film'])){
$num_film = (int) mysql_real_escape_string($_GET['num_film']);}

$sql = "SELECT *, genre.genre, realisateur.nom_real FROM film LEFT JOIN genre ON genre.Num_genre = film.Num_genre LEFT JOIN realisateur ON realisateur.Num_real = film.Num_real HAVING num_film=".$num_film.";";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
$sql2 = "SELECT * FROM GENRE";
$result2 = mysql_query($sql2)or die ('Erreur SQL !'.$sql2.'<br />'.mysql_error()); 
$sql3 = "SELECT * FROM realisateur";
$result3= mysql_query($sql3)or die ('Erreur SQL !'.$sql3.'<br />'.mysql_error()); 
while ($donnees = mysql_fetch_assoc($result))
{
?>
	<div class="films">
   			<p>
	        <h3 onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($num_film);?>'" style="cursor:pointer;">
	            <?php echo htmlspecialchars($donnees['titre']); ?> 
	        </h3>
	        <?php $resume = htmlspecialchars($donnees['resume']); $titre = htmlspecialchars($donnees['titre']);
		$duree = htmlspecialchars($donnees['duree']); $affiche = htmlspecialchars($donnees['affiche']); $video = $donnees['video'];
		$annee = htmlspecialchars($donnees['Annee']); $genre = htmlspecialchars($donnees['genre']); $realisateur = htmlspecialchars($donnees['nom_real']);?>
       
	     <?php echo"<form action='Films_modif.php' method='post' enctype='multipart/form-data'>
	     <input type='hidden' name='num_film' value='$num_film'>
	       <label style='display: block;width: 100px;float: left;' for='Titre'><b>Titre:</b></label> <input type='text' name='titre' size='30px;' id='titre' value='$titre'><br>
	    	<label style='display: block;width: 150px;float: left;' for='Réalisateur'><b>Réalisateur:</b></label> "; echo"<SELECT name='Num_real'>"; 
	    	$Num_real = htmlspecialchars($donnees['Num_real']);
   while($data2 = mysql_fetch_assoc($result3))
    {	 
  		echo '<option value="'.htmlspecialchars($data2['Num_real']).'" ';
		if ($data2['Num_real'] == $donnees['Num_real']) {echo "selected='selected'";} // Si le réalisateur parcouru depuis la table Realisateur est celui du film, on le "selected"
		echo '>'.htmlspecialchars($data2['nom_real']).' '.htmlspecialchars($data2['prenom_real']).'</option>';
    }
  echo "</SELECT>"; 
  echo "<span title='Ajouter un réalisateur' onclick=location.href='Ajout_real.php' style='cursor:pointer; text-shadow:#fff 0px 0px 10px'> +</span><br>";
  echo "	<label style='display: block;width: 150px;float: left;' for='Année'><b>Année:</b></label><input type='text' name='annee' size='10px;' id='annee' value='$annee'><br>
			<label style='display: block;width: 150px;float: left;' for='Genre'><b>Genre:</b></label> "; echo "<SELECT name='Num_genre'> ";
			while($data = mysql_fetch_assoc($result2))
			{
			echo '<option value="'.htmlspecialchars($data['Num_genre']).'" ';
			if ($data['Num_genre'] == $donnees['Num_genre']) {echo "selected='selected'";} // Si le genre parcouru depuis la table genre est celui du film, on le "selected"
echo '>'.htmlspecialchars($data['Genre']).'</option>';
	 } 
	 
	 $video2 = str_replace("'", "\"", $video);
	 
  echo "</SELECT><br>"; 
			echo "<label style='display: block;width: 150px;float: left;' for='resume'><b>Resumé:</b></label>  <textarea name='resume' rows='6' cols='45' id='resume' value='$resume';>$resume</textarea><br>
  	        <label style='display: block;width: 150px;float: left;' for='duree'><b>Durée:</b></label>  <input type='text' name='duree' size='5px;' id='duree' value='$duree'></input><br>
  	        <label style='display: block;width: 150px;float: left;' for='affiche'><b>Affiche: </b></label>  <input type='text' size='50px;' name='affiche' id='affiche' value='$affiche'><br>
   	        <label style='display: block;width: 150px;float: left;' for='video'><b>Video (allociné): </b></label>  <input type='text' size='50px;' name='video' id='video' value='";?><?php echo htmlspecialchars($video2); ?> <?php echo"'><br>
	      <br>  <input style='margin-left:70%;width: 100px;' type='submit' value='Modifier'>
	        	        </form><br>";?>
	
               <br>
                <br>
   <?php
   echo "<a href='Suppr_film.php?num_film=$num_film'> Supprimer le film </a><br>";
   ?>
          </div>
         <div class="cadre"><?php $connexion = mysql_connect('127.0.0.1', 'root', '');
		mysql_select_db('Films',$connexion); 
		     $num_film = $_GET['num_film'];
		  $requete = mysql_query("SELECT num_film, affiche FROM film WHERE num_film=$num_film");
		  while ($row = mysql_fetch_array($requete))
		  {
		?>
		<a href="Films.php?num_film=<?php echo htmlspecialchars($row['num_film']);?>"><img alt="affiche" src="<?php echo htmlspecialchars($row['affiche']);?>"></a>
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