<?php

  // Initialisation des fonctions personnalisées du thème.
  add_action('after_setup_theme', 'muzivox_setup');

  // File d'attente des styles et des scripts
  add_action('wp_enqueue_scripts', 'muzivox_scripts_styles');
  
  // Register the menu locations
  add_action('init', 'muzivox_register_menus');
  
  add_filter( 'single_template', 'single_template_for_artiste' );


if(isset($_POST['login-submit'])) {
  $username = $_POST['username'];
  $password = $_POST['pass'];

  $user = wp_authenticate($username, $password);

  if(is_wp_error($user)) {
    // Si les informations de connexion sont incorrectes, affichez un message d'erreur
    echo "<p>Les informations de connexion sont incorrectes. Veuillez réessayer.</p>";
  } else {
    // Si les informations de connexion sont correctes, connectez l'utilisateur
    wp_set_current_user($user->ID, $username);
    wp_set_auth_cookie($user->ID);
    do_action('wp_login', $username);
    // Rediriger l'utilisateur vers la page d'accueil ou toute autre page souhaitée
    wp_redirect(site_url('/espace-pro/'));
    exit;
  }
}


