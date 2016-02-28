<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Doctor */

$this->title = $searchModel->doctor->user->fullname;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'patient.user.fullname',
                'value'=> 'patient.user.fullname',
                'filter' => Select2::widget([
                    'attribute' => 'patient_id',
                    'model' => $searchModel,
                    'data' => $patients,
                    'language' => 'ru',
                    'options' => ['placeholder' => 'select ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'contentOptions'=>['style'=>'width: 350px;'],
            ],
            [
                'attribute' => 'start_at',
                'value' => 'start_at',
                'format' =>  ['date', 'php:Y-m-d H:i'],
                'filter' =>  DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'start_at',
                    'options' => ['placeholder' => 'Select date and time'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd hh:ii',
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'autoclose' => true,
                        'startView' => 2,
                    ]
                ]),
            ],
            [
                'attribute' => 'finish_at',
                'value' => 'finish_at',
                'format' =>  ['date', 'php:Y-m-d H:i'],
                'filter' =>  DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'finish_at',
                    'options' => ['placeholder' => 'Select date and time'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd hh:ii',
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'autoclose' => true,
                        'startView' => 2,
                    ]
                ]),
            ],
        ],
    ]); ?>


</div>
