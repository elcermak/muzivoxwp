<?php
/* Template Name: Accueil */

get_header();


$mesConcerts = array(
  'post_type' => 'agenda',
  'post_per_page' => -1,
  'meta_key' => 'date',
  'order_by' => 'meta_value',
  'order' => 'ASC',

);
function cmp($a, $b)
{
  return strcmp($a["date"], $b["date"]);
}

$concerts = get_posts($mesConcerts);

foreach ($concerts as $key => $concert) {

  $artiste = get_field('artiste_concert', $concert->ID);

  $artiste_name = $artiste[0]->post_title;
}
// Exécuter la wp query
$my_query = new WP_Query($mesConcerts);


//récupération date du jours
$dt = time();
$dateDuJour = date("Y/m/d", $dt);

//initialisé de l'indice du tableau concert*
$i = 0;

//génération du tableau concert
// On lance la boucle 
if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
    if (get_field('concert_important') == true && get_field('date') > $dateDuJour) {

      $date_formatted = get_field('date');
      $date_obj = DateTime::createFromFormat('Y/m/d H:i', $date_formatted);
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      $concert_date_formatted = strftime('%a %d %b %Y à %HH%M', $date_obj->getTimestamp());
      $arrayConcerts[$i]['date'] = $concert_date_formatted;
      $artistObjet = get_field('artiste_concert');
      $arrayConcerts[$i]['nameArtist'] = $artistObjet[0]->post_title;
      $arrayConcerts[$i]['imageConcert']['url'] = get_field('image_concert')['url'];
      $arrayConcerts[$i]['imageConcert']['alt'] = get_field('image_concert')['alt'];
      $arrayConcerts[$i]['priorityConcert'] = get_field('concert_prioritaire');
      $arrayConcerts[$i]['townConcert'] = get_field('ville');
      $arrayConcerts[$i]['roomConcert'] = get_field('salle_de_concert');
      $arrayConcerts[$i]['isFull'] = get_field('complet');
      $i++;
    }
  endwhile;
// usort($arrayConcerts, "cmp");
endif;

?>

<div class="first-carrousel">

  <div class="orange-egalizers">
    <div class="single-egalizer">
      <p class="nom_egalizer" id="nom_egalizer"> <?php echo $arrayConcerts[0]['nameArtist']; ?></p>
    </div>
    <div class="single-egalizer">
      <p class="date_egalizer" id="date_egalize"><?php echo $arrayConcerts[0]['date']; ?></p>
    </div>
    <div class="single-egalizer">
      <p class="lieu_egalizer" id="lieu_egalizer"><?php echo $arrayConcerts[0]['townConcert'] . ', ' . $arrayConcerts[0]['roomConcert'] ?></p>
    </div>
    <div class="single-egalizer">
      <a href="<?php echo get_permalink(get_page_by_title('agenda')) ?>">Voir toutes les dates</a>
    </div>
  </div>
  <div class="images-carrousel">

    <div class="first-image">
      <div id="headband_full">
      </div>
      <img class="carrousel-cover" src="<?php echo $arrayConcerts[0]['imageConcert']['url'] ?>" alt="<?php echo $arrayConcerts[0]['imageConcert']['alt'] ?>" id="image_principale">
    </div>
    <div class="card_next_concert">
      <div id="loader">
        <div class="progress-bar">
          <div class="progress" id="progress"></div>
        </div>
      </div>
      <div class="image_next_concert">
        <img class="carrousel-cover" src="<?php echo $arrayConcerts[1]['imageConcert']['url'] ?>" alt="<?php echo $arrayConcerts[1]['imageConcert']['alt'] ?>" id="image_next">
        <div class="card_footer">
          <div class="card_next_infos">
            <p id="next_nameArtist"><?php echo $arrayConcerts[1]['nameArtist']; ?></p>
            <p id="next_date"><?php echo $arrayConcerts[1]['date']; ?></p>
          </div>
          <div class="card_next_buttons">
            <i class="fa fa-duotone fa-square-caret-left" onclick="arriere()"></i>
            <i class="fa fa-duotone fa-square-caret-right" onclick="avant()"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container_aPropos">
  <?php while (have_posts()) :
    the_post();
    the_content();
  endwhile; ?>
</div>

</main>

<!-- Carrousel Artistes -->

<?php

$mesArtistes = array(
  'post_type' => 'artiste',
  'nopaging' => true,
  'meta_key' => 'nom_artistegroupe',
  'orderby' => 'meta_value',
  'order' => 'ASC',
);

$artistes = get_posts($mesArtistes);

// Exécuter la wp query
$my_queryArtist = new WP_Query($mesArtistes);

//initialisé de l'indice du tableau artiste*
$i = 0;

//génération du tableau concert
// On lance la boucle 
if ($my_queryArtist->have_posts()) : while ($my_queryArtist->have_posts()) : $my_queryArtist->the_post();
    if (get_field('mettre_en_avant') == true) {
      $arrayArtists[$i]['nameArtist'] = get_field('nom_artistegroupe');
      $arrayArtists[$i]['imageArtist']['url'] = get_field('image_carrousel_1')['url'];
      $arrayArtists[$i]['imageArtist']['alt'] = get_field('image_carrousel_1')['alt'];
      $arrayArtists[$i]['permalink'] = get_permalink();
      $i++;
    }


  endwhile;
