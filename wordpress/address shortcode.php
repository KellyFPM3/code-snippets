<?php
/* Display Address */

function get_address ($atts = null, $show = null) {
    $a = shortcode_atts(array(
		'company' => get_theme_mod('contact_company'),
		'address_1' => get_theme_mod('contact_address_1'),
		'address_2' => get_theme_mod('contact_address_2'),
		'city' => get_theme_mod('contact_city'),
		'province' => get_theme_mod('contact_province'),
		'country' => get_theme_mod('contact_country'),
		'postal_code' => get_theme_mod('contact_postal_code'),		
		'phone' => get_theme_mod('contact_phone_1'),		
        'breaks' => false,
        'show' => 'street,city,province,country,postal code',
    ), $atts);

	if ($a['breaks'] == 'true') {
    	$line_breaks = true;
	}
	
	$show = explode(',', $a['show']);

	$shown = array();
	
	$address = '<div class="address">';
	
	foreach ($show as $item) {		
		if (trim($item, ' ') == 'company' && $a['company']) {
			$address .= '<span class="company">' . $a['company'] . '</span>';
			$shown[] = 'company';
			
			if ($line_breaks) {
				$address .= '<br />';
			}
		}
	
		if (trim($item, ' ') == 'street' && $a['address_1']) {			
			if (!$line_breaks && in_array('company', $shown)) {
				$address .= ' ';
			}

			$address .= '<span class="street">' . $a['address_1'] . '</span>';
			$shown[] = 'street';
			
			if ($line_breaks) {
				$address .= '<br />';
			}
		}
	
		if (trim($item, ' ') == 'city' && $a['city']) {
			
			$address .= '<span class="city">';
			
			if (!$line_breaks && in_array('street', $shown)) {
				$address .= ', ';
			}

			$address .= $a['city'] . '</span>';
			$shown[] = 'city';
		}
		
		if (trim($item, ' ') == 'province' && $a['province']) {
			
			$address .= '<span class="province">';
	
			if (!$line_breaks && (in_array('street', $shown) || in_array('city', $shown))) {
				$address .= ', ';
			} else if ($line_breaks && in_array('city', $shown)) {
				$address .= ', ';
			}
			
			$address .= $a['province'] . '</span>';
			$shown[] = 'province';
		}
		
		if (trim($item, ' ') == 'country' && $a['country']) {
			
			$address .= '<span class="country">';
	
			if (!$line_breaks && (in_array('street', $shown) || in_array('city', $shown) || in_array('province', $shown))) {
				$address .= ', ';
			} else if ($line_breaks && in_array('province', $shown)) {
				$address .= ', ';
			}
			
			$address .= $a['country'] . '</span>';
			$shown[] = 'country';
			
			if ($line_breaks) {
				$address .= '<br />';
			}
		}
		
		if (trim($item, ' ') == 'postal code' && $a['postal_code']) {
			
			$address .= '<span class="postal_code">';

			if (in_array('street', $shown) || in_array('city', $shown) || in_array('province', $shown)) {
                if (!$line_breaks) {
				    $address .= '&nbsp;';
                }
			}
            
			$address .= $a['postal_code'] . '</span>';
			$shown[] = 'postal code';
		}
		
		if (trim($item, ' ') == 'phone' && $a['phone']) {
			$phone_number = do_shortcode('[phone number="' . $a['phone'] . '"]');
			$address .= $phone_number;
			$shown[] = 'phone';
		}
	}
    
    $address .= '</div>';
	
	return $address;
}

add_shortcode('address', 'get_address');
?>