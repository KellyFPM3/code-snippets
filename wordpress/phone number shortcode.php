<?php
/* Display Phone Number Link */

function display_phone_link ($atts) {
	$a = shortcode_atts( array(
		'number' => get_theme_mod('contact_phone_1'),
		'country_prefix' => '+1', 
		'title' => 'Phone'
	), $atts);

	$phone_number = $a['number'];
	
	if ($phone_number) {
		$link_replacements = array(
			'(' => '',
			')' => '',
			'-' => '',
			'.' => '',
			' ' => ''
		);
		
		$label_replacements = array(
			'(' => '',
			')' => '',
			'-' => '.',
			' ' => '.'
		);
		
		$phone_link = $phone_number;
		
		foreach ($link_replacements as $search => $replace) {
			$phone_link = str_replace($search, $replace, $phone_link);
		}

		$phone_link = 'tel:' . $a['country_prefix'] . $phone_link;
		
		$phone .= '<a class="phone" href="' . $phone_link . '" title="' . $a['title'] . '">' . $phone_number . '</a>';
	}
	
	return $phone;
}

add_shortcode('phone', 'display_phone_link');
?>