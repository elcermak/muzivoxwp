<?php 
query_posts( array(
    'post_type' => 'artiste',
    'posts_per_page' => -1
) );
?>

<?php while ( have_posts() ) : the_post(); ?>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
<?php endwhile; ?>


<?php wp_reset_query(); ?>
