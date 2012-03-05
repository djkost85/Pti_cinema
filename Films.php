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
//require_once '\inc\autoload.inc.php';
require_once '\Classes\Db.php';
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
<script type='text/javascript' src='Script/mediaplayer-5.8/jwplayer.js'></script>

<script type="text/javascript" src="Script/Verification_formulaire.js"></script>
<script type="text/javascript" src="../Pti_Cinema/Script/jquery.color.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
/*$("#formcom").submit(function(){
	$("#loader").show();
	num_film = $(this).find("input[name=num_film]").val();
	Aujourdhui = new Date;
	var clicked;
	var clicked = 1;
        Jour = Aujourdhui.getDate();
        Mois = (Aujourdhui.getMonth())+1;
        Annee = Aujourdhui.getFullYear();
        daate = Jour + "-" + Mois + "-" + Annee
        pseudo = $(this).find("input[name=pseudo]").val();
        commentaire = $(this).find("textarea[name=commentaire]").val();
        $.post("Films_post.php", {num_film: num_film, pseudo: pseudo, commentaire: commentaire}, function(data){
        $("#loader").hide();
                $("#titred").append("<span style='text-decoration:underline; font-weight:bold;'>"+pseudo+"</span>"+" le "+daate+" :"+"<br>").slideDown();
                $("#posted").append(commentaire).slideDown();
                $("h4").fadeOut();
                $("#formcom").fadeOut();
                clicked = 0;
        });*/
	/*else {
            alert("Veuillez cliquer qu'une seule fois svp");}
	return false;*/
	});
});

function suppr(num_film, num_commentaire, num_div){
	$("#loader2").show();
alert('numfilm:'+num_film);
alert('numcomm:'+num_commentaire);
alert('numdiv:'+num_div);
	$.get("Suppr_commentaire.php", {num_film: num_film, num_commentaire: num_commentaire}, function(){
	//alert(div);
	//$('div:nth-child([5 + num_div])').fadeOut();
	$('commentaires:nth-child([2]').remove();
	$("#comm"+num_div).remove();
	alert("Commentaire supprimé");
	$("#loader2").hide();
	});
}
</script>
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

					<!--------- MENU ------------------>
					<?php include("\inc\menu.inc.php"); ?>

<div id="corps" style="display:none;">
<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>
<br>
				<!--------------- CONNEXION ADMIN --------------->
<?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span> <?php } else { ?>
<span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php }?>
<span id="Formulaire"><form method="post" action="Films.php?num_film=<?php if (isset($_GET['num_film'])) {$num_film = $_GET['num_film'];} echo (int) htmlspecialchars($num_film);?>"><br>Login: <input type="text" name="login"><br> 
		Mot de passe: <input type="password" name="mdp" size="4">
		<input type="submit" value="Connexion">
		</form></span>
		<?php
