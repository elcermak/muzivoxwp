<?php
/**
 * La classe Walker_Nav_Menu permet de personnaliser le rendu des menus de wordpress
 * @link https://developer.wordpress.org/reference/classes/walker_nav_menu/
 */
class MyCustom_Walker_Nav_Menu extends Walker_Nav_Menu {

	private $menuClass 						 = 'menu__list';      // Classe du menu
	private $menuItemClass 				 = 'menu__item';      
	private $menuItemCurrentClass  = '-current';
	private $menuItemDropdownClass = '-hasDropdown';
	private $menuItemBtn					 = 'menu__item--btn';
	private $menuLinkClass 				 = 'menu__link';
	private $submenuClass 				 = 'submenu__list';
	private $submenuItemClass 		 = 'submenu__item';
 
	/**
	 * Starts the list before the elements are added.
	 *
	 * Adds classes to the unordered list sub-menus.
	 *
	 * @param string $output Correspond à la variable retournée en fin de walker.
	 * @param int    $depth  Correspond à la profondeur du niveau.
	 * @param array  $args   Un tableau d'arguments. @see wp_nav_menu()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
			// Depth-dependent classes.
			$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
			$display_depth = ( $depth + 1); // because it counts the first submenu as 0
			$classes = array( $this->submenuClass );
			$class_names = implode( ' ', $classes );

			// Build HTML for output.
			$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	/**
	 * Start the element output.
	 *
	 * Adds main/sub-classes to the list items and links.
	 *
	 * @param string $output Correspond à la variable retournée en fin de walker.
	 * @param object $item   Correspond aux information sur l'item en cours.
	 * @param int    $depth  Correspond à la profondeur du niveau.
	 * @param array  $args   Un tableau d'arguments. @see wp_nav_menu()
	 * @param int    $id     ID courant.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// Depth-dependent classes.
		$depth_classes = array(
			( $depth == 0 ? $this->menuItemClass : $this->submenuItemClass ),
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// Passed classes.
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$myClasses = array();
		//print_r($args->walker->has_children);
		if ( isset( $args->walker->has_children ) && $args->walker->has_children ) {
			$myClasses[] = $this->menuItemDropdownClass;
		}
		if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) ) {
			$myClasses[] = 'active';
		}
		if ( in_array( $this->menuItemBtn, $classes, true ) ) {
			$myClasses[] = $this->menuItemBtn;
		}
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $myClasses ), $item ) ) );

		// Build HTML.
		$output .= $indent . '<li class="' . $depth_class_names . ' ' . $class_names . '">';

		// Link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="'.$this->menuLinkClass.'"';

		// Build HTML output and pass through the proper filter.
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}