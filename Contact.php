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
<link href="../Pti_Cinema/Css/contact.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Script/Verification_formulaire.js"></script>
<script type="text/javascript" src="../Pti_Cinema/Script/jquery.color.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="Script/script.js"></script>
<script>
$(document).ready(function(){
	    $('#corps').fadeIn(2000);
	    $('.loader').hide();
	});
</script>
<script>
    function send(){
	    $.ajax({
		type: 'POST',
		url: 'Mail.php', 
		data: "nom="+$('#nom').val()+"&email="+$('#email').val()+"&message="+$('#message').val(),
						
		beforeSend:function(){
		$('.loader').stop().fadeIn().show();
				    },
		success:function(data){
		$('.loader').fadeOut();
		$('#result').fadeIn(1500).show().html(data);
		$('#result').delay(20000).fadeOut();
		document.forms.form_c.reset();
				    }});
    };
</script>
</head>
<body>	
<div id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
<span class="v" onclick="location.href='Contact.php'" style="cursor:pointer;">Contacter</span><span id="c" onclick="location.href='Contact.php'" style="cursor:pointer;" > l'administrateur</span>
</div>
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinémas </span></div>

<div id="corps">
<span class="liens" onclick="location.href='Index.php'" style="font-style:italic;font-weight:bolder;">Accueil</span>
<br>
<div id="form_contact"><h3>Contacter l'administrateur:</h3><br>
		<form id="form_c"> <div id="result" style="display:none;"></div>
	    <label for="nom">Nom : </label>
	<input type="text" name="nom" id="nom">
	    <label for="email">E-mail : </label>
	<input type="text" name="email" id="email">
	    <label for="message">Message : </label>
	<textarea name="message" id="message" cols=35 rows=5;"></textarea>
	    <input type="button" value="Envoyer" onclick="send()">
	<div class="loader" style="margin-top:5px;"><img src="loader-blanc.gif"></div>
		</form>	
</div>
<div class="fb" style="margin-top:20px;">
<iframe src="https://www.facebook.com/plugins/like.php?href=florianlopes.comoj.com"
        scrolling="no" frameborder="0"
        style="border:none; width:200px; height:60px"></iframe>
<span id="plus" style="float:right; margin-bottom:8px; margin-right:8px;" onclick="location.href='http://florianlopes.comoj.com'"> Florian Lopes <br><span style="margin-right:10px;padding-top:10px;">
		<a class="plus" href='https://www.facebook.com/profile.php?id=100001980478907' target="_blank"><img class="logo" src='../Pti_Cinema/Images/facebook-logo-45x45.png' title='Retrouvez moi sur Facebook' alt='Florian Lopes Facebook'/></a>
<a class="plus" href='http://fr.linkedin.com/pub/florian-lopes/34/247/126' target="blank"><img class="logo" src='../Pti_Cinema/Images/LinkedIn_25.png' title='Retrouvez moi sur LinkedIn' alt='Florian Lopes LinkedIn'/></a>
 <a class="plus" href='http://www.doyoubuzz.com/florian-lopes' target="blank"><img class="logo" src='../Pti_Cinema/Images/logo_doyoubuzz.png' title='CV Florian Lopes' alt='CV Florian Lopes'/></a>
  <a class="plus" href='https://plus.google.com/112441095655755956811'><img class="logo" src='../Pti_Cinema/Images/mobile.png' title='Google +' alt='Google +'/></a>
		</span></span>
		
		
</div>
</div>
</body>
</html>
