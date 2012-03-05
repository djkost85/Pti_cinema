<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Base de données de films</title>
<meta name="description" content="Sorties Cinema" >
<meta name="keywords" content="Sorties, cinema, films, affiche" >
<link href="../Pti_Cinema/Css/default_admin.css" rel="stylesheet" type="text/css">
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
<span id="c" >Mode </span><span class="v">administrateur</span>
</div>
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinémas </span></div>

<div id="corps" style="display:none;">
<span class="text">
<?php
session_start();
Require_once 'Connexion.php';
include 'inc/fonctions.php';
if (!empty($_POST)){
    $post = $_POST;
    if (!saveData($post)){
        echo "<span class='liens' style='cursor:pointer;' onclick=location.href='log.php'>Retour</span>";
    }
    print_r($post);
}

if ((empty($_POST['titre_f'])) OR (empty($_POST['duree'])) OR (empty($_POST['synopsis'])) OR (empty($_POST['genre'])) OR (empty($_POST['annee'])))
{
    echo "<br><h4 class='liens'>Veuillez remplir tous les champs!</h4><br>";
    //print_r($_POST);
}
else
{
$titre = mysql_real_escape_string($_POST['titre_f']);
$duree = (int)  mysql_real_escape_string($_POST['duree']);
$synopsis = mysql_real_escape_string($_POST['synopsis']);
$affiche = mysql_real_escape_string($_POST['affiche']);
$num_genre = mysql_real_escape_string($_POST['genre']);
$real = (int) mysql_real_escape_string($_POST['realisateur']);
$annee = mysql_real_escape_string($_POST['annee']);
$video = str_replace("'", "\"", mysql_real_escape_string($_POST['video']));


$sql = 'INSERT INTO film(num_film, titre, duree, synopsis, affiche, video, Num_genre, num_real, annee) VALUES(NULL, "'.$titre.'", "'.$duree.'", "'.$synopsis.'", "'.$affiche.'", "'.$video.'", "'.$num_genre.'", "'.$real.'", "'.$annee.'")'; 
 
            mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
      $dernier_film = mysql_insert_id();
      $result = mysql_query("SELECT * FROM film WHERE num_film = ".$dernier_film.";");
      while ($row = mysql_fetch_assoc($result)) 
      {
      echo "<br>Titre: <br> ";
   echo htmlspecialchars($row["titre"]);
	}
	
      mysql_close();
      unset($_SESSION['form']);
      echo "<span class='retour' > <br><h4>Le film suivant a bien été ajouté! </h4><br> ";
?>
</span>
</span>
<span style="cursor:pointer;" onclick="location.href='Films.php?num_film=<?php echo htmlspecialchars($dernier_film);?>'"><br>Retour</span>
<span class="liens" style="font-weight:bolder;font-style:italic;">ADMINISTRATEUR
<p id="pdf" onmouseover="javascript:document.getElementById('pdf').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('pdf').style.textShadow='none';">Film aleatoire: </p>
<div class="cadre"><img src="<?php
$films = $db->queryArray("SELECT * FROM film WHERE num_film = ".$dernier_film.";");
foreach ($films as $film){
 echo htmlspecialchars($film->affiche);}?> "></div>
</div>
<?php } ?>
</div>
</div>
</body>
</html>
