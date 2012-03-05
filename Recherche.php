<?php
if(!empty($_POST) && !empty($_POST['search']))
{
	$search = mysql_real_escape_string($_POST['search']);
	
	Require_once 'Connexion.php';

    $req ="SELECT * FROM film INNER JOIN genre on genre.Num_genre = film.Num_genre WHERE film.titre LIKE '%$search%' OR resume LIKE '%$search%' ORDER BY num_film DESC";
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
				echo nl2br(htmlspecialchars($donnees['resume']));
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
}	?>