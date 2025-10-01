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

use Altum\Meta;
use Altum\Title;

defined('ALTUMCODE') || die();

class ToolsCategories extends Controller {

    public function index() {
        redirect();
    }

    private function initiate() {
        if(!settings()->tools->categories_pages_is_enabled) {
            redirect();
        }

        if(string_starts_with('tools-categories/', \Altum\Router::$original_request)) {
            redirect(str_replace('_', '-', \Altum\Router::$method), true, 301);
        }

        /* Plans View */
        $view = new \Altum\View('partials/plans', (array) $this);
        $this->add_view_content('plans', $view->run());

        $tools_usage = (new \Altum\Models\Tools())->get_tools_usage();

        /* Popular tools View */
        $view = new \Altum\View('tools/popular_tools', (array) $this);
        $this->add_view_content('popular_tools', $view->run([
            'tools_usage' => $tools_usage,
            'tools' => require APP_PATH . 'includes/tools/tools.php',
            'category' => \Altum\Router::$method,
            'category_properties' => \Altum\Router::$data['tools_categories'][\Altum\Router::$method],
            'wrapper' => false,
        ]));

        /* Meta & title */
        Title::set(sprintf(l('tools_categories.title'), l('tools.' . \Altum\Router::$method )));
        Meta::set_description(l('tools.' . \Altum\Router::$method . '_help'));

        /* Prepare the view */
        $data = [
            'category' => \Altum\Router::$method,
            'category_properties' => \Altum\Router::$data['tools_categories'][\Altum\Router::$method],
            'tools_usage' => $tools_usage,
        ];

        $view = new \Altum\View('tools-categories/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    public function checker_tools() {
        $this->initiate();
    }

    public function text_tools() {
        $this->initiate();
    }

    public function converter_tools() {
        $this->initiate();
    }

    public function generator_tools() {
        $this->initiate();
    }

    public function developer_tools() {
        $this->initiate();
    }

    public function image_manipulation_tools() {
        $this->initiate();
    }

    public function unit_converter_tools() {
        $this->initiate();
    }

    public function time_converter_tools() {
        $this->initiate();
    }

    public function data_converter_tools() {
        $this->initiate();
    }

    public function misc_tools() {
        $this->initiate();
    }

    public function length_converter_tools() {
        $this->initiate();
    }

    public function weight_converter_tools() {
        $this->initiate();
    }

    public function volume_converter_tools() {
        $this->initiate();
    }

    public function area_converter_tools() {
        $this->initiate();
    }

    public function force_converter_tools() {
        $this->initiate();
    }

    public function color_converter_tools() {
        $this->initiate();
    }
}
