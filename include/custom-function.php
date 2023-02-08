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

/**
 * Cette fonction prend en entrée une date au le format "YYYY/MM/DD" et la convertit en date au format ('D d M Y') et traduit en Francais
 * @param date $dateRaw  date au le format "YYYY/MM/DD" 
 * @return date $convertDate date au format ('D d M Y')
 */
function convert_date_format($rawDate)
{
	// définition des traductions anglais/francais des jours et mois dans un tableau associatif
	$fr_days = array(
		'Monday' => 'Lundi',
		'Tuesday' => 'Mardi',
		'Wednesday' => 'Mercredi',
		'Thursday' => 'Jeudi',
		'Friday' => 'Vendredi',
		'Saturday' => 'Samedi',
		'Sunday' => 'Dimanche'
	);
	$fr_months = array(
		'January' => 'Janvier',
		'February' => 'Février',
		'March' => 'Mars',
		'April' => 'Avril',
		'May' => 'Mai',
		'June' => 'Juin',
		'July' => 'Juillet',
		'August' => 'Août',
		'September' => 'Septembre',
		'October' => 'Octobre',
		'November' => 'Novembre',
		'December' => 'Décembre'
	);

	$date = date_create($rawDate);
	$day = date_format($date, 'l'); // récupère le jour de la date
	$month = date_format($date, 'F'); // récupère le mois de la date
	$day_number = date_format($date, 'd'); // conbertit le jour en nombre
	$year = date_format($date, 'Y'); // récupère l'année de la date
	$converted_date = $fr_days[$day] . ' ' . $day_number . ' ' . $fr_months[$month] . ' ' . $year; // création de la chaine de caractère de la date en Francais
	return $converted_date;
}


function dateToString($month)
{
	switch ($month) {
		case '01':
			echo "Janvier";
			break;
		case '02':
			echo "Février";
			break;
		case '03':
			echo "Mars";
			break;
		case '04':
			echo "Avril";
			break;
		case '05':
			echo "Mai";
			break;
		case '06':
			echo "Juin";
			break;
		case '07':
			echo "Juillet";
			break;
		case '08':
			echo "Août";
			break;
		case '09':
			echo "Septembre";
			break;
		case '10':
			echo "Octobre";
			break;
		case '11':
			echo "Novembre";
			break;
		case '12':
			echo "Décembre";
			break;
		default:
			echo "error";
			break;
	}
}
