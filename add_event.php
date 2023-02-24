<?php

require_once 'vendor/autoload.php'; // Charge les bibliothèques Google

// Initialise le client Google
$client = new Google_Client();
$client->setApplicationName("Mon application");
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setAuthConfig('chemin/vers/fichier/identifiant.json'); // Chemin vers votre fichier d'identification
$client->setAccessType('offline');

// Récupère le jeton d'accès
$token = '375106286224-offsvsb56m1oq4gki7ie7r5rldob4ldt.apps.googleusercontent.com';
$client->setAccessToken($token);

// Crée l'événement
$service = new Google_Service_Calendar($client);

$event = new Google_Service_Calendar_Event();
$event->setSummary('Nom de l\'événement');
$event->setLocation('Lieu de l\'événement');
$start = new Google_Service_Calendar_EventDateTime();
$start->setDateTime('2023-02-25T10:00:00+01:00'); // Début de l'événement
$start->setTimeZone('Europe/Paris');
$event->setStart($start);
$end = new Google_Service_Calendar_EventDateTime();
$end->setDateTime('2023-02-25T12:00:00+01:00'); // Fin de l'événement
$end->setTimeZone('Europe/Paris');
$event->setEnd($end);

$event = $service->events->insert('primary', $event);

// Affiche le lien vers l'événement créé
echo 'L\'événement a été ajouté à votre calendrier : ' . $event->htmlLink;

?>
