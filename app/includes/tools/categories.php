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

$categories = [
    'checker_tools' => [
        'type' => 'default',
        'color' => '#d72cef', // pink
        'faded_color' => '#f5d2fe', // pink
        'icon' => 'fas fa-check-square',
    ],

    'text_tools' => [
        'type' => 'default',
        'color' => '#64748b', // grey
        'faded_color' => '#dbeaff', // grey
        'icon' => 'fas fa-font',
    ],

    'converter_tools' => [
        'type' => 'default',
        'color' => '#10b981', // emerald
        'faded_color' => '#c0ffea', // emerald
        'icon' => 'fas fa-exchange-alt',
    ],

    'generator_tools' => [
        'type' => 'default',
        'color' => '#0ea5e9', // sky
        'faded_color' => '#c9eeff', // sky
        'icon' => 'fas fa-cogs',
    ],

    'developer_tools' => [
        'type' => 'default',
        'color' => '#3b82f6', // blue
        'faded_color' => '#ccdfff', // blue
        'icon' => 'fas fa-code',
    ],

    'image_manipulation_tools' => [
        'type' => 'default',
        'color' => '#f97316', // orange
        'faded_color' => '#ffd5b7', // orange
        'icon' => 'fas fa-image',
    ],

    'unit_converter_tools' => [
        'type' => 'default',
        'color' => '#f43f5e', // rose
        'faded_color' => '#ffd1d9', // rose
        'icon' => 'fas fa-ruler-combined',
    ],

    'time_converter_tools' => [
        'type' => 'default',
        'color' => '#32758c', // green something
        'faded_color' => '#c9eefb', // green something
        'icon' => 'fas fa-clock',
    ],

    'data_converter_tools' => [
        'type' => 'default',
        'color' => '#43571d', // olive
        'faded_color' => '#e4f6c1', // olive
        'icon' => 'fas fa-database',
    ],

    'color_converter_tools' => [
        'type' => 'default',
        'color' => '#16a34a', // green (distinct yet harmonious with emerald and olive)
        'faded_color' => '#bfffc9', // soft green tint
        'icon' => 'fas fa-palette',
    ],

    'misc_tools' => [
        'type' => 'default',
        'color' => '#a855f7', // purple
        'faded_color' => '#e4cdfa', // purple
        'icon' => 'fas fa-tools',
    ],
];

$pro_categories = \Altum\Plugin::is_active('pro-tools') && file_exists(\Altum\Plugin::get('pro-tools')->path . 'includes/tools/pro_categories.php') ? include \Altum\Plugin::get('pro-tools')->path . 'includes/tools/pro_categories.php' : [];

return array_merge($categories, $pro_categories);
