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

return [
    'celsius_to_fahrenheit' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-temperature-low',
        'similar' => [
            'fahrenheit_to_celsius'
        ]
    ],

    'celsius_to_kelvin' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-temperature-low',
        'similar' => [
            'kelvin_to_celsius'
        ]
    ],

    'fahrenheit_to_celsius' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-temperature-high',
        'similar' => [
            'celsius_to_fahrenheit'
        ]
    ],

    'fahrenheit_to_kelvin' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-temperature-high',
        'similar' => [
            'kelvin_to_fahrenheit'
        ]
    ],

    'kelvin_to_celsius' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-thermometer-empty',
        'similar' => [
            'celsius_to_kelvin'
        ]
    ],

    'kelvin_to_fahrenheit' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-thermometer-empty',
        'similar' => [
            'fahrenheit_to_kelvin'
        ]
    ],

    'miles_per_hour_to_kilometers_per_hour' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-road',
        'similar' => [
            'kilometers_per_hour_to_miles_per_hour'
        ]
    ],

    'kilometers_per_hour_to_miles_per_hour' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-archway',
        'similar' => [
            'miles_per_hour_to_kilometers_per_hour'
        ]
    ],

    'number_to_roman_numerals' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-sort-numeric-up-alt',
        'similar' => [
            'roman_numerals_to_number'
        ]
    ],

    'roman_numerals_to_number' => [
        'category' => 'unit_converter_tools',
        'icon' => 'fas fa-sort-numeric-up',
        'similar' => [
            'number_to_roman_numerals'
        ]
    ],
];
