<?php
if (isset($_POST['action']) && isset($_POST['search'])){
    $action = htmlspecialchars($_POST['action']);
    $action();
}
else if (isset($_GET['action']))
{
    $action = htmlspecialchars($_GET['action']);
    $action();
}
getFilmsInfos();
function getFilmsInfos(){
    if (isset($_POST['search'])){
        include 'api-allocine-helper-2.1.php';
        $q = htmlspecialchars($_POST['search']);
        // Objet AlloHelper de l'API Allocine
        $helper = new AlloHelper;

        // @params: suppression des tags dans le synopsis
        $helper->set('striptags', 'synopsis');
        $page = 1;
        $count = 1;
        // type recherché : movie => film
        $filter = array('movie');
        $r = array('code' => '',
                        'titre_f' => '',
                        'annee' => '',
                        'duree' => '',
                        'realisateur' => '',
                        'affiche' => '',
                        'synopsis' => '',
                        'lien' => '' );
        // Envoi de la requête et traitement des données reçues.
        // $url est passée par référence et contiendra l'URL ayant appelé les données.
        $donnees = $helper->search( $q, $page, $count, true, $filter, $url );
        $r['code'] = $donnees['movie']['0']['code'];
        $r['titre_f'] = $donnees['movie']['0']['title'];
        $r['annee'] = $donnees['movie']['0']['productionYear'];
        $r['lien'] = $donnees['movie']['0']['link']['0']['href'];
        // img est de type AlloImage
        $img = $donnees['movie']['0']['poster'];
        $r['affiche'] = $src = $img->url();
        $img = $img->resize(300, 210);
        // Récupération des infos du film en question ($return['code'])
        $film = $helper->movie($r['code']);
        $r['duree'] = $film['runtime']/60;
        $r['synopsis'] = utf8_encode($film['synopsis']);
        $real = $film['castingShort']['directors'];
        $code_real = $film['castMember']['0']['person']['code'];
        $code_video = $film['trailer']['code'];
        $video = $helper->media($code_video);
        $video_url = $video['rendition']['1']['href'];
        //Boucle pour chercher les vidéos avec l'extension .flv
        $i = 0;
        /*$ext = '';
        while ($ext != 'flv'){
            $length = count($film['rendition'][i]);
            $ext = substr($film['rendition'][i], (-$length -3));
            $i++;
        }*/
        // Récupération du 1er réalisateur au cas ou il y en aurai plusieurs...
        //$real = explode(",", $real);
        //$r['realisateur'] = $real['0'];
        $return = array('titre_f' => '',
                        'duree' => '',
                        'annee' => '',
                        'code_real' => '',
                        'realisateur' => '',
                        'affiche' => '',
                        'synopsis' => '',
                        'video' => '');
        $return['titre_f'] = $donnees['movie']['0']['title'];
        $return['duree'] = $film['runtime']/60;
        $return['annee'] = $donnees['movie']['0']['productionYear'];
        $return['code_real'] = $code_real;
        $return['realisateur'] = $real;
        $return['affiche'] = $img->url();
        $return['synopsis'] = utf8_encode($film['synopsis']);
        $return['video'] = $video_url;
        
        echo json_encode($return);
    }
}

function autoCompFilm(){
    if (!empty($_REQUEST['term']))
    {
        $search = mysql_real_escape_string($_REQUEST['term']);
        /*Require_once 'Connexion.php';
        
        $req ="SELECT * FROM film WHERE film.titre LIKE '%$search%'";
        $res = mysql_query ($req) or die ('Erreur SQL !'.$req.'<br />'.mysql_error());
        
        echo json_encode($res);*/
        echo 'salut';

    }
}

function mySearchAjax_film(){
    if(!empty($_POST) && !empty($_POST['search']))
    {
            $search = mysql_real_escape_string($_POST['search']);

            Require_once 'Connexion.php';

        $req ="SELECT * FROM film INNER JOIN genre on genre.Num_genre = film.Num_genre WHERE film.titre LIKE '%$search%' OR synopsis LIKE '%$search%' ORDER BY num_film DESC";
        $req = mysql_query ($req) or die ('Erreur SQL !'.$req.'<br />'.mysql_error()); 
            if (mysql_num_rows($req) > 0){
        while($donnees = mysql_fetch_assoc($req))
        {
                    echo "<div class='films' style='cursor:pointer;margin:auto;' onclick="."location.href='Films.php?num_film="; echo htmlspecialchars($donnees['num_film'])."'>";
                    echo "
                            <p><h3 style='cursor:pointer;' onclick="."location.href='Films.php?num_film="; echo htmlspecialchars($donnees['num_film'])."'>";
                                    echo htmlspecialchars($donnees['titre']);
                            echo "</h3><table> <tr><td> <img align='middle;' alt='affiche' name='affiche' src="; echo htmlspecialchars($donnees['affiche'])."></td>
                            <td>";
                                    // Contenu du film
                                    echo "<span style='font-weight:bold;'> Genre : </span>"; echo htmlspecialchars($donnees['Genre'])."<br>";
                                    echo nl2br(htmlspecialchars($donnees['synopsis']));
                                    echo "</td></tr><br></table>
                            <em>Durée:"; echo htmlspecialchars($donnees['duree'])." min</em><br>"; echo "<hr>";
                    echo "</div>	 ";
            }
            }

            else{
                    echo "<h2 style='color:white;text-align:center;'>Aucun résultat</h2>";
                    }
    }
    else{
            echo "<h2>Aucun résultat</h2>";
    }	
}

function mySearchAjax_cin(){
    if(!empty($_POST) && !empty($_POST['search']))
    {
        $search = mysql_real_escape_string($_POST['search']);
        Require_once 'Connexion.php';

                    // Affichage des films
        $req ="SELECT * FROM cinema WHERE cinema.nom_cin LIKE '%$search%' OR ville_cin LIKE '%$search%' ORDER BY num_cin DESC";
        $req = mysql_query ($req) or die ('Erreur SQL !'.$req.'<br />'.mysql_error()); 
        if (mysql_num_rows($req) > 0){
            while($donnees = mysql_fetch_assoc($req))
            {
                        echo "<div class='films' style='cursor:pointer;margin:auto;' onclick="."location.href='Cinemas.php?num_cin="; echo htmlspecialchars($donnees['num_cin'])."'>";
                        echo "
        <p><h3 style='cursor:pointer;' onclick="."location.href='Cinemas.php?num_cin="; echo htmlspecialchars($donnees['num_cin'])."'>";
                        echo htmlspecialchars($donnees['nom_cin']); ?> 
                        </h3><br>
                        <em><b>Nom: </b><?php echo htmlspecialchars($donnees['nom_cin']); ?><br></em>
                        <em><b>Adresse: </b><?php echo htmlspecialchars($donnees['adresse_cin']); ?><br></em> 
                        <em><b>Code Postal: </b><?php echo htmlspecialchars($donnees['codepos_cin']); ?><br></em>
                        <em><b>Ville: </b><?php echo htmlspecialchars($donnees['ville_cin']); ?><br></em>
                        <?php echo "</div>	 ";
                }
        }
        else{
            echo "<h2 style='color:white;text-align:center;'>Aucun résultat</h2>";
        }
    }
    else{
        echo "<h2>Aucun résultat</h2>";
    }
}
?>
