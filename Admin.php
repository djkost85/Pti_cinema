<?php 
session_start();



?>

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

<div id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
<span id="c" >Mode </span><span class="v">administrateur</span>
</div>	
<div id="corps" style="display:none;">
<span class="liens" style="font-weight:bolder;font-style:italic;">ADMINISTRATEUR<br></span>
<?php if((isset($_SESSION['login']) AND isset ($_SESSION['mdp']) AND (($_SESSION['login'] == 'admin') AND $_SESSION['mdp'] == 'admin'))) { ?> <span class="liens" style="font-style:italic;font-weight:bolder;">Connecté [<?php echo $_SESSION['login'];?>]</span>

<span class="liens" onclick="location.href='Index.php'" style="cursor:pointer;">Accueil</span><br>
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
 </div>
</body>
</html>