<?php 
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page([
		'page_title' => 'Infos générales',
		'menu_title' => 'Infos',
		'menu_slug' => 'infos-site',
		'capability' => 'edit_posts',
		'parent_slug' => '',
		'position' => 3,
		'icon_url' => false,
		'redirect' => false,
		'post_id' => 'infos',
		'autoload' => false,
		'update_button' => 'Mettre à jour',
	]);
}; 

?>