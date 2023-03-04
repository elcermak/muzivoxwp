<?php

/**
 * Template Name: single_artiste
 */

get_header();
while (have_posts()) : the_post(); ?>
	<?php
	$name_artiste = get_the_title();
	?>

	<?php
	$url = get_permalink();

	$path = parse_url($url, PHP_URL_PATH);  // Récupère le chemin de l'URL
	$segments = explode('/', $path);  // Divise le chemin en segments

	if ($segments[1] === 'fr') {
		$language = 'fr';
	} else {
		$language = 'en';
	}

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
		// $post_id = $post->ID;

		// // Récupère tous les champs ACF pour l'ID de post donné
		// $fields = get_fields($post_id);
		
		// // Affiche les clés et les valeurs des champs ACF
		// foreach ($fields as $key => $value) {
		// 		echo $key . ': ' . $value . '<br>';
		// }
		if ($artiste_concert->post_title == $name_artiste) {
			$region_name = get_term(get_field('region_concert'))->name;

			$concert[$name_artiste][$i]['id_region'] = $region_name;
			$concert[$name_artiste][$i]['ville'] = get_field('ville');
			$concert[$name_artiste][$i]['date'] = get_field('date');
			$concert[$name_artiste][$i]['lien'] = get_field('lien_reservation');
			$concert[$name_artiste][$i]['salle'] = get_field('salle_de_concert');
			$concert[$name_artiste][$i]['complet'] = get_field('complet');
			$i++;
		}
	endforeach;

	if (!empty($concert)) {
		$next_concert = get_last_concert($concert, $name_artiste);
	}
	wp_reset_postdata();

	?>

	<main>
		<div class="wrapper">
			<div class="galerie_area">
				<div class="carousel-container">
					<div class="carousel-slide">
						<img src="<?php echo get_field('image_carrousel_1')['url']; ?>" alt="<?php get_field('image_carrousel_1')['alt']; ?>" />
					</div>
					<div class="carousel-slide">
						<img src="<?php echo get_field('image_carrousel_2')['url']; ?>" alt="<?php get_field('image_carrousel_2')['alt']; ?>" />
					</div>
					<div class="carousel-slide">
						<img src="<?php echo get_field('image_carrousel_3')['url']; ?>" alt="<?php get_field('image_carrousel_3')['alt']; ?>" />
					</div>
				</div>
				<div class="galerie_area-nav">

					<button class="btn__arrow" onclick="prevSlide()">
						<i class="fa fa-duotone fa-square-caret-left arrowSingleArtist"></i>
					</button>
					<button class="btn__arrow" onclick="nextSlide()">
						<i class="fa fa-duotone fa-square-caret-right arrowSigleArtist"></i>
					</button>
				</div>
			</div>

			<div class="agenda">
				<div class="agenda__header">
					<strong>
						<?
						if ($language == "fr") {
							echo "Prochain concert";
						} else {
							echo "Next concert";
						}
						?>
					</strong>
				</div>
				<hr>
				<div class="agenda__concert">
					<div class="agenda__concert--date">
						<?php
						if (!empty($next_concert['date'])) {
							$date_obj = DateTime::createFromFormat('Y/m/d H:i', $next_concert['date']);

							if ($language == "fr") {
								setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
								echo strftime('%a %d %b %Y à %HH%M', $date_obj->getTimestamp());

							} else {
								setlocale(LC_TIME, 'en_EN.UTF-8', 'en');
								echo strftime('%a %d %b %Y at %HH%M', $date_obj->getTimestamp());

							}

						} else {
							if ($language == "fr") {
								echo "Pas de concert prévu pour le moment";
							} else {
								echo "No concerts are scheduled.";
							}
						}



						// echo $date;
						?>
					</div>
					<div class="agenda__concert--lieu">
						<?php echo $next_concert['ville']; ?>
					</div>
					<?php
					if ($next_concert['complet'] == 1) { ?>
						<div class="btn-full">
							<?
							if ($language == "fr") {
								echo "Complet";
							} else {
								echo "Solde out";
							}
							?> </div>
					<?php
					} else { ?>
						<div></div>
					<?php
					}
					?>

					<div class="agenda__concert--booked">
						<a href="#">
							<i class="fa fa-calendar"></i>
						</a>
					</div>
				</div>
				<hr>
				<div class="agenda__footer">
					<div class="agenda__footer--txt">
						<?
						if ($language == "fr") {
							echo "Programmer cet artiste ?";
						} else {
							echo "Schedule this artist?";
						}
						?>

					</div>
					<div class="agenda__footer--mail">
						<a href="#">
							<i class="fa fa-envelope"></i>
						</a>
					</div>

				</div>
			</div>
			<div class="description_area">
				<div class="description">
					<h2 class="description__title">
						<div><?php echo $name_artiste; ?></div>
						<!-- <div> <a href="<?php the_field('lien_soundcloud'); ?>" class="btn-filter" target="_blank">Playlist musical</a></div> -->
					</h2>
					<div class="description__rs">
						<i class="fa fa-facebook" aria-hidden="true"></i>
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</div>
					<div class="description__text">
						<p class="description__short">
							<?php the_field('description_courte'); ?>
						</p>
						<div id='d1' class='collapsed'>
							<div>
								<?php the_field('description_longue'); ?>

							</div>
						</div>
					</div>
					<div class="description__savoirPlus">
						<a href="#more" id="expand-collapse-button">
							<?
							if ($language == "fr") {
								echo "En savoir plus";
							} else {
								echo "Learn more";
							}
							?>

						</a>
					</div>
				</div>
			</div>
			<div class="youtube yt1">
				<div class="animation flexbox_player ">
					<a href='<?php the_field('lien_soundcloud'); ?>' class='playBut test'>
						<div class="flexbox_player">
							<?
							if ($language == "fr") {
								echo "Ecouter cet artiste.";
							} else {
								echo "Listen to this artist.";
							}
							?>

							<div class='container_buttonPlay'>

								<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In  -->
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="213.7px" height="213.7px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">

									<polygon class='triangle' id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="
	73.5,62.5 148.5,105.8 73.5,149.1 " />

									<circle class='circle' id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
								</svg>
							</div>
							<div class="muzik">
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
								<div class="loader"></div>
							</div>
						</div>
					</a>
				</div>

			</div>
			<div class="youtube yt2">
				<?php
				echo (get_field('lien_youtube_2'));
				?>
			</div>
			<div class="youtube yt3">
				<?php
				echo (get_field('lien_youtube_3'));
				?>
			</div>
		</div>
	</main>

	<script src="<?php echo get_template_directory_uri() . "/dist/gallerieArtiste.js" ?>"></script>
	<script src="<?php echo get_template_directory_uri() . "/dist/savoirPlus.js" ?>"></script>


<?php endwhile; // End of the loop.
?>
<?php
get_footer();
