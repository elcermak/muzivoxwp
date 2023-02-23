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
      'meta_query' => array(
        'relation' => 'OR',
        array(
          'key' => 'artiste_concert',
          'compare' => 'EXISTS',
        ),
        array(
          'key' => 'date',
          'compare' => 'EXISTS',
        ),
      ),
      'orderby' => array(
        'meta_value' => 'ASC',
        'date_concert' => 'ASC',
      ),
    );
  } else {
    echo "<br><br><br><br>";
    echo 'test';
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


  if ($filtre == "artistes") {
    foreach ($concerts as $concert) {
      $concert_date = strtotime($concert['date']); // convertir la date en timestamp
      $now = time(); // timestamp de la date actuelle

      if ($concert_date >= $now) { // ne pas inclure les concerts passés
        $concertFomated[$concert['artiste_name']][$concert['date']]['ville'] = $concert['ville'];
        $concertFomated[$concert['artiste_name']][$concert['date']]['salle'] = $concert['salle'];
        $concertFomated[$concert['artiste_name']][$concert['date']]['region'] = $concert['region'];
        $concertFomated[$concert['artiste_name']][$concert['date']]['lien_reservation'] = $concert['lien_reservation'];
        $concertFomated[$concert['artiste_name']][$concert['date']]['is_full'] = $concert['is_full'];
      }
    }


    foreach ($concertFomated as $artiste => $concertDates) {
      ksort($concertDates);
      $concertFomated[$artiste] = $concertDates;
    }
  }
  echo '<pre style="color:green">';
  print_r($concerts);
  echo '</pre>';
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

        $total_concerts = count($concerts);
        $current_concert_index = 1;
        $concertFomated = formatConcerts($concerts, "artistes");
        echo '<pre style="color:white;">';
        print_r($concertFomated);
        echo '</pre>';
        foreach ($concerts as $concert) {
          if ($_GET['filtre'] == "artistes") {

            $date_obj = DateTime::createFromFormat('Y/m/d', $concert['date']);
            setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
            $col1 = strftime('%a %d %b %Y', $date_obj->getTimestamp());

            $col2 = $concert['salle'];
            $col3 = $concert['ville'];
            $col4 = $concert['region'];
            $title = $concert['artiste_name'];

            if ($title != $previous_filter) {
              $filtreTitle = true;
            } else {
              $filtreTitle = false;
            }
          } else if ($_GET['filtre'] == "regions") {
            $col1 = $concert['ville'];

            $date_obj = DateTime::createFromFormat('Y/m/d', $concert['date']);
            setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
            $col2 = strftime('%a %d %b %Y', $date_obj->getTimestamp());

            $col3 = $concert['artiste_name'];
            $col4 = $concert['salle'];
            $title = $concert['region'];
            if ($title != $previous_filter) {
              $filtreTitle = true;
            } else {
              $filtreTitle = false;
            }
          } else {
            $previous_month = '';
            $previous_year = '';

            $date_obj = DateTime::createFromFormat('Y/m/d', $concert['date']);
            setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
            $month =  strftime('%B', $date_obj->getTimestamp());

            $year = date("Y", strtotime($concert['date']));

            if ($month != $previous_month || $year != $previous_year) {
              $filtreTitle = true;
            } else {
              $filtreTitle = false;
            }
            $col1 = $concert['artiste_name'];
            $col2 = $concert['salle'];
            $col3 = $concert['ville'];
            $col4 = $concert['region'];

            $date_obj = DateTime::createFromFormat('Y/m/d', $concert['date']);
            setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
            $col5 = strftime('%a %d %b %Y', $date_obj->getTimestamp());

            echo $month;
            $title = $month;
          }
          // echo "<p style='color:white'>$key</p>";
          // echo '<pre style="color:white">';
          // print_r($concert);
          // echo '</pre>';
          // echo '<hr>';
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

          <tr class="agenda_tr" <?php if ($current_concert_index != $total_concerts) { ?>style="border-bottom: 1px solid #FF6B00;" <?php } ?>>
            <td><?php echo $col1; ?></td>
            <td><?php echo $col5; ?></td>
            <td><?php echo $col2; ?></td>
            <td><?php echo $col3; ?></td>
            <td><?php echo $col4; ?></td>
            <td><?php
                if ($concert['is_full'] == 1) { ?>
                <div class='btn-full'>Complet</div>
              <?php

                } else { ?>
                <div class="flexbox justify_center">
                  <div class="agenda__concert--booked">
                    <a href="#">
                      <i class="fa fa-calendar logo_agenda"></i>
                    </a>
                  </div>
                  <div class="agenda__concert--booked">
                    <a target="_blank" href="<?php echo $concert['lien_reservation']; ?>">
                      <i class="fa fa-ticket logo_agenda"></i>
                    </a>
                  </div>

                </div>
              <?php
                } ?>
            </td> <!-- Si concert complet, alors affiche "Complet" sinon affiche "" -->
          </tr>
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