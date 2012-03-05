<?php
include 'api-allocine-helper-2.1.php';
$q = htmlspecialchars($_GET['search']);
// Objet AlloHelper de l'API Allocine
$helper = new AlloHelper;

// @params: suppression des tags dans le synopsis
$helper->set('striptags', 'synopsis');
$page = 1;
$count = 1;
// type recherché : movie => film
$filter = array('movie');
$return = array('code' => '',
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
$return['code'] = $donnees['movie']['0']['code'];
$return['titre_f'] = $donnees['movie']['0']['title'];
$return['annee'] = $donnees['movie']['0']['productionYear'];
$return['lien'] = $donnees['movie']['0']['link']['0']['href'];
// img est de type AlloImage
$img = $donnees['movie']['0']['poster'];
$return['affiche'] = $src = $img->url();
$img = $img->resize(300, 160);
// Récupération des infos du film en question ($return['code'])
$film = $helper->movie($return['code']);
$return['duree'] = $film['runtime']/60;
$return['synopsis'] = utf8_encode($film['synopsis']);
//$real = $film['castingShort']['directors'];
$real = $film['castMember']['0']['person']['name'];
print_r($real);
echo $real;
        $code_video = $film['trailer']['code'];
        $video = $helper->media($code_video);
        //$url_video = $video['rendition']['1'];
        echo $url_video;
// Récupération du 1er réalisateur au cas ou il y en aurai plusieurs...
//$real = explode(",", $real);
$return['realisateur'] = $film['castMember']['0']['person']['name'];
        echo    "<a href=\"$url\">$url</a><br /><pre>",
                print_r($video->getArray(), 1),
                "</pre>";
        
        echo 'le FILM ////////////////////////////////';
                echo    "<a href=\"$url\">$url</a><br /><pre>",
                print_r($film->getArray(), 1),
                "</pre>";
print_r(json_encode($return));

?>
<form>
<SELECT id="fonction" name="fonction">
		<OPTION VALUE="enseignant">Enseignant</OPTION>
		<OPTION VALUE="etudiant">Etudiant</OPTION>
		<OPTION VALUE="ingenieur">Ingénieur</OPTION>
		<OPTION VALUE="retraite">Retraité</OPTION>
		<OPTION VALUE="autre">Autre</OPTION>
                <OPTION VALUE="1">1</OPTION>
	</SELECT>
</form>

return json_encode($return);
?>
