<?php 

// Intégration du fichier avec les appels add_action().
  require_once get_template_directory() . '/include/actions.php';

// Intégration du fichier avec les fonctions de template.
  require_once get_template_directory() . '/include/template-functions.php';
  
 // Intégration du fichier avec les fonctions personnalisé.
 require_once get_template_directory() . '/include/custom-function.php';

//Walker Nav Menu 
  require_once get_template_directory() . '/classes/class-muzivox-walker-menu.php';
  