// usort($arrayConcerts, "cmp");
endif;


?>
<h3 class="title_home">NOS ARTISTES</h3>
<div class="carrousel_hightlight">


  <div class="carrousel_background"></div>

  <div class="container_hightlight">
    <div class="hightlight-arrow" onclick="avantHightlight()">
      <i class="fa fa-solid fa-less-than"></i>
    </div>
    <div class="hightlight-cell">
      <a href="<?php echo $arrayArtists[0]['permalink']; ?>">
        <img src="<?php echo $arrayArtists[0]['imageArtist']['url']; ?>" alt="<?php echo $arrayArtists[0]['imageArtist']['alt']; ?>" class="hightlight_artist" id="artist_image_1">
        <p class="title_hightlight-artist" id="artist_name_hightlight_1"><?php echo $arrayArtists[0]['nameArtist']; ?></p>
      </a>
    </div>
    <div class="hightlight-cell">
      <a href="<?php echo $arrayArtists[1]['permalink']; ?>">

        <img src="<?php echo $arrayArtists[1]['imageArtist']['url']; ?>" alt="<?php echo $arrayArtists[1]['imageArtist']['alt']; ?>" class="hightlight_artist" id="artist_image_2">
        <p class="title_hightlight-artist" id="artist_name_hightlight_2"><?php echo $arrayArtists[1]['nameArtist']; ?>
        </p>
      </a>
    </div>
    <div class="hightlight-cell">
      <a href="<?php echo $arrayArtists[2]['permalink']; ?>">

        <img src="<?php echo $arrayArtists[2]['imageArtist']['url']; ?>" alt="<?php echo $arrayArtists[2]['imageArtist']['alt']; ?>" class="hightlight_artist" id="artist_image_3">
        <p class="title_hightlight-artist" id="artist_name_hightlight_3"><?php echo $arrayArtists[2]['nameArtist']; ?>
        </p>
      </a>
    </div>
    <div class="hightlight-cell">
      <a href="<?php echo $arrayArtists[3]['permalink']; ?>">

        <img src="<?php echo $arrayArtists[3]['imageArtist']['url']; ?>" alt="<?php echo $arrayArtists[3]['imageArtist']['alt']; ?>" class="hightlight_artist" id="artist_image_4">
        <p class="title_hightlight-artist" id="artist_name_hightlight_4"><?php echo $arrayArtists[3]['nameArtist']; ?>
        </p>
      </a>
    </div>
    <div class="hightlight-arrow" onclick="arriereHightlight()">
      <i class="fa fa-solid fa-greater-than"></i>
    </div>

  </div>


</div>

<div class="section-btn">
  <div class="btn-artiste">
    <a href="<?php echo get_permalink(get_page_by_title('artistes')) ?>">Voir tous nos artistes</a>
  </div>
</div>

<?php
$arrayConcerts_json = json_encode($arrayConcerts);
$arrayArtists_json = json_encode($arrayArtists);

echo "
  <script>
    let arrayConcerts = $arrayConcerts_json;
    let arrayArtists = $arrayArtists_json;
  </script>
  ";
