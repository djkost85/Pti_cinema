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
<link href="../Pti_Cinema/Css/default.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="Script/Verification_formulaire.js"></script>
<script type="text/javascript" src="../Pti_Cinema/Script/jquery.color.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script> 
    $(document).ready(function(){
           $('#corps').fadeIn(2000);
		   $('.loader').hide();
		   
		   $('#search').keyup(function(){
					$field = $(this);
					$('#result').html('');
					if($field.val().length > 1)
					{
						$.ajax({
						type: 'POST',
						url: 'Recherche_cin.php', 
						data: 'search='+$('#search').val()+'&action=mySearchAjax_film',
						
						beforeSend:function(){
							$('.loader').stop().fadeIn();
							},
							
						success:function(data){
								$('.loader').fadeOut();
								$('#result').fadeIn(1500).show().html(data);
							}
						});
					}
									});
	});	   
</script>
<script src="Script/script.js"></script>

</head>
<body>	
<div id="titre" onmouseover="javascript:document.getElementById('titre').style.textShadow='#fff 0px 0px 5px';"
onmouseout="javascript:document.getElementById('titre').style.textShadow='none';">
<span class="v" onclick="location.href='Rechercher_cin.php'" style="cursor:pointer;">Rechercher</span><span id="c" onclick="location.href='Rechercher_cin.php'" style="cursor:pointer;" > un cinéma</span>
</div>
<div id="menu" style="text-align:center;"><span class="liens" onclick="location.href='Index.php'"> Les films | </span><span class="liens" onclick="location.href='Realisateurs.php?num_real=1'"> Les réalisateurs |</span><span class="liens" onclick="location.href='Cinemas.php?num_cin=1'"> Les cinémas </span></div>

<div id="corps">
<br><br>
<div id="champ">Rechercher un cinéma:<br>
		<form> 
			<label for="search"></label>
	<input type="text" name="search" id="search" size=50 style="margin-top:10px;">
	<div class="loader" style="margin-top:5px;"><img src="loader-blanc.gif"></div>
		</form>	
</div>
<div id="result" style="display:none;"></div>
<div class="fb" style="margin-top:20px;">
<iframe src="https://www.facebook.com/plugins/like.php?href=florianlopes.comoj.com"
        scrolling="no" frameborder="0"
        style="border:none; width:200px; height:60px"></iframe>	
</div>
</div>
</body>
</html>
