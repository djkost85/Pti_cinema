<?php
session_start();

if (isset ($_POST['login']) AND isset ($_POST['mdp']))
{
    if(($_POST['login'] == 'admin') AND ($_POST['mdp'] == 'admin'))
    {
       $_SESSION['login'] = htmlspecialchars($_POST['login']);
        $_SESSION['mdp'] = htmlspecialchars($_POST['mdp']);
    }
} require_once '\Classes\Db.php';
$db = new Db;
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
<body>					<!--------------- HEADER ------------------>
<?php include("\inc\header.inc.php"); ?>
								<!----------- MENU --------->
<?php include("\inc\menu.inc.php"); ?>
<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
						      <!--------------- CONNEXION ----------------->
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo htmlspecialchars($_SESSION['login']);?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
<span id="Formulaire"><form method="post" action="Films.php?num_film=<?php echo htmlspecialchars($_GET['num_film']);?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span>

<?php Require_once 'Connexion.php';
$sql = "SELECT * FROM genre ORDER BY genre ASC";
		$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
    $donnees = mysql_fetch_array($result);
echo "<br><br><SELECT name='Num_genre' onChange='location=this.options[this.selectedIndex].value'> 
    <OPTION> ";
if (empty($donnees[0])){echo "<span class='films' style='text-align:center; margin-left:325px'><br>Ce genre n'existe pas!<br></span>";} 

   while($donnees = mysql_fetch_assoc($result))
    {?><OPTION value="Films_genre.php?Num_genre=<?php echo htmlspecialchars($donnees['Num_genre'])?>"> <?php echo htmlspecialchars($donnees['Num_genre']); echo "  "; echo htmlspecialchars($donnees['Genre']); echo "</OPTION>";} 
  echo "</SELECT>";?>
<?php
$connexion = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('Films',$connexion);
if (isset($_GET['page'])){$page = (int) mysql_real_escape_string($_GET['page']); $limit = ($page - 1) * 3;
} else {$limit = 0; }
if (!empty($_GET['Num_genre'])) {$Num_genre = (int) mysql_real_escape_string($_GET['Num_genre']); $num_film = ''; 
$sql = "SELECT *, genre.genre, realisateur.nom_real FROM film LEFT JOIN genre ON genre.Num_genre = film.Num_genre LEFT JOIN realisateur ON realisateur.Num_real = film.Num_real HAVING film.Num_genre=".$Num_genre." LIMIT ".$limit.",3;";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
Echo "<h3>Genre: "; 
$donnees = mysql_fetch_array($result); echo $donnees['Genre']; 
echo "</h3><br>";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 

while ($donnees = mysql_fetch_assoc($result))
{
?>
<div class="films">
<p><h3 style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($donnees['num_film']);?>'">
<?php echo htmlspecialchars($donnees['titre']); ?> </h3>
 		<table><tr> <td> <img align="middle;" alt="affiche" name="affiche" src="<?php echo htmlspecialchars($donnees['affiche']);?>"></td>
	       <td> <span style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($donnees['num_film']);?>'"> <?php
	       // Affichage du film
	        echo nl2br(htmlspecialchars($donnees['resume']));?></span></td></tr><br /></table>
	      <?php echo "<br><em><b>Durée: </b>"; echo htmlspecialchars($donnees['duree']);  echo"min";
	        $num_real = (int) htmlspecialchars($donnees['Num_real']);
	        $Annee = htmlspecialchars($donnees['Annee']);
	         echo "<span onclick=location.href='Films_annee.php?Annee=$Annee' style='cursor:pointer;'>";
	        echo "<em><br><b>Année: </b></em>"; echo htmlspecialchars($donnees['Annee']); echo"</span>";
	       echo "<em><br> <b>Réalisateur: </b></em>";
	        echo "<span onclick=location.href='Films_real.php?num_real=$num_real' style='cursor:pointer;'>";
	        echo htmlspecialchars($donnees['nom_real']); echo" "; echo htmlspecialchars($donnees['prenom_real']); echo"</span>";
     //if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_films.php?num_film='$donnees['num_film']'> Modifier le film</a></i></span>"; }?>
</em> <br></b><br><br></p>
   </div>
<?php }
}
else {$Num_genre = 0; echo "<h3>Genre inconnu</h3>";}
 ?>
 <span style="margin-left:40%; color:white;"><b>Page: </b>
 <?php 
 //Comptage du nb de films pour faire les pages
 $sql = "SELECT COUNT(*) as nb_films FROM film WHERE Num_genre=".$Num_genre.";";
 $result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
$donnees = mysql_fetch_array($result);
$nb_pages = $donnees[0] / 3; 
if (isset($_GET['page'])) {
$cur_page = $_GET['page'];} else {$cur_page = 1;}
for ($i = 1; $i <= ceil($nb_pages); $i++){
echo "<span style='cursor:pointer;"; if ($i == $cur_page){ echo "color:red;";} echo "' onclick=location.href='Films_genre.php?Num_genre=$Num_genre&page=$i'>"; echo $i; echo"</span>";//}
}
 ?>
    </span>
</div>
</body>
</html>