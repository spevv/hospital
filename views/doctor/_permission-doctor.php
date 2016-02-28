<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permission-doctor bs-example">
    <h3>Doctors who can view your schedule</h3>

    <?php $form = ActiveForm::begin(['action' => ['site/permission-doctor', 'id'=> $doctor_id]]); ?>
    <?= $form->field($model, 'permissions', [])->widget(Select2::classname(), [
        'data' => $doctors,
        'options' => ['placeholder' => 'Select doctor',  'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ["title"=>"Save", 'class' =>'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

