<?php

/**
 * Template Name: agenda
 */

function getInfoAgenda($filter)
{
  $meta_key = $filter;
  if ($filter == 'region_concert') {
    $args = array(
      'post_type' => 'agenda',
      'posts_per_page' => -1,
      'meta_key' => $meta_key,
      'orderby' => array(
        'meta_value' => 'ASC',
        'slug' => 'ASC'
      )
    );
  } else if ($filter == 'artiste_concert') {
    $args = array(
      'post_type' => 'agenda',
      'posts_per_page' => -1,
      'meta_key' => 'artiste_concert',
      'orderby' => 'meta_value',
      'order' => 'ASC'
    );
  } else {
    $args = array(
      'post_type' => 'agenda',
      'posts_per_page' => -1,
      'meta_key' =>   $meta_key,
      'orderby' => 'meta_value',
      'order' => 'ASC'
    );
  }

  $concerts = get_posts($args);

  foreach ($concerts as $key => $concert) {

    // Récupération des données du champ "régions"
    $id_regions = get_field('region_concert', $concert->ID);
    $terms = get_terms(array(
      'taxonomy' => 'region',
      'hide_empty' => false,
    ));
    foreach ($terms as $value) {

      if ($id_regions == $value->term_id) {
        $region = $value->name;
      }
    }
    // Récupération des données du champ "artiste"

    $artiste = get_field('artiste_concert', $concert->ID);

    $artiste_name = $artiste[0]->post_title;

    // Récupération des données du champ "ville"
    $ville = get_field('ville', $concert->ID);
    // print_r(get_field('artiste_concert', $concert->ID));

    // Récupération des données du champ "date"
    $date = get_field('date', $concert->ID);
    // Récupération des données du champ "complet"
    $is_full = get_field('complet', $concert->ID);
    $reservation_link = get_field('lien_reservation', $concert->ID);

    // Récupération des données du champ "salle"
    $salle = get_field('salle_de_concert', $concert->ID);

    $infoConcert[$key]['artiste_name'] = $artiste_name;
    $infoConcert[$key]['ville'] = $ville;
    $infoConcert[$key]['date'] = $date;
    $infoConcert[$key]['region'] = $region;
    $infoConcert[$key]['salle'] = $salle;
    $infoConcert[$key]['lien_reservation'] = $reservation_link;
    $infoConcert[$key]['is_full'] = $is_full;
  }

  return $infoConcert;
}
if ($_GET['filtre'] == "artistes") {
  $concerts = getInfoAgenda('artiste_concert');
} else if ($_GET['filtre'] == "regions") {
  $concerts = getInfoAgenda('region_concert');
} else {
  $concerts = getInfoAgenda('date');
}

