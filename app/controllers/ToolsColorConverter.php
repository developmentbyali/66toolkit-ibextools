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

class ToolsColorConverter extends Controller {

    public function index() {
        $url = $this->params[0];
        $tool_key = str_replace('-', '_', $url);

        /* Process the URL */
        $exploded = explode('-to-', $url);
        $from = str_replace('-', '_', $exploded[0]);
        $to = str_replace('-', '_', $exploded[1]);

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
        Title::set(sprintf(l('tools.tool_title'), sprintf(l('tools.color_converter_tools.name'), l('tools.' . $from), l('tools.' . $to))), true);
        Meta::set_description(sprintf(l('tools.color_converter_tools.description'), l('tools.' . $from), l('tools.' . $to)));
        Meta::set_keywords(sprintf(l('tools.color_converter_tools.meta_keywords'), l('tools.' . $from), l('tools.' . $to)));

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
            'tools_usage' => $tools_usage,
            'input' => [],
            'input_fields' => [
                'input' => '',
            ]
        ];

        if(empty($_POST) && isset($_GET['submit'])) {
            foreach($data['input_fields'] as $field_key => $field_default_value) {
                $_POST[$field_key] = $_GET[$field_key] ?? $field_default_value;
            }
        }

        if(!empty($_POST)) {
            $_POST['input'] = input_clean($_POST['input']);

            /* Check for any errors */
            $required_fields = ['input'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            $type = null;

            if(mb_substr($_POST['input'], 0, strlen('#')) === '#') {
                $type = 'hex';
            }

            if(mb_substr($_POST['input'], 0, strlen('#')) === '#' && mb_strlen($_POST['input']) > 7) {
                $type = 'hexa';
            }

            foreach(['rgb', 'rgba', 'hsl', 'hsla', 'hsv'] as $color_type) {
                if(mb_substr($_POST['input'], 0, strlen($color_type)) === $color_type) {
                    $type = $color_type;
                }
            }

            if(!$type) {
                Alerts::add_field_error('input', l('tools.color_converter.error_message'));
            } else {
                try {
                    $class = '\OzdemirBurak\Iris\Color\\' . ucfirst($type);
                    $color = new $class($_POST['input']);
                } catch (\Exception $exception) {
                    Alerts::add_field_error('input', l('tools.color_converter.error_message'));
                }
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $data['result']['hex'] = $color->toHex();
                $data['result']['hexa'] = $color->toHexa();
                $data['result']['rgb'] = $color->toRgb();
                $data['result']['rgba'] = $color->toRgba();
                $data['result']['hsv'] = $color->toHsv();
                $data['result']['hsl'] = $color->toHsl();
                $data['result']['hsla'] = $color->toHsla();

                foreach($data['input_fields'] as $field_key => $field_default_value) {
                    $data['input'][$field_key] = $_POST[$field_key] ?? $field_default_value;
                }

                (new \Altum\Models\Tools())->process_usage($tool_key, $data['input']);

                /* Meta & title */
                Title::set(sprintf(l('tools.tool_title'), sprintf(l('tools.color_converter_tools.submission'), $data['input']['input'], l('tools.' . $from), l('tools.' . $to))), true);
                Meta::set_canonical_url(url($url) . '?' . http_build_query((array) $data['input']));
            }
        }

        $values = [];
        foreach($data['input_fields'] as $field_key => $field_default_value) {
            $values[$field_key] = $_POST[$field_key] ?? $_GET[$field_key] ?? $field_default_value;
        }

        /* Prepare the view */
        $data['values'] = $values;
        $data['from'] = $from;
        $data['to'] = $to;
        $data['tool'] = $tool_key;

        $view = new \Altum\View('tools/color_converter_tool', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

}
