<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
    Yii::t('application', 'Manage groups')=>array('admin'),
    Yii::t('application', 'Qualification of users')
);

$this->menu=array(
    array('label'=>Yii::t('application', 'Create group'), 'url'=>array('create')),
    array('label'=>Yii::t('application', 'Update group'), 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>Yii::t('application', 'Manage groups'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Qualification of users').' '.$model->name; ?></h1>

<form class="form-horizontal" enctype="multipart/form-data" id="group-form" method="post">
<?php
    /** @var $groupUsers GroupUsers */
    foreach ($model->users as $groupUsers) {
        /** @var $user User */
        $user = User::model()->findByPk($groupUsers->user_id);
        echo '
    <div class="control-group"><label class="control-label">' . $user->surname . ' ' . $user->firstname . '</label>
        <div class="controls controls-row">
            <input class="span3" type="text" name="penalty['.$groupUsers->user_id.'_'.$groupUsers->group_id.']" value="' . (100 - $groupUsers->penalty) . '">
        </div>
    </div>';
    }
?>
    <div class="form-actions">
        <button class="btn btn-primary" type="submit" name="yt0">Сохранить</button>
    </div>
</form>
