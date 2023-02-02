<?php

/**
 * Template Name: agenda
 */

get_header(); ?>

<table>
  <?php
  $args = array(
    'post_type' => 'agenda',
    'posts_per_page' => -1,
    'meta_key' => 'date',
    'orderby' => 'meta_value',
    'order' => 'ASC'
  );


  $artiste_posts = get_posts($args);
  echo '<pre>';
  print_r($artiste_posts);
  echo '</pre>';
  $i = 0;
  foreach ($artiste_posts as $post) {
    // Récupération des données du champ "régions"
    $id_regions = get_field('region_concert');

    // Récupération des données du champ "artiste"
    $artiste = get_field('artiste_concert');

    // Récupération des données du champ "ville"
    $ville = get_field('ville');

    // Récupération des données du champ "date"
    $date = get_field('date');


    // Affichage des données
    $terms = get_terms(array(
      'taxonomy' => 'region',
      'hide_empty' => false,
    ));
    $taxo = get_the_terms($post->ID, 'region');




  ?>
    <tr>

      <td><?php echo $artiste[0]->post_title; ?> </td>
      <td><?php echo $ville; ?></td>
      <td><?php echo $date; ?></td>
      <td><?php foreach ($terms as $value) {
            if ($id_regions == $value->term_id) {
              echo $value->name;
            }
          } ?></td>
    </tr>

  <?php
  }
  ?>
</table <?php get_footer();
