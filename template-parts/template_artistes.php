<?php

/**
 * Template Name: artistes
 */
?>
<?php
if (have_posts()) {
  $i = 0;
  while (have_posts()) {
    the_post();
    query_posts(array(
      'post_type' => 'artiste',
      'posts_per_page' => -1
    ));
    while (have_posts()) {
      the_post();
      $artistes[$i]['link'] = get_permalink();
      $artistes[$i]['name'] = get_the_title();
      $artistes[$i]['thumbnail'] = get_the_post_thumbnail_url();
      $i++;
    }
    wp_reset_query();
  }
} else {
  echo "pas de post";
  get_template_part('template-parts/content', 'none');
};
// echo '<pre>';
// print_r($artistes);
// echo '</pre>';
?>
<?php get_header(); ?>

<?php get_header(); ?>

<main id='app'>
  <div class="container container-flex">
    <div class="container-rectangle" id="artist" :style="{'background-image': 'url(' + currentBackground + ')'}">
      <div class="filtreColor">
        <div class="flexbox justify_center align_center artist__search">
          <input class="artist__search--input" type="text" v-model="searchTerm" placeholder="Recherche">
          <i class="fa fa-magnifying-glass" style="color:#FF6B00;font-size: 1.2em;"></i>
        </div>
        <div class="Artistes_List">
          <ul class="artist">
            <li v-for="person in filteredPersons">
              <a class="artist__link" :href="person.link" @mouseover="updateBackground(person.thumbnail)"  @mouseout="updateBackground('<?php echo get_template_directory_uri()."/asset/image/ETOILE_BIG.png" ; ?>')">{{ person.name }}</a>
            </li>
          </ul>

        </div>
        <div class="artist__footer"></div>

      </div>
    </div>
  </div>
</main>



<script>
  let artistes = <?php echo json_encode(array_map(function ($artist) {
                    return [
                      'link' => $artist['link'],
                      'name' => html_entity_decode($artist['name']),
                      'thumbnail' => $artist['thumbnail']
                    ];
                  }, $artistes)); ?>;
  console.log(artistes);
  var app = new Vue({
    el: '#app',
    data: {
      persons: artistes.map(person => {
        return {
          name: person.name,
          link: person.link,
          thumbnail: person.thumbnail
        };
      }),
      searchTerm: '',
      currentBackground: 'url(../asset/image/ETOILE_BIG.png)'
    },
    computed: {
      filteredPersons() {
        return this.persons.filter(person => {
          return person.name.toLowerCase().includes(this.searchTerm.toLowerCase());
        });
      }
    },
    methods: {
      updateBackground(thumbnail) {
        if (thumbnail) {
          this.currentBackground = thumbnail;
  
        }else {
          this.currentBackground = "url(../asset/image/ETOILE_BIG.png)";
        }
      }
    }
  })
</script>

<?php get_footer(); ?>