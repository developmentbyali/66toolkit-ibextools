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

$time_converter_units = [
    'seconds' => 1,
    'milliseconds' => 0.001,
    'microseconds' => 0.000001,
    'nanoseconds' => 0.000000001,
    'picoseconds' => 0.000000000001,
    'minutes' => 60,
    'hours' => 3600,
    'days' => 86400,
    'weeks' => 604800,
    'months' => 2629746,
    'years' => 31556952,
    'decades' => 315569520,
    'centuries' => 3155695200,
    'millennia' => 31556952000,
];

$pro_time_converter_units = \Altum\Plugin::is_active('pro-tools') && file_exists(\Altum\Plugin::get('pro-tools')->path . 'includes/tools/pro_time_converter_units.php') ? include \Altum\Plugin::get('pro-tools')->path . 'includes/tools/pro_time_converter_units.php' : [];

return array_merge($time_converter_units, $pro_time_converter_units);
