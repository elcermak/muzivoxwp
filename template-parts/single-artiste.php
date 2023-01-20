<?php
/**
 * Template Name: artiste
 */

get_header(); 
while ( have_posts() ) : the_post(); ?>


		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
		</article><!-- #post-<?php the_ID(); ?> -->







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
            @Kriss
          </div>
          <div class="agenda__footer--mail">
            <a href="#">
              <i class="fa fa-envelope"></i>
            </a>
          </div>

        </div>
      </div>
      <div class="soundcloud">
        <iframe width="100%" height="450" scrolling="no" frameborder="no" allow="autoplay"
          src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1104759286&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true">
        </iframe>
      </div>
      <div class="description_area">
        <div class="description">
          <h2 class="description__title">
					<?php the_title(); ?>
          </h2>
          <div class="description__rs">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
          </div>
          <div class="description__text">
            <p>

            </p>
            <p>

            </p>
          </div>
          <div class="description__savoirPlus">
            <a href="#more" id="expand-collapse-button">En savoir plus</a>
          </div>
        </div>
      </div>
      <div class="youtube">
        <iframe width="100%" height="500px" src="https://www.youtube.com/embed/mmdoc8qCxUc" title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen></iframe>
      </div>
    </div>
  </main>









<?php endwhile; // End of the loop.

get_footer();
