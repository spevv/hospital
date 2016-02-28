<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="schedule-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="col-xs-3">
            <?=  $form->field($model, 'start_at', [])->widget(DateTimePicker::className(), [
                'options' => ['placeholder' => 'Select date and time'],
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                ]
            ]); ?>
        </div>
        <div class="col-xs-3">
            <?=  $form->field($model, 'finish_at', [])->widget(DateTimePicker::className(), [
                'options' => ['placeholder' => 'Select date and time'],
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                ]
            ]); ?>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <?= Html::submitButton('Create', ['class' => 'btn btn-success btn-margingtop']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>