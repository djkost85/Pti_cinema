<?php
session_start();
require_once '\inc\conf.inc.php';
require_once '\Classes\Db.php';
$db=new Db;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Base de données de films</title>
<meta name="description" content="Sorties Cinema" >
<meta name="keywords" content="Sorties, cinema, films, affiche" >
<link href="../Pti_Cinema/Css/default.css" rel="stylesheet" type="text/css">
<script src="../Pti_Cinema/Script/jquery.js"></script>
<script type="text/javascript" src="Script/Verification_formulaire.js"></script>
<script type="text/javascript" src="../Pti_Cinema/Script/jquery.color.js"></script>
<script type="text/javascript"> 
    $('#corps').ready(function(){
           $('#corps').fadeIn(2000);
   });
</script>
<script src="Script/script.js"></script>
</head>
<body>						<!--------------- HEADER ---------------->
<?php include("\inc\header.inc.php"); ?>
						<!-------- MENU ---------->
<?php include("\inc\menu.inc.php"); ?>
					    <!----- CONNEXION ADMIN ------>
<div id="corps" style="display:none;">
<?php if ((isset($_SESSION['login']) AND isset ($_SESSION['mdp']) AND (($_SESSION['login'] == 'admin') AND $_SESSION['mdp'] == 'admin'))) { ?> 
    <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo htmlspecialchars($_SESSION['login']);?>]</span> 
        <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
<?php if ((!empty($_SESSION['login']))) {?>
<a href="Deconnexion.php">Déconnexion<img alt="Déconnexion" align="bottom" src="Images/fermer.png"></a>
<?php }
   if ((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin'))
   { ?>    
  <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='Log.php'"><br>+ Ajouter un film</span>
  <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';" onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='admin_films.php'"><br>+ Gérer les films</span>
<?php } ?>
<span id="Formulaire"><form method="post" action="log.php" onsubmit="return verifForm(this)"><br>Login: <input type="text" name="login"><br> Mot de passe: <input type="password" name="mdp" size="4">
    <input type="submit" value="Connexion">
    </form></span>
<br><br><span class="texte" style="font-style:italic">Rechercher un film: </span>
    
<?php										// COMBO de films
	$films = $db->queryArray("SELECT * FROM film ORDER BY num_film DESC;");
    echo "<FORM> 
  <SELECT onChange='location=this.options[this.selectedIndex].value' style='width:250px;'> 
    <OPTION> "; foreach ($films as $film){
    echo "<OPTION value='Films.php?num_film=$film->num_film'>"; echo htmlspecialchars($film->titre); echo " ("; echo htmlspecialchars($film->Annee); echo ")</OPTION>";}
  echo "</SELECT>"; echo "</FORM>"; 
?>
<p class="texte" style="font-style:italic;">Les 3 derniers films ajoutés:</p>
		<?php
						// AFFICHAGE DES TROIS DERNIERS FILMS
    $films = $db->queryArray("SELECT *, genre.Num_genre FROM film LEFT JOIN genre ON genre.Num_genre = film.Num_genre ORDER BY num_film DESC LIMIT 0,3;");
    foreach ($films as $film)
    {
    ?>
  	<div class="films" style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($film->num_film);?>'">
<p><h3 style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php //echo htmlspecialchars($donnees['num_film']);?>'">
	            <?php echo htmlspecialchars($film->titre); ?> </h3>
<table><tr><td> <img align="middle;" alt="affiche" name="affiche" src="<?php echo htmlspecialchars($film->affiche);?>"></td>
<td> <?php // Contenu du film
echo nl2br(htmlspecialchars($film->synopsis));?></td></tr><br /></table>
     <em>Durée: <?php echo htmlspecialchars($film->duree); ?>min</em> <br>
        <em><a href="Films.php?num_film=<?php echo htmlspecialchars($film->num_film);?>">Commentaires</a></em><br><br></p>
   </div>
        <?php
    } // FIN DE LA BOUCLE DES FILMS
        ?>
				    <!----------- // CADRE DU FILM ALEATOIRE --------->
<p id="pdf" onmouseover="javascript:document.getElementById('pdf').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('pdf').style.textShadow='none';">Film aléatoire: </p>
		<div class="cadre"><?php
		  $a = 1; // nombre d'éléments à extraire aléatoirement
		$films = $db->queryArray("SELECT * FROM film ORDER BY rand() LIMIT $a");
	    foreach ($films as $film) {?>
	    <a href="Films.php?num_film=<?php echo htmlspecialchars($film->num_film);?>"><img src="<?php echo htmlspecialchars($film->affiche);?>"></a>
	    <?php }?>
</div>	

<div class="fb"><iframe src="https://www.facebook.com/plugins/like.php?href=florianlopes.eu"
        scrolling="no" frameborder="0"
        style="border:none; width:200px; height:60px"></iframe><span id="plus" style="float:right; margin-bottom:8px; margin-right:8px;" onclick="location.href='http://florianlopes.eu'"> Florian Lopes </span>	</div>
</div>
<div id="contact" style="text-align:center;"><span style="margin:auto;" onclick="location.href='Contact.php'"><br> Contact </span></div>
</body>
</html>
