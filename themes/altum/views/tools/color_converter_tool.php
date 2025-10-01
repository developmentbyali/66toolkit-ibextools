<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <?php if(settings()->main->breadcrumbs_is_enabled): ?>
        <nav aria-label="breadcrumb">
            <ol class="custom-breadcrumbs small">
                <li><a href="<?= url() ?>"><?= l('tools.breadcrumb') ?></a> <i class="fas fa-fw fa-angle-right"></i></li>
            <?php if(settings()->tools->categories_pages_is_enabled): ?>
            <li><a href="<?= url(str_replace('_', '-', \Altum\Router::$data['tools'][$data->tool]['category'])) ?>"><?= sprintf(l('tools_categories.breadcrumb'), l('tools.' . \Altum\Router::$data['tools'][$data->tool]['category'])) ?></a> <i class="fas fa-fw fa-angle-right"></i></li>
            <?php endif ?>
                <li class="active" aria-current="page"><?= sprintf(l('tools.color_converter_tools.name'), l('tools.' . $data->from), l('tools.' . $data->to)) ?></li>
            </ol>
        </nav>
    <?php endif ?>

    <div class="row mb-4">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0 text-truncate">
            <h1 class="h4 m-0 text-truncate"><?= sprintf(l('tools.color_converter_tools.name'), l('tools.' . $data->from), l('tools.' . $data->to)) ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= sprintf(l('tools.color_converter_tools.description'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>">
                    <i class="fas fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <?= $this->views['ratings'] ?>
    </div>

    <div class="card">
        <div class="card-body">

            <form id="tool_form" action="" method="post" role="form" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="input"><i class="fas fa-fw fa-palette fa-sm text-muted mr-1"></i> <?= l('tools.' . $data->from) ?></label>
                    <input type="text" id="input" name="input" class="form-control <?= \Altum\Alerts::has_field_errors('input') ? 'is-invalid' : null ?>" value="<?= $data->values['input'] ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('input') ?>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.submit') ?></button>
            </form>

        </div>
    </div>

    <?php if(isset($data->result)): ?>
        <div class="mt-4">
            <div class="table-responsive table-custom-container">
                <table class="table table-custom">
                    <tbody>
                    <tr>
                        <td class="font-weight-bold">
                            <i class="fas fa-palette fa-fw fa-sm mr-1"></i> <?= l('tools.color_converter.color') ?>
                        </td>
                        <td style="background: <?= $data->result['hex'] ?>">
                        </td>
                        <td style="background: <?= $data->result['hex'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">
                            <?= l('tools.' . $data->to) ?>
                        </td>
                        <td class="text-nowrap">
                            <?= $data->result[$data->to] ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <button
                                        type="button"
                                        class="btn btn-link text-secondary"
                                        data-toggle="tooltip"
                                        title="<?= l('global.clipboard_copy') ?>"
                                        aria-label="<?= l('global.clipboard_copy') ?>"
                                        data-copy="<?= l('global.clipboard_copy') ?>"
                                        data-copied="<?= l('global.clipboard_copied') ?>"
                                        data-clipboard-text="<?= $data->result[$data->to] ?>"
                                >
                                    <i class="fas fa-fw fa-sm fa-copy"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>

    <?php if(settings()->tools->last_submissions_is_enabled && isset($data->tools_usage[$data->tool]) && !empty((array) $data->tools_usage[$data->tool]->data)): ?>
        <div class="mt-5">
            <h2 class="small font-weight-bold text-uppercase text-muted mb-3"><i class="fas fa-fw fa-sm fa-plus text-primary mr-1"></i> <?= l('tools.last_submissions') ?></h2>

            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <?php foreach((array) $data->tools_usage[$data->tool]->data as $key => $value): ?>
                            <div class="col-12 col-lg-6">
                                <div class="text-truncate my-2">
                                    <a href="<?= url(str_replace('_', '-', $data->tool) . '?' . http_build_query((array) $value)) ?>" onclick="this.href += '&submit=1<?= \Altum\Csrf::get_url_query() ?>'">
                                        <?= sprintf(l('tools.color_converter_tools.submission'), $value->input, $data->from, $data->to) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endif ?>

    <?php require_once THEME_PATH . 'views/tools/js_dynamic_url_processor.php' ?>

    <?= $this->views['extra_content'] ?>

    <?= $this->views['similar_tools'] ?>

    <?= $this->views['popular_tools'] ?>
</div>

<?php include_view(THEME_PATH . 'views/partials/clipboard_js.php') ?>
