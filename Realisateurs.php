<?php
session_start();

if (isset ($_POST['login']) AND isset ($_POST['mdp']))
{
    if(($_POST['login'] == 'admin') AND ($_POST['mdp'] == 'admin'))
    {
       $_SESSION['login'] = $_POST['login'];
        $_SESSION['mdp'] = $_POST['mdp'];
    }
}require_once '\Classes\Db.php';
$db = new Db;?>

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
<body>						<!------------- HEADER ---------------->
<?php include("\inc\header.inc.php"); ?>		<!------------------- MENU ------------->
<?php include("\inc\menu.inc.php"); ?>
<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br> 					<!------------ CONNEXION ----------->
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
 <?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {?>
 <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='Ajout_real.php'"><br>+ Ajouter un réalisateur</span>
 <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='admin_reals.php'"><br>+ Gérer les réalisateurs</span><?php }?>

<span id="Formulaire"><form method="post" action="Realisateurs.php?num_real=<?php if(isset($_GET['num_real'])){ echo (int) $_GET['num_real'];}?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		<input type="hidden" value="<?php if(!empty($_GET['num_real'])) { echo (int) $_GET['num_real'];}?>">
		</form></span><br><br><br>		
		<span class="texte" style="font-style:italic">Réalisateurs: <br></span>
				<?php
Require_once 'Connexion.php';
$sql = "SELECT * FROM realisateur";
		$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
    $donnees = mysql_fetch_array($result);	
echo"<SELECT name='real' onChange='location=this.options[this.selectedIndex].value'> 
    <OPTION> ";
if (empty($donnees[0])){echo "<span class='films' style='text-align:center; margin-left:325px'><br>Ce réalisateur n'existe pas!<br></span>";} 

   while($donnees = mysql_fetch_array($result))
    {echo "<OPTION value='Realisateurs.php?num_real=$donnees[0]'>"; echo htmlspecialchars($donnees[1]); echo "</OPTION>";} 
  echo "</SELECT>"; 

if (!empty($_GET['Num_real'])){$num_real = (int) mysql_real_escape_string($_GET['Num_real']);}
if (!empty($_GET['num_real'])){$num_real = (int) mysql_real_escape_string($_GET['num_real']); 

$realisateurs = $db->queryArray("SELECT * FROM realisateur WHERE Num_real=".$num_real.";");
foreach ($realisateurs as $real)
{ ?>
	<div class="films">
<p><h3><?php echo htmlspecialchars($real->real); ?> </h3>

	        <?php  echo "<br></em>";
 if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_reals.php?Num_real=$real->Num_real;'> Modifier le réalisateur</a></i></span>"; }
 } ?>
   <h4>Filmographie : </h4>
   <?php
   $proj_films = $db->queryArray("SELECT * FROM film WHERE Num_real=".$num_real.";");
foreach ($proj_films as $proj)
{ ?>
   <!--<span onclick="location.href="."'Films.php?num_film=".<?php echo htmlspecialchars($donnees[0]);?>."'"> <?php echo htmlspecialchars($donnees['titre']);?></span> -->
   <b><li><a style="text-decoration:none; color:white;" href="Films.php?num_film=<?php echo htmlspecialchars($proj->num_film);?>"> <?php echo htmlspecialchars($proj->titre);?></a></b><br>
<?php }
}
else { $num_real = 0; echo "<h4 style='color:white;'>Sélectionnez un réalisateur dans la liste déroulante</h4>"; }
 ?>  
   </div>
		<div class="cadre"><?php
		
		  $a = 1; // nombre d'éléments à extraire aléatoirement
		$reals = $db->queryArray("SELECT * FROM realisateur WHERE Num_real = $num_real");
	    foreach ($reals as $real) {?><img src="<?php echo htmlspecialchars($real->photo);?>">
	    <?php }?>
</div>	
</body>
</html>