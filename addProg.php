<?php
session_start();

if (isset($_POST['login']) AND isset($_POST['mdp'])) {
    if (($_POST['login'] == 'admin') AND ($_POST['mdp'] == 'admin')) {
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
<?php if ((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login']; ?>]</span> <?php } else { ?>
                <span class="liens" style="font-style:italic;font-weight:bolder;" onclick="javascript:document.getElementById('Formulaire').style.display='block'; $('#Formulaire').fadeIn(2000)">Connexion admin</span> <?php } ?>
            <?php if ((isset($_SESSION['login'])) AND ($_SESSION['login'] == 'admin')) { ?>
                <span id="plus" style="text-align:left;" onmouseover="javascript:document.getElementById('plus').style.textShadow='#fff 0px 0px 5px';"
                      onmouseout="javascript:document.getElementById('plus').style.textShadow='none';" onclick="location.href='Ajout_cinema.php'"><br>+ Ajouter un cinéma</span> <?php } ?>


            <span id="Formulaire"><form method="post" action="Cinemas.php?num_cin=<?php echo $_GET['num_cin']; ?>"><br>Login: <input type="text" name="login"><br> 
                    Mot de passe: <input type="password" name="mdp" size="4">
                    <input type="submit" value="Connexion">
                </form></span><br><br><br>		
            <span class="texte" style="font-style:italic">Cinémas: <br></span>

<?php


$connexion = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('Films', $connexion);
/********** Liste déroulante des cinémas ******/
$sql = "SELECT * FROM cinema";
$result = mysql_query($sql) or die('Erreur SQL !' . $sql . '<br />' . mysql_error());
echo"<SELECT name='real' onChange='location=this.options[this.selectedIndex].value'> 
    <OPTION> ";
while ($donnees = mysql_fetch_array($result)) {
    echo "<OPTION value='addProg.php?num_cin=$donnees[0]'>";
    echo htmlspecialchars($donnees[2]);
    echo "  ";
    echo "</OPTION>";
}
echo "</SELECT><br/>";
if (!isset($_GET['num_cin'])) {
    echo '<h3>Cin&eacute;ma non trouv&eacute;</h3>';
    die();
}
if (isset($_POST['date']) && isset($_POST['heure']) && isset($_POST['num_film'])){
    $date = mysql_real_escape_string($_POST['date']);
    $heure = mysql_real_escape_string($_POST['heure']);
    $num_film = mysql_real_escape_string($_POST['num_film']);
    $num_cin = mysql_real_escape_string($_POST['num_cin']);
    $sql = "INSERT INTO projection VALUES(NULL, ".$num_cin.", ".$num_film.", ".$date.", ".$heure.");";
    
    mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
}
?>
            <?php 
                        $sql = "SELECT * FROM film";
            $result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); print_r($_POST);?>

            <br/>
           
        <form method="POST" action="addProg.php?num_cin=<?php echo $_GET['num_cin'];?>" style="margin-left:30px;">
            <input type="hidden" name="num_cin" value="<?php echo $_GET['num_cin'];?>">
            <label class="liens" style="margin-right:15px;">Film</label><select id="code_genre" name='num_film'><option></option>
            <?php while($donnees = mysql_fetch_assoc($result)){
                echo "<OPTION id='num_film' value=".$donnees['num_film'].">"; echo htmlspecialchars($donnees['titre']); echo "</OPTION>";
            }?></select><br/>
            <label class="liens" style="margin-right:15px;">Date</label><input type="text" name="date"><br/>
            <label class="liens" style="margin-right:7px;">Heure</label><input type="text" name="heure"><br/>
            <input style="margin-left:100px; margin-top:8px;" type="submit" value="Ajouter">
        </form>
            
        </div>


    </div>
</div>
</body>
</html>