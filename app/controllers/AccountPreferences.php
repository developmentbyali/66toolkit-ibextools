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

namespace Altum\Controllers;

use Altum\Alerts;

defined('ALTUMCODE') || die();

class AccountPreferences extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        if(is_null($this->user->preferences)) {
            $this->user->preferences = new \StdClass();
        }
        
        if(!empty($_POST)) {

            /* White labeling */
            $_POST['white_label_title'] = isset($_POST['white_label_title']) ? input_clean($_POST['white_label_title'], 32) : '';

            /* Uploads processing */
            foreach(['logo_light', 'logo_dark', 'favicon'] as $image_key) {
                $this->user->preferences->{'white_label_' . $image_key} = \Altum\Uploads::process_upload($this->user->preferences->{'white_label_' . $image_key}, 'users', 'white_label_' . $image_key, 'white_label_' . $image_key . '_remove', null);
            }

            /* Clean some posted variables */
            $_POST['default_results_per_page'] = isset($_POST['default_results_per_page']) && in_array($_POST['default_results_per_page'], [10, 25, 50, 100, 250, 500, 1000]) ? (int) $_POST['default_results_per_page'] : settings()->main->default_results_per_page;
            $_POST['default_order_type'] = isset($_POST['default_order_type']) && in_array($_POST['default_order_type'], ['ASC', 'DESC']) ? $_POST['default_order_type'] : settings()->main->default_order_type;
            $_POST['signatures_default_order_by'] = isset($_POST['signatures_default_order_by']) && in_array($_POST['signatures_default_order_by'], ['signature_id', 'last_datetime', 'name', 'datetime']) ? $_POST['signatures_default_order_by'] : 'signature_id';
            $_POST['projects_default_order_by'] = isset($_POST['projects_default_order_by']) && in_array($_POST['projects_default_order_by'], ['project_id', 'last_datetime', 'name', 'datetime']) ? $_POST['projects_default_order_by'] : 'project_id';

            /* Custom */
            $_POST['documents_default_order_by'] = isset($_POST['documents_default_order_by']) && in_array($_POST['documents_default_order_by'], ['document_id', 'datetime', 'last_datetime', 'name', 'words']) ? $_POST['documents_default_order_by'] : 'document_id';
            $_POST['images_default_order_by'] = isset($_POST['images_default_order_by']) && in_array($_POST['images_default_order_by'], ['image_id', 'datetime', 'last_datetime', 'name']) ? $_POST['images_default_order_by'] : 'image_id';
            $_POST['transcriptions_default_order_by'] = isset($_POST['transcriptions_default_order_by']) && in_array($_POST['transcriptions_default_order_by'], ['transcription_id', 'datetime', 'last_datetime', 'name', 'words']) ? $_POST['transcriptions_default_order_by'] : 'transcription_id';
            $_POST['syntheses_default_order_by'] = isset($_POST['syntheses_default_order_by']) && in_array($_POST['syntheses_default_order_by'], ['synthesis_id', 'datetime', 'last_datetime', 'name', 'total_messages']) ? $_POST['syntheses_default_order_by'] : 'synthesis_id';
            $_POST['chats_default_order_by'] = isset($_POST['chats_default_order_by']) && in_array($_POST['chats_default_order_by'], ['chat_id', 'datetime', 'last_datetime', 'name', 'total_messages']) ? $_POST['chats_default_order_by'] : 'chat_id';

            $_POST['openai_api_key'] = input_clean($_POST['openai_api_key'] ?? null);
            $_POST['clipdrop_api_key'] = input_clean($_POST['clipdrop_api_key'] ?? null);

            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

            /* Check for any errors */
            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $preferences = json_encode([
                    'white_label_title' => $_POST['white_label_title'],
                    'white_label_logo_light' => $this->user->preferences->white_label_logo_light,
                    'white_label_logo_dark' => $this->user->preferences->white_label_logo_dark,
                    'white_label_favicon' => $this->user->preferences->white_label_favicon,
                    'default_results_per_page' => $_POST['default_results_per_page'],
                    'default_order_type' => $_POST['default_order_type'],
                    'projects_default_order_by' => $_POST['projects_default_order_by'],
                    'signatures_default_order_by' => $_POST['signatures_default_order_by'],

                    'documents_default_order_by' => $_POST['documents_default_order_by'],
                    'images_default_order_by' => $_POST['images_default_order_by'],
                    'transcriptions_default_order_by' => $_POST['transcriptions_default_order_by'],
                    'syntheses_default_order_by' => $_POST['syntheses_default_order_by'],
                    'chats_default_order_by' => $_POST['chats_default_order_by'],

                    'openai_api_key' => $_POST['openai_api_key'],
                    'clipdrop_api_key' => $_POST['clipdrop_api_key'],
                    'aws_access_key' => $_POST['aws_access_key'],
                    'aws_secret_access_key' => $_POST['aws_secret_access_key'],
                    'aws_region' => $_POST['aws_region'],
                ]);

                /* Database query */
                db()->where('user_id', $this->user->user_id)->update('users', [
                    'preferences' => $preferences,
                ]);

                /* Set a nice success message */
                Alerts::add_success(l('account_preferences.success_message'));

                /* Clear the cache */
                cache()->deleteItemsByTag('user_id=' . $this->user->user_id);

                /* Send webhook notification if needed */
                if(settings()->webhooks->user_update) {
                    fire_and_forget('post', settings()->webhooks->user_update, [
                        'user_id' => $this->user->user_id,
                        'email' => $this->user->email,
                        'name' => $this->user->name,
                        'source' => 'account_preferences',
                    ]);
                }

                redirect('account-preferences');
            }

        }

        /* Get the account header menu */
        $menu = new \Altum\View('partials/account_header_menu', (array) $this);
        $this->add_view_content('account_header_menu', $menu->run());

        /* Prepare the view */
        $data = [];

        $view = new \Altum\View('account-preferences/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
