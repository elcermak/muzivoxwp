<?php

/**
 * Cette fonction prend en entrée un tableau de concerts et le nom d'un artiste, 
 * elle parcours les concerts de cet artiste et retourne le prochain concert à partir de la date courante.
 * elle renvois un tableau comportant le prochain concert (date, ville, région, lien de réservation, salle, si_complet)
 * @param array $concerts  tableau des concerts
 * @param string $name_artiste nom de l'artiste dont on veut trouver le prochain concert
 * @return array $next_concert tableau qui contient les informations du prochain concert
 */
function get_last_concert($concerts, $name_artiste)
{
	$current_time = time(); // On récupère le timestamp de la date courante

	// On initialise des variables pour stocker le prochain concert et sa date
	$next_concert = null;
	$next_date = null;

	foreach ($concerts[$name_artiste] as $concert) { // On parcours tous les concerts de l'artiste donné
		$concert_time = strtotime($concert['date']);
		if ($current_time < $concert_time) { // Si c'est le premier prochain concert qu'on trouve
			if ($next_date === null) {
				$next_date = $concert_time;
				$next_concert = $concert;
			} else if ($next_date > $concert_time) { // Sinon si on a déjà trouvé un concert, on compare les deux dates pour savoir lequel est le plus proche
				$next_date = $concert_time;
				$next_concert = $concert;
			}
		}
	}
	return $next_concert;
}


// Ajouter les colonnes "Complet" et "Concert important" à l'interface d'agenda personnalisé
function ajouter_colonnes_agenda($columns){
  $columns['complet'] = 'Complet';
  $columns['concert_important'] = 'Concert important';
  return $columns;
}
add_filter('manage_agenda_posts_columns', 'ajouter_colonnes_agenda');


// Ajouter les colonnes "Complet" et "Concert important" au système de triage de l'interface d'agenda personnalisé
function ajouter_colonnes_au_tri_agenda($columns){
    $columns['complet'] = 'complet';
    $columns['concert_important'] = 'concert_important';
    return $columns;
}
add_filter('manage_edit-agenda_sortable_columns', 'ajouter_colonnes_au_tri_agenda');

// Effectuer le tri en fonction des champs ACF "complet" et "concert_important"
function trier_colonnes_agenda($wp_query){
    if(!is_admin()){
        return;
    }

    $orderby = $wp_query->get('orderby');

    if('complet' == $orderby){
        $wp_query->set('meta_key', 'complet');
        $wp_query->set('orderby', 'meta_value');
    } elseif('concert_important' == $orderby){
        $wp_query->set('meta_key', 'concert_important');
        $wp_query->set('orderby', 'meta_value');
    }
}

// Remplir les colonnes "Complet" et "Concert important" avec le contenu des champs ACF "complet" et "concert_important" et des cases à cocher
function remplir_colonnes_agenda($column_name, $post_id){
  if($column_name == 'complet' || $column_name == 'concert_important'){
      $valeur = get_field($column_name, $post_id);
      echo '<input type="checkbox" name="'.$column_name.'" '.($valeur ? 'checked' : '').' onclick="mettre_a_jour_acf(this, \''.$column_name.'\', '.$post_id.')"/>';
  }
}




// Mettre à jour la valeur des champs ACF "complet" et "concert_important" en utilisant AJAX
function mettre_a_jour_acf(){
  // Vérifier les permissions
  if(current_user_can('edit_posts')){
      // Récupérer les paramètres AJAX
      $post_id = $_POST['post_id'];
      $field_name = $_POST['field_name'];
      $value = $_POST['value'];
      // Mettre à jour le champ ACF correspondant
      update_field($field_name, $value, $post_id);
      // Retourner une réponse JSON
      wp_send_json_success();
  } else {
      // Retourner une réponse d'erreur
      wp_send_json_error('Vous n\'avez pas les autorisations nécessaires pour effectuer cette action.');
  }
}

// Ajouter le script JavaScript
function ajouter_script_javascript(){
  echo '<script>
      function mettre_a_jour_acf(case_a_cocher, field_name, post_id){
          var value = case_a_cocher.checked ? 1 : 0;
          jQuery.ajax({
              type: "POST",
              url: ajaxurl,
              data: {
                  action: "mettre_a_jour_acf",
                  post_id: post_id,
                  field_name: field_name,
                  value: value
              }
          });
      }
  </script>';
}

add_action('pre_get_posts', 'trier_colonnes_agenda');

add_action('manage_agenda_posts_custom_column', 'remplir_colonnes_agenda', 10, 2);

add_action('wp_ajax_mettre_a_jour_acf', 'mettre_a_jour_acf');

add_action('admin_footer', 'ajouter_script_javascript');

  // Ajouter les colonnes "mettre_en_avant" et "Concert important" à l'interface d'artiste personnalisé
	function ajouter_colonnes_artiste($columns){
		$columns['mettre_en_avant'] = 'mettre_en_avant';
		return $columns;
	}
	add_filter('manage_artiste_posts_columns', 'ajouter_colonnes_artiste');
	
	// Ajouter les colonnes "mettre_en_avant" et "Concert important" au système de triage de l'interface d'artiste personnalisé
	function ajouter_colonnes_au_tri($columns){
		$columns['mettre_en_avant'] = 'mettre_en_avant';
		return $columns;
	}
	add_filter('manage_edit-artiste_sortable_columns', 'ajouter_colonnes_au_tri');
	
	// Effectuer le tri en fonction des champs ACF "mettre_en_avant" et 
	function trier_colonnes_artiste($wp_query){
		if(!is_admin()){
				return;
		}
	
		$orderby = $wp_query->get('orderby');
	
		if('mettre_en_avant' == $orderby){
				$wp_query->set('meta_key', 'mettre_en_avant');
				$wp_query->set('orderby', 'meta_value');
		} 
	}
	add_action('pre_get_posts', 'trier_colonnes_artiste');
	
	
	// Remplir les colonnes "mettre_en_avant" et "Concert important" avec le contenu des champs ACF "mettre_en_avant" et  et des cases à cocher
	function remplir_colonnes_artiste($column_name, $post_id){
		if($column_name == 'mettre_en_avant'){
				$valeur = get_field($column_name, $post_id);
				echo '<input type="checkbox" name="'.$column_name.'" '.($valeur ? 'checked' : '').' onclick="mettre_a_jour_acf(this, \''.$column_name.'\', '.$post_id.')"/>';
		}
	}
	add_action('manage_artiste_posts_custom_column', 'remplir_colonnes_artiste', 10, 2);
	
	
	
	// Ajouter le script JavaScript
	function ajouter_script_javascript_en_avant(){
		echo '<script>
				function mettre_a_jour_acf(case_a_cocher, field_name, post_id){
						var value = case_a_cocher.checked ? 1 : 0;
						jQuery.ajax({
								type: "POST",
								url: ajaxurl,
								data: {
										action: "mettre_a_jour_acf",
										post_id: post_id,
										field_name: field_name,
										value: value
								}
						});
				}
		</script>';
	}
	add_action('admin_footer', 'ajouter_script_javascript_en_avant');
	
	