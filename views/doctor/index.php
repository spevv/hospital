<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */

$this->title = 'Doctor - '.$user->fullname;
?>

<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
    <?php
    Modal::begin([
        'header' => '<h2></h2>',
        //'toggleButton' => ['label' => 'click me'],
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    ?>
    <div id="modalContent">Загрузка...</div>
    <?php

    Modal::end();
    ?>
    <div class="col-xs-12">
        <?= $this->render('_doctor-table', [
            'patients' => $patients,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]) ?>
    </div>

    <div class="col-xs-12">
        <?= $this->render('_permission-doctor', [
            'doctor_id' => $doctor_id,
            'doctors' => $doctors,
            'model' => $permissionDoctor
        ]) ?>
    </div>

    <div class="col-xs-12">
        <?= $this->render('_charts-doctors', [
            'doctors' => $chartsDoctors,
        ]) ?>
    </div>
</div>
