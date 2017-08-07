<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<link href="/css/datepicker.css" rel="stylesheet">
<link href="/js/jplayer/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jplayer/jquery.jplayer.min.js"></script>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'file')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Прослушать файл</h4>
</div>
<div class="modal-body">
    <div id="jquery_jplayer_1" class="jp-jplayer"></div>
    <div id="jp_container_1" class="jp-audio-stream">
        <div class="jp-type-single">
            <div class="jp-gui jp-interface">
                <ul class="jp-controls">
                    <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                    <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                    <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                </ul>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
            </div>
            <div class="jp-no-solution">
                <span>Update Required</span>
                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
        </div>
    </div>
    <br>
    <a class="btn" href="#" id="modal-download-file">Скачать</a>
</div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>Yii::t("application", "close"),

        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'modal-file-close',),
    )); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Report'),
);

?>

<h1><?php echo $model->name ?></h1>

<?php
	if (isset($dataProvider)) {
		$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'report-form',
            'action'=>'/statistics/template/report?id=' . $model->id,
			'enableAjaxValidation'=>true,
			'method' => 'get',
			'type'=>'horizontal',
		));

		foreach ($params as $val) {
			switch ($val['type']) {
				case 'text':
					echo '<div class="control-group">
				        <label class="control-label">'.$val['header'].'</label>
				        <div class="controls controls-row">
				            <input class="span3" type="text" name="Report['.$val['name'].']" value="'.trim($val['value'], '%').'">
				        </div>
				    </div>';
					break;
				case 'date':
					echo '<div class="control-group">
				        <label class="control-label">'.$val['header'].'</label>
				        <div class="controls controls-row">
				        	с
					        <div class="input-append date" id="' . $val['name'] . '_from" data-date="' . $val['value'][0] . '" data-date-format="yyyy-mm-dd">
								<input class="span2" type="text" name="Report[' . $val['name'] . '_from]" value="' . $val['value'][0] . '">
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div>
							по
							<div class="input-append date" id="' . $val['name'] . '_to" data-date="' . $val['value'][1] . '" data-date-format="yyyy-mm-dd">
								<input class="span2" type="text" name="Report[' . $val['name'] . '_to]" value="' . $val['value'][1] . '">
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div>
				        </div>
				    </div>
				    <script>
				    	$("#' . $val['name'] . '_from").datepicker();
				    	$("#' . $val['name'] . '_to").datepicker();
				    </script>
				    ';
					break;
                case 'checkboxes':
                    $this->widget('widgets.ACheckboxSelector', [
                        'title' => $val['header'],
                        'module' => 'Report',
                        'name' => $val['name'],
                        'data' => $val['data'],
                        'value' => $val['value'],
                        ]);
                    break;
				default:
			}
		}

		$this->widget('bootstrap.widgets.TbButton', array(
	        'buttonType'=>'submit',
	        'type'=>'primary',
	        'label'=>Yii::t('application', 'Search'),
	    ));
        echo CHtml::hiddenField('export', '0');
        echo CHtml::link(Yii::t('application','Export'), '#', array('class' => 'export-button btn'));
		$this->endWidget();

		$this->widget('bootstrap.widgets.TbGridView', array(
			'id'=>'students-grid',
			'type'=>'striped bordered condensed',
			'dataProvider'=> $dataProvider,
			'columns' => $columns,
		)); 
	}
?>

<script language="javascript">
    $( document ).ready(function() {
        ready = false;
        $("#jquery_jplayer_1").jPlayer({
            ready: function (event) {
                ready = true;
            },
            pause: function() {
                $(this).jPlayer("clearMedia");
            },
            error: function(event) {
                if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
                    // Setup the media stream again and play it.
                    $(this).jPlayer("setMedia", stream).jPlayer("play");
                }
            },
            swfPath: "js",
            supplied: "mp3",
            preload: "none",
            wmode: "window",
            keyEnabled: true
        });
    });

    $('.export-button').click(function(){
        $('input[name=export]').val('1');
        $('#report-form').submit();
        $('input[name=export]').val('0');
    });

    $('.btn-file').live('click', function(){
        $('#modal-download-file').attr('href', 'getfile?file=' + $(this).attr('data-filename'));
        $('#file').modal().css({
            'width': '215px',
            'margin-left': function () {
                return -($(this).width() / 2);
            }
        });

        $("#jquery_jplayer_1").jPlayer(
            "setMedia",
            { title: "Audio record", mp3: "getfile?file=" + $(this).attr('data-filename') }
        );
    });

    $('#file').on('hidden', function () {
        $("#jquery_jplayer_1").jPlayer("clearMedia");
    });

</script>

