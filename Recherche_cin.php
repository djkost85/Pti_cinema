<?php
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
}	?>