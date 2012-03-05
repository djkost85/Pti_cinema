<?php

if (isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['message']))
    {
        $nom = mysql_escape_string($_POST['nom']);
        $email = mysql_escape_string($_POST['email']);
        $message = mysql_escape_string($_POST['message']);

    $pos= strpos($email, "@");
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	echo "<span style='color:white;font-weight:bold;'>Entrez un email valide! <p>Votre email doit être de la forme \"example@ex.com\" </h5></span>";
	}
else
    {   
$entete="From: Pti_cinema <$email> \n";
$entete .="MIME-version: 1.0\n";
$entete .="Content-type: text/html; charset= utf-8 \n";
$complet= "
NOM: $nom <br>
EMAIL: $email <br>
MESSAGE: $message <br>
";
    if (@mail("flopes@epsi.fr","Message du site Pti_cinema",$message, $entete)==FALSE)
	{
	    echo "Erreur!";
	}
    else
	    echo " Message envoyé! <img src='logo_success.png' width=24 height=24><br>";
    }

}
?>