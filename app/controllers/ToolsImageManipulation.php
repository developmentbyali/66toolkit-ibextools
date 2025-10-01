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
use Altum\Meta;
use Altum\Router;
use Altum\Title;

defined('ALTUMCODE') || die();

class ToolsImageManipulation extends Controller {

    public function index() {
        $url = $this->params[0];
        $tool_key = str_replace('-', '_', $url);

        /* Process the URL */
        $exploded = explode('-to-', $url);
        $from = $exploded[0];
        $to = $exploded[1];

        /* Process everything else */
        if(!settings()->tools->available_tools->{$tool_key}) {
            redirect();
        }

        if(!$this->user->plan_settings->enabled_tools->{$tool_key}) {
            Alerts::add_info(l('global.info_message.plan_feature_no_access'));
            redirect();
        }

        if(string_starts_with('tools/', \Altum\Router::$original_request)) {
            redirect(str_replace('_', '-', $tool_key), true, 301);
        }

        /* Detect extra details about the user */
        $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);

        /* Add a new view to the page */
        $cookie_name = 't_statistics_' . $tool_key;
        if(!isset($_COOKIE[$cookie_name]) && $whichbrowser->device->type != 'bot') {
            setcookie($cookie_name, (int) true, time()+60*60*24*1);
            db()->onDuplicate(['total_views'], 'id');
            db()->insert('tools_usage', [
                'tool_id' => $tool_key,
                'total_views' => db()->inc(),
            ]);
        }

        $tools_usage = (new \Altum\Models\Tools())->get_tools_usage();

        /* Meta & title */
        Title::set(sprintf(l('tools.tool_title'), sprintf(l('tools.image_manipulation_tools.name'), l('tools.' . $from), l('tools.' . $to))), true);
        Meta::set_description(sprintf(l('tools.image_manipulation_tools.description'), l('tools.' . $from), l('tools.' . $to)));
        Meta::set_keywords(sprintf(l('tools.image_manipulation_tools.meta_keywords'), l('tools.' . $from), l('tools.' . $to)));

        /* Popular tools View */
        $view = new \Altum\View('tools/popular_tools', (array) $this);
        $this->add_view_content('popular_tools', $view->run([
            'tools_usage' => $tools_usage,
            'tools' => Router::$data['tools']
        ]));

        /* Similar tools View */
        $view = new \Altum\View('tools/similar_tools', (array) $this);
        $this->add_view_content('similar_tools', $view->run([
            'tools_usage' => $tools_usage,
            'tool' => $tool_key,
            'tools' => Router::$data['tools'],
        ]));

        /* Ratings View */
        $view = new \Altum\View('tools/ratings', (array) $this);
        $this->add_view_content('ratings', $view->run([
            'tools_usage' => $tools_usage,
            'tool_id' => $tool_key,
        ]));

        /* Extra content View */
        $view = new \Altum\View('tools/extra_content', (array) $this);
        $this->add_view_content('extra_content', $view->run([
            'from' => $from,
            'to' => $to,
        ]));

        $data = [
            'tool' => $tool_key,
        ];

        $values = [
            'image' => $_POST['image'] ?? null,
            'quality' => $_POST['quality'] ?? 85,
        ];

        /* Prepare the view */
        $data['values'] = $values;
        $data['from'] = $from;
        $data['to'] = $to;

        $view = new \Altum\View('tools/image_manipulation', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

}
