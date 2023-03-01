<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="font-awesome/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header>
  <div id="menu">
    <!-- debut du menu -->
    <div class="header">
    <div id="menu-bar" onclick="menuOnClick()">
        <div id="bar1" class="bar"></div>
        <div id="bar2" class="bar"></div>
        <div id="bar3" class="bar"></div>
      </div>
      <?php
        $image_id = 21; 
        $image = wp_get_attachment_image_src($image_id, 'full');
        $image_url = $image[0];
      ?>
      <img src="<?php echo $image_url; ?>" alt="Description de l'image" class="logo-bg">
      </div>
      <nav class="header__menu menu" id="mainNav" aria-label="Menu principal">

      <?php 
          wp_nav_menu( array(
            'theme_location' => 'header',
            'container' => false,
            'menu_class' => 'menu__list',
            'walker' => new MyCustom_Walker_Nav_Menu(),
          ) );
        ; ?>
        
      <!-- fin du menu -->
        

        <?php
        wp_nav_menu(array(
          'theme_location' => 'header',
          'container' => false,
          'menu_class' => 'menu__list',
          'walker' => new MyCustom_Walker_Nav_Menu(),

        )); ?>

        <!-- fin du menu -->


        ));; ?>

        <!-- fin du menu -->


      </nav>
    
    </div>
    
    <div class="menu-bg" id="menu-bg"></div>
  </header>

</body>

<script src="<?php echo get_template_directory_uri() . "/dist/headerResponsive.js" ?>"></script>

</html>