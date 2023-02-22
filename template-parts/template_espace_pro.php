<?php

/**
 * Template Name: espace pro
 */
get_header();

$artistes = array();
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

<?php

if ((!is_user_logged_in())) { ?>
  <main class="container" id="form">
    <div class="container container-rectangle">
      <form method="post">
        <h2 id="fromGroup_Title" class="description__title">ESPACE PRO</h2>
        <div class="formGroup">
          <label>Nom d'utilisateur</label>
          <input class="formGroup-input" id="username" type="text" name="username" placeholder="Username">
        </div>
        <div class="formGroup">
          <label>Mot de passe</label>
          <input class="formGroup-input" id="password" type="password" name="pass" placeholder="Password">
        </div>
        <div class="btn-container">
          <button class="btn" name="login-submit">
            Connexion
          </button>
        </div>
      </form>
    </div>
  </main>

<?php
} else {
?>


  <main id='app'>
    <div class="wrapperEspacePro">
      <div class="flexbox align_center directionCol gap10px">
        <h2>Bonjour <?php $current_user = wp_get_current_user();
                    echo $current_user->user_login; ?></h2>
        <a href="<?php echo wp_logout_url(site_url('/espace-pro/')); ?>">
          <div class="btn-container" id="logout">
            <button class="btn" name="login-submit">
              Déconnexion
            </button>
          </div>
        </a>
      </div>

      <div class="displaySearch">
        <div class="displaySearch__background">
          <input class="displaySearch__input" type="text" v-model="searchTerm" placeholder="Rechercher votre artiste">
          <i class="fa fa-magnifying-glass"></i>
        </div>
      </div>

      <div class="EspacePro__artist">
        <div class="espacePro__artist--background" v-for="person in filteredPersons">

          <div v-if="person.name" class="EspacePro__artist--item">
            <a class="" :href="person.link"><i class="fa fa-download"></i></a>
            {{ person.name }}
          </div>
        </div>

        <?php if (count($artistes) === 0) {
        ?>
          <div class="espacePro__artist--background">
            <div class="EspacePro__artist--item">
              Vous n'avez pas d'artistes affectés.

            </div>

          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </main>
<?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
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
      }).filter(person => person.name),
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