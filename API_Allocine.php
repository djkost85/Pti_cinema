<?php

									   //////////////////////////////////////
									  //////// API ALLOCIN� V3.6.3 /////////
									 //////// cr��e par E.GAUVIN  /////////
									////////////////////////////////////// 
									
	/*
		Ce code source est sous licence Creative Commons (CC-by)
		http://creativecommons.org/licenses/by/2.0/fr/
		Auteur original de la source: Etienne GAUVIN
		
		- Pour informations suppl�mentaires au sujet de l'API Allocin�: -
		Etn3000@laposte.net
	*/
	
	$API_ALLOCINE_VERSION = "3.6.2";
	
	// Classement des informations sur les films
	// Modifiez ces options comme vous le souhaitez
	{
		// Films ()
		$AAm = array(
			'code' =>				'id',
			'title' =>				'titre',
			'originalTitle' =>		'titreOriginal',
			'keywords' =>			'mots-cl�s',
			'productionYear' =>		'ann�eProduction',
			'nationality' =>		'nationalit�',
			'nationality_str' =>	'nationalit�s',
			'genre' =>				'genre',
			'synopsis' =>			'synopsis',
			'synopsisShort' =>		'synopsisCourt',
			'r�alisateur' =>		'r�alisateur',
			'acteur' =>				'acteur',
			'r�alisateurs_str' =>	'r�alisateurs',
			'acteurs_str' =>		'acteurs',
			'poster' =>				'posterHref',
			'runtime' =>			'dur�e',
			'releaseDate_s' =>		'dateSortie', // Mode simple
			'trailer_s' =>			'BA', // Mode simple
			'genres_str' =>			'genres',
			
			'release' =>			'sortie',
				'releaseDate' =>	 	'date',
				'releaseState' =>		'�tat',
				'distributor' =>		'distributeur',
				
			'trailer' =>			'BA',
				'href' =>				'href',
				'code' =>				'code',
			
			'statistics' =>			'statistiques',
				'pressRating' =>		'notePresse',
				'pressReviewCount' =>	'avisPresse',
				'userRating' =>			'notePublic',
				'userReviewCount' =>	'avisPublic',
				'userNoteCount' =>		'votesPublic'
		);
	}
	
	function getMovieById($id=0, $glue=', ')
	{
		{
			// V�rification du bon format de l'id
			if (empty($id) OR !is_numeric($id) or $id==0) return false;
			// V�rification du bon format de $glue
			if (empty($glue) OR !is_string($glue)) return false;
			
			// URL � appeler
			$url = 'http://api.allocine.fr/xml/movie?code='.$id.'&partner=1&json=1&profile=medium';
			
			// R�cup�ration du JSON
			$json = file_get_contents($url);
			
			// Transfert des infos du format JSON => array
			$tab = json_decode($json, true);
			
			// V�rification de la pr�sence d'erreur(s)
			if (!empty($tab['error'])) return false;
			
			// Supprimer le ['movie']
			$tab2 = array();
			foreach ($tab['movie'] as $key => $row)
			{
				$tab2[$key] = $row;
			}
			
			global $AAm;
			
		}
		//// Adaptation ////
		{
		$tab3 = array();
		
		// Id
		if (isset($tab2['code']))
			$tab3[$AAm['code']] = $tab2['code'];
		
		// Titre original
		if (isset($tab2['originalTitle']))
			$tab3[$AAm['originalTitle']] = utf8_decode($tab2['originalTitle']);
		
		// Titre
		if (isset($tab2['title']))
			$tab3[$AAm['title']] = utf8_decode($tab2['title']);
		
		// Mots-cl�s
		if (isset($tab2['keywords']))
			$tab3[$AAm['keywords']] = utf8_decode($tab2['keywords']);
		
		// Ann�e de production
		if (isset($tab2['productionYear']))
			$tab3[$AAm['productionYear']] = $tab2['productionYear'];
		
		// Nationnalit�s
		if (isset($tab2['nationality']))
		{
			foreach ($tab2['nationality'] as $key => $row)
			{
				$tab3[$AAm['nationality']][$key] = utf8_decode($row['$']);
			}
		}
		
		// Genres
		if (isset($tab2['genre']))
		{
			foreach ($tab2['genre'] as $key => $row)
			{
				$tab3[$AAm['genre']][$key] = utf8_decode($row['$']);
			}
		}
		
		// Sortie
		if (isset($tab2['release']))
		{
			$tab3[$AAm['release']][$AAm['releaseDate']] = (isset($tab2['release']['releaseDate'])) ? $tab2['release']['releaseDate'] : "";
			$tab3[$AAm['release']][$AAm['releaseState']] = (isset($tab2['release']['releaseState']['$'])) ? utf8_decode($tab2['release']['releaseState']['$']) : "";
			$tab3[$AAm['release']][$AAm['distributor']] = (isset($tab2['release']['distributor']['name'])) ? utf8_decode($tab2['release']['distributor']['name']) : "";
		}
		
		// Synopsis et Synopsis court
		if (isset($tab2['synopsis']))
			$tab3[$AAm['synopsis']] = utf8_decode($tab2['synopsis']);
		if (isset($tab2['synopsisShort']))
			$tab3[$AAm['synopsisShort']] = utf8_decode($tab2['synopsisShort']);
			
		// Poster
		if (isset($tab2['poster']))
			$tab3[$AAm['poster']] = utf8_decode($tab2['poster']['href']);
		
		// Bande-annonce
		if (isset($tab2['trailer']))
		{
			$tab3[$AAm['trailer']][$AAm['href']] = utf8_decode($tab2['trailer']['href']);
			$tab3[$AAm['trailer']][$AAm['code']] = utf8_decode($tab2['trailer']['code']);
		}
		
		// Acteurs - R�alisateur
		if (isset($tab2['castMember']))
		{
			$acteurs = array();
			$realisateur = array();
			foreach ($tab2['castMember'] as $key => $row)
			{
				if ($row['activity']['$'] == "Acteur" OR $row['activity']['$'] == "Actrice")
				$tab3[$AAm['acteur']][] = utf8_decode($row['person']['$']);
				if (utf8_decode($row['activity']['$']) == "R�alisateur" OR utf8_decode($row['activity']['$']) == "R�alisatrice")
				$tab3[$AAm['r�alisateur']][] = utf8_decode($row['person']['$']);
			}
			if (!empty($tab3['acteur']))
				$tab3[$AAm['acteurs_str']] = implode($glue, $tab3['acteur']);
			else
				$tab3[$AAm['acteurs_str']] = '';
			if (!empty($tab3['r�alisateur']))
				$tab3[$AAm['r�alisateurs_str']] = implode($glue, $tab3['r�alisateur']);
			else
				$tab3[$AAm['r�alisateurs_str']] = '';
		} else {
			$tab3[$AAm['acteur']] = array();
			$tab3[$AAm['r�alisateur']] = array();
			$tab3[$AAm['acteurs_str']] = "";
			$tab3[$AAm['r�alisateurs_str']] = "";
		}
		
		
		// Statistiques - Merci � Hellmer pour sa participation (gestion des erreurs)
		if (isset($tab2['statistics']))
		{
			$tab3[$AAm['statistics']][$AAm['pressRating']] = (isset($tab2['statistics']['pressRating']) ? utf8_decode($tab2['statistics']['pressRating']) : "" );
			$tab3[$AAm['statistics']][$AAm['pressReviewCount']] = (isset($tab2['statistics']['pressReviewCount']) ? utf8_decode($tab2['statistics']['pressReviewCount']) : "" );
			$tab3[$AAm['statistics']][$AAm['userRating']] = (isset($tab2['statistics']['userRating']) ? utf8_decode($tab2['statistics']['userRating']) : "" );
			$tab3[$AAm['statistics']][$AAm['userReviewCount']] = (isset($tab2['statistics']['userReviewCount']) ? utf8_decode($tab2['statistics']['userReviewCount']) : "" );
			$tab3[$AAm['statistics']][$AAm['userNoteCount']] = (isset($tab2['statistics']['userNoteCount']) ? utf8_decode($tab2['statistics']['userNoteCount']) : "" );
		}
		
		// Duree du film - Merci � Glumbob pour sa participation
		if (isset($tab2['runtime']) AND $tab2['runtime'] != 0)
		{
			$duree = $tab2['runtime'];
			$minutes = $duree / 60;
			$tab3[$AAm['runtime']]['heures'] = floor( $minutes / 60 );
			$tab3[$AAm['runtime']]['minutes'] = $minutes % 60;
			$tab3[$AAm['runtime']]['totalSecondes'] = $tab2['runtime'];
			$tab3[$AAm['runtime']]['totalMinutes'] = $minutes;
			$tab3[$AAm['runtime']]['total'] = floor( $minutes / 60 ) .'h'. $minutes % 60;
		} else {
			$tab3[$AAm['runtime']]['heures'] = 0;
			$tab3[$AAm['runtime']]['minutes'] = 0;
			$tab3[$AAm['runtime']]['totalSecondes'] = 0;
			$tab3[$AAm['runtime']]['totalMinutes'] = 0;
			$tab3[$AAm['runtime']]['total'] = '';
		}
		
		// Retour du tableau
		return $tab3;
		}
	}

	function getMovieByIdSimple($id=0, $glue=', ')
	{
		///// M�me chose que la fonction getMovieById mais
		///// Retourne les infos sous une forme plus simple (Sans surplus)
		{
			// V�rification du bon format de l'id
			if (empty($id) OR !is_numeric($id) or $id==0) return false;
			// V�rification du bon format de $glue
			if (empty($glue) OR !is_string($glue)) return false;
			
			// URL � appeler
			$url = 'http://api.allocine.fr/xml/movie?code='.$id.'&partner=1&json=1&profile=medium';
			
			// R�cup�ration du JSON
			$json = file_get_contents($url);
			
			// Transfert des infos du format JSON => array
			$tab = json_decode($json, true);
			
			// V�rification de la pr�sence d'erreur(s)
			if (!empty($tab['error'])) return false;
			
			// Supprimer le ['movie']
			$tab2 = array();
			foreach ($tab['movie'] as $key => $row)
			{
				$tab2[$key] = $row;
			}
			
			global $AAm;
			
		}
		//// Adaptation ////
		{
		$tab3 = array();
		
		// Id
		if (isset($tab2['code']))
			$tab3[$AAm['code']] = $tab2['code'];
		
		// Titre
		if (isset($tab2['title']))
			$tab3[$AAm['title']] = utf8_decode($tab2['title']);
		elseif (isset($tab2['originalTitle']))
			$tab3[$AAm['title']] = utf8_decode($tab2['originalTitle']);
		else
			$tab3[$AAm['title']] = '';
		
		// Ann�e de production
		if (isset($tab2['productionYear']))
			$tab3[$AAm['productionYear']] = $tab2['productionYear'];
		else
			$tab3[$AAm['productionYear']] = '';
		
		// Nationnalit�s
		if (isset($tab2['nationality']))
		{
			foreach ($tab2['nationality'] as $key => $row)
			{
				$natio[$key] = utf8_decode($row['$']);
			}
			$tab3[$AAm['nationality_str']] = implode($glue, $natio);
			unset($natio); // Pas de place inutile :)
		} else $tab3[$AAm['nationality_str']] = "";
		
		// Genres
		if (isset($tab2['genre']))
		{
			foreach ($tab2['genre'] as $key => $row)
			{
				$genre[$key] = utf8_decode($row['$']);
			}
			$tab3[$AAm['genres_str']] = implode($glue, $genre);
			unset($genre);
		} else $tab3[$AAm['genres_str']] = "";
		
		// Sortie
		if (isset($tab2['release']['releaseDate']))
		{
			$tab3[$AAm['releaseDate_s']] = $tab2['release']['releaseDate'];
		} else $tab3[$AAm['releaseDate_s']] = "";
		
		// Synopsis et Synopsis court
		if (isset($tab2['synopsis']))
			$tab3[$AAm['synopsis']] = utf8_decode($tab2['synopsis']);
		else $tab3[$AAm['synopsis']] = "";
		if (isset($tab2['synopsisShort']))
			$tab3[$AAm['synopsisShort']] = utf8_decode($tab2['synopsisShort']);
		else $tab3[$AAm['synopsisShort']] = "";
			
		// Poster
		if (isset($tab2['poster']))
			$tab3[$AAm['poster']] = utf8_decode($tab2['poster']['href']);
		else $tab3[$AAm['poster']] = "";
		
		// Bande-annonce
		if (isset($tab2['trailer']['href']))
		{
			$tab3[$AAm['trailer_s']] = utf8_decode($tab2['trailer']['href']);
		} else $tab3[$AAm['trailer_s']] = "";
		
		// Acteurs - R�alisateur
		if (isset($tab2['castMember']))
		{
			$acteurs = array();
			$realisateur = array();
			foreach ($tab2['castMember'] as $key => $row)
			{
				if ($row['activity']['$'] == "Acteur" OR $row['activity']['$'] == "Actrice")
				$tab3[$AAm['acteur']][] = utf8_decode($row['person']['$']);
				if (utf8_decode($row['activity']['$']) == "R�alisateur" OR utf8_decode($row['activity']['$']) == "R�alisatrice")
				$tab3[$AAm['r�alisateur']][] = utf8_decode($row['person']['$']);
			}
			$tab3[$AAm['acteurs_str']] = implode($glue, $tab3['acteur']);
			$tab3[$AAm['r�alisateurs_str']] = implode($glue, $tab3['r�alisateur']);
		} else {
			$tab3[$AAm['acteur']] = array();
			$tab3[$AAm['r�alisateur']] = array();
			$tab3[$AAm['acteurs_str']] = "";
			$tab3[$AAm['r�alisateurs_str']] = "";
		}
		
		
		// Statistiques - Merci � Hellmer pour sa participation (gestion des erreurs)
		if (isset($tab2['statistics']))
		{
			$tab3[$AAm['statistics']][$AAm['pressRating']] = (isset($tab2['statistics']['pressRating']) ? utf8_decode($tab2['statistics']['pressRating']) : "" );
			$tab3[$AAm['statistics']][$AAm['pressReviewCount']] = (isset($tab2['statistics']['pressReviewCount']) ? utf8_decode($tab2['statistics']['pressReviewCount']) : "" );
			$tab3[$AAm['statistics']][$AAm['userRating']] = (isset($tab2['statistics']['userRating']) ? utf8_decode($tab2['statistics']['userRating']) : "" );
			$tab3[$AAm['statistics']][$AAm['userReviewCount']] = (isset($tab2['statistics']['userReviewCount']) ? utf8_decode($tab2['statistics']['userReviewCount']) : "" );
			$tab3[$AAm['statistics']][$AAm['userNoteCount']] = (isset($tab2['statistics']['userNoteCount']) ? utf8_decode($tab2['statistics']['userNoteCount']) : "" );
		}
		
		// Duree du film - Merci � Glumbob pour sa participation
		if (isset($tab2['runtime']) AND $tab2['runtime'] != 0)
		{
			$duree = $tab2['runtime'];
			$minutes = $duree / 60;
			$tab3[$AAm['runtime']] = floor( $minutes / 60 ) .'h'. $minutes % 60;
		} else {
			$tab3[$AAm['runtime']] = '';
		}
		
		// Retour du tableau
		return $tab3;
		}
	}

	function getNewsById($id=0)
	{
		// V�rification du bon format de l'id
		if (empty($id) OR !is_numeric($id) or $id==0) return false;
		
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/news?code='.$id.'&partner=1&json=1';
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Supprimer le ['news']
		$tab2 = array();
		foreach ($tab['news'] as $key => $row)
		{
			$tab2[$key] = $row;
		}
		
		// Id de l'article
		if (isset($tab2['code']))
			$tab3['id'] = utf8_decode($tab2['code']);
			
		// Date de publication
		if (isset($tab2['publication']['dateStart']))
			$tab3['datePublication'] = utf8_decode($tab2['publication']['dateStart']);
		
		// Titre court
		if (isset($tab2['titleShort']))
			$tab3['titre'] = utf8_decode($tab2['titleShort']);
		
		// Titre long
		if (isset($tab2['titleLong']))
			$tab3['titreLong'] = utf8_decode($tab2['titleLong']);
		
		// Image
		if (isset($tab2['picture']['href']))
			$tab3['imageHref'] = utf8_decode($tab2['picture']['href']);
		
		// Cat�gorie(s)
		if (isset($tab2['category']))
		{
			foreach ($tab2['category'] as $key => $row)
			{
				$tab3['cat�gorie'][$key] = utf8_decode($row['$']);
			}
		}
		
		// Corps de l'article
		if (isset($tab2['body']))
			$tab3['texte'] = utf8_decode($tab2['body']);
		
		// Niveau de priorit� de l'article
		if (isset($tab2['priorityLevel']))
			$tab3['priorit�'] = utf8_decode($tab2['priorityLevel']);
		
		// Retour du tableau
		return $tab3;
	}
	
	function getPersonById($id=0)
	{
		// V�rification du bon format de l'id
		if (empty($id) OR !is_numeric($id) or $id==0) return false;
		
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/person?code='.$id.'&partner=1&json=1&format=h264';
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Supprimer le ['person']
		$tab2 = array();
		foreach ($tab['person'] as $key => $row)
		{
			$tab2[$key] = $row;
		}
		
		//// Adaptation ////
		$tab3 = array();
		
		// Id de l'article
		if (isset($tab2['code']))
			$tab3['id'] = utf8_decode($tab2['code']);
			
		// Pr�nom & Nom / Nom r�el
		if (isset($tab2['commonName']['givenName']))
			$tab3['pr�nom'] = utf8_decode($tab2['commonName']['givenName']);
		else $tab3['pr�nom'] = "";
		if (isset($tab2['commonName']['name']))
			$tab3['nom'] = utf8_decode($tab2['commonName']['name']);
		else $tab3['nom'] = "";
		if (isset($tab2['realName']['name']))
			$tab3['nomR�el'] = utf8_decode($tab2['realName']['name']);
		else $tab3['nomR�el'] = "";
		
		// Sexe
		if (isset($tab2['titleShort']))
			$tab3['titre'] = utf8_decode($tab2['titleShort']);
		
		// Nationnalit�(s)
		if (isset($tab2['nationality']))
		{
			foreach ($tab2['nationality'] as $key => $row)
			{
				$tab3['nationalit�'][$key] = utf8_decode($row['$']);
			}
		}
		
		// Activit�(s)
		if (isset($tab2['activity']))
		{
			foreach ($tab2['activity'] as $key => $row)
			{
				$tab3['activit�'][$key] = utf8_decode($row['$']);
			}
		}
		
		// Image
		if (isset($tab2['picture']['href']))
			$tab3['imageHref'] = utf8_decode($tab2['picture']['href']);
		
		// Cat�gorie(s)
		if (isset($tab2['category']))
		{
			foreach ($tab2['category'] as $key => $row)
			{
				$tab3['cat�gorie'][$key] = utf8_decode($row['$']);
			}
		}
		
		// Corps de l'article
		if (isset($tab2['biography']))
			$tab3['biographie'] = utf8_decode($tab2['biography']);
		
		// Date & Lien de naissance
		if (isset($tab2['birthDate']))
			$tab3['naissance']['date'] = utf8_decode($tab2['birthDate']);
		if (isset($tab2['birthPlace']))
			$tab3['naissance']['lieu'] = utf8_decode($tab2['birthPlace']);
		
		// Participations � des films
		if (isset($tab2['participation']))
		{
			foreach ($tab2['participation'] as $key => $row)
			{
				if (isset($row['movie']))
				{
					// Id
					$tab3['participation'][$key]['id'] = $row['movie']['code'];
					
					// Titre
					if (isset($row['movie']['title']))
						$tab3['participation'][$key]['titre'] = utf8_decode($row['movie']['title']);
					else
						$tab3['participation'][$key]['titre'] = utf8_decode($row['movie']['originalTitle']);
					
					// Titre original
					$tab3['participation'][$key]['titreOriginal'] = utf8_decode($row['movie']['originalTitle']);
					
					// Ann�e de production
					if (isset($row['movie']['productionYear']))
						$tab3['participation'][$key]['ann�eProduction'] = $row['movie']['productionYear'];
					
					// Poster
					if (isset($row['movie']['poster']))
						$tab3['participation'][$key]['posterHref'] = $row['movie']['poster'];
						
					// Activit� sur ce film
					if (isset($row['activity']['$']))
						$tab3['participation'][$key]['activit�'] = utf8_decode($row['activity']['$']);
					
					// R�le
					if (isset($row['role']))
						$tab3['participation'][$key]['r�le'] = utf8_decode($row['role']);
				}
			}
		}
		// Retour du tableau
		return $tab3;
	}
	
	function getMovieByKeywords($q='')
	{
		// V�rification du bon format de la recherche
		if (empty($q) OR !is_string($q) or $q=='') return false;
		
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($q).'&partner=1&json=1&profile=medium&count=1';
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Retour du tableau
		if (!empty($tab['feed']['movie'][0]['code']))
			return getMovieById($tab['feed']['movie'][0]['code']);
		else
			return false;
	}

	function getMovieByKeywordsSimple($q='', $glue=', ')
	{
		// V�rification du bon format de la recherche
		if (empty($q) OR !is_string($q) or $q=='') return false;
		// V�rification du bon format de $glue
		if (empty($glue) OR !is_string($glue)) return false;
		
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($q).'&partner=1&json=1&profile=medium&count=1';
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Retour du tableau
		if (!empty($tab['feed']['movie'][0]['code']))
			return getMovieByIdSimple($tab['feed']['movie'][0]['code'], $glue);
		else
			return false;
	}
	
	function searchMoviesByKeywords($q='', $maxresults=10)
	{
		// V�rification du bon format de la recherche
		if (empty($q) OR !is_string($q) or $q=='') return false;
		
		// V�rification du bon format du nombre de r�sultats maximum
			if (empty($maxresults) OR !is_numeric($maxresults) or $maxresults<=0) $maxresults = 10;
			
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($q).'&partner=1&json=1&profile=small&count='.$maxresults;
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Supprimer le ['feed'] et le ['movie']
		$tab2 = array();
		if (isset($tab['feed']))
		{
			foreach ($tab['feed'] as $key => $row)
			{
				$tab2[$key] = $row;
			}
		}
		$tab3 = array();
		if (isset($tab2['movie']))
		{
			foreach ($tab2['movie'] as $key => $row)
			{
				$tab3[$key] = $row;
			}
		}
		
		global $AAm;
		$tab4 = array();
		
		foreach ($tab3 as $key => $row)
		{
			// Id
			$tab4[$key][$AAm['code']] = $row['code'];
		
			// Titres
			if (isset($row['title']))
				$tab4[$key][$AAm['title']] = utf8_decode($row['title']);
			else
				$tab4[$key][$AAm['title']] = utf8_decode($row['originalTitle']);
		
			// Titres originaux
			if (isset($row['originalTitle']))
				$tab4[$key][$AAm['originalTitle']] = utf8_decode($row['originalTitle']);
			else
				$tab4[$key][$AAm['originalTitle']] = "";
		
			// Ann�e de production
			if (isset($row['productionYear']))
				$tab4[$key][$AAm['productionYear']] = $row['productionYear'];
		
			// Poster
			if (isset($row['poster']['href']))
				$tab4[$key][$AAm['poster']] = $row['poster']['href'];
		}
		
		// Retour du tableau
		return $tab4;
	}
	
	function searchNewsByKeywords($q='', $maxresults=10)
	{
		// V�rification du bon format de la recherche
		if (empty($q) OR !is_string($q) or $q=='') return false;
		
		// V�rification du bon format du nombre de r�sultats maximum
			if (empty($maxresults) OR !is_numeric($maxresults) or $maxresults<=0) $maxresults = 10;
			
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($q).'&partner=1&json=1&profile=medium&count='.$maxresults;
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Supprimer le ['feed'] et le ['movie']
		$tab2 = array();
		foreach ($tab['feed'] as $key => $row)
		{
			$tab2[$key] = $row;
		}
		$tab3 = array();
		if (isset($tab2['news']))
		{
			foreach ($tab2['news'] as $key => $row)
			{
				$tab3[$key] = $row;
			}
		} else return false;
		$tab4 = array();
		
		
		foreach ($tab3 as $key => $row)
		{
			// Id
			$tab4[$key]['id'] = $row['code'];
		
			// Titre
			if (isset($row['titleShort']))
				$tab4[$key]['titre'] = utf8_decode($row['titleShort']);
			else
				$tab4[$key]['titre'] = "";
		
			// Titres long
			if (isset($row['titleLong']))
				$tab4[$key]['titreLong'] = utf8_decode($row['titleLong']);
			else
				$tab4[$key]['titreLong'] = "";
		
			// Date de publication
			if (isset($row['publication']['dateStart']))
				$tab4[$key]['datePublication'] = $row['publication']['dateStart'];
		
			// Image
			if (isset($row['picture']['href']))
				$tab4[$key]['imageHref'] = $row['picture']['href'];
		
			// Cat�gorie(s)
			foreach ($row['category'] as $skey => $srow)
			{
				$tab4[$key]['cat�gorie'][$skey] = utf8_decode($row['category'][$skey]['$']);
			}
		}
	
		// Retour du tableau
		return $tab4;
	}
	
	function searchPersonsByKeywords($q='', $maxresults=10)
	{
		// V�rification du bon format de la recherche
		if (empty($q) OR !is_string($q) or $q=='') return false;
		
		// V�rification du bon format du nombre de r�sultats maximum
			if (empty($maxresults) OR !is_numeric($maxresults) or $maxresults<=0) $maxresults = 10;
		
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($q).'&partner=1&json=1&profile=small&count='.$maxresults;
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Supprimer le ['feed'] et le ['person']
		$tab2 = array();
		foreach ($tab['feed'] as $key => $row)
		{
			$tab2[$key] = $row;
		}
		$tab3 = array();
		if (isset($tab2['person'])) {
			foreach ($tab2['person'] as $key => $row)
			{
				$tab3[$key] = $row;
			}
		} else return false;
		
		$tab4 = array();
		
		foreach ($tab3 as $key => $row)
		{
			// Id
			$tab4[$key]['id'] = $row['code'];
		
			// Nom de la personne
			if (isset($row['name']))
				$tab4[$key]['nom'] = utf8_decode($row['name']);
			
			// Nationnalit�(s)
			if (isset($row['nationality']))
			{
				foreach ($row['nationality'] as $skey => $row)
				{
					$tab4[$key]['nationalit�'][$skey] = utf8_decode($row['$']);
				}
			}
		
			// Activit�(s)
			if (isset($row['activity']))
			{
				foreach ($row['activity'] as $skey => $row)
				{
					$tab4[$key]['activit�'][$skey] = utf8_decode($row['$']);
				}
			}
		
			// Image
			if (isset($row['poster']['href']))
				$tab4[$key]['imageHref'] = $row['poster']['href'];
		}
		
		// Retour du tableau
		return $tab4;
	}
	
	function searchTVSeriesByKeywords($q='', $maxresults=10, $glue=', ')
	{
		// V�rification du bon format de la recherche
		if (empty($q) OR !is_string($q)) return false;
		// V�rification du bon format de $glue
		if (empty($glue) OR !is_string($glue)) return false;
		// V�rification du bon format du nombre de r�sultats maximum
			if (empty($maxresults) OR !is_numeric($maxresults) or $maxresults<=0) $maxresults = 10;
		// URL � appeler
		$url = 'http://api.allocine.fr/xml/search?q='.urlencode($q).'&partner=1&json=1&profile=large&count='.$maxresults;
		
		// R�cup�ration du JSON
		$json = file_get_contents($url);
		
		// Transfert des infos du format JSON => array
		$tab = json_decode($json, true);
		
		// V�rification de la pr�sence d'erreur(s)
		if (!empty($tab['error'])) return false;
		
		// Supprimer le ['feed'] et ne r�cup�rer que les infos des s�ries TV
		$tab2 = array();
		if (isset($tab['feed']))
		{
			foreach ($tab['feed'] as $key => $row)
			{
				$tab2[$key] = $row;
			}
		}
		$tab3 = array();
		if (isset($tab2['tvseries']))
		{
			foreach ($tab2['tvseries'] as $key => $row)
			{
				$tab3[$key] = $row;
			}
		} else return false;
		
		$tab4 = array();
		
		foreach ($tab3 as $key => $row)
		{
			// Id
			$tab4[$key]['id'] = $row['code'];
		
			// Titres
			if (isset($row['title']))
				$tab4[$key]['titre'] = utf8_decode($row['title']);
			else
				$tab4[$key]['titre'] = utf8_decode($row['originalTitle']);
				
			// Titres originaux
			if (isset($row['originalTitle']))
				$tab4[$key]['titreOriginal'] = utf8_decode($row['originalTitle']);
			else
				$tab4[$key]['titreOriginal'] = "";
		
			// Ann�e de d�part
			if (isset($row['yearStart']))
				$tab4[$key]['ann�eD�part'] = $row['yearStart'];
			else $tab4[$key]['ann�eD�part'] = '';
		
			// [Ann�e de fin]
			if (isset($row['yearEnd']))
				$tab4[$key]['ann�eFin'] = $row['yearEnd'];
			else $tab4[$key]['ann�eFin'] = '';
		
			// Statistiques - Merci � Hellmer pour sa participation (gestion des erreurs)
			if (isset($tab3['statistics']))
			{
				$tab4[$key]['statistiques']['notePresse'] = (isset($row['statistics']['pressRating']) ? utf8_decode($row['statistics']['pressRating']) : "" );
				$tab4[$key]['statistiques']['avisPresse'] = (isset($row['statistics']['pressReviewCount']) ? utf8_decode($row['statistics']['pressReviewCount']) : "" );
				$tab4[$key]['statistiques']['notePublic'] = (isset($row['statistics']['userRating']) ? utf8_decode($row['statistics']['userRating']) : "" );
				$tab4[$key]['statistiques']['avisPublic'] = (isset($row['statistics']['userReviewCount']) ? utf8_decode($row['statistics']['userReviewCount']) : "" );
				$tab4[$key]['statistiques']['votesPublic'] = (isset($row['statistics']['userNoteCount']) ? utf8_decode($row['statistics']['userNoteCount']) : "" );
			}
		
			// Poster
			if (isset($row['poster']['href']))
				$tab4[$key]['posterHref'] = $row['poster']['href'];
		
			// Personnes
			if (isset($row['castMember']))
			{
				$acteurs = array();
				$realisateur = array();
				foreach ($row['castMember'] as $srow)
				{
					if ($srow['activity']['code'] == 8001)
					$acteurs[] = $srow['person'];
					if (utf8_decode($srow['activity']['code']) == 8002)
					$realisateur[] = $srow['person'];
				}
				$tab4[$key]['acteurs'] = implode($glue, $acteurs);
				$tab4[$key]['r�alisateur'] = implode($glue, $realisateur);
			} else {
				$tab4[$key]['acteurs'] = "";
				$tab4[$key]['r�alisateur'] = "";
			}
			
			// Liens
			foreach ($row['link'] as $skey => $srow)
			{
				if (isset($srow['href']))
					$tab4[$key]['liens'][$skey] = $srow['href'];
			}
		}
		
		// Retour du tableau
		return $tab4;
	}
	
	function getShowTimeList($options)
	{
		
		// V�rification du bon format de $options
		if (empty($options) OR !is_array($options)) return false;
		
		/**** V�rification et application des options ****/
		$modeCP = false;
		$url = "http://api.allocine.fr/xml/showtimelist?partner=1&json=1&";
		{
			// Dans le cas d'une recherche pour les horaires d'un film seulement
			if (!empty($options['filmId']) AND is_numeric($options['filmId']) AND $options['filmId'] > 0)
				$url .= "movie=" . $options['filmId'] . "&";
			
			// Dans le cas d'une recherche avec la date (format AAAA-MM-JJ)
			if (!empty($options['date']) AND is_string($options['date']) AND preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#",$options['date']))
				$url .= "date=" . $options['date'] . "&";
			
			// Cr�ation automatique de tableau d'horaires
			if (!empty($options['autoTableHTML']) AND is_array($options['autoTableHTML']))
			{
				$autoTableHTML = true;
				if (!empty($options['autoTableHTML']['classTR']))
					$classTR = " class='".$options['autoTableHTML']['classTR']."' ";
				else $classTR = "";
				if (!empty($options['autoTableHTML']['classTD']))
					$classTD = " class='".$options['autoTableHTML']['classTD']."' ";
				else $classTD = "";
				if (!empty($options['autoTableHTML']['classTH']))
					$classTH = " class='".$options['autoTableHTML']['classTH']."' ";
				else $classTH = "";
				if (!empty($options['autoTableHTML']['classTABLE']))
					$classTABLE = " class='".$options['autoTableHTML']['classTABLE']."' ";
				else $classTABLE = "";
				if (!empty($options['autoTableHTML']['classCAPTION']))
					$classCAPTION = " class='".$options['autoTableHTML']['classCAPTION']."' ";
				else $classCAPTION = "";
				if (!empty($options['autoTableHTML']['textCAPTION']))
					$textCAPTION = $options['autoTableHTML']['textCAPTION'];
				else $textCAPTION = "";
			} else $autoTableHTML = false;
			
			// Code Postal
			if (isset($options['CP']))
			{
				if (!is_numeric($options['CP'])) return false;
				$url .= 'zip='.$options['CP'].'&';
				$modeCP = true;
			}
			
			// Latitude / longitude
			if (isset($options['lat']) AND isset($options['long']))
			{
				if ($modeCP == true) return false;
				if (!is_numeric($options['lat']) OR !is_numeric($options['long'])) return false;
				$url .= 'lat='.$options['lat'].'&long='.$options['lat'].'&';
			}
			
			// Rayon
			if (isset($options['rayon']))
			{
				if (!is_numeric($options['rayon'])) return false;
				$options['rayon'] = ceil($options['rayon']); // Arrondir � l'entier sup�rieur
				if ($options['rayon'] < 1 OR $options['rayon'] > 500) return false; // Limites 1< Rayon >500
			} else $options['rayon'] = 10;
			$url .= 'radius='.$options['rayon'];
			
		}
		
		/**** Traitement des donn�es ****/
		{
			// R�cup�ration du JSON
			$json = file_get_contents($url);
			
			// Transfert des infos du format JSON => array
			$tab0 = json_decode($json, true);
			
			// V�rification de la pr�sence d'erreur(s)
			if (!empty($tab0['error'])) return false;
			if ($tab0['feed']['totalResults'] == 0) return array(); // Si pas de r�sultat, retourne un tableau vide
			
			// Supprimer le ['feed']
			$tab = array();
			foreach ($tab0['feed'] as $key => $row)
				{ $tab[$key] = $row; }
			
			// R�sultats des cin�mas � part de la MAJ et du nb de r�sultats
			$tcine = array();
			foreach ($tab['theaterShowtimes'] as $key => $row)
			{
				$tcine[$key] = $row;
			}
			$tinfos = array(
				'nombreResultats' => $tab['totalResults'],
				'MAJ' => $tab['updated']
			);
		}
		
		// Informations sur le cin�ma
		{
			// Id du cin�ma
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['id'] = $row['theater']['code'];
			}
			
			// Adresse du cin�ma
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['adresse'] = utf8_decode($row['theater']['address']);
			}
			
			// Nom du cin�ma
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['nom'] = utf8_decode($row['theater']['name']);
			}
			
			// Ville du cin�ma
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['ville'] = utf8_decode($row['theater']['city']);
			}
			
			// Code postal du cin�ma
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['codePostal'] = utf8_decode($row['theater']['postalCode']);
			}
			
			// Distance cin�ma / rep�re (indiqu� dans les options)
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['distance'] = $row['theater']['distance'];
			}
			
			// M�tro
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['m�tro'] = utf8_decode($row['theater']['subway']);
				if (empty($tcine2[$key]['infosCin�ma']['m�tro']))
					$tcine2[$key]['infosCin�ma']['m�tro'] = "Aucun";
			}
			
			// Latitude / longitude du cin�ma
			foreach ($tcine as $key => $row)
			{
				$tcine2[$key]['infosCin�ma']['latitude'] = $row['theater']['latitude'];
				$tcine2[$key]['infosCin�ma']['longitude'] = $row['theater']['longitude'];
			}
		}
		
		$catFilms = 'films';
		$catHoraires = 'horaires';
		
		// Horaires et informations des films, par cin�ma
		foreach ($tcine as $ckey => $cine)
		{
			foreach ($cine['movieShowtimes'] as $fkey => $film)
			{
				// Id
				if (isset($film['movie']['code']))
					$tcine2[$ckey][$catFilms][$fkey]['id'] = $film['movie']['code'];
				
				// Titre
				if (isset($film['movie']['title']))
					$tcine2[$ckey][$catFilms][$fkey]['titre'] = utf8_decode($film['movie']['title']);
				
				// Dur�e du film HhMM
				if (isset($film['movie']['runtime']))
				{
					$mintotal = $film['movie']['runtime'] / 60;
					$heures = floor( $mintotal / 60 );
					$minplus = $mintotal % 60;
					// Pour afficher les minutes en deux chiffres (ex: 2h03 au lieu de 2h3)
					if ($minplus<10 AND $minplus>=0) $minplus = "0" . $minplus;
					$tcine2[$ckey][$catFilms][$fkey]['dur�e'] = $heures . "h" . $minplus;
				}
				
				// Genres
				if (isset($film['movie']['genre']))
				{
					foreach ($film['movie']['genre'] as $key => $row)
					{
						$tcine2[$ckey][$catFilms][$fkey]['genre'][$key] = utf8_decode($row['$']);
					}
				}
				
				// R�alisateur - Acteurs
				if (isset($film['movie']['castingShort']['director']))
					$tcine2[$ckey][$catFilms][$fkey]['r�alisateur'] = utf8_decode($film['movie']['castingShort']['director']);
				if (isset($film['movie']['castingShort']['actors']))
					$tcine2[$ckey][$catFilms][$fkey]['acteurs'] = utf8_decode($film['movie']['castingShort']['actors']);
				
				// Version (Fran�ais,...)
				if (isset($film['version']['$']))
					$tcine2[$ckey][$catFilms][$fkey]['version'] = utf8_decode($film['version']['$']);
				
				// Poster (URL)
				if (isset($film['poster']['href']))
					$tcine2[$ckey][$catFilms][$fkey]['posterHref'] = utf8_decode($film['poster']['href']);
				
				// Format image 3D
				if (isset($film['screenFormat']['$']))
					$tcine2[$ckey][$catFilms][$fkey]['formatImage'] = utf8_decode($film['screenFormat']['$']);
				
				// Horaires des s�ances
				if (isset($film['scr']))
				{
					foreach ($film['scr'] as $dkey => $row)
					{
						// Jour
						$tcine2[$ckey][$catFilms][$fkey][$catHoraires][$dkey]['jour'] = utf8_decode($row['d']);
						// Heures s�ances
						if (isset($row['t']))
						{
							foreach ($row['t'] as $hkey => $srow)
							{
								$tcine2[$ckey][$catFilms][$fkey][$catHoraires][$dkey]['heures'][$hkey] = utf8_decode($srow['$']);
							}
						}
					}
					if ($autoTableHTML)
					{
						$tableauHTML = "\n<table".$classTABLE.">\n";
						if (!empty($textCAPTION))
							$tableauHTML .= "\t<caption".$classCAPTION.">".$textCAPTION.$tcine2[$ckey][$catFilms][$fkey]['titre']."</caption>\n";
						// Affichage des jours en header
						$tableauHTML .= "\t<tr".$classTH.">";
						foreach($film['scr'] as $thkey => $row)
						{
							$tableauHTML .= "<th".$classTD.">".$row['d']."</th>";
						}
						$tableauHTML .= "</tr>\n";
						// Compter le nombre d'heures maximal
						$nbheures = 0;	$nbheuresmax = 0;
						foreach($film['scr'] as $comptkey => $jour)
						{
							$nbheures = 0;
							if (isset($jour['t']))
								$nbheures = count($jour['t']);
							if ($nbheures > $nbheuresmax)
								$nbheuresmax = $nbheures;
						}
						$nbheuresmax--;
						
						for ($i=0 ; $i<=$nbheuresmax ; $i++)
						{
							$tableauHTML .= "\t<tr".$classTR.">\n";
							foreach($film['scr'] as $row)
							{
								if (isset($row['t']))
								{
									if (isset($row['t'][$i]['$']))
										$tableauHTML .= "\t\t<td".$classTD.">".$row['t'][$i]['$']."</td>\n";
									else
										$tableauHTML .= "\t\t<td".$classTD."></td>\n";
								}
							}
							$tableauHTML .= "\t</tr>\n";
						}
						
						
						$tableauHTML .= "</table>\n";
						$tcine2[$ckey][$catFilms][$fkey]['tableauHTML'] = $tableauHTML;
					}
				}
				
			}
		}
		
		return $tcine2;
	}
	
	