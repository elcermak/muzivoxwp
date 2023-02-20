<?php

/**
 * Cette fonction prend en entrée un tableau de concerts et le nom d'un artiste, 
 * elle parcours les concerts de cet artiste et retourne le prochain concert à partir de la date courante.
 * elle renvois un tableau comportant le prochain concert (date, ville, région, lien de réservation, salle, si_complet)
 * @param array $concerts  tableau des concerts
 * @param string $name_artiste nom de l'artiste dont on veut trouver le prochain concert
 * @return array $next_concert tableau qui contient les informations du prochain concert
 */
function get_last_concert($concerts, $name_artiste)
{
	$current_time = time(); // On récupère le timestamp de la date courante

	// On initialise des variables pour stocker le prochain concert et sa date
	$next_concert = null;
	$next_date = null;

	foreach ($concerts[$name_artiste] as $concert) { // On parcours tous les concerts de l'artiste donné
		$concert_time = strtotime($concert['date']);
		if ($current_time < $concert_time) { // Si c'est le premier prochain concert qu'on trouve
			if ($next_date === null) {
				$next_date = $concert_time;
				$next_concert = $concert;
			} else if ($next_date > $concert_time) { // Sinon si on a déjà trouvé un concert, on compare les deux dates pour savoir lequel est le plus proche
				$next_date = $concert_time;
				$next_concert = $concert;
			}
		}
	}
	return $next_concert;
}
