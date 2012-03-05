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
require_once '\Classes\Db.php';
$db= new Db;
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
<?php include("\inc\header_cin.inc.php"); ?>
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinémas </span></div>

<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
 <?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {?>
  <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='Ajout_cinema.php'"><br>+ Ajouter un cinéma</span>
<span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='admin_cinemas.php'"><br>+ Gérer les cinémas</span><?php }?>

<span id="Formulaire"><form method="post" action="Cinemas.php?num_cin=<?php echo htmlspecialchars($_GET['num_cin']);?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion"></form></span><br><br><br>		
<span class="texte" style="font-style:italic">Cinémas: <br></span>
<?php
$cinemas = $db->queryArray("SELECT * FROM cinema");
echo"    <SELECT name='real' onChange='location=this.options[this.selectedIndex].value'> 
    <OPTION> ";
foreach ($cinemas as $cin)
    {echo "<OPTION value='Cinemas.php?num_cin=$cin->num_cin'>"; echo htmlspecialchars($cin->nom_cin); echo "  "; echo "</OPTION>";} 
  echo "</SELECT>"; 

if (!empty($_GET['num_cin'])) {$num_cin = (int) mysql_real_escape_string($_GET['num_cin']);
$cinemas = $db->queryArray("SELECT * FROM cinema WHERE num_cin=".$num_cin.";");
foreach ($cinemas as $cin)
{ ?>
	<div class="films">
<p><h3><?php echo htmlspecialchars($cin->nom_cin); ?> 
	        </h3><br>
	        <em><b>Nom: </b><?php echo htmlspecialchars($cin->nom_cin); ?><br></em>
	        <em><b>Adresse: </b><?php echo htmlspecialchars($cin->adresse_cin); ?><br></em> 
	        <em><b>Code Postal: </b><?php echo htmlspecialchars($cin->codepos_cin); ?><br></em>
	        <em><b>Ville: </b><?php echo htmlspecialchars($cin->ville_cin); ?><br></em>
<?php echo "<span style='float:right;' <i><a href='Modif_prog.php?num_cin=$num_cin'> Programmation</a></i></span>"; ?>
               <br>
       <?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_cin.php?num_cin=$num_cin'> Modifier le cinéma</a></i></span>"; }?>
   <br>
   <?php }
   } else {echo "<h3>Cinéma introuvable</h3>";}
   ?>
   </div>
		<div class="cadre"><?php
		  $a = 1; // nombre d'éléments à extraire aléatoirement
		$films = $db->queryArray("SELECT * FROM film ORDER BY rand() LIMIT $a");
	    foreach ($films as $film) {?>
	    <a href="Films.php?num_film=<?php echo htmlspecialchars($film->num_film);?>"><img src="<?php echo htmlspecialchars($film->affiche);?>"></a>
	    <?php }?>
</div>	
</div>
</body>
</html>