<?php defined('ALTUMCODE') || die() ?>

<div class="index-background pt-7 pb-7 mb-4">
    <div class="container">
        <?= \Altum\Alerts::output_alerts() ?>

        <div class="row justify-content-center">
            <div class="col-11 col-md-10 col-lg-7">
                <h1 class="index-header text-center mb-2"><?= l('index.header') ?></h1>
            </div>

            <div class="col-10 col-sm-8 col-lg-6">
                <p class="index-subheader text-center mb-5"><?= sprintf(l('index.subheader'), '<span class="text-primary font-weight-bold">' . nr(settings()->tools->available_tools_count ?? 0) . '</span>') ?></p>
            </div>
        </div>

        <div class="d-flex flex-column flex-lg-row justify-content-center">
            <a href="<?= url('#tools') ?>" class="btn btn-primary index-button mb-3 mb-lg-0 mr-lg-3">
                <i class="fas fa-fw fa-sm fa-tools mr-1"></i> <?= l('index.tools') ?>
            </a>

            <?php if(settings()->users->register_is_enabled && !is_logged_in()): ?>
                <a href="<?= url('register') ?>" target="_blank" class="btn btn-gray-200 index-button mb-3 mb-lg-0">
                    <i class="fas fa-fw fa-sm fa-user-plus mr-1"></i> <?= l('index.register') ?>
                </a>
            <?php endif ?>
        </div>
    </div>
</div>


