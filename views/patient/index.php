<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Patient - '.$user->fullname;
?>

<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= Html::encode($this->title. '. Your doctor is '.$doctor) ?>
        </h1>
    </div>

    <div class="col-xs-12">
        <?= $this->render('_patient-form', [
            'model' => $modelScheduleCreate,
        ]) ?>
    </div>

    <div class="col-xs-12">
        <?= $this->render('_patient-table', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]) ?>
    </div>
</div>