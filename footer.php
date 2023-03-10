</main>
<footer>


  <div class="grid-footer-container">
    <div class="grid-item-footer">
      <nav class="footer-menu-left" aria-label="Menu secondaire gauche">
        <?php wp_nav_menu(array(
          'theme_location' => 'footer_left',
          'container' => false,
          'menu_class' => 'menu_footer_1',
        )); ?>
      </nav>
    </div>

    <div class="grid-item-footer-image">

    </div>

    <div class="grid-item-footer">
      <nav class="footer-menu-right" aria-label="Menu secondaire droit ">
        <?php wp_nav_menu(array(
          'theme_location' => 'footer_right',
          'container' => false,
          'menu_class' => 'menu_footer_2',
        ));

        ?>
      </nav>
    </div>

    <?php
    $mySocialMedia = array(
      'post_type' => 'information_muzivox',
      'post_per_page' => -1,
    );


    // Exécuter la wp query
    $my_query = new WP_Query($mySocialMedia);


    if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
        $arraySocialMedia['facebook'] = get_field('facebook');
        $arraySocialMedia['twitter'] = get_field('twitter');
        $arraySocialMedia['chaine_youtube'] = get_field('chaine_youtube');
      endwhile;
    // usort($arrayConcerts, "cmp");
    endif;
    ?>

    <div class="grid-item-footer footer-media">
      <div class="media">
        <?php
        if (!empty($arraySocialMedia['facebook'])) { ?>
          <a href="<?php echo $arraySocialMedia['facebook'] ; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <?php
        }

        if (!empty($arraySocialMedia['twitter'])) { ?>
          <a href="<?php echo $arraySocialMedia['twitter'] ; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        <?php
        }

        if (!empty($arraySocialMedia['chaine_youtube'])) { ?>
          <a href="<?php echo $arraySocialMedia['chaine_youtube'] ; ?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>