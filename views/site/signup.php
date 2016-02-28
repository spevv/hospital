<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use kartik\select2\Select2;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;


$items = [
    'Patient' => 'Patient',
    'Doctor' => 'Doctor'
];
$params = [
    'prompt' => 'Select...'
];

?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'fullname') ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'type')->dropDownList($items,$params); ?>


                <?= $form->field($model, 'doctor', [])->widget(Select2::classname(), [
                    'data' => $doctors,
                    'options' => ['placeholder' => 'Select doctor...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
