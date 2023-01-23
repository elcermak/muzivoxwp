</main>
<footer>

<footer>
  <div class="grid-footer-container">
  <div class="grid-item-footer">
       <nav class="footer-menu-left" aria-label="Menu secondaire gauche">
        <?php wp_nav_menu( array( 
           'theme_location' => 'footer_left',
           'container' => false,
           'menu_class' => 'menu_footer_1',) ); ?>
      </nav>
    </div>


        </div>

    <div class="grid-item-footer">
        <nav class="footer-menu-right" aria-label="Menu secondaire droit ">
        <?php wp_nav_menu( array( 
          'theme_location' => 'footer_right',
          'container' =>false,
          'menu_class' => 'menu_footer_2', ) ); 
    
  // $logoFooter = get_field('logo_footer');
  //         echo $logoFooter;
  //       ; ?>
        </nav>
        </div>

        <div class="grid-item-footer">
          <div class="media">
      <i class="fa fa-facebook" aria-hidden="true"></i>
      <i class="fa fa-twitter" aria-hidden="true"></i>
       </div>

     
   </div>
      
</footer>

          </div>






  </footer>
<?php wp_footer(); ?>
</body>
</html>