<?php
add_theme_support('custom-logo');
add_theme_support('post-thumbnails');

/* Add Social Media links to the theme customizer */

/* Create an array of available social media networks */

function theme_customizer_social_media_array() {
    $social_sites = array(
        'twitter' => 'Twitter', 
        'facebook' => 'Facebook', 
        'youtube' => 'YouTube', 
        'linkedin' => 'LinkedIn', 
        'instagram' => 'Instagram', 
        'github' => 'GitHub'
    );

    return $social_sites;
}

/* Add settings to create various social media text areas. */

add_action('customize_register', 'add_social_sites_customizer');

function add_social_sites_customizer($wp_customize) {
    $wp_customize->add_section('theme_social_settings', array(
            'title' => __('Social Media', 'text-domain'),
            'priority' => 35,
        )
    );

    $social_sites = theme_customizer_social_media_array();
    $priority = 5;

    foreach ($social_sites as $key => $label) {
        if ($key == 'email') {
            $sanitize = 'sanitize_email';
        } else {
            $sanitize = 'esc_url_raw';
        }

        $wp_customize->add_setting("$key", array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => $sanitize
            )
        );

        $wp_customize->add_control($key, array(
                'label' => __("$label", 'text-domain'),
                'section' => 'theme_social_settings',
                'type' => 'text',
                'priority' => $priority,
            )
        );

        $priority = $priority + 5;
    }
}

/* Display social media icons */

function display_social_media_icons() {
    $social_sites = theme_customizer_social_media_array();
    $output = false;

    /* Add social media links to an array if they aren't blank */

    foreach ($social_sites as $key => $value) {
        if (strlen(get_theme_mod($key)) > 0) {
            $active_sites[$key] = $value;
        }
    }

    /* For each active social site, add it as a list item */

    if (!empty($active_sites)) {
        $output = '
            <ul class="social-media-icons">
        ';
    
        foreach ($active_sites as $key => $value) {
            $class = 'fab fa-' . $key;

            if ($key == 'email') {
                $email = get_theme_mod($key);

                if ($email) {
                    if (is_email($email)) {
                        $output .= '
                            <li>
                                <a class="email" target="_blank" href="mailto:' . antispambot($email) . '">
                                    <i class="fas fa-envelope" title="Email"></i>
                                </a>
                            </li>
                        ';
                    }
                }
            } else {
                $output .= '
                    <li>
                        <a class="' . $key . '" target="_blank" href="' . esc_url(get_theme_mod($key)) . '">
                            <i class="' . esc_attr($class) . '" title="' . $value . '"></i>
                        </a>
                    </li>
                ';
            }
        }

        $output .= '</ul>';
    }

    return $output;
}

add_shortcode('social-icons', 'display_social_media_icons');

/* Add contact info fields to the theme customizer */

/* Create an array of contact fields */

function theme_customizer_contact_fields() {
    $contact_fields = array(
        'contact_company' => 'Company', 
        'contact_name' => 'Contact Name', 
        'contact_email' => 'Email', 
        'contact_phone_1' => 'Primary Phone', 
        'contact_phone_2' => 'Alternate Phone', 
        'contact_fax' => 'Fax', 
        'contact_address_1' => 'Address', 
        'contact_address_2' => 'Address', 
        'contact_city' => 'City', 
        'contact_province' => 'Province / State', 
        'contact_country' => 'Country', 
        'contact_postal_code' => 'Postal Code / ZIP'
    );

    return $contact_fields;
}

/* Add settings to create various social media text areas. */

add_action('customize_register', 'add_contact_customizer');

function add_contact_customizer($wp_customize) {
    $wp_customize->add_section('theme_contact_settings', array(
            'title' => __('Contact Information', 'text-domain'),
            'priority' => 35,
        )
    );

    $contact_fields = theme_customizer_contact_fields();
    $priority = 5;

    foreach ($contact_fields as $key => $label) {
        if ($key == 'contact_email') {
            $sanitize = 'sanitize_email';
        } else {
            $sanitize = 'wp_filter_nohtml_kses';
        }

        $wp_customize->add_setting("$key", array(
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => $sanitize
            )
        );

        $wp_customize->add_control($key, array(
                'label' => __("$label", 'text-domain'),
                'section' => 'theme_contact_settings',
                'type' => 'text',
                'priority' => $priority,
            )
        );

        $priority = $priority + 5;
    }
}
?>