if (isset($_GET['num_film']))
	{
		$num_film = (int) mysql_real_escape_string($_GET['num_film']);
$films = $db->queryArray("SELECT * FROM film LEFT JOIN genre ON genre.code_allocine = film.Num_genre LEFT JOIN realisateur ON realisateur.code_allocine = film.num_real HAVING num_film=".$num_film.";");
if (empty($films)){echo "<span class='films' style='text-align:center; margin-left:325px'><br>Ce film n'existe pas!<br></span>";} 
foreach ($films as $film)
{
?>
						<!----------------------FILMS--------------------------->
	<div class="films">	
	        <h3>
	            <?php echo htmlspecialchars($film->titre); ?> 
	        </h3>
       <p>
	        <?php
	        // On affiche le contenu du billet
	        echo htmlspecialchars($film->synopsis); echo "<br>";
	        $Num_genre = htmlspecialchars($film->Num_genre);
                echo "<span onclick=location.href='Films_genre.php?Num_genre=$film->num_genre' style='cursor:pointer;'>";	      
 		echo"<br><b><em>Genre: </b></em>"; echo htmlspecialchars($film->Genre); echo "</span>";
	        //$num_real = htmlspecialchars($film->Num_real);
	        $Annee = $film->Annee;
	        echo "<em><br> <b>Réalisateur: </b></em>";
	        //echo "<span onclick=location.href='Films_real.php?num_real=$num_real' style='cursor:pointer;'>";
	        echo htmlspecialchars($film->real); echo" ";echo"</span>";
	        echo "<span onclick=location.href='Films_annee.php?Annee=$Annee' style='cursor:pointer;'>";
	        echo "<em><br><b>Année: </b></em>"; echo htmlspecialchars($film->Annee); echo"</span>";  	
	        ?><br>
	        <em><b>Durée:</b></em> <?php echo htmlspecialchars($film->duree); ?>min<br> 
               </p>
       <?php if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) {echo "<span style='float:right;' <i><a href='Modif_films.php?num_film=$num_film;'> Modifier le film</a></i></span>"; }?>
   <br>
   <h3 style="text-align:center;">Bande annonce</h3>
    <div id='video' style='margin-left:100px;'>        
<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='470' height='320' id='single1' name='single1'>
<param name='movie' value='player.swf'>
<param name='allowfullscreen' value='true'>
<param name='allowscriptaccess' value='always'>
<param name='wmode' value='transparent'>
<param name='flashvars' value='file=<?php echo $film->video; ?>'>
<embed
  id='single2'
  name='single2'
  src='player.swf'
  width='470'
  height='320'
  bgcolor='#000000'
  allowscriptaccess='always'
  allowfullscreen='true'
  flashvars='file=<?php echo $film->video; ?>'
/>
</object>
    </div><br>
    <?php
    $num_film = $film->num_film;
    echo "<table border='1'><tr align='center'><th align='center'>Date</th><th align='center'>Heure</th></tr>";
    
						//<--------------------------PROGRAMMATION------------------------------->
	$films = $db->queryArray("SELECT COUNT(DISTINCT num_cin) as nb_cin FROM projection WHERE num_film=".$film->num_film.";");
	foreach ($films as $film) {echo "<span style='text-decoration:underline;font-size:1.1em;'>En projection dans ".$film->nb_cin." cinémas</span> : <br>";}
	$nb_cin = $film->nb_cin;
	$films = $db->queryArray("SELECT DISTINCT * FROM projection INNER JOIN cinema on cinema.num_cin = projection.num_cin WHERE num_film=".$num_film." GROUP BY projection.num_cin;");
	//$projections =$db->queryArray("SELECT * FROM projection INNER JOIN cinema on cinema.num_cin = projection.num_cin WHERE projection.num_cin=".$num_cin.";");
	foreach ($films as $film){
		echo "<a href='Modif_prog.php?num_cin=$film->num_cin'> <h3 style='text-align:left;'>".htmlspecialchars($film->num_cin)." ".htmlspecialchars($film->ville_cin)." (".htmlspecialchars($film->codepos_cin).")</h3></a>";
			echo "<tr><td>".htmlspecialchars($film->date)."</td><td>".htmlspecialchars($film->heure)."</td></tr>";			
				}
   echo"</table>";
    ?>
        <em><br><br>Commentaires:</em><br><br>
	<div id='commentaires'>
					<!----------------------------------- COMMENTAIRES ------------------------------------>
        <?php $num_com = 0;
        $sql = "SELECT num_commentaire, DATE_FORMAT(date_commentaire, '%d-%m-%Y %H:%i') AS date, commentaire_num_film,  pseudo, commentaire FROM commentaire WHERE commentaire_num_film =".$num_film.";";
$result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
while ($donnees = mysql_fetch_array($result))
	{
        
            echo "<div id='comm'".htmlspecialchars($num_com)."'>";
            echo htmlspecialchars($num_com); echo 'comm'.htmlspecialchars($num_com);
            echo "<span style='text-decoration:underline; font-weight:bold; margin-left:10px;'>".$donnees['pseudo']; echo "</span> le "; echo htmlspecialchars($donnees['date']); echo " : ";
            echo "<div id='contenu_comm'></p>"; echo htmlspecialchars($donnees['commentaire']); 
            if((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?><span style='float:right;font-weight:bold;' onclick="suppr(<?php echo htmlspecialchars($num_film);?>,<?php //echo htmlspecialchars($num_commentaire);?>, <?php echo htmlspecialchars($num_com);?>)"> <img src='Images/fermer.png' alt='Supprimer le commentaire' title='Supprimer le commentaire'></span> <?php }
            echo "</p></div>";
            echo "</div>";
        $num_commentaire = $donnees['num_commentaire'];
        $num_com++;
     }
     $date = getdate();

       ?><span id="loader2" style="display:none;"><img src="ajax-loader.gif" alt="loader"></span>         
        <div class="error" style="display:none; background-color:green;"></div>
        <span id="titred" style="display:none;"></span>
   </div>
	</div>
									<!---------------- Résultat AJAX -------------->
	<div id="posted" style="display:none; padding-left:25px;"></div>
	
									<!----------- AJOUT de comm ---------------->
 <span class="films" style="text-align:center; font-weight:bold;"><br><h4>Ajouter un commentaire:</h4>
<form id="formcom" action='Films_post.php' style="margin-left:200px;" method="post">
<table>
        <input type="hidden" name="num_film" value="<?php if(isset($_GET['num_film'])) {echo (int) htmlspecialchars($_GET['num_film']);}?>">
        <tr><td><label for="pseudo">Pseudo :</label> </td> <td><input type="text" name="pseudo" id="pseudo"><br></td></tr>
         <tr><td><label for="commentaire">Commentaire :</label></td>  <td><textarea name="commentaire" rows='2' cols='20' id='commentaire'> </textarea></td>
</table><input type="submit" value="Envoyer" >
    </form>
    <div id="loader" style="display:none;"><img src="ajax-loader.gif" alt="loader"></div>
    </span>
    <!-------------------------------------- CADRE AFFICHE DU FILM ------------------->
<div class="cadre"><img src="<?php
$films = $db->queryArray("SELECT * FROM film WHERE num_film = ".$num_film.";");
foreach ($films as $film){
 echo htmlspecialchars($film->affiche);}?>"></div>
</div>
<?php
}
}
else{echo "<span style='color:white; display:block; text-align:center;'> <br><br>Ce film n'existe pas!</span>";}
 ?>
<?php ?>
<div id="contact" style="text-align:center;"><span style="margin:auto;" onclick="location.href='Contact.php'"><br> Contact </span></div>

</body>

</html>