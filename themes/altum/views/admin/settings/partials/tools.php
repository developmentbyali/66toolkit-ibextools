<?php defined('ALTUMCODE') || die() ?>

<div>
    <div class="form-group">
        <label for="style"><?= l('admin_settings.tools.style') ?></label>
        <select id="style" name="style" class="custom-select">
            <option value="frankfurt" <?= settings()->tools->style == 'frankfurt' ? 'selected="selected"' : null ?>><?= l('admin_settings.tools.style_frankfurt') ?></option>
            <option value="munich" <?= settings()->tools->style == 'munich' ? 'selected="selected"' : null ?>><?= l('admin_settings.tools.style_munich') ?></option>
        </select>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="categories_pages_is_enabled" name="categories_pages_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->categories_pages_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="categories_pages_is_enabled"><i class="fas fa-fw fa-sm fa-paragraph text-muted mr-1"></i> <?= l('admin_settings.tools.categories_pages_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="categories_expanded_is_enabled" name="categories_expanded_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->categories_expanded_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="categories_expanded_is_enabled"><i class="fas fa-fw fa-sm fa-paragraph text-muted mr-1"></i> <?= l('admin_settings.tools.categories_expanded_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="categories_collapsible_is_enabled" name="categories_collapsible_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->categories_collapsible_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="categories_collapsible_is_enabled"><i class="fas fa-fw fa-sm fa-compress-arrows-alt text-muted mr-1"></i> <?= l('admin_settings.tools.categories_collapsible_is_enabled') ?></label>
        <small class="form-text text-muted"><?= l('admin_settings.tools.categories_collapsible_is_enabled_help') ?></small>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="extra_content_is_enabled" name="extra_content_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->extra_content_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="extra_content_is_enabled"><i class="fas fa-fw fa-sm fa-paragraph text-muted mr-1"></i> <?= l('admin_settings.tools.extra_content_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="share_is_enabled" name="share_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->share_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="share_is_enabled"><i class="fas fa-fw fa-sm fa-share-alt text-muted mr-1"></i> <?= l('admin_settings.tools.share_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="popular_widget_is_enabled" name="popular_widget_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->popular_widget_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="popular_widget_is_enabled"><i class="fas fa-fw fa-sm fa-fire text-muted mr-1"></i> <?= l('admin_settings.tools.popular_widget_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="similar_widget_is_enabled" name="similar_widget_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->similar_widget_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="similar_widget_is_enabled"><i class="fas fa-fw fa-sm fa-clone text-muted mr-1"></i> <?= l('admin_settings.tools.similar_widget_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="views_is_enabled" name="views_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->views_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="views_is_enabled"><i class="fas fa-fw fa-sm fa-eye text-muted mr-1"></i> <?= l('admin_settings.tools.views_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="submissions_is_enabled" name="submissions_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->submissions_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="submissions_is_enabled"><i class="fas fa-fw fa-sm fa-check text-muted mr-1"></i> <?= l('admin_settings.tools.submissions_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="last_submissions_is_enabled" name="last_submissions_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->last_submissions_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="last_submissions_is_enabled"><i class="fas fa-fw fa-sm fa-table text-muted mr-1"></i> <?= l('admin_settings.tools.last_submissions_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="ratings_is_enabled" name="ratings_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->ratings_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="ratings_is_enabled"><i class="fas fa-fw fa-sm fa-star text-muted mr-1"></i> <?= l('admin_settings.tools.ratings_is_enabled') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input id="google_safe_browsing_is_enabled" name="google_safe_browsing_is_enabled" type="checkbox" class="custom-control-input" <?= settings()->tools->google_safe_browsing_is_enabled ? 'checked="checked"' : null?>>
        <label class="custom-control-label" for="google_safe_browsing_is_enabled"><?= l('admin_settings.tools.google_safe_browsing_is_enabled') ?></label>
        <small class="form-text text-muted"><?= l('admin_settings.tools.google_safe_browsing_is_enabled_help') ?></small>
    </div>

    <div class="form-group">
        <label for="google_safe_browsing_api_key"><?= l('admin_settings.tools.google_safe_browsing_api_key') ?></label>
        <input id="google_safe_browsing_api_key" type="text" name="google_safe_browsing_api_key" class="form-control" value="<?= settings()->tools->google_safe_browsing_api_key ?>" />
    </div>

    <div class="form-group mt-5">
        <?php $tools = require APP_PATH . 'includes/tools/tools.php'; ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h5"><?= l('admin_settings.tools.available_tools') . ' (' . count($tools) . ')' ?></h3>

            <div>
                <button type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.select_all') ?>" data-tooltip-hide-on-click onclick="document.querySelectorAll(`[name='available_tools[]']`).forEach(element => element.checked ? null : element.checked = true)"><i class="fas fa-fw fa-check-square"></i></button>
                <button type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.deselect_all') ?>" data-tooltip-hide-on-click onclick="document.querySelectorAll(`[name='available_tools[]']`).forEach(element => element.checked ? element.checked = false : null)"><i class="fas fa-fw fa-minus-square"></i></button>
            </div>
        </div>

        <?php foreach(require APP_PATH . 'includes/tools/categories.php' as $tool_category => $tool_category_properties): ?>
            <?php $tools_category = $tool_category_properties['type'] == 'default' ? require APP_PATH . 'includes/tools/' . $tool_category . '.php' : require \Altum\Plugin::get($tool_category_properties['type'] . '-tools')->path . 'includes/tools/' . $tool_category . '.php' ?>

            <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="h6"><?= l('tools.' . $tool_category) . ' (' . count($tools_category) . ')' ?></h4>

                            <div class="d-flex align-items-center">
                                <div class="mr-2">
                                    <button type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.select_all') ?>" data-tooltip-hide-on-click onclick="document.querySelectorAll(`[data-tool-category='<?= $tool_category ?>']`).forEach(element => element.checked ? null : element.checked = true)"><i class="fas fa-fw fa-check-square"></i></button>
                                    <button type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.deselect_all') ?>" data-tooltip-hide-on-click onclick="document.querySelectorAll(`[data-tool-category='<?= $tool_category ?>']`).forEach(element => element.checked ? element.checked = false : null)"><i class="fas fa-fw fa-minus-square"></i></button>
                                </div>

                                <?php /* determine existing per-category collapsible setting or fallback to developer default */ ?>
                                <?php $categories_collapsible_settings = isset(settings()->tools->categories_collapsible) ? (array) settings()->tools->categories_collapsible : []; ?>
                                <?php $category_collapsible_checked = array_key_exists($tool_category, $categories_collapsible_settings) ? (bool) $categories_collapsible_settings[$tool_category] : (isset($tool_category_properties['collapsible']) && $tool_category_properties['collapsible']); ?>

                                <div class="custom-control custom-switch ml-3">
                                    <input id="categories_collapsible_<?= $tool_category ?>" name="categories_collapsible[]" value="<?= $tool_category ?>" type="checkbox" class="custom-control-input" <?= $category_collapsible_checked ? 'checked="checked"' : null ?>>
                                    <label class="custom-control-label" for="categories_collapsible_<?= $tool_category ?>"><?= l('admin_settings.tools.category_collapsible') ?></label>
                                </div>
                            </div>
                        </div>

                <div class="row">
                    <?php foreach($tools_category as $key => $value): ?>
                        <?php
                        /* Determine the tool name / description */
                        if(isset($value['category']) && in_array($value['category'],['color_converter_tools', 'data_converter_tools', 'length_converter_tools', 'image_manipulation_tools', 'weight_converter_tools', 'volume_converter_tools', 'time_converter_tools', 'area_converter_tools', 'force_converter_tools',])) {
                            /* Process the tool */
                            $exploded = explode('_to_', $key);
                            $from = $exploded[0];
                            $to = $exploded[1];

                            $name = sprintf(l('tools.' . $value['category'] . '.name'), l('tools.' . $from), l('tools.' . $to));
                        } else {
                            $name = l('tools.' . $key . '.name');
                        }
                        ?>

                        <div class="col-12 col-lg-6">
                            <div class="custom-control custom-checkbox my-2">
                                <input id="<?= 'tool_' . $key ?>" name="available_tools[]" value="<?= $key ?>" type="checkbox" class="custom-control-input" <?= settings()->tools->available_tools->{$key} ? 'checked="checked"' : null ?> data-tool-category="<?= $tool_category ?>">
                                <label class="custom-control-label d-flex align-items-center" for="<?= 'tool_' . $key ?>">
                                    <?= $name ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
