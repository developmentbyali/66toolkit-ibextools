<?php defined('ALTUMCODE') || die() ?>

<div class="col-12 col-lg-6 p-3 position-relative" data-tool-id="<?= $data->tool_id ?>" data-tool-name="<?= $data->name ?? l('tools.' . $data->tool_id . '.name') ?>" data-tool-category="<?= $data->tool_category ?? '' ?>" <?= isset($data->is_animated) && $data->is_animated ? 'data-aos="fade-up"' : null ?>>
    <div class="card d-flex flex-row h-100 overflow-hidden" <?= user()->plan_settings->enabled_tools->{$data->tool_id} ? null : 'container-disabled' ?>" <?= user()->plan_settings->enabled_tools->{$data->tool_id} ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
        <div class="tool-icon-wrapper d-flex flex-column justify-content-center">
            <div class="bg-primary-100 d-flex align-items-center justify-content-center rounded tool-icon" <?= isset($data->category_properties) ? 'style="background: ' . $data->category_properties['faded_color'] . ' !important;"' : null ?>>
                <i class="<?= $data->tool_icon ?> fa-fw text-primary-600" <?= isset($data->category_properties) ? 'style="color: ' . $data->category_properties['color'] . ' !important;"' : null ?>></i>
            </div>
        </div>

        <div class="card-body text-truncate">
            <a href="<?= url(str_replace('_', '-', $data->tool_id)) ?>" class="stretched-link text-decoration-none text-dark" <?= 1 == 2 && isset($data->category_properties) ? 'style="color: ' . $data->category_properties['color'] . ' !important;"' : null ?>>
                <strong><?= $data->name ?? l('tools.' . $data->tool_id . '.name') ?></strong>
            </a>
            <p class="text-truncate text-muted small m-0"><?= $data->description ?? l('tools.' . $data->tool_id . '.description') ?></p>
        </div>

        <?php if(settings()->tools->views_is_enabled || settings()->tools->last_submissions_is_enabled): ?>
            <div class="p-3 d-flex flex-column">
                <?php if(settings()->tools->views_is_enabled): ?>
                    <div class="badge badge-gray-100 mb-2" data-toggle="tooltip" title="<?= l('tools.total_views') ?>">
                        <i class="fas fa-fw fa-sm fa-eye mr-1"></i> <?= nr($data->tools_usage[$data->tool_id]->total_views ?? 0) ?>
                    </div>
                <?php endif ?>

                <?php if(settings()->tools->last_submissions_is_enabled): ?>
                    <div class="badge badge-gray-100" data-toggle="tooltip" title="<?= l('tools.total_submissions') ?>">
                        <i class="fas fa-fw fa-sm fa-check mr-1"></i> <?= nr($data->tools_usage[$data->tool_id]->total_submissions ?? 0) ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>
