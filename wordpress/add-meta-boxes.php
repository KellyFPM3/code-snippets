<?php
// Add custom meta boxes

add_action('add_meta_boxes', 'add_cpt_metaboxes');

function add_cpt_metaboxes() {
    /* 
        Replace 'post-type' with the slug of your custom post type (eg. 'project'), or 
        use one of the default post types (post, page, etc.). 

        More information: https://developer.wordpress.org/reference/functions/add_meta_box/
    */

    add_meta_box('cpt_meta_box_function', 'Title', 'cpt_meta_box_function', 'post-type', 'normal', 'default');
}

// Add the form fields to the meta box

function cpt_meta_box_function() {
    global $post;
    
    // Create a 'noncename' to add security to the meta box

	echo '<input type="hidden" name="cpt_meta_noncename" id="cpt_meta_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    // Get the previously saved values for the fields

    $first_name = get_post_meta($post->ID, 'first_name', true);
    $last_name = get_post_meta($post->ID, 'last_name', true);
    $email = get_post_meta($post->ID, 'email', true);
    $link = get_post_meta($post->ID, 'link', true);

    // Display the fields

    echo '
        <input class="widefat" type="text" name="first_name" value="' . $first_name . '" /><br />
        <input class="widefat" type="text" name="last_name" value="' . $last_name . '" /><br />
        <input class="widefat" type="text" name="email" value="' . $email . '" /><br />
        <input class="widefat" type="text" name="link" value="' . $link . '" /><br />
    ';
}

// Save the metabox data

function save_cpt_meta($post_id, $post) {
	if (!wp_verify_nonce($_POST['cpt_meta_noncename'], plugin_basename(__FILE__))) {
		return $post->ID;
	}

	if (!current_user_can('edit_post', $post->ID)) {
        return $post->ID;
    }

    // Add the submitted field values to an array

    $cpt_meta['first_name'] = $_POST['first_name'];
    $cpt_meta['last_name'] = $_POST['last_name'];
    $cpt_meta['email'] = $_POST['email'];
    $cpt_meta['link'] = $_POST['link'];

    // Save the array to the database
	
	foreach ($cpt_meta as $key => $value) { 
        if ($post->post_type == 'revision') return;
        
        $value = implode(',', (array)$value);
        
		if (get_post_meta($post->ID, $key, FALSE)) {
			update_post_meta($post->ID, $key, $value);
		} else {
			add_post_meta($post->ID, $key, $value);
        }
        
		if (!$value) delete_post_meta($post->ID, $key);
	}
}

add_action('save_post', 'save_cpt_meta', 1, 2);
?>