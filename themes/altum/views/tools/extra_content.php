<?php defined('ALTUMCODE') || die() ?>

<?php if(settings()->tools->extra_content_is_enabled): ?>
    <?php if(\Altum\Router::$controller_key == 'tools-data-converter'): ?>
        <?php $extra_content = sprintf(l('tools.data_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-image-manipulation'): ?>
        <?php $extra_content = sprintf(l('tools.image_manipulation_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-length-converter'): ?>
        <?php $extra_content = sprintf(l('tools.length_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-weight-converter'): ?>
        <?php $extra_content = sprintf(l('tools.weight_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-volume-converter'): ?>
        <?php $extra_content = sprintf(l('tools.volume_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-time-converter'): ?>
        <?php $extra_content = sprintf(l('tools.time_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-area-converter'): ?>
        <?php $extra_content = sprintf(l('tools.area_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-force-converter'): ?>
        <?php $extra_content = sprintf(l('tools.force_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php elseif(\Altum\Router::$controller_key == 'tools-color-converter'): ?>
        <?php $extra_content = sprintf(l('tools.color_converter_tools.extra_content'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>
    <?php else: ?>
        <?php $extra_content = l('tools.' . \Altum\Router::$method . '.extra_content') ?: l('tools.extra_content') ?>
    <?php endif ?>

    <?php if($extra_content): ?>
    <div class="card mt-5">
        <div class="card-body">
            <?= $extra_content ?>
        </div>
    </div>
    <?php endif ?>
<?php endif ?>


<?php if(settings()->tools->share_is_enabled): ?>
<div class="mt-5">
    <h2 class="small font-weight-bold text-uppercase text-muted mb-3"><i class="fas fa-fw fa-sm fa-share-alt text-primary mr-1"></i> <?= l('tools.share') ?></h2>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <?= include_view(THEME_PATH . 'views/partials/share_buttons.php', ['url' => url(\Altum\Router::$original_request), 'class' => 'btn btn-gray-100 mb-2 mb-md-0 mr-md-3']) ?>
            </div>
        </div>
    </div>
</div>
<?php endif ?>


<?php ob_start() ?>
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
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "<?= \Altum\Title::$page_title ?>",
                    "item": "<?= url(\Altum\Router::$original_request) ?>"
                }
            ]
        }
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
