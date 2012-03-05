<?php

function saveData($post){
    $form = array('titre_f' => '',
                    'duree' => '',
                    'annee' => '',
                    'genre' => '',
                    'realisateur' => '',
                    'synopsis' => '',
                    'affiche' => '',
                    'video' => '',);
    
    $requiredFiels = array('titre_f', 'duree', 'annee', 'genre', 'realisateur', 'synopsis');
    
    foreach ($post as $k => $p)
    {
        $form[$k] = htmlspecialchars($p);
    }
    
    $e = getErreurs($form, $requiredFiels);
    $_SESSION['form'] = $form;

    if (!empty($e)){
        echo "<span style='color:white;'>Les champs <b>suivants</b> comportent des erreurs : <br/> <b>";
        foreach ($e as $erreur){
            echo $erreur."<br/>";
        }
        echo "</b></span>";
        return false;
    }
    return true;
}

function getErreurs($form, $requiredFields){
    $erreurs = array();
    foreach ($requiredFields as $required){
        if ($form [$required] == false){
            $erreurs[] = $required;
        }
    }
    if (isset($erreurs)){
        return $erreurs;
    }
    else{
        return 0;
    }
}

function recupData(){
    $count = count($_SESSION['form']);
    $data = $_SESSION['form'];
    $return = array('titre_f' => '',
                    'duree' => '',
                    'annee' => '',
                    'genre' => '',
                    'realisateur' => '',
                    'synopsis' => '',
                    'affiche' => '',
                    'video' => '',);
    foreach ($data as $k => $val){
        $return[$k] = $val;
    }
    return $return;
    
}
?>