?>
<script>
  setInterval(() => {
    avant();
  }, 5000);


  let imagePrincipale = document.getElementById("image_principale");
  let index = 0;
  let contenu = "";

  let imageNext = document.getElementById("image_next");
  let indexNext = 1;

  let nextNameArtist = document.getElementById("next_nameArtist");

  let nextDate = document.getElementById("next_date");

  let headbandFull = document.getElementById("headband_full");


  // definition des égalizers
  let nameEgalizer = document.getElementById("nom_egalizer");
  let dateEgalizer = document.getElementById("date_egalize");
  let placeEgalizer = document.getElementById("lieu_egalizer");

  // incrementer i++ fleche avant et i-- pour la fleche arriere 
  imagePrincipale.innerHTML = contenu;
  imageNext.innerHTML = contenu;


  if (arrayConcerts[index].isFull) {
    headbandFull.innerHTML = "<div class='full'><p class='textFull'>Complet</p></div>";
  } else {
    headbandFull.innerHTML = "";

  }


  function avant() {
    index++;
    indexNext++;

    if (arrayConcerts.length == index) {
      index = 0;

    } else if (arrayConcerts.length == indexNext) {
      indexNext = 0;
    }
    clearInterval(id);

    display();


  };

  function arriere() {
    index--;
    indexNext--;
    if (index < 0) {
      index = arrayConcerts.length - 1;
    } else if (indexNext < 0) {

      indexNext = arrayConcerts.length - 1;
    }
    clearInterval(id);
    display();


  };

  function display() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("loader").style.display = "flex";
    imagePrincipale.setAttribute("src", arrayConcerts[index].imageConcert.url);
    imageNext.setAttribute("src", arrayConcerts[indexNext].imageConcert.url);
    imagePrincipale.setAttribute("alt", arrayConcerts[index].imageConcert.alt);
    imageNext.setAttribute("alt", arrayConcerts[indexNext].imageConcert.alt);
    nextNameArtist.innerHTML = arrayConcerts[indexNext].nameArtist;
    nextDate.innerHTML = arrayConcerts[indexNext].date;
    nameEgalizer.innerHTML = arrayConcerts[index].nameArtist;
    console.log('isFull?', arrayConcerts[index].isFull);
    dateEgalizer.innerHTML = arrayConcerts[index].date;
    placeEgalizer.innerHTML = arrayConcerts[index].townConcert + ", " + arrayConcerts[index].roomConcert;
    console.log("test");
    console.log("div", headbandFull);

    if (arrayConcerts[index].isFull) {
      headbandFull.innerHTML = "<div class='full'><p class='textFull'>Complet</p></div>";
    } else {
      headbandFull.innerHTML = "";
    }

    progress();
  }
  let id = 0;
  progress();

  /*Fonction barre de progression */
  function progress() {
    let progr = document.getElementById('progress');
    let progress = 1;
    id = setInterval(frame, 50);



    function frame() {
      if (progress == 100) {
        console.log("clear");
        clearInterval(id);
        document.getElementById("loader").style.display = "flex";

      } else {
        progress += 1;
        progr.style.width = progress + '%'
      }

    }


  }



  // carrousel Hightlight
  console.log(arrayArtists);
  // definition des images carrousel Artistes
  let imageArtist1 = document.getElementById("artist_image_1");
  let imageArtist2 = document.getElementById("artist_image_2");
  let imageArtist3 = document.getElementById("artist_image_3");
  let imageArtist4 = document.getElementById("artist_image_4");

  // definition des noms carrousel Artistes
  let nameArtistHightlight_1 = document.getElementById("artist_name_hightlight_1");
  let nameArtistHightlight_2 = document.getElementById("artist_name_hightlight_2");
  let nameArtistHightlight_3 = document.getElementById("artist_name_hightlight_3");
  let nameArtistHightlight_4 = document.getElementById("artist_name_hightlight_4");

  // definition carrousel Hightlight
  let indexHightlight1 = 0;
  let indexHightlight2 = 1;
  let indexHightlight3 = 2;
  let indexHightlight4 = 3;
  let contenuHightlight = "";
  imageArtist1.innerHTML = contenuHightlight;
  imageArtist2.innerHTML = contenuHightlight;
  imageArtist3.innerHTML = contenuHightlight;
  imageArtist4.innerHTML = contenuHightlight;


  function avantHightlight() {
    indexHightlight1++;
    indexHightlight2++;
    indexHightlight3++;
    indexHightlight4++;

    if (arrayArtists.length == indexHightlight1) {
      indexHightlight1 = 0;

    } else if (arrayArtists.length == indexHightlight2) {
      indexHightlight2 = 0;
    } else if (arrayArtists.length == indexHightlight3) {
      indexHightlight3 = 0;
    } else if (arrayArtists.length == indexHightlight4) {
      indexHightlight4 = 0;
    }
    displayHightlight();
    console.log(indexHightlight1, indexHightlight2, indexHightlight3, indexHightlight4);
  };

  function arriereHightlight() {
    indexHightlight1--;
    indexHightlight2--;
    indexHightlight3--;
    indexHightlight4--;
    if (indexHightlight1 < 0) {
      indexHightlight1 = arrayArtists.length - 1;
    } else if (indexHightlight2 < 0) {
      indexHightlight2 = arrayArtists.length - 1;
    } else if (indexHightlight3 < 0) {
      indexHightlight3 = arrayArtists.length - 1;
    } else if (indexHightlight4 < 0) {
      indexHightlight4 = arrayArtists.length - 1;
    }
    displayHightlight();
    console.log(indexHightlight1, indexHightlight2, indexHightlight3, indexHightlight4);

  };

  function displayHightlight() {
    imageArtist1.setAttribute("src", arrayArtists[indexHightlight1].imageArtist.url);
    imageArtist1.setAttribute("alt", arrayArtists[indexHightlight1].imageArtist.alt);

    imageArtist2.setAttribute("src", arrayArtists[indexHightlight2].imageArtist.url);
    imageArtist2.setAttribute("alt", arrayArtists[indexHightlight2].imageArtist.alt);

    imageArtist3.setAttribute("src", arrayArtists[indexHightlight3].imageArtist.url);
    imageArtist3.setAttribute("alt", arrayArtists[indexHightlight3].imageArtist.alt);

    imageArtist4.setAttribute("src", arrayArtists[indexHightlight4].imageArtist.url);
    imageArtist4.setAttribute("alt", arrayArtists[indexHightlight4].imageArtist.alt);

    nameArtistHightlight_1.innerHTML = arrayArtists[indexHightlight1].nameArtist;
    nameArtistHightlight_2.innerHTML = arrayArtists[indexHightlight2].nameArtist;
    nameArtistHightlight_3.innerHTML = arrayArtists[indexHightlight3].nameArtist;
    nameArtistHightlight_4.innerHTML = arrayArtists[indexHightlight4].nameArtist;


  }
</script>



<?php get_footer() ?>