<div class="container">
    <div class="mb-5">
        <h1 class="h3 mb-4"><?= l('tools.popular_tools') ?></h1>
        <?= $this->views['popular_tools'] ?>
    </div>

    <h1 class="h3 mb-4"><?= l('tools.header') ?></h1>

    <?php if(!settings()->tools->categories_pages_is_enabled): ?>
        <form id="search" action="" method="get" role="form">
            <div class="form-group">
                <input type="search" name="search" class="form-control form-control-lg" value="" placeholder="<?= l('global.filters.search') ?>" aria-label="<?= l('global.filters.search') ?>" />
            </div>
        </form>
    <?php endif ?>

    <div id="tools_no_data" class="mt-5 d-none">
        <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
            'filters_get' => $data->filters->get ?? [],
            'name' => 'tools',
            'has_secondary_text' => false,
            'has_wrapper' => true,
        ]); ?>
    </div>

    <div id="tools">
        <?php function get_tools_section_output($file_name, $user, $data, $category_properties) { ?>
            <?php $tools_category = $category_properties['type'] == 'default' ? require APP_PATH . 'includes/tools/' . $file_name . '.php' : require \Altum\Plugin::get($category_properties['type'] . '-tools')->path . 'includes/tools/' . $file_name . '.php' ?>

            <?php $enabled_tools_html = $disabled_tools_html = ''; ?>
            <?php foreach($tools_category as $key => $value): ?>
                <?php if(settings()->tools->available_tools->{$key}): ?>
                    <?php ob_start() ?>
                    <?php
                    /* Determine the tool name / description */
                    if(isset($value['category']) && in_array($value['category'],['color_converter_tools', 'data_converter_tools', 'length_converter_tools', 'image_manipulation_tools', 'weight_converter_tools', 'volume_converter_tools', 'time_converter_tools', 'area_converter_tools', 'force_converter_tools',])) {
                        /* Process the tool */
                        $exploded = explode('_to_', $key);
                        $from = $exploded[0];
                        $to = $exploded[1];

                        $name = sprintf(l('tools.' . $value['category'] . '.name'), l('tools.' . $from), l('tools.' . $to));
                        $description = sprintf(l('tools.' . $value['category'] . '.description'), l('tools.' . $from), l('tools.' . $to));
                    } else {
                        $name = l('tools.' . $key . '.name');
                        $description = l('tools.' . $key . '.description');
                    }
                    ?>

                    <?= include_view(THEME_PATH . 'views/tools/tool_widget_' . (settings()->tools->style ?? 'frankfurt') . '.php', [
                        'tool_id' => $key,
                        'tool_icon' => $value['icon'],
                        'tools_usage' => $data->tools_usage,
                        'name' => $name,
                        'description' => $description,
                        'tool_category' => $file_name,
                        'category_properties' => $data->category_properties ?? null,
                        'is_animated' => !(isset(settings()->tools->categories_expanded_is_enabled) ? settings()->tools->categories_expanded_is_enabled : false)
                    ]); ?>

                    <?php
                    if($user->plan_settings->enabled_tools->{$key}) {
                        $enabled_tools_html .= ob_get_clean();
                    } else {
                        $disabled_tools_html .= ob_get_clean();
                    }
                    ?>
                <?php endif ?>
            <?php endforeach ?>

            <?php return ['enabled_tools_html' => $enabled_tools_html, 'disabled_tools_html' => $disabled_tools_html] ?>
        <?php } ?>

        <?php foreach(require APP_PATH . 'includes/tools/categories.php' as $tool_category => $tool_category_properties): ?>
            <?php ${$tool_category} = get_tools_section_output($tool_category, $this->user, $data, $tool_category_properties); ?>
            <?php if(empty(${$tool_category}['enabled_tools_html']) && empty(${$tool_category}['disabled_tools_html'])) continue; ?>

            <div class="card mt-5 mb-4 position-relative" data-category="<?= $tool_category ?>" style="background: <?= $tool_category_properties['color'] ?>; border-color: <?= $tool_category_properties['color'] ?>; color: white;" <?= settings()->tools->categories_expanded_is_enabled ? null : 'data-aos="fade-up"' ?>>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex text-truncate">
                            <div class="d-flex align-items-center justify-content-center rounded mr-3 tool-icon" style="background: <?= $tool_category_properties['faded_color'] ?>;">
                                <i class="<?= $tool_category_properties['icon'] ?> fa-fw" style="color: <?= $tool_category_properties['color'] ?>"></i>
                            </div>

                            <div class="text-truncate ml-3">
                                <strong><?= l('tools.' . $tool_category) ?></strong>
                                <p class="text-truncate small m-0"><?= l('tools.' . $tool_category . '_help') ?></p>
                            </div>
                        </div>

                        <?php if(!settings()->tools->categories_pages_is_enabled): ?>
                            <!-- collapse toggle removed to make categories always visible -->
                        <?php else: ?>
                            <div class="ml-3">
                                <a href="<?= url(str_replace('_', '-', $tool_category)) ?>" class="stretched-link" style="color: white !important;">
                                    <i class="fas fa-fw fa-lg fa-circle-chevron-right"></i>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <?php if(!settings()->tools->categories_pages_is_enabled): ?>
                <div id="<?= $tool_category . '_tools' ?>" class="row" data-category-tools>
                    <?php echo ${$tool_category}['enabled_tools_html']; echo ${$tool_category}['disabled_tools_html']; ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>

        <?php if(!settings()->tools->categories_pages_is_enabled): ?>
            <?php ob_start() ?>
            <script>
                'use strict';

                /* Prevent default form submission */
                document.querySelector('#search').addEventListener('submit', event => {
                    event.preventDefault();
                });

                /* Cache references to repeated DOM elements */
                const tools_element = document.querySelector('#tools');
                const search_input_element = document.querySelector('#search input[name="search"]');

                /* Cache all data-category-tools elements */
                const data_category_tools_elements = [
                    ...tools_element.querySelectorAll('[data-category-tools]')
                ];

                /* Cache all data-category headers */
                const data_category_header_elements = [
                    ...tools_element.querySelectorAll('[data-category]')
                ];

                /* Build an array of tool info + a map of tool ID => DOM element */
                let tools = [];
                let tool_elements_map = {};

                tools_element.querySelectorAll('[data-tool-id]').forEach(element => {
                    const tool_id = element.getAttribute('data-tool-id');
                    const tool_name = element.getAttribute('data-tool-name').toLowerCase();
                    const tool_category = element.getAttribute('data-tool-category').toLowerCase();

                    tools.push({
                        id: tool_id,
                        name: tool_name,
                        category: tool_category
                    });

                    /* Map the tool ID to the actual DOM element for quick reference */
                    tool_elements_map[tool_id] = element;
                });

                /* Keep the state of the current search value */
                let search_value = search_input_element.value.toLowerCase();

                /* Debounce on search */
                let timer = null;

                /* Attach the same events as in your original code */
                ['change', 'paste', 'keyup', 'search'].forEach(event_type => {
                    search_input_element.addEventListener(event_type, () => {
                        clearTimeout(timer);

                        const string = search_input_element.value.toLowerCase();

                        /* Do not search if the value did not change */
                        if (string === search_value) {
                            return true;
                        }

                        /* Add loading state */
                        tools_element.classList.add('position-relative');

                        if (!document.querySelector('#tools-loading-overlay')) {
                            const overlay = document.createElement('div');
                            overlay.id = 'tools-loading-overlay';
                            overlay.classList.add('loading-overlay');
                            overlay.innerHTML = '<div class="spinner-border spinner-border-lg" role="status"></div>';
                            tools_element.prepend(overlay);
                        }

                        timer = setTimeout(() => {

                            /* Do not use collapse when searching */
                            data_category_tools_elements.forEach(element => {
                                if (string.length) {
                                    element.classList.remove('collapse');
                                } else {
                                    element.classList.add('collapse');
                                }
                            });

                            /* collapse buttons were removed from the markup - nothing to toggle here */

                            /* Hide header sections if searching */
                            data_category_header_elements.forEach(element => {
                                element.removeAttribute('data-aos');

                                if (string.length) {
                                    element.classList.add('d-none');
                                } else {
                                    element.classList.remove('d-none');
                                }
                            });

                            /* Show/hide tools based on the search value */
                            for (let tool of tools) {
                                const tool_element = tool_elements_map[tool.id];

                                /* Remove data-aos if present */
                                if (tool_element.hasAttribute('data-aos')) {
                                    tool_element.removeAttribute('data-aos');
                                }

                                if (tool.name.includes(string)) {
                                    tool_element.classList.remove('d-none');

                                    /* Also show the matching category header */
                                    const matching_header = tools_element.querySelector(
                                        `[data-category="${tool.category}"]`
                                    );
                                    if (matching_header) {
                                        matching_header.classList.remove('d-none');
                                    }
                                } else {
                                    tool_element.classList.add('d-none');
                                }
                            }

                            /* Update the new search value */
                            search_value = string;

                            /* Remove loading state */
                            tools_element.classList.remove('position-relative');
                            const loading_overlay = document.querySelector('#tools-loading-overlay');
                            loading_overlay && loading_overlay.remove();

                            /* Check if any tool is visible */
                            const any_tool_visible = tools.some(tool =>
                                !tool_elements_map[tool.id].classList.contains('d-none')
                            );

                            /* Show or hide the #tools_not_found div */
                            const tools_not_found_element = document.querySelector('#tools_no_data');
                            if (any_tool_visible) {
                                tools_not_found_element.classList.add('d-none');
                            } else {
                                tools_not_found_element.classList.remove('d-none');
                            }
                        }, 300);
                    });
                });
            </script>
            <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
        <?php endif ?>
    </div>