function formatConcerts($concerts, $filtre)
{
  $concertsSorted = array();



  foreach ($concerts as $concert) {
    $concert_date = strtotime($concert['date']); // convertir la date en timestamp
    $now = time(); // timestamp de la date actuelle

    if ($concert_date >= $now) { // ne pas inclure les concerts passés
      $concertsSorted[] = array(
        'artiste_name' => $concert['artiste_name'],
        'date' => $concert_date,
        'ville' => $concert['ville'],
        'salle' => $concert['salle'],
        'region' => $concert['region'],
        'lien_reservation' => $concert['lien_reservation'],
        'is_full' => $concert['is_full']
      );
    }
  }

  // trier par ordre alphabétique de l'artiste, puis par date
  usort($concertsSorted, function ($a, $b) {
    if ($a['artiste_name'] === $b['artiste_name']) {
      return $a['date'] - $b['date'];
    }
    return strcmp($a['artiste_name'], $b['artiste_name']);
  });

  $concertFomated = array();

  if ($filtre == "artistes") {
    foreach ($concertsSorted as $concert) {
      $date_unformatted = date('Ymd', $concert['date']);
      $hour_unformatted = date('H:i', $concert['date']);
      $date_formatted = date('Y/m/d H:i', $concert['date']);
      $date_obj = DateTime::createFromFormat('Y/m/d H:i', $date_formatted);
      $concert_date_formatted = $date_obj->format('%a %d %b %Y');
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $concert_date_formatted = strftime('%a %d %b %Y à %HH%M', $date_obj->getTimestamp());

      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['salle'] = $concert['salle'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['date_unformated'] = $date_unformatted;
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['hour_unformated'] = $hour_unformatted;
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['ville'] = $concert['ville'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['region'] = $concert['region'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['lien_reservation'] = $concert['lien_reservation'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['is_full'] = $concert['is_full'];
    }
  } else if ($filtre == "regions") {
    foreach ($concertsSorted as $concert) {
      $date_unformatted = date('Ymd', $concert['date']);
      $hour_unformatted = date('H:i', $concert['date']);
      $date_formatted = date('Y/m/d H:i', $concert['date']);
      $date_obj = DateTime::createFromFormat('Y/m/d H:i', $date_formatted);
      $concert_date_formatted = $date_obj->format('%a %d %b %Y');
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $concert_date_formatted = strftime('%a %d %b %Y à %HH%M', $date_obj->getTimestamp());

      $concertFomated[$concert['region']][$concert_date_formatted]['artiste_name'] = $concert['artiste_name'];
      $concertFomated[$concert['region']][$concert_date_formatted]['date_unformated'] = $date_unformatted;
      $concertFomated[$concert['region']][$concert_date_formatted]['hour_unformated'] = $hour_unformatted;
      $concertFomated[$concert['region']][$concert_date_formatted]['ville'] = $concert['ville'];
      $concertFomated[$concert['region']][$concert_date_formatted]['salle'] = $concert['salle'];
      $concertFomated[$concert['region']][$concert_date_formatted]['lien_reservation'] = $concert['lien_reservation'];
      $concertFomated[$concert['region']][$concert_date_formatted]['is_full'] = $concert['is_full'];
    }
  } else {
    foreach ($concertsSorted as $concert) {
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $month = strftime('%B', $concert['date']);
      $date_unformatted = date('Ymd', $concert['date']);
      $hour_unformatted = date('H:i', $concert['date']);
      $date_formatted = date('Y/m/d H:i', $concert['date']);
      $date_obj = DateTime::createFromFormat('Y/m/d H:i', $date_formatted);
      $concert_date_formatted = $date_obj->format('%a %d %b %Y');
      $concert_date_formatted = strftime('%a %d %b %Y à %HH%M', $date_obj->getTimestamp());


      $concertFomated[$month][$concert_date_formatted]['artiste_name'] = $concert['artiste_name'];
      $concertFomated[$month][$concert_date_formatted]['date_unformated'] = $date_unformatted;
      $concertFomated[$month][$concert_date_formatted]['hour_unformated'] = $hour_unformatted;
      $concertFomated[$month][$concert_date_formatted]['ville'] = $concert['ville'];
      $concertFomated[$month][$concert_date_formatted]['salle'] = $concert['salle'];
      $concertFomated[$month][$concert_date_formatted]['region'] = $concert['region'];
      $concertFomated[$month][$concert_date_formatted]['lien_reservation'] = $concert['lien_reservation'];
      $concertFomated[$month][$concert_date_formatted]['is_full'] = $concert['is_full'];
    }
  }

  return $concertFomated;
}

?>


<?php get_header(); ?>

<main>

  <div class="container container-flex">
    <div class="container-rectangle " id="background-none">
      <div class="btns-filters">
        <a href="?filtre=artistes" class="btn-filter" title="Filtrez par artistes">Artistes</a>
        <a href="?filtre=dates" class="btn-filter" title="Filtrez par dates">Dates</a>
        <a href="?filtre=regions" class="btn-filter" title="Filtrez par régions">Régions</a>
      </div>
      <table class="agenda-table">
        <?php
        $previous_filter = '';


        $current_concert_index = 1;
        $concertFomated = formatConcerts($concerts, $_GET['filtre']);
        $total_concerts = count($concertFomated);
        foreach ($concertFomated as $keyTitle => $concerts) {
          $title = $keyTitle;

          foreach ($concerts as $keyDate => $infoConcert) {
            if ($title != $previous_filter) {
              $filtreTitle = true;
            } else {
              $filtreTitle = false;
            }

            if ($filtreTitle) { ?>
              <tr class="title_calendar" style=" border-bottom: none;">
                <td colspan="5">
                  <h3 class="description__title" id="name-filter">
                    <?php
                    echo $title;
                    ?>
                  </h3>
                </td>
              </tr>
            <?php
              $previous_filter = $title;
            } ?>
            <tr class="agenda_tr" <?php if ($current_concert_index != $total_concerts) { ?> style="border-bottom: 1px solid #FF6B00;" <?php } ?>>
              <td><?php echo $keyDate; ?></td>

              <?php
              if ($_GET['filtre'] == 'artistes') {
                $col1 = $infoConcert['salle'];
                $col2 = $infoConcert['ville'];
                $col3 = $infoConcert['region'];
              } else if ($_GET['filtre'] == 'regions') {
                $col1 = $infoConcert['artiste_name'];
                $col2 = $infoConcert['ville'];
                $col3 = $infoConcert['salle'];
              } else {
                $col1 = $infoConcert['artiste_name'];
                $col2 = $infoConcert['ville'];
                $col3 = $infoConcert['salle'];
                $col4 = $infoConcert['region'];
              }
              ?>

              <td><?php echo $col1; ?></td>
              <td><?php echo $col2; ?></td>
              <td><?php echo $col3; ?></td>
              <?php
              if ($_GET['filtre'] == 'dates' || !empty($_GET)) { ?>

                <td><?php echo $col4; ?></td>
              <?php
              }
              ?>
              <td><?php
                  if ($infoConcert['is_full'] == 1) { ?>
                  <div class='btn-full'>Complet</div>
                <?php

                  } else { ?>
                  <div class="flexbox justify_center">
                    <div class="agenda__concert--booked">
                      <?php
                      // $timestamp = strtotime($infoConcert['date_unformated']);
                      // https://stackoverflow.com/questions/10488831/link-to-add-to-google-calendar/21653600#21653600?newreg=8dbf44232293488791af87ee82b26974

                      $heure_locale = $infoConcert['hour_unformated'];
                      $date_locale = $infoConcert['date_unformated'];
                      // Fuseau horaire local
                      $timezone = new DateTimeZone('Europe/Paris');

                      // Création d'un objet DateTime à partir de la date et l'heure locale
                      $date_locale_obj = DateTime::createFromFormat('Ymd H:i', $date_locale . ' ' . $heure_locale, $timezone);

                      // Conversion en UTC
                      $date_utc = $date_locale_obj->format('Ymd\THis');

                      $lien = "http://www.google.com/calendar/render?action=TEMPLATE" .
                        "&text=Concert de " . $infoConcert['artiste_name'] .
                        "&dates=" . $date_utc . "/" . $date_utc . "" .
                        "&details=Retrouvez " . $infoConcert['artiste_name'] . " pour son concert!" .
                        "&location=" . $infoConcert['region'] . ", " . $infoConcert['ville'] . ", " . $infoConcert['salle'] .
                        "&trp=false" .
                        "&sprop=" .
                        "&sprop=name:";
                      ?>

                      <a href="<?php echo $lien; ?>" target="_blank" rel="nofollow" title="Ajouter la date à votre google Agenda">
                        <i class="fa fa-calendar logo_agenda"></i>
                      </a>
                    </div>
                    <div class="agenda__concert--booked">
                      <a target="_blank" href="<?php echo $infoConcert['lien_reservation']; ?>" title="Reservez votre billet">
                        <i class="fa fa-ticket logo_agenda"></i>
                      </a>
                    </div>

                  </div>
                <?php
                  } ?>
              </td>
            </tr>
          <?php
          }
          $title = $keyTitle;

          ?>
        <?php
          $current_concert_index++;
        }
        ?>
      </table>
    </div>
  </div>
</main>

<?php getInfoAgenda("date") ?>
<?php get_footer(); ?>