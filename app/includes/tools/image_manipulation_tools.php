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

$types = [
    'png' => 'fas fa-camera-retro',
    'jpg' => 'fas fa-photo-video',
    'bmp' => 'fas fa-film',
    'ico' => 'fas fa-portrait',
    'gif' => 'fas fa-icons',
    'webp' => 'fas fa-images',
    'heic' => 'fas fa-mobile',
    'avif' => 'fas fa-sd-card',
    'tiff' => 'fas fa-camera',
    'tga' => 'fas fa-eye',
];

foreach($types as $main_key => $icon) {
    foreach($types as $secondary_key => $icon2) {
        if($main_key == $secondary_key) continue;
        if($secondary_key == 'heic') continue;
        if($main_key == 'tga') continue;

        /* Generate similar */
        $similar = [
            $secondary_key . '_to_' . $main_key
        ];

        if($main_key == 'heic') $similar = [];
        if($secondary_key == 'tga') $similar = [];

        $tools[$main_key . '_to_' . $secondary_key] = [
            'icon' => $icon,
            'category' => 'image_manipulation_tools',
            'similar' => $similar
        ];
    }
}


return $tools;
