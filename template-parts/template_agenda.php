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
      $month = date('F', $concert['date']);
      $date_formatted = date('Y/m/d', $concert['date']);

      $date_obj = DateTime::createFromFormat('Y/m/d', $date_formatted);
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $concert_date_formatted =  strftime('%a %d %b %Y', $date_obj->getTimestamp());

      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['col1'] = $concert['salle'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['col2'] = $concert['ville'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['col3'] = $concert['region'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['lien_reservation'] = $concert['lien_reservation'];
      $concertFomated[$concert['artiste_name']][$concert_date_formatted]['is_full'] = $concert['is_full'];
    }
  } else if ($filtre == "regions") {
    foreach ($concertsSorted as $concert) {
      $month = date('F', $concert['date']);
      $date_formatted = date('Y/m/d', $concert['date']);

      $date_obj = DateTime::createFromFormat('Y/m/d', $date_formatted);
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $concert_date_formatted =  strftime('%a %d %b %Y', $date_obj->getTimestamp());

      $concertFomated[$concert['region']][$concert_date_formatted]['col1'] = $concert['artiste_name'];
      $concertFomated[$concert['region']][$concert_date_formatted]['col2'] = $concert['ville'];
      $concertFomated[$concert['region']][$concert_date_formatted]['col3'] = $concert['salle'];
      $concertFomated[$concert['region']][$concert_date_formatted]['lien_reservation'] = $concert['lien_reservation'];
      $concertFomated[$concert['region']][$concert_date_formatted]['is_full'] = $concert['is_full'];
    }
  } else {
    foreach ($concertsSorted as $concert) {
      $month = date('F', $concert['date']);
      $date_formatted = date('Y/m/d', $concert['date']);

      $date_obj = DateTime::createFromFormat('Y/m/d', $date_formatted);
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $concert_date_formatted =  strftime('%a %d %b %Y', $date_obj->getTimestamp());


      $concertFomated[$month][$concert_date_formatted]['col1'] = $concert['artiste_name'];
      $concertFomated[$month][$concert_date_formatted]['col2'] = $concert['ville'];
      $concertFomated[$month][$concert_date_formatted]['col3'] = $concert['salle'];
      $concertFomated[$month][$concert_date_formatted]['col3'] = $concert['region'];
      $concertFomated[$month][$concert_date_formatted]['lien_reservation'] = $concert['lien_reservation'];
      $concertFomated[$month][$concert_date_formatted]['is_full'] = $concert['is_full'];
    }
  }

  // echo'<pre style="color:white">';
  // print_r($concertFomated);
  // echo'</pre>';
  return $concertFomated;
}

?>


<?php get_header(); ?>

<main>

  <div class="container container-flex">
    <div class="container-rectangle">
      <div class="btns-filters">
        <a href="?filtre=artistes" class="btn-filter">Artistes</a>
        <a href="?filtre=dates" class="btn-filter">Dates</a>
        <a href="?filtre=regions" class="btn-filter">Régions</a>
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

              <td><?php echo $infoConcert['col1']; ?></td>
              <td><?php echo $infoConcert['col2']; ?></td>
              <td><?php echo $infoConcert['col3']; ?></td>
              <?php
              if ($_GET['filtre'] == 'dates' || !empty($_GET)) { ?>

                <td><?php echo $infoConcert['col4']; ?></td>
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
                      <!-- <a href="ajouter_evenement.php?date=2023-02-25">
                        <i class="fa fa-calendar logo_agenda"></i>
                      </a> -->
                        
                      [add-to-calendar-button name="Title" options="'Apple','Google'" startDate="2023-02-27"]
                    </div>
                    <div class="agenda__concert--booked">
                      <a target="_blank" href="<?php echo $infoConcert['lien_reservation']; ?>">
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