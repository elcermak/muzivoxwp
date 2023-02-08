<?php

/**
 * Template Name: agenda
 */

get_header(); ?>

<main>
  
  <div class="container container-flex">

    <!-- <nav>
      <ul>
        <li><a href="?filtre=artiste">Artiste</a></li>
        <li><a href="?filtre=date">Date</a></li>
        <li><a href="?filtre=region">Région</a></li>
      </ul>
    </nav> -->




    <?php

    // echo '<pre>';
    // print_r($_GET);
    // echo '</pre>';

    if ($_GET['filtre'] == "dates") { ?>

      <div class="container-rectangle">
        <div class="btns-filters">
          <a href="?filtre=artistes" class="btn-filter">Artistes</a>
          <a href="?filtre=dates" class="btn-filter">Dates</a>
          <a href="?filtre=regions" class="btn-filter">Régions</a>
        </div>
        <table class="agenda-table">
          <?php
          $args = array(
            'post_type' => 'agenda',
            'posts_per_page' => -1,
            'meta_key' => 'date',
            'orderby' => 'meta_value',
            'order' => 'ASC'
          );

          $artiste_posts = get_posts($args);
          $i = 0;
          $previous_month = '';
          $previous_year = '';
          foreach ($artiste_posts as $post) {

            // Récupération des données du champ "régions"
            $id_regions = get_field('region_concert');

            // Récupération des données du champ "artiste"
            $artiste = get_field('artiste_concert');

            // Récupération des données du champ "ville"
            $ville = get_field('ville');

            // Récupération des données du champ "date"
            $date = get_field('date');

            // Récupération des données du champ "date"
            $is_full = get_field('complet');
            echo $is_full;

            // Affichage des données
            $terms = get_terms(array(
              'taxonomy' => 'region',
              'hide_empty' => false,
            ));
            $taxo = get_the_terms($post->ID, 'region');

            $month = date("m", strtotime($date));
            $year = date("Y", strtotime($date));

            if ($month != $previous_month || $year != $previous_year) { ?>
              <tr class="title_calendar">
                <td>
                  <h3 class="description__title" id="name-filter">
                    <?php
                    dateToString($month);

                    ?>
                  </h3>
                </td>
              </tr>
            <?php
              $previous_month = $month;
              $previous_year = $year;
            } ?>
            <tr>

              <td><?php echo $artiste[0]->post_title; ?> </td>
              <td><?php echo $ville; ?></td>
              <td><?php echo convert_date_format($date); ?></td>
              <td>
                <?php foreach ($terms as $value) {
                  if ($id_regions == $value->term_id) {
                    echo $value->name;
                  }
                } ?>
              </td>
              <td><?php echo ($is_full == 1) ? "Complet" : ""; ?></td> <!-- Si concert complet, alors affiche "Complet" sinon affiche "" -->
            </tr>
          <?php
          }
          ?>
        </table>
      </div>
    <?php
    } else if ($_GET['filtre'] == "regions") { ?>
      <table>
        <?php
        $args = array(
          'post_type' => 'agenda',
          'posts_per_page' => -1,
          'meta_key' => 'region_concert',
          'orderby' => 'meta_value',
          'order' => 'DSC'
        );

        $artiste_posts = get_posts($args);
        $i = 0;
        $previous_region = '';
        foreach ($artiste_posts as $post) {

          // Récupération des données du champ "régions"
          $id_regions = get_field('region_concert');

          // Récupération des données du champ "artiste"
          $artiste = get_field('artiste_concert');

          // Récupération des données du champ "ville"
          $ville = get_field('ville');

          // Récupération des données du champ "date"
          $date = get_field('date');

          // Récupération des données du champ "date"
          $is_full = get_field('complet');

          // Affichage des données
          $terms = get_terms(array(
            'taxonomy' => 'region',
            'hide_empty' => false,
          ));
          $taxo = get_the_terms($post->ID, 'region');

          $month = date("m", strtotime($date));
          $year = date("Y", strtotime($date));
          foreach ($terms as $value) {
            if ($id_regions == $value->term_id) {
              $region = $value->name;
            }
          }
          // echo "<hr>";
          // echo "previous ".$previous_region;
          // echo '<br>';
          // echo "current " .$region;
          // echo "<hr>";


          if ($region != $previous_region) { ?>
            <tr class="title_calendar">
              <td>
                <h2>
                  <?php
                  foreach ($terms as $value) {
                    if ($id_regions == $value->term_id) {
                      $region = $value->name;
                      echo $region;
                    }
                  }
                  ?>
                </h2>
              </td>
            </tr>
          <?php
            $previous_region = $region;
          } ?>



          <tr>

            <td><?php echo $artiste[0]->post_title; ?> </td>
            <td><?php echo $ville; ?></td>
            <td><?php echo $date; ?></td>
            <td>
            <td>
              <?php echo $region; ?>
            </td>
            </td>
            <td><?php echo ($is_full == 1) ? "Complet" : ""; ?></td> <!-- Si concert complet, alors affiche "Complet" sinon affiche "" -->
          </tr>
        <?php
        }
        ?>
      </table>
    <?php
    } else if ($_GET['filtre'] == "artistes") { ?>
      <table>
        <?php
        $args = array(
          'post_type' => 'agenda',
          'posts_per_page' => -1,
          'meta_key' => 'artiste_concert',
          'orderby' => 'meta_value',
          'order' => 'ASC'
        );

        $artiste_posts = get_posts($args);



        $i = 0;
        $previous_artiste = '';
        foreach ($artiste_posts as $post) {


          // Récupération des données du champ "régions"
          $id_regions = get_field('region_concert');

          // Récupération des données du champ "artiste"
          $artiste = get_field('artiste_concert');
          $artiste_name = $artiste[0]->post_title;

          // Récupération des données du champ "ville"
          $ville = get_field('ville');

          // Récupération des données du champ "date"
          $date = get_field('date');

          // Récupération des données du champ "date"
          $is_full = get_field('complet');
          // Affichage des données
          $terms = get_terms(array(
            'taxonomy' => 'region',
            'hide_empty' => false,
          ));

          $month = date("m", strtotime($date));


          if ($artiste_name != $previous_artiste) { ?>
            <tr class="title_calendar">
              <td>
                <h2><?php echo $artiste_name ?></h2>
              </td>
            </tr>
          <?php
            $previous_artiste = $artiste_name;
          } ?>
          <tr>

            <td><?php echo $artiste_name; ?> </td>
            <td><?php echo $ville; ?></td>
            <td><?php echo $date; ?></td>
            <td>
              <?php foreach ($terms as $value) {

                if ($id_regions == $value->term_id) {
                  echo $value->name;
                }
              } ?>
            </td>
            <td><?php echo ($is_full == 1) ? "Complet" : ""; ?></td> <!-- Si concert complet, alors affiche "Complet" sinon affiche "" -->
          </tr>
        <?php
        }
        ?>
      </table>

    <?php
    } else { ?>
      <div class="container-rectangle">
      <div class="btns-filters">
        <a href="?filtre=artistes" class="btn-filter">Artistes</a>
        <a href="?filtre=dates" class="btn-filter">Dates</a>
        <a href="?filtre=regions" class="btn-filter">Régions</a>
      </div>
      <table class="agenda-table">
        <?php
        $args = array(
          'post_type' => 'agenda',
          'posts_per_page' => -1,
          'meta_key' => 'date',
          'orderby' => 'meta_value',
          'order' => 'ASC'
        );

        $artiste_posts = get_posts($args);
        $i = 0;
        $previous_month = '';
        $previous_year = '';
        foreach ($artiste_posts as $post) {

          // Récupération des données du champ "régions"
          $id_regions = get_field('region_concert');

          // Récupération des données du champ "artiste"
          $artiste = get_field('artiste_concert');

          // Récupération des données du champ "ville"
          $ville = get_field('ville');

          // Récupération des données du champ "date"
          $date = get_field('date');

          // Récupération des données du champ "date"
          $is_full = get_field('complet');
          echo $is_full;

          // Affichage des données
          $terms = get_terms(array(
            'taxonomy' => 'region',
            'hide_empty' => false,
          ));
          $taxo = get_the_terms($post->ID, 'region');

          $month = date("m", strtotime($date));
          $year = date("Y", strtotime($date));

          if ($month != $previous_month || $year != $previous_year) { ?>
            <tr class="title_calendar">
              <td>
                <h3 class="description__title" id="name-filter">
                  <?php
                  dateToString($month);

                  ?>
                </h3>
              </td>
            </tr>
          <?php
            $previous_month = $month;
            $previous_year = $year;
          } ?>
          <tr>

            <td><?php echo $artiste[0]->post_title; ?> </td>
            <td><?php echo $ville; ?></td>
            <td><?php echo convert_date_format($date); ?></td>
            <td>
              <?php foreach ($terms as $value) {
                if ($id_regions == $value->term_id) {
                  echo $value->name;
                }
              } ?>
            </td>
            <td><?php echo ($is_full == 1) ? "Complet" : ""; ?></td> <!-- Si concert complet, alors affiche "Complet" sinon affiche "" -->
          </tr>
        <?php
        }
        ?>
      </table>
    </div>
  <?php

    }
    ?>
  </div>
</main>
<?php get_footer(); ?>