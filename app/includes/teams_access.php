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

$access = [
    'read' => [
        'read.all' => l('global.all')
    ],

    'create' => [
    ],

    'update' => [
    ],

    'delete' => [
    ],
];

if(\Altum\Plugin::is_active('email-signatures')) {
    $access['create']['create.signatures'] = l('signatures.title');
    $access['update']['update.signatures'] = l('signatures.title');
    $access['delete']['delete.signatures'] = l('signatures.title');
}

if(\Altum\Plugin::is_active('aix')) {
    if(settings()->aix->documents_is_enabled) {
        $access['create']['create.documents'] = l('documents.title');
        $access['update']['update.documents'] = l('documents.title');
        $access['delete']['delete.documents'] = l('documents.title');
    }

    if(settings()->aix->images_is_enabled) {
        $access['create']['create.images'] = l('images.title');
        $access['update']['update.images'] = l('images.title');
        $access['delete']['delete.images'] = l('images.title');
    }

    if(settings()->aix->transcriptions_is_enabled) {
        $access['create']['create.transcriptions'] = l('transcriptions.title');
        $access['update']['update.transcriptions'] = l('transcriptions.title');
        $access['delete']['delete.transcriptions'] = l('transcriptions.title');
    }

    if(settings()->aix->syntheses_is_enabled) {
        $access['create']['create.syntheses'] = l('syntheses.title');
        $access['update']['update.syntheses'] = l('syntheses.title');
        $access['delete']['delete.syntheses'] = l('syntheses.title');
    }

    if(settings()->aix->chats_is_enabled) {
        $access['create']['create.chats'] = l('chats.title');
        $access['update']['update.chats'] = l('chats.title');
        $access['delete']['delete.chats'] = l('chats.title');
    }
}

return $access;
