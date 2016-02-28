<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="comment-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="col-xs-12">
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
