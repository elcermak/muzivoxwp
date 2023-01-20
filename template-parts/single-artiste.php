<?php

/**
 * Template Name: artiste
 */

get_header();
while (have_posts()) : the_post(); ?>
<?php
$name_artiste = get_the_title();
?>

<?php
	$args = array(
		'post_type' => 'agenda',
		'posts_per_page' => -1
	);
	$artiste_posts = get_posts($args);
	$i = 0;
	foreach ($artiste_posts as $post) :
	
		setup_postdata($post);
	
		$artiste_concert = get_field('artiste_concert')[0];
		// $name_artiste = $artiste_concert->post_title; //Tout les artistes présent dans la base de donnée
		$artiste = $name_artiste; //Récupère le nom de l'artiste de la page
	
		if ($artiste_concert->post_title == $name_artiste) {
			$region_name = get_term(get_field('region_concert'))->name;
	
			$concert[$artiste][$i]['id_region'] = $region_name;
			$concert[$artiste][$i]['ville'] = get_field('ville');
			$concert[$artiste][$i]['date'] = get_field('date');
			$concert[$artiste][$i]['lien'] = get_field('lien_reservation');
			$concert[$artiste][$i]['salle'] = get_field('salle_de_concert');
			$concert[$artiste][$i]['complet'] = get_field('complet');
	
			$i++;
		}
	endforeach;

	$last_concert= get_last_concert($concert, $name_artiste);
	wp_reset_postdata();

?>

	<main>
		<div class="wrapper">
			<div class="galerie_area">
				<div class="carousel-container">
					<div class="carousel-slide">
						<img src="asset/photo/LauraCox/lauraCox1.jpg" />
					</div>
					<div class="carousel-slide">
						<img src="asset/photo/LauraCox/lauraCox2.jpg" />
					</div>
					<div class="carousel-slide">
						<img src="asset/photo/LauraCox/lauraCox3.jpg" />
					</div>
				</div>
				<div class="galerie_area-nav">

					<button class="btn__arrow" onclick="prevSlide()">
						<div class="btn__arrow--left"> </div>
					</button>
					<button class="btn__arrow" onclick="nextSlide()">
						<div class="btn__arrow--right"> </div>
					</button>
				</div>
			</div>


			<div class="agenda">
				<div class="agenda__header">
					<strong>Concert</strong> à venir
				</div>
				<hr>
				<div class="agenda__concert">
					<div class="agenda__concert--date">
						Ven 18 Nov 2022
					</div>
					<div class="agenda__concert--lieu">
						Peroy-les-Gobries (60)
					</div>
					<div class="btn-full">
						Complet
					</div>
					<div class="agenda__concert--booked">
						<a href="#">
							<i class="fa fa-calendar"></i>
						</a>
					</div>
				</div>
				<hr>
				<div class="agenda__footer">
					<div class="agenda__footer--txt">
						Programmer cet artiste ?
					</div>
					<div class="agenda__footer--booker">
						@<?php echo get_field('contact_artiste')[0]->post_title; ?>
					</div>
					<div class="agenda__footer--mail">
						<a href="#">
							<i class="fa fa-envelope"></i>
						</a>
					</div>

				</div>
			</div>
			<div class="soundcloud">
				<iframe width="100%" height="450" scrolling="no" frameborder="no" allow="autoplay" src="<?php the_field('lien_soundcloud'); ?>">
				</iframe>
			</div>
			<div class="description_area">
				<div class="description">
					<h2 class="description__title">
						<?php echo $name_artiste; ?>
					</h2>
					<div class="description__rs">
						<i class="fa fa-facebook" aria-hidden="true"></i>
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</div>
					<div class="description__text">
						<p>
							<?php the_field('description_courte'); ?>
						</p>
						<p>
							<?php the_field('description_longue'); ?>

						</p>
					</div>
					<div class="description__savoirPlus">
						<a href="#more" id="expand-collapse-button">En savoir plus</a>
					</div>
				</div>
			</div>
			<div class="youtube">
				<iframe width="100%" height="500px" src="<?php the_field('lien_youtube'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			</div>
		</div>
	</main>









<?php endwhile; // End of the loop.

get_footer();
