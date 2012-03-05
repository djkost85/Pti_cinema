<?php
session_start();
if (isset ($_POST['login']) AND isset ($_POST['mdp']))
{
    if(($_POST['login'] == 'admin') AND ($_POST['mdp'] == 'admin'))
    {
       $_SESSION['login'] = $_POST['login'];
        $_SESSION['mdp'] = $_POST['mdp'];
        header('Location: \Pti_Cinema\index.php');
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>Base de données de films</title>
        <meta name="description" content="Sorties Cinéma" >
        <meta name="keywords" content="Sorties, cinema, films, affiche" >
        <link href="../Pti_Cinema/Css/default_admin.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../Pti_Cinema/Script/jquery.color.js"></script>
        <script type='text/javascript' src='jquery.autocomplete.js'></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="Script/jquery-autocomplete/jquery.autocomplete.js"></script>
        <script>
            $('#corps').ready(function(){
                $('#corps').fadeIn(2000);
            //autocompletion film
                $("#film_titre").autocomplete("ajax.php?action=autoCompFilm", {
                    minLength: 3,
                    focus: function(event, ui) {if(ui.item) this.value = ui.item.value.split('<strong>').join('').split('</strong>').join('');return false;},
                    select: function(event, ui) {if(ui.item) this.value = ui.item.value.split('<strong>').join('').split('</strong>').join('');return false;}
                });
                function search(){
                    if ($("#titre_f").val().length > 3){
                        alert('oj');
                        $.ajax({
                            type: "POST",
                            url: "ajax.php",
                            data: 'search='+$(this).val()+'&action="getFilmsInfos"',
                            success: function(data){
                                var film = jQuery.parseJSON(data);
                                //form = "#realisateur[value="+film['realisateur'];
                                //$(form).attr("selected", "selected");
                                for (i in film){
                                    div = '#'+i;
                                    $(div).val(film[i]);
                                }
                            }
                        });
                    }
            }
        });

        </script>
        <script type="text/javascript">
        function post(){
            var real = document.getElementById('realisateur').value;
            var code_real = document.getElementById('code_real').value;
            document.ajout_film.action = 'Ajout_real.php?real='+real+'&code_allocine='+code_real;
            document.ajout_film.submit();
        }

        function search(){
            if ($("#titre_f").val().length > 3){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: "search="+$('#titre_f').val(),
                    success: function(data){
                        var film = jQuery.parseJSON(data);
                        //form = "#realisateur[value="+film['realisateur'];
                        //$(form).attr("selected", "selected");
                        for (i in film){
                            div = '#'+i;
                            $(div).val(film[i]);
                        }
                        document.getElementById('code_genre').value = film.code_genre;
                        alert(film.code_genre);
                        alert(film.realisateur);
                        document.getElementById('code_real').value = film.code_real;
                    }
                });
            }
        }
        </script>
        </head>
    <body>
        <?php
        include 'inc/fonctions.php';
        if (isset($_SESSION['form'])){
            $v = recupData();
            //print_r($v);
        }
        if((isset($_SESSION['login']) AND isset ($_SESSION['mdp']) AND (($_SESSION['login'] == 'admin') AND $_SESSION['mdp'] == 'admin')))
        { // Si le mot de passe est bon
        ?>
        <div id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
        onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
            <span id="c">Mode </span><span class="v">administrateur</span>
        </div>
        <div id="corps" style="display:none;">
            <span class="liens" style="font-weight:bolder;font-style:italic;">ADMINISTRATEUR<br></span>
            <span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span><br>

        <div id="cadre2" style="margin-left:150px;">
            <span class="liens"><br>
                    <h3 style="text-align:center; margin-top:2px;"> Ajouter un film</h3>

        <form name="ajout_film" method="post" action="Ajout.php">
            <table>

                <tr><td>Titre: </td><td><?php echo "<input type='text' id='titre_f'"; if(isset($v)){ echo "value='".$v['titre_f']."'"; } echo "name='titre_f'>";?> <span id="click" onclick="search();">Rechercher</span></td></tr>
                <tr><td>Durée: </td><td><?php echo "<input type='text' id='duree' size='4'"; if(isset($v)){ echo "value='".$v['duree']."'"; } echo "name='duree'>";?></td></tr>
                <tr><td>Année de sortie: </td><td><?php echo "<input type='text' id='annee' size='2'"; if(isset($v)){ echo "value='".$v['annee']."'"; } echo "name='annee'>";?></td></tr>
                <tr><td>Genre:</td>
            <?php
            Require_once 'Connexion.php';
            $sql = "SELECT * FROM genre ORDER BY genre ASC";
            $result = mysql_query($sql)or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());?>
                    <?php unset($v);?>
            <td><SELECT id="code_genre" name='genre'><option></option>
                    <?php
                    
            while($donnees = mysql_fetch_assoc($result)){
                echo "<OPTION id='code_genre'"; if (isset($v)) {echo "value=".$v['genre'].">";} else {echo "value=".$donnees['code_allocine'].">";} echo htmlspecialchars($donnees['Genre']); echo "</OPTION>";
            }?>
                </SELECT>
	    </td>
              </tr>
              <tr>
                   <td><input name="code_real" id="code_real" type="hidden"></td>
	      </tr>
            <tr>
            <td>Réalisateur:</td>
            
                <td>
                <?php echo "<input type='text' id='realisateur' "; if(isset($v)){ echo "value='".$v['realisateur']."'"; } echo "name='realisateur'>";?><span title="Ajouter un réalisateur" onclick="post();" style="cursor:pointer;"> +<br><br></span>
                </td>
            </tr>
                <tr><td>Synopsis: <td><?php echo "<textarea id='synopsis' name='synopsis'>";if(isset($v)){ echo $v['synopsis'].""; } echo "</textarea>"; ?></td></tr>
                <tr><td>Affiche: <td><?php echo "<input type='text' id='affiche' "; if(isset($v)){ echo "value='".$v['affiche']."'"; } echo "name='affiche'>";?></td></tr>
                <tr><td>Video: <td><?php echo "<input type='text' id='video' "; if(isset($v)){ echo "value='".$v['video']."'"; } echo "name='video'>";?></td></tr>
                <div id="recherche" style='float:right;margin-right:100px;text-decoration:none;color:white;'></div>
            <tr><td><input type='submit' value='Ajouter'></td></tr>
            </table>
        </form> </span></div>

        </div>

        <?php
        }
        else //Message d'erreur puis Retour
        {
        ?>
        <div onload="setTimeout(obj,3000); " id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
        onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
            <span id="c" >Mode </span><span class="v">utilisateur</span>
        </div>
        <div id="corps" style="display:none;">
            <span class="liens" style="font-weight:bolder;font-style:italic;">Anonyme<br></span>
            <span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span>

            <span class="texte">
            <br><br>Le mot de passe et ou le login entrés sont incorrects, veuillez réessayer.
            <span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;text-align:center;">
            <br><br>
            RETOUR
            </span>
            </span>
        <?php
        }
        ?>
        </div>
    </body>
</html>