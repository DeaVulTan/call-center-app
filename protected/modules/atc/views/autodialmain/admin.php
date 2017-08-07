<?php
$this->breadcrumbs = array(
    'Управление заданиями' => array('admin'),
);

$this->menu = array(
    array('label' => 'Создание задания', 'url' => array('create')),
    array('label' => 'Импорт номеров', 'url' => array('import')),
);
?>
<style>
    .control-button {
        width: 22px;
        height: 22px;
    }
</style>

<script>
    $('document').ready(function() {
        $('.autodial-play').on('click', function () {
            var id = $(this).data('id');

            $('#modal-continue').attr('href', '<?= Yii::app()->createAbsoluteUrl('atc/autodialmain/playcontinue');?>/id/' + id);
            $('#modal-to-start').attr('href', '<?= Yii::app()->createAbsoluteUrl('atc/autodialmain/playfromstart');?>/id/' + id);
            $('#modal-play').modal('show');
        });
    });
</script>

<h1>Управление заданиями для автообзвона</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id'           => 'autodial-main-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => [
        [
            'type'   => 'raw',
            'value' => function($data) {
                $status_list = [
                    ['id' => 0, 'img' => 'stop.png'],
                    ['id' => 1, 'img' => 'play.png'],
                    ['id' => 2, 'img' => 'pause.png'],
                ];

                $result = '';
                foreach ($status_list as $status) {
                    if ($status['id'] == $data->status) {
                        $result .= '<img style="opacity: 0.5" class="control-button" src="' . Yii::app()->request->baseUrl . '/images/buttons/' . $status['img'] . '">';
                    } else {
                        if ($status['id'] == 1 && $data->status == 0 && $data->checkStarterNumbers()) {
                            $result .= '<img class="control-button autodial-play" data-id="' . $data->id . '" src="' . Yii::app()->request->baseUrl . '/images/buttons/' . $status['img'] . '">';
                        } else {
                            $result .= '<a href="' . Yii::app()->createAbsoluteUrl('atc/autodialmain/changestatus', ['id' => $data->id, 'status' => $status['id']]) . '"">'
                                . '<img class="control-button" src="' . Yii::app()->request->baseUrl . '/images/buttons/' . $status['img'] . '">'
                                . '</a>';
                        }
                    }
                }

                return $result;
            }
        ],
        'name',
        [
            'header' => 'Процесс',
            'value'  => function ($data) {
                return $data->getProcess();
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => [
                'delete' => [
                    'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))',
                    'label' => 'delete',
                    'options' => [
                        'confirm' => "Внимание! При удалятся все номера и файлы записей разговоров этого задания. Продолжить?",
                        'ajax' => [
                            'type' => 'POST',
                            'url' => "js:$(this).attr('href')",
                            'success' => 'function(data) {
                                if (data == "true") {
                                    $.fn.yiiGridView.update("liquor-category-grid");
                                    return false;
                                } else {
                                    window.location="admin?del=exist";
                                    return false;
                                }
                            }',
                        ],
                    ],
                ],
            ],
            'htmlOptions' => ['width' => '58px'],
        ],
    ],
]); ?>

<div class="modal fade hide" id="modal-play" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Запуск автообзвона</h4>
            </div>
            <div class="modal-body">
                Продолжить задание или запустить с начала?
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" id="modal-continue">Продолжить</a>
                <a href="#" class="btn btn-primary" id="modal-to-start">С начала</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>