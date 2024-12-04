<?php
/** 
 * To create custom post types
*/

/**
 * Custom post: Space
 */
function office_space_post_type() {

	$labels = array(
		'name'                  => _x( 'Spaces', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Space', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Spaces', 'text_domain' ),
		'name_admin_bar'        => __( 'Space', 'text_domain' ),
		'archives'              => __( 'Space Archives', 'text_domain' ),
		'attributes'            => __( 'Space Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Space:', 'text_domain' ),
		'all_items'             => __( 'All Spaces', 'text_domain' ),
		'add_new_item'          => __( 'Add New Space', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Space', 'text_domain' ),
		'edit_item'             => __( 'Edit Space', 'text_domain' ),
		'update_item'           => __( 'Update Space', 'text_domain' ),
		'view_item'             => __( 'View Space', 'text_domain' ),
		'view_items'            => __( 'View Spaces', 'text_domain' ),
		'search_items'          => __( 'Search Space', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Space', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Space', 'text_domain' ),
		'items_list'            => __( 'Spaces list', 'text_domain' ),
		'items_list_navigation' => __( 'Spaces list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Spaces list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Space', 'text_domain' ),
		'description'           => __( 'Post type for office spaces', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes','excerpt' ),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-screenoptions',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'space', $args );

}
add_action( 'init', 'office_space_post_type', 0 );


