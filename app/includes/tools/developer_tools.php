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
    'html_minifier' => [
        'category' => 'developer_tools',
        'icon' => 'fab fa-html5',
        'similar' => [
            'css_minifier',
            'js_minifier'
        ]
    ],

    'css_minifier' => [
        'category' => 'developer_tools',
        'icon' => 'fab fa-css3',
        'similar' => [
            'html_minifier',
            'js_minifier'
        ]
    ],

    'js_minifier' => [
        'category' => 'developer_tools',
        'icon' => 'fab fa-js',
        'similar' => [
            'html_minifier',
            'css_minifier'
        ]
    ],

    'json_validator_beautifier' => [
        'category' => 'developer_tools',
        'icon' => 'fas fa-project-diagram'
    ],

    'sql_beautifier' => [
        'category' => 'developer_tools',
        'icon' => 'fas fa-database'
    ],

    'html_entity_converter' => [
        'category' => 'developer_tools',
        'icon' => 'fas fa-file-code'
    ],

    'bbcode_to_html' => [
        'category' => 'developer_tools',
        'icon' => 'fab fa-html5'
    ],

    'markdown_to_html' => [
        'category' => 'developer_tools',
        'icon' => 'fas fa-code'
    ],

    'html_tags_remover' => [
        'category' => 'developer_tools',
        'icon' => 'fab fa-html5'
    ],

    'user_agent_parser' => [
        'category' => 'developer_tools',
        'icon' => 'fas fa-columns'
    ],

    'url_parser' => [
        'category' => 'developer_tools',
        'icon' => 'fas fa-paperclip'
    ],
];
