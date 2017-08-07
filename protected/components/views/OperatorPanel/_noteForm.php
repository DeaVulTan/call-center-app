<?php
/* @var $this NotesController */
/* @var $model Notes */
/* @var $form CActiveForm */
?>

<div class="form">
    <form class="well form-vertical" id="noteForm" action="/callcenter/operatorpanel/savenote" method="post" ng-init="">
        <input type="hidden" value="<?php echo $id; ?>" name="linkedid" />
        <input type="hidden" value="<?php echo $group_id; ?>" name="group_id" />
        <input type="hidden" value="<?php echo $cid; ?>" name="cid" />
        <input type="hidden" value="<?php echo $id; ?>" name="linkedid"/>
        <?php
        if (is_array($fields) && count($fields)) {

            foreach ($fields as $id => $field) {
                if ($field['type'] == 'text') { ?>
                    <label for="field<?php echo $id; ?>">
                        <?php echo $field['name']; ?>  <?php echo ($field['require'] == 1) ? '*' : ''; ?>
                    </label>
                    <input class="span3" name="field<?php echo $id; ?>" id="field<?php echo $id; ?>"
                           type="text" <?php echo ($field['require'] == 1) ? 'required' : ''; ?>>
                <?php }
                if ($field['type'] == 'bool') { ?>
                    <label class="checkbox" for="field<?php echo $id; ?>">
                        <input id="checkbox_field<?php echo $id; ?>" type="hidden" value="0" name="field<?php echo $id; ?>">
                        <input name="field<?php echo $id; ?>" id="field<?php echo $id; ?>" value="1" type="checkbox">
                        <?php echo $field['name']; ?>
                    </label>
                <?php }
                if ($field['type'] == 'select') { ?>
                    <label for="field<?php echo $id; ?>">
                        <?php echo $field['name']; ?>  <?php echo ($field['require'] == 1) ? '*' : ''; ?>
                    </label>
                    <select name="field<?php echo $id; ?>[]" id="field<?php echo $id; ?>">
                        <?php foreach (explode(',', $field['options']) as $option) { ?>
                            <option value="<?= $option ?>"><?= $option ?></option>
                        <?php } ?>
                    </select>
                <?php }
            }
            echo '<button class="btn" type="submit">Сохранить</button>';
            //echo '<a class="btn op-noteform-close">Закрыть</a>';
        }
        ?>
    </form>
</div><!-- form -->
