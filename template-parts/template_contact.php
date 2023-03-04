<?php 

/* Template Name: contact */


acf_form_head();
get_header();
?>

<main>
    <div class="container container-flex">
      <div class="container-rectangle" id="container-formulaire">
        <div class="title-formulaire">
        <h3 class="description__title" id="title_contact">Nous contacter</h3>
        </div>
   

       
        <?php while ( have_posts() ) : the_post(); 
             acf_form(array(
            'post_id'       => 'new_post',
            'honeypot'      => false,
            'field_groups' => array('group_63ff604940981'),
            'new_post'      => array(
             'post_type'     => 'formulaire',
             'post_status'   => 'publish'
            ),
           'submit_value'  => 'Envoyer',
          //  'return' => '%post_url%'
           'updated_message' => 'Votre demande a bien été prise en compte',
        
      
    )); 

       ?>
        <?php endwhile; ?>

        </div>
    </div>
  

</main>

<?php get_footer(); ?>