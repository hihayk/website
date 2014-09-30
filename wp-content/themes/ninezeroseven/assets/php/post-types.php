<?php
/************************************************************************
* Custom Post Types
*************************************************************************/


add_action('init', 'one_page_section'); 
add_action('init', 'one_page_parallax');  
add_action('init', 'one_page_recent_works');  
add_action('init', 'one_page_portfolio'); 
add_action('init', 'team_members'); 

function one_page_section()  {  
  $labels = array(  
    'name' => __('Page Sections', 'framework'),  
    'singular_name' => __('Page Sections', 'framework'),  
    'add_new' => __('Add New Section', 'framework'),  
    'add_new_item' => __('Add New Section', 'framework'),  
    'edit_item' => __('Edit section', 'framework'),  
    'new_item' => __('New section', 'framework'),  
    'view_item' => __('View section', 'framework'),  
    'search_items' => __('Search sections', 'framework'),  
    'not_found' =>  __('No sections found', 'framework'),  
    'not_found_in_trash' => __('No sections found in Trash', 'framework'),  
    'parent_item_colon' => '' 
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => false,  
    'show_ui' => true,  
    'query_var' => true,
    'rewrite' => true,  
    'capability_type' => 'post',
    'show_in_nav_menus' => true,  	 
    'hierarchical' => false, 
	'exclude_from_search' => true,	 
    'menu_position' => 5, 
    'menu_icon' => get_template_directory_uri().'/admin/assets/images/icon-headers.png', 
    'supports' => array('title','editor')  
  );  
  register_post_type('page-sections',$args);  
} 

function one_page_parallax()  {  
  $labels = array(  
    'name' => __('Parallax Sections', 'framework'),  
    'singular_name' => __('Parallax Sections', 'framework'),  
    'add_new' => __('Add New Parallax', 'framework'),  
    'add_new_item' => __('Add New Parallax', 'framework'),  
    'edit_item' => __('Edit parallax', 'framework'),  
    'new_item' => __('New parallax', 'framework'),  
    'view_item' => __('View parallax', 'framework'),  
    'search_items' => __('Search parallax', 'framework'),  
    'not_found' =>  __('No parallax found', 'framework'),  
    'not_found_in_trash' => __('No parallax found in Trash', 'framework'),  
    'parent_item_colon' => ''  
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => false,  
    'show_ui' => true,  
    'query_var' => true,  
    'rewrite' => true,  
    'capability_type' => 'post', 
    'show_in_nav_menus' => false,    
    'hierarchical' => false, 
    'exclude_from_search' => true,   
    'menu_position' => 5,  
    'menu_icon' => get_template_directory_uri().'/admin/assets/images/icon-parallax.png',
    'supports' => array('title','editor')  
  );  
  register_post_type('parallax-sections',$args);  
} 

function one_page_recent_works()  {  
  $labels = array(  
    'name' => __('Recent Works', 'framework'),  
    'singular_name' => __('Recent Works', 'framework'),  
    'add_new' => __('Add Recent Works', 'framework'),  
    'add_new_item' => __('Add Recent Works', 'framework'),  
    'edit_item' => __('Edit Recent Works', 'framework'),  
    'new_item' => __('New Recent Works', 'framework'),  
    'view_item' => __('View Recent Works', 'framework'),  
    'search_items' => __('Search Recent Works', 'framework'),  
    'not_found' =>  __('No Recent Works found', 'framework'),  
    'not_found_in_trash' => __('No Recent Works found in Trash', 'framework'),  
    'parent_item_colon' => ''  
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => true,  
    'show_ui' => true,  
    'query_var' => true,
    'capability_type' => 'post',
    'show_in_nav_menus' => false,       
    'hierarchical' => false, 
    'exclude_from_search' => true,   
    'menu_position' => 5, 
    'rewrite' => array( 'slug' => 'project' ),
    'menu_icon' => get_template_directory_uri().'/admin/assets/images/icon-works.png',
    'supports' => array('title','editor','thumbnail','comments','excerpt')  
  );  
  register_post_type('recent_works',$args);  
}

function works_categories() {
    register_taxonomy("filter_works", 
    array("recent_works"), 
    array(
        "hierarchical" => true, 
        "label" => __( "Categories", 'framework'), 
        "singular_label" => __( "Category", 'framework'),
        'show_in_nav_menus' => false,  
        )
    ); 
}

add_action( 'init', 'works_categories', 0);


function team_members()  {  
  $labels = array(  
    'name' => __('Team', 'framework'),  
    'singular_name' => __('Team', 'framework'),  
    'add_new' => __('Add Member', 'framework'),  
    'add_new_item' => __('Add Member', 'framework'),  
    'edit_item' => __('Edit Member', 'framework'),  
    'new_item' => __('New Member', 'framework'),  
    'view_item' => __('View Member', 'framework'),  
    'search_items' => __('Search Member', 'framework'),  
    'not_found' =>  __('No Members found', 'framework'),  
    'not_found_in_trash' => __('No Members found in Trash', 'framework'),  
    'parent_item_colon' => ''  
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => false,  
    'show_ui' => true,  
    'query_var' => true,  
    'rewrite' => true,  
    'show_in_nav_menus' => false,  
    'capability_type' => 'post',     
    'hierarchical' => false, 
    'exclude_from_search' => true,   
    'menu_position' => 5,  
    'menu_icon' => get_template_directory_uri().'/admin/assets/images/icon-team.png',
    'supports' => array('title','editor','thumbnail')  
  );  
  register_post_type('team_members',$args);  
} 

function team_categories() {
    register_taxonomy("filter_team", 
    array("team_members"), 
    array(
        "hierarchical" => true, 
        "label" => __( "Categories", 'framework'), 
        "singular_label" => __( "Category", 'framework'),
        'show_in_nav_menus' => false,  
        )
    ); 
}

add_action( 'init', 'team_categories', 0);

function one_page_portfolio()  {  
  $labels = array(  
    'name' => __('Portfolio', 'framework'),  
    'singular_name' => __('Portfolio', 'framework'),  
    'add_new' => __('Add Portfolio', 'framework'),  
    'add_new_item' => __('Add Portfolio', 'framework'),  
    'edit_item' => __('Edit Portfolio', 'framework'),  
    'new_item' => __('New Portfolio', 'framework'),  
    'view_item' => __('View Portfolio', 'framework'),  
    'search_items' => __('Search Portfolio', 'framework'),  
    'not_found' =>  __('No Portfolio found', 'framework'),  
    'not_found_in_trash' => __('No Portfolio found in Trash', 'framework'),  
    'parent_item_colon' => ''  
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => true,  
    'show_ui' => true,  
    'query_var' => true,
    'capability_type' => 'post',
    'show_in_nav_menus' => false,       
    'hierarchical' => false, 
    'exclude_from_search' => true,   
    'menu_position' => 5, 
    'rewrite' => array( 'slug' => 'portfolio' ),
    'menu_icon' => get_template_directory_uri().'/admin/assets/images/icon-portfolio.png', 
    'supports' => array('title','editor','thumbnail','comments','excerpt')  
  );  
  register_post_type('one_page_portfolio',$args);  
} 

function portfolio_filter() {
    register_taxonomy("filter", 
    array("one_page_portfolio"), 
    array(
        "hierarchical" => true, 
        "label" => __( "Filter", 'framework'), 
        "singular_label" => __( "Filter", 'framework'), 
        "rewrite" => array( 'slug' => 'filter', 'hierarchical' => true),
        'show_in_nav_menus' => false,  
        )
    ); 
}

add_action( 'init', 'portfolio_filter', 0);


?>
