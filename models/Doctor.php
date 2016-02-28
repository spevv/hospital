<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "doctor".
 *
 * @property string $id
 * @property string $type
 * @property string $user_id
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'integer'],
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
        ];
    }

    /**
     * User info
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * get doctor permissions
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(User::className(), ['id' => 'destination_id'])->viaTable(PermissionDoctor::tableName(), ['owner_id' => 'id']);
    }

    /**
     * get all doctors
     * @param integer $id
     * @return array
     */
    public static function getAllDoctorsAsArray()
    {
        $doctors = ArrayHelper::map(Doctor::find()->all(), 'id', 'user.fullname');
        asort($doctors);
        return $doctors;
    }

    /**
     * get doctors else one
     * @param integer $id
     * @return array
     */
    public static function findAllElseOne($id)
    {
        $doctors = ArrayHelper::map(Doctor::find()->where(['<>', 'id', $id])->all(), 'id', 'user.fullname');
        asort($doctors);
        return $doctors;
    }



    /**
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findDoctorModel($id)
    {
        if (($model = Doctor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
