<?php

namespace app\models;

use Yii;
use juniq\helper\Time;

/**
 * This is the model class for table "schedule".
 *
 * @property string $id
 * @property integer $visit
 * @property string $start_at
 * @property string $finish_at
 * @property string $created_at
 * @property string $comment
 * @property string $patient_id
 * @property string $doctor_id
 */
class Schedule extends \yii\db\ActiveRecord
{
   // protected $start_at;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }


    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_id', 'doctor_id', 'start_at', 'finish_at'], 'required'],
            [['visit', 'patient_id', 'doctor_id'], 'integer'],
            [['start_at', 'finish_at', 'created_at'], 'safe'],
            [['comment'], 'string'],
        ];
    }


    /**
     *
     *  validation doctor free time
     */
    public function validateTime($attribute, $attribute2)
    {
        if($this->start_at < Yii::$app->formatter->asDate('now', 'yyyy-MM-dd HH:mm')){
            $this->addError($attribute, 'Can not be less than now');
            return false;
        }
        if($this->start_at > $this->finish_at){
            $this->addError($attribute2, 'It can not be started before');
            return false;
        }
        $schedule = Schedule::find()->where(['visit' => 1, 'doctor_id' => $this->doctor_id])->andWhere(['>', 'finish_at', $this->start_at])->andWhere(['<', 'start_at', $this->finish_at])->all();
        if ($schedule) {
            $this->addError($attribute, 'This period of time is not available');
            $this->addError($attribute2, 'This period of time is not available');
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visit' => 'Visit',
            'start_at' => 'Start of session',
            'finish_at' => 'End of session',
            'created_at' => 'Created At',
            'comment' => 'Comment',
            'patient_id' => 'Patient ID',
            'doctor_id' => 'Doctor ID',
            'patient.user.fullname' => 'Patient name',
        ];
    }

    /**
     * User info
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    /**
     * User info
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * $models - Schedule model
     * @return 0|string
     */
    public function getLoadTime($models)
    {
        if($models)
        {
            $allTime = 0;
            foreach($models as $model)
            {
                $allTime += Yii::$app->formatter->asTimestamp($model->finish_at) - Yii::$app->formatter->asTimestamp($model->start_at);
            }
            return Time::formatDuration($allTime);
        }
        return "0";
    }

}
