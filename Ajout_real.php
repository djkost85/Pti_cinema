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
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films  </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'">| Les réalisateurs </span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'">| Les cinémas </span></div>

<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
<span id="Formulaire"><form method="post" action="Films.php?num_film=<?php echo (int) htmlspecialchars($_GET['num_film']);?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span><br><br>	
<span class="liens"><?php
if ((isset($_POST['Realisateur']) && isset($_POST['code_allocine'])))
{
	if ((!isset($_POST['Realisateur'])) OR (!isset($_POST['code_allocine'])) OR (!isset($_POST['photo'])))
		{
                    echo "<span class='liens'> Veuillez remplir tous les champs </span>";
                }
	else{
                $real = mysql_real_escape_string($_POST['Realisateur']); $photo_real = mysql_real_escape_string($_POST['photo']);
                $code_allocine = mysql_real_escape_string($_POST['code_allocine']);
                Require_once 'Connexion.php';
                $sql = 'INSERT INTO realisateur VALUES(NULL, "'.$real.'", "'.$photo_real.'", "'.$code_allocine.'");';
                $result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
                if ($result) { 
                     echo "<span class='liens'> <br>Le réalisateur a bien été ajouté! <br> </span> ";
                     }
        }
}
 ?>

<form method="post" action="Ajout_real.php"><h3 style="margin-top:2px;"> Ajouter un réalisateur</h3>
    <?php
    if (isset($_GET['real']) && isset($_GET['code_allocine'])){
        $real = htmlspecialchars($_GET['real']) ;
        $code_allocine = htmlspecialchars($_GET['code_allocine']);
    }
    else{
        $real = 'Réalisateur';
    }
            ?>
    <table style="margin-left:30%;">
        <tr><td>Code allociné:</td> <td><input id="code_allocine" type="text" name="code_allocine" value="<?php if (isset($_GET['code_allocine'])) echo $code_allocine; ?>"></td></tr>
        <tr><td>Réalisateur:</td> <td><input id="nom" type="text" name="Realisateur" value="<?php if (isset($_GET['real'])) echo $real; ?>"></td></tr>
        <tr><td>Photo:</td> <td><input id="photo" type="text" name="photo" value=""></td></tr> 
    </table><br><br>

<input type='submit' value='Ajouter'>
</form>
</span>
    

   </div>

</body>
</html>