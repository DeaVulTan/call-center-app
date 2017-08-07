<?php
/**
 * @var SmsContact $model
 */
$this->breadcrumbs = [
    Yii::t('application', 'Управление контактами') => ['admin'],
    Yii::t('application', 'Создание контакта'),
];

$this->menu = [
    ['label' => Yii::t('application', 'Управление контактами'), 'url' => ['admin']],
];
?>

<h1><?= Yii::t('application', 'Создание контакта') ?></h1>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>