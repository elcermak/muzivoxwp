<?php

/**
 * Template Name: espace pro
 */
get_header();


if (have_posts()) {
  $i = 0;
  while (have_posts()) {
    the_post();
    query_posts(array(
      'post_type' => 'espace_pro',
      'posts_per_page' => -1
    ));
    while (have_posts()) {
      the_post();
      $artistes[$i]['link'] = get_field('lien_dossier', get_the_ID());
      $artistes[$i]['name'] = get_the_title();
      $i++;
    }
    wp_reset_query();
  }
} else {
  echo "pas de post";
  get_template_part('template-parts/content', 'none');
};
?>

<main id='app'>
  <div class="wrapperEspacePro">
    <div class="displaySearch">
      <div class="displaySearch__background">
        <input class="displaySearch__input" type="text" v-model="searchTerm" placeholder="Rechercher votre artiste">
        <i class="fa fa-magnifying-glass"></i>
      </div>
    </div>

    <div class="EspacePro__artist">
      <div class="espacePro__artist--background" v-for="person in filteredPersons">
        <div class="EspacePro__artist--item">
          <a class="" :href="person.link"><i class="fa fa-file"></i></a>
          {{ person.name }}
        </div>
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
      currentBackground: ''
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
        this.currentBackground = thumbnail;
      }
    }
  })
</script>


<?php get_footer(); ?>