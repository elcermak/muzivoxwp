<?php 

// Intégration du fichier avec les appels add_action().
  require_once get_template_directory() . '/include/actions.php';

// Intégration du fichier avec les fonctions de template.
  require_once get_template_directory() . '/include/template-functions.php';
  
 // Intégration du fichier avec les fonctions personnalisé.
 require_once get_template_directory() . '/include/custom-function.php';

//Walker Nav Menu 
  require_once get_template_directory() . '/classes/class-muzivox-walker-menu.php';
  


function wppln_responsive_images( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html ); return $html;
}
add_filter( 'post_thumbnail_html', 'wppln_responsive_images', 10 );
add_filter( 'image_send_to_editor', 'wppln_responsive_images', 10 );
add_filter( 'wp_get_attachment_link', 'wppln_responsive_images', 10 );

?>