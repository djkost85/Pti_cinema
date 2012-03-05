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
<div id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
<span id="c" onclick="location.href='Index.php'" style="cursor:pointer;" >Films à </span><span class="v" onclick="location.href='Index.php'" style="cursor:pointer;">l'affiche</span>
</div>
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinemas </span></div>

<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
<span id="Formulaire"><form method="post" action="Films.php?num_film=<?php echo htmlspecialchars($_GET['num_film']);?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span><br><br>	
<span class="liens"><?php
if ((isset($_REQUEST['nom']) && isset($_REQUEST['adresse']) && isset($_REQUEST['ville']) && isset($_REQUEST['codepos'])))
{
	if ((!isset($_REQUEST['nom'])) OR (!isset($_REQUEST['adresse'])) OR (!isset($_REQUEST['ville'])) OR (!isset($_REQUEST['codepos'])))
		{echo "<span class='liens'> Veuillez remplir tous les champs </span>";}
	else{
$ville = mysql_real_escape_string($_POST['ville']); $nom = mysql_real_escape_string($_POST['nom']); $adresse = mysql_real_escape_string($_POST['adresse']); $codepos = mysql_real_escape_string($_POST['codepos']);
Require_once 'Connexion.php';
$sql = 'INSERT INTO cinema(Num_cin, nom_cin, adresse_cin, codepos_cin, ville_cin) VALUES(NULL, "'.$nom.'", "'.$adresse.'", "'.$codepos.'", "'.$ville.'");';
$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
if ($result) { 
echo "<span class='liens'> <br>Le cinéma a bien été ajouté! <br> </span> ";}
}}
 ?>

<form method="post" action="Ajout_cinema.php"><h3 style="margin-top:2px;"> Ajouter un cinéma</h3>
<table style="margin-left:30%;"><tr><td>Nom:</td> <td><input type="text" name="nom"></td></tr> <tr><td>Adresse:</td> <td><input type="text" name="adresse"></td></tr><br><br>
<tr><td>Code Postal: </td> <td><input type="text" name="codepos"></td></tr> <tr><td>Ville: </td> <td><input type="text" name="ville"></td></tr>

 </table>

		<input type='submit' value='Ajouter'>
		</form>
		</span>
    

   </div>

</body>
</html>