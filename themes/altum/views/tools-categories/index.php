<!-- Collapsible behavior removed: categories are always visible -->
<?php defined('ALTUMCODE') || die() ?>

<div class="index-background pt-7 pb-7 mb-4">
    <div class="container">
        <?= \Altum\Alerts::output_alerts() ?>

        <div class="row justify-content-center">
            <div class="col-11 col-md-10 col-lg-7">
                <h1 class="index-header text-center mb-2" style="color: <?= $data->category_properties['color'] ?>"><?= l('tools.' . $data->category) ?></h1>
            </div>

            <div class="col-10 col-sm-8 col-lg-6">
                <p class="index-subheader text-center mb-5"><?= l('tools.' . $data->category . '_help') ?></p>
            </div>
        </div>

        <div class="d-flex flex-column flex-lg-row justify-content-center">
            <a href="#tools" class="btn btn-primary index-button mb-3 mb-lg-0 mr-lg-3" style="background: <?= $data->category_properties['color'] ?> !important; border: 0 !important;">
                <i class="fas fa-fw fa-sm fa-tools mr-1"></i> <?= l('global.view_all') ?>
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

    <form id="search" action="" method="get" role="form">
        <div class="form-group">
            <input type="search" name="search" class="form-control form-control-lg" value="" placeholder="<?= l('global.filters.search') ?>" aria-label="<?= l('global.filters.search') ?>" />
        </div>
    </form>

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

        <?php $tool_category = $data->category; $tool_category_properties = $data->category_properties ?>
            <?php ${$tool_category} = get_tools_section_output($tool_category, $this->user, $data, $tool_category_properties); ?>

            <div class="card mt-5 mb-4 position-relative" data-category="<?= $tool_category ?>" style="background: <?= $tool_category_properties['color'] ?>; border-color: <?= $tool_category_properties['color'] ?>; color: white;">
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

                        <!-- collapse toggle removed to make categories always visible -->
                    </div>
                </div>
            </div>

            <div id="<?= $tool_category . '_tools' ?>" class="row" data-category-tools>
                <?php echo ${$tool_category}['enabled_tools_html']; echo ${$tool_category}['disabled_tools_html']; ?>
            </div>

        <?php ob_start() ?>
        <script>
            'use strict';

            /* Prevent default form submission */
            document.querySelector('#search').addEventListener('submit', event => {
                event.preventDefault();
            });

            /* Cache references to the tools container & search input */
            const tools_element = document.querySelector('#tools');
            const search_input_element = document.querySelector('#search input[name="search"]');

            /* Cache references for data-category-tools and data-category */
            const data_category_tools_elements = [...tools_element.querySelectorAll('[data-category-tools]')];
            const data_category_header_elements = [...tools_element.querySelectorAll('[data-category]')];

            /* Build a list of tools, and also map tool IDs & categories to their elements for quick lookup */
            let tools = [];
            let tool_elements_map = {};
            let category_elements_map = {};

            /* Fill in the tools array & tool_elements_map */
            tools_element.querySelectorAll('[data-tool-id]').forEach(element => {
                const tool_id = element.getAttribute('data-tool-id');
                const tool_name = element.getAttribute('data-tool-name').toLowerCase();
                const tool_category = element.getAttribute('data-tool-category').toLowerCase();

                tools.push({ id: tool_id, name: tool_name, category: tool_category });
                tool_elements_map[tool_id] = element;
            });

            /* Fill in category_elements_map (if you have unique data-category attributes) */
            data_category_header_elements.forEach(category_element => {
                const category_name = category_element.getAttribute('data-category').toLowerCase();
                category_elements_map[category_name] = category_element;
            });

            /* Keep the state of the current search value */
            let search_value = search_input_element.value.toLowerCase();

            /* Debounce timer */
            let timer = null;

            /* Attach the events */
            ['change', 'paste', 'keyup', 'search'].forEach(event_type => {
                search_input_element.addEventListener(event_type, () => {
                    clearTimeout(timer);

                    let string = search_input_element.value.toLowerCase();

                    /* Do not search if the value didn't change */
                    if (string === search_value) {
                        return true;
                    }

                    /* Add loading state */
                    tools_element.classList.add('position-relative');

                    if (!document.querySelector('#tools-loading-overlay')) {
                        let overlay = document.createElement('div');
                        overlay.id = 'tools-loading-overlay';
                        overlay.classList.add('loading-overlay');
                        overlay.innerHTML = '<div class="spinner-border spinner-border-lg" role="status"></div>';
                        tools_element.prepend(overlay);
                    }

                    timer = setTimeout(() => {
                                    /* Hide header sections if searching */
                        data_category_header_elements.forEach(element => {
                            element.removeAttribute('data-aos');
                            if (string.length) {
                                element.classList.add('d-none');
                            } else {
                                element.classList.remove('d-none');
                            }
                        });

                        /* Loop over each tool and toggle it */
                        for (let tool of tools) {
                            const tool_element = tool_elements_map[tool.id];

                            /* Remove data-aos if present */
                            if (tool_element.hasAttribute('data-aos')) {
                                tool_element.removeAttribute('data-aos');
                            }

                            if (tool.name.includes(string)) {
                                tool_element.classList.remove('d-none');

                                /* Also show the matching category header */
                                const category_header = category_elements_map[tool.category];
                                if (category_header) {
                                    category_header.classList.remove('d-none');
                                }
                            } else {
                                tool_element.classList.add('d-none');
                            }
                        }

                        /* Update new search value */
                        search_value = string;

                        /* Remove loading state */
                        tools_element.classList.remove('position-relative');
                        const overlay_to_remove = document.querySelector('#tools-loading-overlay');
                        overlay_to_remove && overlay_to_remove.remove();

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
    </div>
</div>

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
