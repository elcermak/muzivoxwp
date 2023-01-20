<?php 

  function muzivox_setup() {
    // permet aux plugins et aux thèmes de gérer la balise de titre du document.
    add_theme_support('title-tag');

    // permet la prise en charge des images mises en avant.
    add_theme_support( 'post-thumbnails' );

    // permet de rendre le code valide pour HTML5.
    add_theme_support( 
      'html5', 
      array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'style',
        'script'
      )
    );

    // Désactive les tailles de police et couleurs pour Gutenberg
    // add_theme_support( 'disable-custom-colors' );
    // add_theme_support( 'disable-custom-gradients' );
    // add_theme_support( 'editor-font-sizes' );
    // add_theme_support( 'editor-color-palette' );

    /**
     * permet la prise en charge d'un logo personnalisé.
     * @link https://developer.wordpress.org/themes/functionality/custom-logo/
     */
    add_theme_support( 'custom-logo', array(
      'height'      => 250,
      'width'       => 250,
      'flex-height' => true,
      'flex-width'  => true,
    ) );

    /**
     * Enregistre la prise en charge de certaines fonctionnalités pour un type de publication.
     * @link https://developer.wordpress.org/reference/functions/add_post_type_support/
     */
    // permet la prise en charge des extraits.
    add_post_type_support( 'page', 'excerpt' );

    /**
     * La fonction add_image_size permet de définir de nouvelles tailles d'image
     * @link https://developer.wordpress.org/reference/functions/add_image_size/
     */

    add_image_size( 'square', 1024, 1024, true );
    add_image_size( 'paysage', 1024, 680, true );
  }

 
  function muzivox_scripts_styles() {
    wp_enqueue_style( 'muzivox-style', get_template_directory_uri() . '/dist/styles.css' );
    wp_enqueue_script('muzivox-script', get_template_directory_uri() . '/dist/scripts.js',  array(), '', true  );
    wp_enqueue_script('savoir_plus', get_template_directory_uri() . '/dist/savoirPlus.js',  array(), '', true  );
    wp_enqueue_script('gallerie_artiste', get_template_directory_uri() . '/dist/gallerieArtiste.js',  array(), '', true  );

  }
  

  function muzivox_register_menus() {
    register_nav_menus( array(
      'header' => 'Menu principal',
      'footer' => 'Menu secondaire'
    ) );
  }
  
  function single_template_for_artiste( $template ) {
    if ( is_singular( 'artiste' ) ) {
        $template = locate_template( 'template-parts/single-artiste.php' );
    }
    return $template;
}
