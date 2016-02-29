<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "patient".
 *
 * @property string $id
 * @property string $card
 * @property string $user_id
 * @property string $doctor_id
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'doctor_id'], 'required'],
            [['user_id', 'doctor_id'], 'integer'],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'doctor_id' => 'Doctor ID',
        ];
    }

    /**
     * Schedule info
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasMany(Schedule::className(), ['patient_id' => 'id']);
    }

    /**
     * get User info
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * get Doctor info
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }


    /**
     * get all patients by doctor id
     * @param integer $id
     * @return array
     */
    public static function getAllPatientsByDoctor($id)
    {
        return ArrayHelper::map(Patient::find()->where(['doctor_id' => $id])->all(), 'id', 'user.fullname');
    }


}
