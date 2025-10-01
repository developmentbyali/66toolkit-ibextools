<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 * 🌍 View all other existing AltumCode projects via https://altumcode.com/
 * 📧 Get in touch for support or general queries via https://altumcode.com/contact
 * 📤 Download the latest version via https://altumcode.com/downloads
 *
 * 🐦 X/Twitter: https://x.com/AltumCode
 * 📘 Facebook: https://facebook.com/altumcode
 * 📸 Instagram: https://instagram.com/altumcode
 */

defined('ALTUMCODE') || die();

$tools = [];

$color_converter_units = array_keys(require APP_PATH . 'includes/tools/color_converter_units.php');

foreach($color_converter_units as $main_key) {
    foreach($color_converter_units as $secondary_key) {
        if($main_key == $secondary_key) continue;

        $tools[$main_key . '_to_' . $secondary_key] = [
            'icon' => 'fas fa-palette',
            'category' => 'color_converter_tools',
            'similar' => [
                $secondary_key . '_to_' . $main_key
            ]
        ];
    }
}

return $tools;