</div>

<?php if(settings()->main->display_index_testimonials): ?>
    <div class="my-5">&nbsp;</div>

    <div class="p-4 mt-9">
        <div class="py-7 bg-primary-100 rounded-2x">
            <div class="container">
                <div class="text-center">
                    <h2><?= l('index.testimonials.header') ?> <i class="fas fa-fw fa-xs fa-check-circle text-primary"></i></h2>
                </div>

                <?php
                $language_array = \Altum\Language::get(\Altum\Language::$name);
                if(\Altum\Language::$main_name != \Altum\Language::$name) {
                    $language_array = array_merge(\Altum\Language::get(\Altum\Language::$main_name), $language_array);
                }

                $testimonials_language_keys = [];
                foreach ($language_array as $key => $value) {
                    if (preg_match('/index\.testimonials\.(\w+)\./', $key, $matches)) {
                        $testimonials_language_keys[] = $matches[1];
                    }
                }

                $testimonials_language_keys = array_unique($testimonials_language_keys);
                ?>

                <div class="row mt-8">
                    <?php foreach($testimonials_language_keys as $key => $value): ?>
                        <div class="col-12 col-lg-4 mb-6 mb-lg-0" data-aos="fade-up" data-aos-delay="<?= $key * 100 ?>">
                            <div class="card border-0 zoom-animation-subtle">
                                <div class="card-body">
                                    <img src="<?= ASSETS_FULL_URL . 'images/index/testimonial-' . $value . '.webp' ?>" class="img-fluid index-testimonial-avatar" alt="<?= l('index.testimonials.' . $value . '.name') . ', ' . l('index.testimonials.' . $value . '.attribute') ?>" loading="lazy" />

                                    <p class="mt-5">
                                        <span class="text-gray-800 font-weight-bold text-muted h5">“</span>
                                        <span><?= l('index.testimonials.' . $value . '.text') ?></span>
                                        <span class="text-gray-800 font-weight-bold text-muted h5">”</span>
                                    </p>

                                    <div class="blockquote-footer mt-4">
                                        <span class="font-weight-bold"><?= l('index.testimonials.' . $value . '.name') ?></span>, <span class="text-muted"><?= l('index.testimonials.' . $value . '.attribute') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if(settings()->main->display_index_plans): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= l('index.pricing.header') ?></h2>
            <p class="text-muted"><?= l('index.pricing.subheader') ?></p>
        </div>

        <?= $this->views['plans'] ?>
    </div>
