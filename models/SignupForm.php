<?php
namespace app\models;

use Yii;
use app\models\User;
use yii\base\Model;
use app\models\Doctor;
use app\models\Patient;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $type;
    public $doctor;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['doctor', 'required', 'when' => function ($model) {
                return $model->type == 'Patient';
                    }, 'whenClient' => "function (attribute, value) {
                return $( \"#signupform-type option:selected\" ).text() == 'Patient';
            }"],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['type', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['fullname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],


        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {



        if ($this->validate()) {
            $user = new User();
            $user->fullname = $this->fullname;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                if($this->type == "Doctor")
                {
                    $doctor = new Doctor();
                    $doctor->user_id = $user->id;
                    if($doctor->save()){
                        return $user;
                    }

                }
                elseif($this->type == "Patient")
                {
                    $patient = new Patient();
                    $patient->user_id = $user->id;
                    $patient->doctor_id = $this->doctor;
                    if($patient->save()){
                        return $user;
                    }
                }
            }
        }
        return null;
    }



    /**
     * Create patient.
     *
     * @return true the saved model or false if saving fails
     */
    public function createPatient()
    {
        $model = new Patient();

        if ($model->save()) {
            return true;
        }
        return false;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Full name',
            'username' => 'Login',
            'type' => 'User type',
            'doctor' => 'Doctor',
        ];
    }

}
