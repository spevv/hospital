<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission_doctor".
 *
 * @property integer $id
 * @property string $owner_id
 * @property string $destination_id
 */
class PermissionDoctor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission_doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'destination_id'], 'required'],
            [['owner_id', 'destination_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'destination_id' => 'Destination ID',
        ];
    }

    /**
     * get Doctor
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'owner_id']);
    }

    /**
     * get all permission by doctor
     * @param integer $id doctor id
     * @return array
     */
    public static function findAllPermissionDoctorByDestination($id)
    {
        return PermissionDoctor::find()->where(['destination_id' =>  $id])->all();
    }

    /**
     * check doctor permission
     * @param integer $destinationId, $ownerId
     * @return true|false
     */
    public static function canDoctorPermisiion($destinationId, $ownerId)
    {
        $canDoctor = PermissionDoctor::find()->where(['destination_id' => $destinationId, 'owner_id' => $ownerId])->one();
        if($canDoctor !== null){
            return true;
        }
        return false;
    }

    /**
     * change doctor permission
     * @param PermissionDoctor permissions
     * @return true
     */
    public static function changeDoctorPermission($permissions = null, $id)
    {
        if(!empty($permissions)){
            $tempArray = [];
            foreach($permissions as $key)
            {
                $temp = PermissionDoctor::find()->where(['owner_id' => $id, 'destination_id' => $key])->orderBy('id')->all();
                if(!empty($temp))
                {
                    $tempArray[$key] = $temp[0]['id'];
                }
                else
                {
                    $tempArray[$key] = null;
                }
            }
            $tempPDs = PermissionDoctor::find()->where(['owner_id' => $id])->orderBy('id')->all();
            if(!empty($tempPDs))
            {
                foreach($tempPDs as $tempPD)
                {
                    if(!in_array($tempPD['id'], $tempArray)){
                        $PermissionDoctorDelete = PermissionDoctor::findOne($tempPD['id']);
                        $PermissionDoctorDelete->delete();
                    }
                }
            }
            foreach($tempArray as $key => $value){
                if($value == null)
                {
                    $permissionDoctor = new PermissionDoctor([
                        'destination_id' => $key,
                        'owner_id' => $id,
                    ]);
                    $permissionDoctor->save();
                }
            }
        }
        else
        {
            PermissionDoctor::deleteAll('owner_id ='. $id);
        }
        return true;
    }
}
