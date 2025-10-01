<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<div class="row m-n3" id="popular_tools">
    <?php $i = 1; ?>
    <?php foreach($data->tools_usage as $key => $value): ?>
        <?php if(settings()->tools->available_tools->{$key} && $this->user->plan_settings->enabled_tools->{$key}): ?>
        <?php if(isset($data->category) && ($data->tools[$key]['category'] ?? '') !== $data->category) continue ?>

            <?php if(isset($data->tools[$key]['category']) && in_array($data->tools[$key]['category'], ['color_converter_tools', 'data_converter_tools', 'length_converter_tools', 'image_manipulation_tools', 'weight_converter_tools', 'volume_converter_tools', 'time_converter_tools', 'area_converter_tools', 'force_converter_tools',])): ?>
                <?php
                /* Process the tool */
                $exploded = explode('_to_', $key);
                $from = $exploded[0];
                $to = $exploded[1];

                $name = sprintf(l('tools.' . $data->tools[$key]['category'] . '.name'), l('tools.' . $from), l('tools.' . $to));
                $description = sprintf(l('tools.' . $data->tools[$key]['category'] . '.description'), l('tools.' . $from), l('tools.' . $to));
                ?>
            <?php else: ?>
                <?php
                $name = l('tools.' . $key . '.name');
                $description = l('tools.' . $key . '.description') ;
                ?>
            <?php endif ?>

            <?= include_view(THEME_PATH . 'views/tools/tool_widget_' . (settings()->tools->style ?? 'frankfurt') . '.php', [
                'tool_id' => $key,
                'tool_icon' => $data->tools[$key]['icon'],
                'tools_usage' => $data->tools_usage,
                'name' => $name,
                'description' => $description,
                'category_properties' => $data->category_properties ?? null,
            ]); ?>

            <?php
            if($i >= 6) {
                break;
            }

            $i++;
            ?>
        <?php endif ?>
    <?php endforeach ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php if($data->wrapper ?? true): ?>
    <?php if(settings()->tools->popular_widget_is_enabled): ?>
        <div class="mt-5">
            <h2 class="small font-weight-bold text-uppercase text-muted mb-3"><i class="fas fa-fw fa-sm fa-star text-primary mr-1"></i> <?= l('tools.popular_tools') ?></h2>

            <?= $content ?>
        </div>
    <?php endif ?>
<?php else: ?>
    <?= $content ?>
<?php endif ?>
