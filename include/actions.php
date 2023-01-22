<?php

  // Initialisation des fonctions personnalisées du thème.
  add_action('after_setup_theme', 'muzivox_setup');

  // File d'attente des styles et des scripts
  add_action('wp_enqueue_scripts', 'muzivox_scripts_styles');
  
  // Register the menu locations
  add_action('init', 'muzivox_register_menus');
  
  add_filter( 'single_template', 'single_template_for_artiste' );
