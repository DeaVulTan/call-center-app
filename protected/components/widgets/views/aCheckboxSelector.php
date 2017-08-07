<?php
/** @var string $title */
/** @var array $data */
/** @var array $value */
/** @var string $name */
/** @var string $fieldName */
?>

<div ng-controller="checkboxSelector">
    <div class="control-group" ng-init='data=<?= json_encode($data); ?>'>
        <label class="control-label"><?= $title; ?></label>

        <div class="controls controls-row">
            <div class="well" style="width:300px;float:left">
                <input class="op-switch-filter" placeholder="Фильтр" ng-model="search<?= $fieldName; ?>">
                <div  style="height:140px;overflow-x:hidden;overflow-y:scroll">
                    <div ng-repeat="row in (data | filter:search<?= $fieldName; ?>:strict)">
                        <input type="checkbox" ng-model="row.selected"><span> {{row.name}}</span>
                    </div>
                </div>
            </div>
            <div class="well" style="float:left;margin-left:10px">
                <div style="width:285px"><label>Выбрано:</label><button class="btn btn-info pull-right" onclick="return false" ng-click="resetChecked('<?= $name; ?>')">Сбросить</button></div>
                <div ng-repeat="row in data" ng-if="row.selected">
                    <input type="checkbox" name="<?= $name; ?>[{{row.id}}]" ng-model="row.selected"><span> {{row.name}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
