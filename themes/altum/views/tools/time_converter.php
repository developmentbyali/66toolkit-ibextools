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
                <li class="active" aria-current="page"><?= sprintf(l('tools.time_converter_tools.name'), l('tools.' . $data->from), l('tools.' . $data->to)) ?></li>
            </ol>
        </nav>
    <?php endif ?>

    <div class="row mb-4">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0 text-truncate">
            <h1 class="h4 m-0 text-truncate"><?= sprintf(l('tools.time_converter_tools.name'), l('tools.' . $data->from), l('tools.' . $data->to)) ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= sprintf(l('tools.time_converter_tools.description'), l('tools.' . $data->from), l('tools.' . $data->to)) ?>">
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
                    <label for="input"><i class="fas fa-fw fa-sort-numeric-up-alt fa-sm text-muted mr-1"></i> <?= l('tools.' . $data->from) ?></label>
                    <input type="number" step="1" id="input" name="input" class="form-control <?= \Altum\Alerts::has_field_errors('input') ? 'is-invalid' : null ?>" value="<?= $data->values['input'] ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('input') ?>
                </div>

                <div class="form-group">
                    <label for="precision"><i class="fas fa-fw fa-ellipsis-h fa-sm text-muted mr-1"></i> <?= l('tools.precision') ?></label>
                    <input type="number" id="precision" min="0" step="1" name="precision" class="form-control <?= \Altum\Alerts::has_field_errors('precision') ? 'is-invalid' : null ?>" value="<?= $data->values['precision'] ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('precision') ?>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.submit') ?></button>
            </form>

        </div>
    </div>

    <?php if(isset($data->result)): ?>
        <div id="result_wrapper" class="mt-4">
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="result"><?= l('tools.' . $data->to) ?></label>
                            <div>
                                <button
                                        type="button"
                                        class="btn btn-link text-secondary"
                                        data-toggle="tooltip"
                                        title="<?= l('global.clipboard_copy') ?>"
                                        aria-label="<?= l('global.clipboard_copy') ?>"
                                        data-copy="<?= l('global.clipboard_copy') ?>"
                                        data-copied="<?= l('global.clipboard_copied') ?>"
                                        data-clipboard-target="#result"
                                        data-clipboard-text
                                >
                                    <i class="fas fa-fw fa-sm fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <textarea id="result" class="form-control"><?= $data->result ?></textarea>
                    </div>

                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="mt-5">
        <h2 class="h6"><?= sprintf(l('tools.x_to_y_conversion_table_header'), l('tools.' . $data->from), l('tools.' . $data->to)) ?></h2>
        <p class="text-muted font-size-small mb-4"><?= sprintf(l('tools.x_to_y_conversion_table_subheader'), l('tools.' . $data->from), l('tools.' . $data->to)) ?></p>

        <div class="table-responsive table-custom-container">
            <table class="table table-custom">
                <thead>
                <tr>
                    <th><?= l('tools.' . $data->from) ?></th>
                    <th><?= l('tools.' . $data->to) ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data->table as $key => $value): ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

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
                                        <?= sprintf(l('tools.time_converter_tools.submission'), $value->input, $data->from, $data->to) ?>
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
