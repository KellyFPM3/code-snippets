<?php
add_action('init', 'register_custom_post_type');

function register_custom_post_type() {

	register_post_type('employee',
		array(
            'labels' => array (
                'name' => __('Employees'),
                'singular_name' => __('Employee'),
                'all_items' => __('Employees'),
                'add_new' => __('Add Employee'),
            ),
            'menu_icon' => 'dashicons-admin-users',
            'public' => true,
            'exclude_from_search' => true,
            'has_archive' => false,
            'capability_type' => 'page',
            'supports' => array('title','editor','thumbnail')
        )
    );

    register_taxonomy(
        'department', 
        'employee', 
        array(
            'show_in_menu' => false,
            'hierarchical' => true, 
            'label' => __('Department'), 
            'query_var' => 'department'
        )
    );
}

?>