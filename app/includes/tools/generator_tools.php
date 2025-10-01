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
    'paypal_link_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fab fa-paypal'
    ],

    'signature_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-signature',
    ],

    'mailto_link_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-envelope-open'
    ],

    'utm_link_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-external-link-alt'
    ],

    'whatsapp_link_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fab fa-whatsapp'
    ],

    'youtube_timestamp_link_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fab fa-youtube'
    ],

    'slug_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-grip-lines'
    ],

    'lorem_ipsum_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-paragraph'
    ],

    'password_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-lock',
        'similar' => [
            'password_strength_checker',
        ]
    ],

    'random_number_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-random'
    ],

    'uuid_v4_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-compress'
    ],

    'bcrypt_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-passport'
    ],

    'md2_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-hand-sparkles',
        'similar' => [
            'md4_generator',
            'md5_generator',
        ]
    ],

    'md4_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-columns',
        'similar' => [
            'md2_generator',
            'md5_generator',
        ]
    ],

    'md5_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-hashtag',
        'similar' => [
            'md2_generator',
            'md4_generator',
        ]
    ],

    'whirlpool_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-spinner'
    ],

    'sha1_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-asterisk'
    ],

    'sha224_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-atom'
    ],

    'sha256_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-compact-disc'
    ],

    'sha384_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-certificate'
    ],

    'sha512_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-bahai'
    ],

    'sha512_224_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-crosshairs'
    ],

    'sha512_256_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-sun'
    ],

    'sha3_224_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-compass'
    ],

    'sha3_256_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-ring'
    ],

    'sha3_384_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-life-ring'
    ],

    'sha3_512_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-circle-notch'
    ],

    'ripemd128_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-laptop-code'
    ],

    'ripemd160_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-laptop-code'
    ],

    'ripemd256_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-laptop-code'
    ],

    'ripemd320_generator' => [
        'category' => 'generator_tools',
        'icon' => 'fas fa-laptop-code'
    ],
];
