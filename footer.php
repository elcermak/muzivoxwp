</main>
<footer>
<nav class="header__menu menu" id="mainNav" aria-label="Menu secondaire">
      <?php 
          wp_nav_menu( array(
            'theme_location' => 'footer',
            'container' => false,
            'menu_class' => 'menu__list',

          ) );


          $logoFooter = get_field('logo_footer');
          echo $logoFooter;
        ; ?>




<!-- <div class="footer__logo center">
<img src="http://localhost:8888/muzivox_jm/wp-content/uploads/2023/01/etoile_grise.png" class="style-svg"/>

</div> -->
      <!-- <ul>
        <li><a href="#">Conditions Générales de ventes</a></li>
        <li><a href="#">Mentions Legales</a></li>
        <li>© Copyright tous droits reserves a Muzivox </li>
      </ul>
    </nav>
    <img src="/image/etoile_grise.png" alt="">
    <nav class="nav_end">
      <ul>
        <li><a href="#">Politique de confidentialite</a></li>
        <li><a href="#">Conditions generales d’utilisation</a></li>
        <li><a href="#">Plan du site</a></li>
      </ul>
    </nav> -->
    <div class="media">
      <i class="fa fa-facebook" aria-hidden="true"></i>
      <i class="fa fa-twitter" aria-hidden="true"></i>
    </div>
  </footer>
<?php wp_footer(); ?>
</body>
</html>