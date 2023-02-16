<?php
/**
 * Template Name: espace pro
 */
get_header();


// Vérifier si l'utilisateur est connecté
if (!is_user_logged_in()) {
  // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
  wp_redirect(wp_login_url(get_permalink()));
  exit;
}

// Récupérer l'utilisateur connecté
$current_user = wp_get_current_user();

// Récupérer tous les custom post types "espace_pro" accessibles pour l'utilisateur
$args = array(
  'post_type' => 'espace_pro',
  'author' => $current_user->ID,
  'posts_per_page' => -1
);
$espace_pros = new WP_Query($args);

// Vérifier si des custom post types "espace_pro" ont été trouvés
if ($espace_pros->have_posts()) :
  while ($espace_pros->have_posts()) : $espace_pros->the_post();

      // Récupérer les artistes associés à chaque custom post type "espace_pro"
      $artistes = get_field('artistes_associes', get_the_ID());

      // Afficher le titre du custom post type "espace_pro"
      the_title('<h2>', '</h2>');

      // Afficher la liste des artistes associés à ce custom post type "espace_pro"
      if ($artistes) :
          echo '<ul>';
          foreach ($artistes as $artiste) :
              echo '<li>' . $artiste->post_title . '</li>';
          endforeach;
          echo '</ul>';
      endif;

  endwhile;

  // Réinitialiser la requête
  wp_reset_postdata();

else :

  // Aucun custom post type "espace_pro" n'a été trouvé
  echo '<p>Aucun espace pro n\'est disponible pour cet utilisateur.</p>';

endif;

get_footer(); ?>