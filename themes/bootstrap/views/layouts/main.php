<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" ng-app="MyApp">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css"/>
    <?php if (!Yii::app()->user->isGuest) { ?>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <?php } ?>
</head>

<body>

<?php
$current_status = 'Онлайн';

$reportItems = array();
if (Yii::app()->user->checkAccess('viewOperatorPanel')) {
    Yii::import('application.modules.statistics.models.ReportTemplate');
    $reports = ReportTemplate::model()->findAll('is_published = 1' ,array('select' => 'id, name'), array('order'=>' name'));
    foreach ($reports as $val) {
        $reportItems[] = array(
            'label' => $val['name'],
            'url' => '/statistics/template/report?id=' . $val['id'],
            'visible' => Yii::app()->user->checkAccess('manageReports'),
        );
    }
}
$menuItems = array(
	array(
		'class' => 'bootstrap.widgets.TbMenu',
		'items' => array(
            array('label' => 'Автообзвон', 'url' => '#', 'visible' => Yii::app()->user->checkAccess('manageTE'), 'items' => array(
                array('label' => Yii::t('menu', 'Задания автообзвона'), 'url' => array('/atc/autodialmain'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
                array('label' => Yii::t('menu', 'Номера для автообзвона'), 'url' => array('/atc/autodialnumbers'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
            )),
            array('label' => Yii::t('menu', 'services'), 'url' => array('/callcenter/group'), 'visible' => (Yii::app()->user->checkAccess('manageServices') || Yii::app()->user->checkAccess('adminServices'))),
            array('label' => Yii::t('menu', 'Panels'), 'url' => '#', 'visible' => Yii::app()->user->checkAccess('viewOperatorPanel'), 'items' => array(
                array('label' => Yii::t('menu', 'operatorPanel'), 'url' => array('/callcenter/operatorpanel'), 'visible' => Yii::app()->user->checkAccess('viewOperatorPanel')),
            )),
            array('label' => Yii::t('menu', 'Manage Notes'), 'url' => '#', 'visible' => (Yii::app()->user->checkAccess('manageTE') || Yii::app()->user->checkAccess('canAdminNotes')), 'items' => array(
                array('label' => Yii::t('menu', 'Notes'), 'url' => array('/callcenter/notes/admin'), 'visible' => Yii::app()->user->checkAccess('canAdminNotes')),
            )),
            array('label' => Yii::t('menu', 'Users'), 'url' => '#', 'visible' => Yii::app()->user->checkAccess('manageUsers'), 'items' => array(
                array('label' => Yii::t('menu', 'users'), 'url' => array('/atc/user'), 'visible' => Yii::app()->user->checkAccess('manageUsers')),
                array('label' => Yii::t('menu', 'User Statuses'), 'url' => array('/atc/userstatus'), 'visible' => Yii::app()->user->checkAccess('manageUsers')),
                array('label' => Yii::t('menu', 'Auth Panel'), 'url' => array('/auth'), 'visible' => Yii::app()->user->checkAccess('admin')),
                array('label' => Yii::t('menu', 'sip'), 'url' => array('/atc/usersip'), 'visible' => Yii::app()->user->checkAccess('managerUserSip')),
                array('label' => 'Сообщения', 'url' => array('/callcenter/message/all'), 'visible' => Yii::app()->user->checkAccess('manageUsers')),
            )),
			array(
                'label' => Yii::t('menu', 'Manage TE'),
                'url' => '#',
                'visible' => Yii::app()->user->checkAccess('manageTE')
                    || Yii::app()->user->checkAccess('manageSwitchings')
                    || Yii::app()->user->checkAccess('canUseReportsEditor'),
                'items' => array(
                array('label' => Yii::t('menu', 'switching'), 'url' => array('/callcenter/switching'), 'visible' => Yii::app()->user->checkAccess('manageSwitchings')),
                array('label' => Yii::t('menu', 'vip'), 'url' => array('/callcenter/vip'), 'visible' => Yii::app()->user->checkAccess('manageVIP')),
				array('label' => Yii::t('menu', 'Отправить СМС'), 'url' => array('/callcenter/smscontact'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
				array('label' => Yii::t('menu', 'sounds'), 'url' => array('/atc/sound'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
				array('label' => Yii::t('menu', 'ivr'), 'url' => array('/atc/ivr'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
				array('label' => Yii::t('menu', 'sip'), 'url' => array('/atc/sip'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
                array('label' => Yii::t('menu', 'Транки'), 'url' => array('/atc/trunk'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
				array('label' => Yii::t('menu', 'External Numbers'), 'url' => array('/atc/extNumber'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
                array('label' => Yii::t('menu', 'Исходящая маршрутизация'), 'url' => array('/atc/outgoingRule'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
                array('label' => Yii::t('menu', 'Правила по времени'), 'url' => array('/atc/timeCondition'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
                array('label' => Yii::t('menu', 'Временные диапазоны'), 'url' => array('/atc/timeRule'), 'visible' => Yii::app()->user->checkAccess('manageTE')),
				array('label' => Yii::t('menu', 'Template'), 'url' => array('/statistics/template'), 'visible' => Yii::app()->user->checkAccess('canUseReportsEditor')),
                array('label' => Yii::t('menu', 'System setting'), 'url' => array('/atc/setting'), 'visible' => Yii::app()->user->checkAccess('canEditSetting')),
                array('label' => Yii::t('menu', 'Системный монитор'), 'url' => array('/atc/system/monitor'), 'visible' => Yii::app()->user->checkAccess('canEditSetting')),
                array('label' => Yii::t('menu', 'Резервное копирование'), 'url' => array('/atc/system/backup'), 'visible' => Yii::app()->user->checkAccess('canEditSetting')),
			)),
            array('label' => Yii::t('menu', 'Reports'), 'url' => '#', 'visible' => Yii::app()->user->checkAccess('manageReports'), 'items' => $reportItems),
		),
	),
	array(
		'class' => 'bootstrap.widgets.TbMenu',
		'htmlOptions' => array('class' => 'pull-right'),
		'items' => array(
			array('label' => Yii::t('menu', 'login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
		)
	),
);

if (!Yii::app()->user->isGuest) {
	$statusItems = array();

	if (!is_null(SipDevices::model()->findByAttributes(array('chained_user_id' => Yii::app()->user->id)))) {
		foreach (CHtml::listData(UserStatus::model()->findAll(), 'name', 'icon', 'id') as $sId => $aVal) {
			$sName = array_keys($aVal);
			$sName = $sName[0];
			$statusIcon = '<span style="width:16px;height:16px;float:left;"></span>';
			if (!empty($aVal[$sName]))
				$statusIcon = CHtml::image(Yii::app()->request->baseUrl.'/images/user_status/'.$aVal[$sName]);
			$statusItems[] = array('label' => $statusIcon . '&nbsp&nbsp' .$sName, 'url' => '#st' . $sId);
		}

		$statusItems[] = "---";
	}

	$statusItems[] = array('label' => Yii::t('menu', 'logout') . ' (' . Yii::app()->user->name . ')',
		'url' => array('/site/logout'));

	$cs = User::model()->with('statusName')->findByPk(Yii::app()->user->id);
	if($cs->statusName) {
		$statusIcon = '';
		if (!empty($cs->statusName->icon))
			$statusIcon = CHtml::image(Yii::app()->request->baseUrl.'/images/user_status/'.$cs->statusName->icon) . "&nbsp&nbsp";
		$current_status = $statusIcon . $cs->statusName->name;
	}
	$menuItems[] = array(
		'class' => 'bootstrap.widgets.TbButtonGroup',
		'htmlOptions' => array('class' => 'pull-right', 'id' => 'status_menu'),
		'type' => 'info',
		'encodeLabel' => false,
		'buttons' => array(
			array('label' => $current_status, 'items' => $statusItems),
		),
	);
    $menuItems[] = '<audio id="newMessageAudio" src="/js/message.wav"></audio><a class="btn pull-right" style="padding-right:3px; padding-left:3px" href="/callcenter/message" target="_blank"><i class="icon-large icon-envelope"></i><span id="newMessageSpan"></span></a>';
}


$this->widget('bootstrap.widgets.TbNavbar', array(
	'items' => $menuItems
)); ?>
<div class="container" id="page">
	<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true,
		'fade'=>true,
		'closeText'=>'&times;',
		'alerts'=>array(
			'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
			'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
			'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
			'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
		),
	)); ?>
	<?php if (isset($this->breadcrumbs)): ?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'links' => $this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by RQ.<br/>
	</div>
	<!-- footer -->

</div>
<!-- page -->

<script type="text/javascript">
	$(function () {
		$('#status_menu li>a').click(function () {
			var $t = $(this);
			if($t.attr('href').indexOf('#') > -1) {
				var status = $t.attr('href').replace('#st', '');
				$.post('/site/changestatus', {id: status},
					function (data) {
                        data = JSON.parse(data);
                        if (data.status == 'error') {
                            alert(data.msg);
                        } else if(data.status == 'ok') {
							var btn = $('#status_menu a.btn');
							var changed_status = data.name;
							btn.html(changed_status + ' <span class="caret"></span>');
							var changed_icon = data.icon;
							if (changed_icon != '') {
								btn.html('<img src="/images/user_status/' + changed_icon + '"/>&nbsp&nbsp' + btn.html());
							}
						}
					});
				event.preventDefault();
			}
		});
	});
</script>

</body>
</html>
