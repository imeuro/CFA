<?php
// Register Custom Post Type


//////////////////////////////////////
//
//  v 1.6 post type for CFA Authors
//
//////////////////////////////////////


// Register Custom Post Type
function CFA_custom_post_type() {

	$labels = array(
		'name'                => _x( 'CFA Authors', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'CFA Author', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'CFA Authors', 'text_domain' ),
		'name_admin_bar'      => __( 'CFA Authors', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'CFA Author', 'text_domain' ),
		'description'         => __( 'CFA Authors', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-businessman',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);



	$labels2 = array(
		'name'                  => _x( 'Translations', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Translation', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Translations', 'text_domain' ),
		'name_admin_bar'        => __( 'Translations', 'text_domain' ),
		'archives'              => __( 'Translations Archives', 'text_domain' ),
		'attributes'            => __( 'Translations Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Translations:', 'text_domain' ),
		'all_items'             => __( 'All Translations', 'text_domain' ),
		'add_new_item'          => __( 'Add New Translation', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Translation', 'text_domain' ),
		'edit_item'             => __( 'Edit Translation', 'text_domain' ),
		'update_item'           => __( 'Update Translation', 'text_domain' ),
		'view_item'             => __( 'View Translation', 'text_domain' ),
		'view_items'            => __( 'View Translations', 'text_domain' ),
		'search_items'          => __( 'Search Translation', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Translation', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Translation', 'text_domain' ),
		'items_list'            => __( 'Translations list', 'text_domain' ),
		'items_list_navigation' => __( 'Translations list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Translations list', 'text_domain' ),
	);
	$rewrite2 = array(
		'slug'                  => 'it',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args2 = array(
		'label'                 => __( 'translation', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels2,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-translation',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'ita',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite2,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);


	$labels3 = array(
		'name'                => _x( 'CFA Sponsors', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'CFA Sponsor', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'CFA Sponsors', 'text_domain' ),
		'name_admin_bar'      => __( 'CFA Sponsors', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args3 = array(
		'label'               => __( 'CFA Sponsor', 'text_domain' ),
		'description'         => __( 'CFA Sponsors', 'text_domain' ),
		'labels'              => $labels3,
		'supports'            => array( 'title', 'thumbnail', ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-businessman',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);




	$labels4 = array(
		'name'                => _x( 'CFA Live', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'CFA Live', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'CFA Live', 'text_domain' ),
		'name_admin_bar'      => __( 'CFA Live', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args4 = array(
		'label'               => __( 'CFA Live', 'text_domain' ),
		'description'         => __( 'CFA Live', 'text_domain' ),
		'labels'              => $labels4,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'event_label' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-tickets-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest' 		  => true
	);


	// register_post_type( 'cfa_authors', $args );
	register_post_type( 'cfa_translations', $args2 );
	register_post_type( 'cfa_sponsors', $args3 );
	register_post_type( 'cfa_live', $args4 );

}
add_action( 'init', 'CFA_custom_post_type', 0 );



// Register Custom Taxonomy
function event_label_tax() {

	$labels = array(
		'name'                       => _x( 'event labels', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'event label', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'event label', 'text_domain' ),
		'all_items'                  => __( 'All event labels', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent event label:', 'text_domain' ),
		'new_item_name'              => __( 'New event label', 'text_domain' ),
		'add_new_item'               => __( 'Add New event label', 'text_domain' ),
		'edit_item'                  => __( 'Edit event label', 'text_domain' ),
		'update_item'                => __( 'Update event label', 'text_domain' ),
		'view_item'                  => __( 'View event label', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove event label', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular event labels', 'text_domain' ),
		'search_items'               => __( 'Search event labels', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'event labels list', 'text_domain' ),
		'items_list_navigation'      => __( 'event labels list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'show_ui'					 => true,
		'show_admin_column'			 => true,
		'show_in_rest'				 => true, // Needed for tax to appear in Gutenberg editor.
		'query_var'					 => true,
	);
	register_taxonomy( 'event_label', array( 'cfa_live' ), $args );

}
add_action( 'init', 'event_label_tax', 0 );



/** 
 * Snippet Name: Count custom post type items in dashboard 
 * Snippet URL: http://www.wpcustoms.net/snippets/count-custom-post-type-items-dashboard/ 
 */  
 function wpc_cpt_glance_counter( $items = array() ) {  
    $post_types = array( 'cfa_translations' ); // add your custom post type name here  
    foreach( $post_types as $type ) {  
        if( ! post_type_exists( $type ) ) continue;  
        $num_posts = wp_count_posts( $type );  
        if( $num_posts ) {  
            $published = intval( $num_posts->publish );  
            $post_type = get_post_type_object( $type );  
            $text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'your_textdomain' );  
            $text = sprintf( $text, number_format_i18n( $published ) );  
            if ( current_user_can( $post_type->cap->edit_posts ) ) {  
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';  
                echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';  
            } else {  
            $output = '<span>' . $text . '</span>';  
                echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';  
            }  
        }  
    }  
    return $items;  
}  
add_filter( 'dashboard_glance_items', 'wpc_cpt_glance_counter', 10, 1 ); 

?>