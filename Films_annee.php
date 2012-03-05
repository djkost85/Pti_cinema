<?php
session_start();

if (isset ($_POST['login']) AND isset ($_POST['mdp']))
{
    if(($_POST['login'] == 'admin') AND ($_POST['mdp'] == 'admin'))
    {
       $_SESSION['login'] = $_POST['login'];
        $_SESSION['mdp'] = $_POST['mdp'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Base de données de films</title>
<meta name="description" content="Sorties Cinema" >
<meta name="keywords" content="Sorties, cinema, films, affiche" >
<link href="../Pti_Cinema/Css/Films.css" rel="stylesheet" type="text/css">
<script src="../Pti_Cinema/Script/jquery.js"></script>
<script src="Script/Verification_commentaire.js"></script>
<script type="text/javascript" src="Script/Verification_formulaire.js"></script>
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
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
<span id="Formulaire"><form method="post" action="Films.php?num_film=<?php echo htmlspecialchars($_GET['num_film']);?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span>
		
		<?php
Require_once 'Connexion.php';
if (isset($_GET['page'])){$page = (int) mysql_real_escape_string($_GET['page']); $limit = ($page - 1) * 3;
} else {$limit = 0; }
$Annee = (int) mysql_real_escape_string($_GET['Annee']); $num_film = '';
$sql = "SELECT * FROM film LEFT JOIN genre ON genre.code_allocine = film.Num_genre LEFT JOIN realisateur ON realisateur.code_allocine = film.Num_real HAVING annee=".$Annee." LIMIT ".$limit.",3;";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
Echo "<h3>Année "; 
echo $Annee; echo "</h3><br>";
while ($donnees = mysql_fetch_assoc($result))
{
?>
	<div class="films" >
   			<p>
	        <h3 style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($donnees['num_film']);?>'">
	            <?php echo htmlspecialchars($donnees['titre']); ?>
	        </h3>
 		<table>
      <tr>
	       <td> <img align="middle;" alt="affiche" name="affiche" src="<?php echo htmlspecialchars($donnees['affiche']);?>"></td>
	       <td> <span style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($donnees['num_film']);?>'"> <?php
	        // On affiche le contenu du billet
	        echo nl2br(htmlspecialchars($donnees['synopsis']));?></span></td>
	        </tr><br /></table>
	      <?php echo "<br><em><b>Durée: </b>"; echo htmlspecialchars($donnees['duree']);
$Num_genre = $donnees['Num_genre'];
	      echo "<span onclick=location.href='Films_genre.php?Num_genre=$Num_genre' style='cursor:pointer;'>";	      
 echo"min<br><b><em>Genre: </b></em>"; echo htmlspecialchars($donnees['Genre']); echo "</span>";
	        $num_real = htmlspecialchars($donnees['Num_real']);
	        $Annee = htmlspecialchars($donnees['Annee']);
	        echo "<em><br> <b>Réalisateur: </b></em>";
	        echo "<span onclick=location.href='Films_real.php?num_real=$num_real' style='cursor:pointer;'>";
	        echo htmlspecialchars($donnees['real']); echo"</span>";
     //if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_films.php?num_film='$donnees['num_film']'> Modifier le film</a></i></span>"; }?>
</em> 
 <br> 
 </b>           
     <br>

   <br></p>
   </div>

<?php
}
 ?>
 <span style="margin-left:40%; color:white;"><b>Page: </b>
 <?php 
 //Comptage du nb de films pour faire les pages
 $sql = "SELECT COUNT(*) as nb_films FROM film WHERE Annee=".$Annee.";";
 $result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
$donnees = mysql_fetch_array($result);
$nb_pages = $donnees[0] / 3; 
if (isset($_GET['page'])) {
$cur_page = (int) htmlspecialchars($_GET['page']);} else {$cur_page = 1;}
for ($i = 1; $i <= ceil($nb_pages); $i++){
echo "<span style='cursor:pointer;"; if ($i == $cur_page){ echo "color:red;";} echo "' onclick=location.href='Films_annee.php?Annee=$Annee&page=$i'>"; echo $i; echo"</span>";//}
}
 ?>
    </span>
<div class="cadre"><img src="<?php
$sql = "SELECT * FROM film WHERE num_film = ".$num_film.";";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
while ($donnees = mysql_fetch_assoc($result))
{

 echo htmlspecialchars($donnees['affiche']);} ?>"></div>
</div>
</body>
</html>