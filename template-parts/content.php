<?php
query_posts(array(
    'post_type' => 'artiste',
    'posts_per_page' => -1
));
?>



<ul class="artist">
<?php while (have_posts()) : the_post(); ?>

  <li><a class="artist__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
  <?php endwhile; ?>

</ul>
<?php wp_reset_query(); ?>