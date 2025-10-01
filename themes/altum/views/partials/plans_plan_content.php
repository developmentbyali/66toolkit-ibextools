<?php defined('ALTUMCODE') || die() ?>

<div>
    <?php foreach(require APP_PATH . 'includes/tools/categories.php' as $tool_category => $tool_category_properties): ?>
        <?php $tools_category = $tool_category_properties['type'] == 'default' ? require APP_PATH . 'includes/tools/' . $tool_category . '.php' : require \Altum\Plugin::get($tool_category_properties['type'] . '-tools')->path . 'includes/tools/' . $tool_category . '.php' ?>

        <?php
        $enabled_tools_count = 0;
        $enabled_tools_string = '';
        foreach($tools_category as $key => $value) {
            if(settings()->tools->available_tools->{$key} && $data->plan_settings->enabled_tools->{$key}) {
                $enabled_tools_count++;
            }
        }
        ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $enabled_tools_count ? null : 'text-muted' ?>">
            <div>
                <?= sprintf('<strong>%s</strong> %s', $enabled_tools_count, l('tools.' . $tool_category)) ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $enabled_tools_count ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endforeach ?>

    <?php if(\Altum\Plugin::is_active('email-signatures') && settings()->signatures->is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.signatures_limit'), '<strong>' . ($data->plan_settings->signatures_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->signatures_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->signatures_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>


    <?php if(\Altum\Plugin::is_active('email-signatures') && \Altum\Plugin::is_active('aix')): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.projects_limit'), '<strong>' . ($data->plan_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->projects_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if(\Altum\Plugin::is_active('teams')): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.teams_limit'), '<strong>' . ($data->plan_settings->teams_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->teams_limit)) . '</strong>') ?>

                <span class="ml-1" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.plan_settings.team_members_limit'), '<strong>' . ($data->plan_settings->team_members_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->team_members_limit)) . '</strong>') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->teams_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.affiliate_commission_percentage'), '<strong>' . nr($data->plan_settings->affiliate_commission_percentage) . '%</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->affiliate_commission_percentage ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if(settings()->main->api_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.api_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.api_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if(settings()->main->white_labeling_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->white_labeling_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.white_labeling_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.white_labeling_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->white_labeling_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php $enabled_exports_count = count(array_filter((array) $data->plan_settings->export)); ?>

    <?php ob_start() ?>
    <div class='d-flex flex-column'>
        <?php foreach(['csv', 'json', 'pdf'] as $key): ?>
            <?php if($data->plan_settings->export->{$key}): ?>
                <span class='my-1'><?= sprintf(l('global.export_to'), mb_strtoupper($key)) ?></span>
            <?php else: ?>
                <s class='my-1'><?= sprintf(l('global.export_to'), mb_strtoupper($key)) ?></s>
            <?php endif ?>
        <?php endforeach ?>
    </div>
    <?php $html = ob_get_clean() ?>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $enabled_exports_count ? null : 'text-muted' ?>">
        <div>
            <?= sprintf(l('global.plan_settings.export'), $enabled_exports_count) ?>
            <span class="mr-1" data-html="true" data-toggle="tooltip" title="<?= $html ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
        </div>

        <i class="fas fa-fw fa-sm <?= $enabled_exports_count ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
        <div>
            <?= l('global.plan_settings.no_ads') ?>
            <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.no_ads_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
        </div>

        <i class="fas fa-fw fa-sm <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <?php if(
        \Altum\Plugin::is_active('aix')
        && (
            settings()->aix->documents_is_enabled || settings()->aix->images_is_enabled || settings()->aix->transcriptions_is_enabled || settings()->aix->chats_is_enabled
        )
    ): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <button type="button" class="btn btn-sm btn-outline-light text-reset text-decoration-none font-weight-bold px-0 w-100" data-toggle="collapse" data-target=".ai_container">
                <i class="fas fa-fw fa-sm fa-robot mr-1"></i> <?= l('global.plan_settings.aix') ?>
            </button>

        </div>

        <div class="collapse ai_container">
            <?php if(\Altum\Plugin::is_active('aix') && settings()->aix->documents_is_enabled): ?>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.documents_model.' . str_replace('-', '_', $data->plan_settings->documents_model ?? 'gpt-3.5-turbo'))) ?>
                    </div>

                    <i class="fas fa-fw fa-sm fa-check text-success"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.documents_per_month_limit'), '<strong>' . ($data->plan_settings->documents_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->documents_per_month_limit)) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->documents_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.words_per_month_limit'), '<strong>' . ($data->plan_settings->words_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->words_per_month_limit)) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->words_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>
            <?php endif ?>

            <?php if(\Altum\Plugin::is_active('aix') && settings()->aix->images_is_enabled): ?>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.images_per_month_limit'), '<strong>' . ($data->plan_settings->images_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->images_per_month_limit)) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->images_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>
            <?php endif ?>

            <?php if(\Altum\Plugin::is_active('aix') && settings()->aix->transcriptions_is_enabled): ?>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.transcriptions_per_month_limit'), '<strong>' . ($data->plan_settings->transcriptions_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->transcriptions_per_month_limit)) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->transcriptions_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.transcriptions_file_size_limit'), '<strong>' . get_formatted_bytes($data->plan_settings->transcriptions_file_size_limit * 1000 * 1000) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->transcriptions_file_size_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>
            <?php endif ?>

            <?php if(\Altum\Plugin::is_active('aix') && settings()->aix->chats_is_enabled): ?>
                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.chats_per_month_limit'), '<strong>' . ($data->plan_settings->chats_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->chats_per_month_limit)) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->chats_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <div>
                        <?= sprintf(l('global.plan_settings.chat_messages_per_chat_limit'), '<strong>' . ($data->plan_settings->chat_messages_per_chat_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->chat_messages_per_chat_limit)) . '</strong>') ?>
                    </div>

                    <i class="fas fa-fw fa-sm <?= $data->plan_settings->chat_messages_per_chat_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>
