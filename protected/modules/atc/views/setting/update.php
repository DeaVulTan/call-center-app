<?php
$this->breadcrumbs=array(
	'Системные настройки'=>array('admin'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Системные настройки','url'=>array('admin')),
);
?>

<h1>Редактирование <?php echo Setting::model()->getCategoryName($id); ?></h1>

<a class="btn btn-primary" style="margin-bottom: 20px" href="../..">Вернуться</a>



<?php
    $formName = '_form';
	if ($id == 3) {
		$formName .= '_3';
	}
    echo $this->renderPartial($formName, ['models'=>$models]);
?>