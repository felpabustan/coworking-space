<?php

/**
 * Class Name: widgetWalker
 * GitHub URI: https://github.com/dupkey/bs4navwalker
 * Description: A custom WordPress nav walker class for side menu widgets with dropdown
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class menuMobileWalker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t",$depth);
		// $submenu = ($depth > 0) ? ' sub-menu' : '';
		$output .= "\n$indent<ul role=\"menu\" class=\"ps-4 py-3 submenu depth_$depth\">\n";

	}

	// function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	// 	$indent = ($depth) ? str_repeat("\t",$depth) : '';

	// 	$li_attributes = '';
	// 	$class_names = $value = '';

	// 	$classes = empty($item->classes) ? array() : (array) $item->classes;

	// 	$classes[] = ($item->current || $item->current_item_ancestor) ? 'gold':'';
	// 	$classes[] = 'menu-item-'.$item->ID.' py-3';

	// 	$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
	// 	$class_names =' class="'.esc_attr($class_names).'"';

	// 	$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
	// 	$id = strlen($id) ? ' id="'.esc_attr($id).'"':'';

	// 	$output .= $indent.'<li'. $id . $value . $class_names . $li_attributes . '>';

	// 	$atts = array();
	// 	$atts['title']  = ! empty( $item->title )	? $item->title	: '';
	// 	$atts['target'] = ! empty( $item->target )	? $item->target	: '';
	// 	$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
	// 	$atts['href'] 	= ! empty( $item->url ) ? $item->url : '';
	// 	$atts['class'] = ($depth && $args->walker->has_children) ? 'may-child':'walang-child';

	// 	$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

	// 	$attributes = '';
	// 	foreach ( $atts as $attr => $value ) {
	// 		if ( ! empty( $value ) ) {
	// 			$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
	// 			$attributes .= ' ' . $attr . '="' . $value . '"';
	// 		}
	// 	}

	// 	$item_output = $args->before;
	// 	$item_output .= '<a'. $attributes .'>';
	// 	$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	// 	$item_output .= $args->after;

	// 	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	// 	// $args->menu_id = $item->ID;

	// }
}
