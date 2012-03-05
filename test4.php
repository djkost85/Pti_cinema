<?php

$action = $_GET['action'];
$action();

function getFilm(){
    $r = array('annee' => 'intouchable',
            'duree' => '32');

echo json_encode($r);
}

?>