<?php endif ?>

<?php if(settings()->main->display_index_faq): ?>
    <div class="my-3">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= sprintf(l('index.faq.header'), '<span class="text-primary">', '</span>') ?></h2>
        </div>

        <?php
        $language_array = \Altum\Language::get(\Altum\Language::$name);
        if(\Altum\Language::$main_name != \Altum\Language::$name) {
            $language_array = array_merge(\Altum\Language::get(\Altum\Language::$main_name), $language_array);
        }

        $faq_language_keys = [];
        foreach ($language_array as $key => $value) {
            if (preg_match('/index\.faq\.(\w+)\./', $key, $matches)) {
                $faq_language_keys[] = $matches[1];
            }
        }

        $faq_language_keys = array_unique($faq_language_keys);
        ?>

        <div class="accordion index-faq" id="faq_accordion">
            <?php foreach($faq_language_keys as $key): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="" id="<?= 'faq_accordion_' . $key ?>">
                            <h3 class="mb-0">
                                <button class="btn btn-lg font-weight-bold btn-block d-flex justify-content-between text-gray-800 px-0 icon-zoom-animation" type="button" data-toggle="collapse" data-target="<?= '#faq_accordion_answer_' . $key ?>" aria-expanded="true" aria-controls="<?= 'faq_accordion_answer_' . $key ?>">
                                    <span><?= l('index.faq.' . $key . '.question') ?></span>

                                    <span data-icon>
                                        <i class="fas fa-fw fa-circle-chevron-down"></i>
                                    </span>
                                </button>
                            </h3>
                        </div>

                        <div id="<?= 'faq_accordion_answer_' . $key ?>" class="collapse text-muted mt-2" aria-labelledby="<?= 'faq_accordion_' . $key ?>" data-parent="#faq_accordion">
                            <?= l('index.faq.' . $key . '.answer') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <?php ob_start() ?>
    <script>
        'use strict';

        $('#faq_accordion').on('show.bs.collapse', event => {
            let svg = event.target.parentElement.querySelector('[data-icon] svg')
            svg.style.transform = 'rotate(180deg)';
            svg.style.color = 'var(--primary)';
        })

        $('#faq_accordion').on('hide.bs.collapse', event => {
            let svg = event.target.parentElement.querySelector('[data-icon] svg')
            svg.style.color = 'var(--primary-800)';
            svg.style.removeProperty('transform');
        })
    </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
