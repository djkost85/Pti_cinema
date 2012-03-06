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
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinémas </span></div>

<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
 <?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {?>
  <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='Ajout_cinema.php'"><br>+ Ajouter un cinéma</span> <?php }?>


<span id="Formulaire"><form method="post" action="Cinemas.php?num_cin=<?php echo $_GET['num_cin'];?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span><br><br><br>		
		<span class="texte" style="font-style:italic">Cinémas: <br></span>
		
				<?php
                                if (!isset($_GET['num_cin'])){
                                    echo '<h3>Cin&eacute;ma non trouv&eacute;</h3>'; die();
                                }
		$connexion = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('Films',$connexion);
/********** Liste déroulante des cinémas ******/
$sql = "SELECT * FROM cinema";
		$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
echo"    <SELECT name='real' onChange='location=this.options[this.selectedIndex].value'> 
    <OPTION> ";
   while($donnees = mysql_fetch_array($result))
    {echo "<OPTION value='Modif_prog.php?num_cin=$donnees[0]'>"; echo htmlspecialchars($donnees[2]); echo "  "; echo "</OPTION>";} 
  echo "</SELECT>"; 
       ?>
		<?php
		$connexion = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('Films',$connexion);
$num_cin = (int) mysql_real_escape_string($_GET['num_cin']);

$sql = "SELECT * FROM projection INNER JOIN cinema ON cinema.num_cin = projection.num_cin WHERE projection.num_cin=".$num_cin." LIMIT 1;";
		$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
while ($donnees = mysql_fetch_assoc($result))
{
?>
	<div class="films">
   			<p>
	        <h3>
	            <?php echo htmlspecialchars($donnees['nom_cin']); ?> 
	        </h3><br>
	        <em><b>Nom: </b><?php echo htmlspecialchars($donnees['nom_cin']); ?><br></em>
	        <em><b>Adresse: </b><?php echo htmlspecialchars($donnees['adresse_cin']); ?><br></em> 
	        <em><b>Code Postal: </b><?php echo htmlspecialchars($donnees['codepos_cin']); ?><br></em>
	        <em><b>Ville: </b><?php echo htmlspecialchars($donnees['ville_cin']); ?><br></em>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_prog.php?num_cin=$num_cin;'> Programmation</a></i></span>"; }?>

               <br>
   <br>
   <?php }

   $sql = "SELECT * FROM projection INNER JOIN cinema ON cinema.num_cin = projection.num_cin INNER JOIN film ON film.num_film = projection.num_film WHERE projection.num_cin=".$num_cin.";";
		$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
		if (mysql_num_rows($result) > 0){
		 echo "<table><tr><th>Date</th><th>Heure</th><th>Titre</th><tr>";
while ($donnees = mysql_fetch_assoc($result))
{
?>
		<?php 
		 echo "<tr><td>".htmlspecialchars($donnees['date'])."</td><td> ".htmlspecialchars($donnees['heure'])."</td>"; echo "<td> ".htmlspecialchars($donnees['titre'])."</td></tr>.";?>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_prog.php?num_cin=$num_cin'> Programmation</a></i></span>"; }?>

               <br>
   <br>
   <?php } } else { echo "<span class='liens' style='cursor:none;'>Aucune programmation</span>";}
		echo "</table>";
   
   ?>
   </div>


</div>
</div>
</body>
</html>