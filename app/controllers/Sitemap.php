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

defined('ALTUMCODE') || die();

class Sitemap extends Controller {

    public function index() {

        /* Set the header as xml so the browser can read it properly */
        header('Content-Type: text/xml');

        $view = new \Altum\View('sitemap/sitemap_index', (array) $this);

        echo $view->run();

    }

    public function main() {
        /* Set the header as xml so the browser can read it properly */
        header('Content-Type: text/xml');

        $sitemap_urls = [
            '',
            'login',
            'lost-password',
        ];

        if(settings()->users->email_confirmation) {
            $sitemap_urls[] = 'resend-activation';
        }

        if (settings()->users->register_is_enabled) {
            $sitemap_urls[] = 'register';
        }

        if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) {
            $sitemap_urls[] = 'affiliate';
        }

        if (settings()->main->api_is_enabled) {
            $sitemap_urls[] = 'api-documentation';
        }

        if (settings()->email_notifications->contact && !empty(settings()->email_notifications->emails)) {
            $sitemap_urls[] = 'contact';
        }

        if(settings()->payment->is_enabled) {
            $sitemap_urls[] = 'plan';
        }

        if (settings()->content->pages_is_enabled) {
            $sitemap_urls[] = 'pages';
        }

        if (settings()->content->blog_is_enabled) {
            $sitemap_urls[] = 'blog';
        }

        /* Product specific */
        if(settings()->tools->categories_pages_is_enabled) {
            foreach(require APP_PATH . 'includes/tools/categories.php' as $tool_category => $tool_category_properties) {
                $sitemap_urls[] = str_replace('_', '-', $tool_category);
            }
        }

        /* Multilingual */
        $new_sitemap_urls = [];

        foreach(\Altum\Language::$active_languages as $language_name => $language_code) {
            foreach($sitemap_urls as $url) {
                $new_sitemap_urls[] = settings()->main->default_language == $language_name ? SITE_URL . $url : SITE_URL . $language_code . '/' . $url;
            }
        }

        if (settings()->content->pages_is_enabled) {
            $pages = db()->where('type', 'internal')->where('is_published', 1)->get('pages', null, ['url', 'language']);
            $pages_categories = db()->get('pages_categories', null, ['url', 'language']);

            foreach ($pages as $page) {
                $new_sitemap_urls[] = SITE_URL . ($page->language ? \Altum\Language::$active_languages[$page->language] . '/' : '') . 'page/' . $page->url;
            }

            foreach ($pages_categories as $pages_category) {
                $new_sitemap_urls[] = SITE_URL . ($pages_category->language ? \Altum\Language::$active_languages[$pages_category->language] . '/' : '') . 'pages/' . $pages_category->url;
            }
        }

        if (settings()->content->blog_is_enabled) {
            $blog_posts = db()->where('is_published', 1)->get('blog_posts', null, ['url', 'language']);
            $blog_posts_categories = db()->get('blog_posts_categories', null, ['url', 'language']);

            foreach ($blog_posts as $blog_post) {
                $new_sitemap_urls[] = SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : '') . 'blog/' . $blog_post->url;
            }

            foreach ($blog_posts_categories as $blog_posts_category) {
                $new_sitemap_urls[] = SITE_URL . ($blog_posts_category->language ? \Altum\Language::$active_languages[$blog_posts_category->language] . '/' : '') . 'blog/category/' . $blog_posts_category->url;
            }
        }


        /* Main View */
        $data = [
            'sitemap_urls' => $new_sitemap_urls,
        ];

        $view = new \Altum\View('sitemap/sitemap_main', (array) $this);

        echo $view->run($data);

    }

    public function tools() {
        /* Set the header as xml so the browser can read it properly */
        header('Content-Type: text/xml');

        $page = isset($this->params[0]) && array_key_exists($this->params[0], \Altum\Language::$active_languages) ? $this->params[0] : null;

        /* Different answers for different parts */
        switch($page) {

            /* Sitemap index */
            case null:

                /* Prepare the urls */
                $sitemap_urls = [];

                foreach (\Altum\Language::$active_languages as $language_name => $language_code) {
                    $sitemap_urls[] = SITE_URL . 'sitemap/tools/' . $language_name;
                }

                /* Main View */
                $data = [
                    'sitemap_urls' => $sitemap_urls,
                ];

                $view = new \Altum\View('sitemap/sitemap_tools', (array) $this);

                echo $view->run($data);

                break;

            /* Output only indexed external users */
            default:

                $sitemap_urls = [];

                foreach ((require APP_PATH . 'includes/tools/tools.php') as $key => $value){
                    if (settings()->tools->available_tools->{$key} && settings()->plan_guest->settings->enabled_tools->{$key}) {
                        $sitemap_urls[] = SITE_URL . ($page == settings()->main->default_language ? null : $page . '/') . str_replace('_', '-', $key);
                    }
                }

                /* Main View */
                $data = [
                    'sitemap_urls' => $sitemap_urls,
                ];

                $view = new \Altum\View('sitemap/sitemap_tools_list', (array) $this);

                echo $view->run($data);

                break;

        }

    }
}