<?php endif ?>

<?php if(settings()->users->register_is_enabled): ?>
    <div class="my-4">&nbsp;</div>

    <div class="container">
        <div class="card index-background index-cta py-4" data-aos="fade-up">
            <div class="card-body">
                <div class="card-body row align-items-center justify-content-center">
                    <div class="col-12 col-lg-5">
                        <div class="text-center text-lg-left mb-4 mb-lg-0">
                            <h2 class="h3"><?= l('index.cta.header') ?></h2>
                            <p class="h5 text-muted font-weight-normal"><?= l('index.cta.subheader') ?></p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                        <div class="text-center text-lg-right">
                            <?php if(is_logged_in()): ?>
                                <a href="<?= url('dashboard') ?>" class="btn btn-primary index-button">
                                    <?= l('dashboard.menu') ?> <i class="fas fa-fw fa-arrow-right"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= url('register') ?>" class="btn btn-primary index-button">
                                    <?= l('index.cta.register') ?> <i class="fas fa-fw fa-arrow-right"></i>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if(count($data->blog_posts)): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= sprintf(l('index.blog.header'), '<span class="text-primary">', '</span>') ?></h2>
        </div>

        <div class="row">
            <?php foreach($data->blog_posts as $blog_post): ?>
                <div class="col-12 col-lg-4 p-4">
                    <div class="card h-100 zoom-animation-subtle">
                        <div class="card-body">
                            <?php if($blog_post->image): ?>
                                <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>" aria-label="<?= $blog_post->title ?>">
                                    <img src="<?= \Altum\Uploads::get_full_url('blog') . $blog_post->image ?>" class="blog-post-image-small img-fluid w-100 rounded mb-4" alt="<?= $blog_post->image_description ?>" loading="lazy" />
                                </a>
                            <?php endif ?>

                            <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>">
                                <h3 class="h5 card-title mb-2"><?= $blog_post->title ?></h3>
                            </a>

                            <p class="text-muted mb-0"><?= $blog_post->description ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>


<?php ob_start() ?>
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/libraries/aos.min.css?v=' . PRODUCT_CODE ?>">
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/_tools_categories_fix.css?v=' . PRODUCT_CODE ?>">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/aos.min.js?v=' . PRODUCT_CODE ?>"></script>

<script>
    AOS.init({
        delay: 100,
        duration: 600
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php ob_start() ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= settings()->main->title ?>",
        "url": "<?= url() ?>",
        <?php if(settings()->main->{'logo_' . \Altum\ThemeStyle::get()}): ?>
        "logo": "<?= settings()->main->{'logo_' . \Altum\ThemeStyle::get() . '_full_url'} ?>",
        <?php endif ?>
        "slogan": "<?= l('index.header') ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "url": "<?= url('contact') ?>",
            "contactType": "Contact us"
        }
    }
</script>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "<?= l('index.title') ?>",
                    "item": "<?= url() ?>"
                }
            ]
        }
</script>

<?php if(settings()->main->display_index_faq): ?>
    <?php
    $faqs = [];
    foreach($faq_language_keys as $key) {
        $faqs[] = [
            '@type' => 'Question',
            'name' => l('index.faq.' . $key . '.question'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => l('index.faq.' . $key . '.answer'),
            ]
        ];
    }
    ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": <?= json_encode($faqs) ?>
        }
    </script>
<?php endif ?>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
