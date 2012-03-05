<?php
include 'api-allocine-helper-2.1.php';

function getFilmsInfos(){
    // Construire l'objet AlloHelper
    $helper = new AlloHelper;

    // On peut régler des paramètres
    // Ici, supprimer les tags HTML dans le synopsis.
    $helper->set('striptags', 'synopsis');
    $q = "Intouchables";
    $page = 1;
    $count = 3;
    $filter = array('movie');

    // Envoi de la requête et traitement des données reçues.
    // $url est passée par référence et contiendra l'URL ayant appelé les données.
    $donnees = $helper->search( $q, $page, $count, true, $filter, $url );
    echo $donnees['movie']['0']['title'];
    echo $donnees['movie']['0']['productionYear'];
    echo $donnees['movie']['0']['link']['0']['href'];

    $code = $donnees['movie']['0']['code'];
    echo $code;

    $img = $donnees['movie']['0']['poster'];
    echo '<br>url img<br>';
    $src = $img->url();
    $img = $img->resize(300, 160);
    echo '<img src="'.$img->url().'">';

    $film = $helper->movie($code);
    $num_genre = $film['genre']['0']['code'];
    echo $num_genre;
    $synopsis = $film['synopsis'];
    echo $synopsis;
    $real = $film['castingShort']['directors'];
    echo $real;
    $real = explode(",", $real);

    echo $real['0'];


    // Les données sous forme d'un array
    echo    "<a href=\"$url\">$url</a><br /><pre>",
            print_r($film->getArray(), 1),
            "</pre>";
}
