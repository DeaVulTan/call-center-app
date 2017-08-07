<?php
/**
 * @var SmsContact $model
 */

$this->breadcrumbs = [
    Yii::t('application', 'Управление контактами') => ['admin'],
    Yii::t('application', 'Редактирование контакта'),
];

$this->menu = [
    ['label' => Yii::t('application', 'Создание контакта'), 'url' => ['create']],
    ['label' => Yii::t('application', 'Управление контактами'), 'url' => ['admin']],
];
?>

    <h1><?= Yii::t('application', 'Редактирование контакта') ?> <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>