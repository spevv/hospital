<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="schedule-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter'=>true,
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
                    'options' => ['placeholder' => 'Select patient...'],
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
                'footer' =>'Work time: '.$searchModel->getLoadTime($dataProvider->models),
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
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width: 15px;'],
                'template' => '{cancelVisit} {pressComment}',
                'buttons' => [
                    'cancelVisit' => function ($url, $model, $key) {
                        if($model->visit == 1)
                        {
                            return Html::a('<span class="glyphicon glyphicon-remove"> </span>', ['/site/cancel-visit', 'id'=>$model->id], [
                                'title' => "Cancel visit",
                                'data-method' =>'POST'
                            ]);
                        }
                        else
                        {
                            return Html::tag('span', '', ['class' => "glyphicon glyphicon-minus",  'title' => "Canceled visit", 'style' => 'cursor:pointer']);
                        }
                    },
                    'pressComment' => function ($url, $model, $key) {
                        return Html::button('<span class="glyphicon glyphicon-file"> </span>', ['value' => Url::to(['site/comment', 'id'=>$model->id]), 'class' => 'btn modalButton btn-link', 'title' => "Comment",]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
