<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="schedule-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width: 15px;'],
                'template' => '{pressOk}',
                'buttons' => [
                    'pressOk' => function ($url, $model, $key) {
                        if($model->visit == 1)
                        {
                            return Html::a('<span class="glyphicon glyphicon-remove"> </span>', ['/site/cancel-visit', 'id'=>$model->id], [
                                'title' => "Cancel",
                                'data-method' =>'POST'
                            ]);
                        }
                        else
                        {
                            return Html::tag('span', '', ['class' => "glyphicon glyphicon-minus",  'title' => "Canceled", 'style' => 'cursor:pointer']);
                        }
                    },
                ],
            ],
        ],
    ]); ?>

</div>
