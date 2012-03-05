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
<body>
		    <!--------------- HEADER ---------------->
<?php include("\inc\header_cin.inc.php"); ?>
						<!-------- MENU ---------->
<?php include("\inc\menu.inc.php"); ?>
					    <!----- CONNEXION ADMIN ------>

<div id="corps" style="display:none;">
<?php if ((isset($_SESSION['login']) AND isset ($_SESSION['mdp']) AND (($_SESSION['login'] == 'admin') AND $_SESSION['mdp'] == 'admin'))) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo htmlspecialchars($_SESSION['login']);?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>

<span id="Formulaire"><form method="post" action="admin_films.php" onsubmit="return verifForm(this)"><br>Login: <input type="text" name="login"><br> Mot de passe: <input type="password" name="mdp" size="4">
    <input type="submit" value="Connexion">
    </form></span>
    	    <?php
		if (empty($_SESSION['login']) OR ($_SESSION['login']) != 'admin')
		{
		    echo "<br><p><span style='color:white;'>Vous n'avez pas accès à cette page!</span></p><br>";
		    ?>
</div>	

<div class="fb"><iframe src="https://www.facebook.com/plugins/like.php?href=florianlopes.eu"
        scrolling="no" frameborder="0"
        style="border:none; width:200px; height:60px"></iframe><span id="plus" style="float:right; margin-bottom:8px; margin-right:8px;" onclick="location.href='http://florianlopes.eu'"> Florian Lopes </span>	</div>
</div>
<div id="contact" style="text-align:center;"><span style="margin:auto;" onclick="location.href='Contact.php'"><br> Contact </span></div>

</body>
</html>
<?php }else{
		// AFFICHAGE DE TOUS LES CINEMAS
    $cins = $db->queryArray("SELECT * FROM cinema ORDER BY num_cin DESC;");
        $count = $db->querySingle("SELECT COUNT(*) AS nb FROM cinema;");
    echo "<h3>Il y a $count->nb cinémas dans la base de données </h3>";
    foreach ($cins as $cin)
    {
    ?>
  	<div class="films" style="cursor:pointer;" onclick="location.href='Films.php?num_cin=<?php echo htmlspecialchars($cin->num_cin);?>'">
	<h3 style="cursor:pointer;" onclick="location.href='Cinemas.php?num_cin=<?php echo htmlspecialchars($cin->num_cin);?>'"><?php echo htmlspecialchars($cin->nom_cin); ?> </h3>
<table><tr><td><?php if(!empty($_SESSION['login'])){
    $num_cin = $cin->num_cin;
if($_SESSION['login'] == 'admin'){ echo "<a href='Suppr_cin.php?num_cin=$num_cin&ret=admin_cins'>Supprimer le cinéma</a>";}
				    } ?></td></tr></table>
   </div><?php  }?>
				    <!----------- // CADRE DU FILM ALEATOIRE --------->
<p id="pdf" onmouseover="javascript:document.getElementById('pdf').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('pdf').style.textShadow='none';">Film aleatoire: </p>
		<div class="cadre"><?php
		  $a = 1; // nombre d'éléments à extraire aléatoirement
		$films = $db->queryArray("SELECT * FROM film ORDER BY rand() LIMIT $a");
	    foreach ($films as $film) {?>
	    <a href="Films.php?num_film=<?php echo htmlspecialchars($film->num_film);?>"><img src="<?php echo htmlspecialchars($film->affiche);?>"></a>
	    <?php }
    ?></div>	

<div class="fb"><iframe src="https://www.facebook.com/plugins/like.php?href=florianlopes.eu"
        scrolling="no" frameborder="0"
        style="border:none; width:200px; height:60px"></iframe><span id="plus" style="float:right; margin-bottom:8px; margin-right:8px;" onclick="location.href='http://florianlopes.eu'"> Florian Lopes </span>	</div>
</div>
<div id="contact" style="text-align:center;"><span style="margin:auto;" onclick="location.href='Contact.php'"><br> Contact </span></div>

</body>
</html><?php } ?>
