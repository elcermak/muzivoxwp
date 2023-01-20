<?php 
  get_header();

  if(have_posts()) :
    while(have_posts()) : the_post();
    echo "a des post"; echo '<br>';

      // print_r(get_post_type());
      get_template_part( 'template-parts/content', get_post_type() );

    endwhile;
  else :
    echo "pas de post";

    get_template_part( 'template-parts/content', 'none' );

  endif;
  
  get_footer(); 
?>