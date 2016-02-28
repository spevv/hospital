<?php

namespace app\controllers;

use app\models\Patient;
use app\models\PermissionDoctor;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use app\models\Doctor;
use yii\helpers\ArrayHelper;

use app\models\User;
use app\models\Schedule;
use app\models\ScheduletSearch;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * If doctor view doctor/index
     * if patient view patient/index
     * @return mixed
     */
    public function actionIndex()
    {
        $identity = Yii::$app->user->identity;
        $id = Yii::$app->user->id;
        if($identity && $id)
        {
            $user = $this->findUserModel($id);
            if($user && $user->doctor)
            {
                $searchModel = new ScheduletSearch([
                    'doctor_id'=> $user->doctor->id,
                    'start_at' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'),
                    'finish_at' => Yii::$app->formatter->asDate('tomorrow', 'yyyy-MM-dd')
                ]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('/doctor/index', [
                    'user' => $user,
                    'patients' => Patient::getAllPatientsByDoctor($searchModel->doctor_id),
                    'doctors' => Doctor::findAllElseOne($user->doctor->id),
                    'chartsDoctors' => PermissionDoctor::findAllPermissionDoctorByDestination($searchModel->doctor_id),
                    'doctor_id' => $searchModel->doctor_id,
                    'permissionDoctor' =>  Doctor::findDoctorModel($searchModel->doctor_id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
            elseif($user && $user->patient)
            {
                $modelScheduleCreate = new Schedule([
                    'patient_id' => $user->patient->id,
                    'doctor_id' => $user->patient->doctor_id
                ]);
                if ($modelScheduleCreate->load(Yii::$app->request->post()) && $modelScheduleCreate->validateTime('start_at', 'finish_at'))
                {
                    $modelScheduleCreate->visit = 1;
                    if($modelScheduleCreate->save())
                    {
                        $modelScheduleCreate = new Schedule([
                            'patient_id' => $user->patient->id,
                            'doctor_id' => $user->patient->doctor_id
                        ]);
                    }
                }
                $searchModel = new ScheduletSearch([
                    'patient_id' => $user->patient->id,
                    'doctor_id' => $user->patient->doctor_id,
                    'start_at' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd')
                ]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('/patient/index', [
                    'user' => $user,
                    'doctor' => $user->patient->doctor->user->fullname,
                    'modelScheduleCreate' => $modelScheduleCreate,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
            else
            {
                return $this->redirect(['login']);
            }
        }
        return $this->render('index');
    }

    /**
     * make checks whether a user (doctor) to move to page doctor/view
     * @param integer $id
     * @return doctor/view
     * @throws NotFoundHttpException
     */
    public function actionDoctor($id)
    {
        $identity = Yii::$app->user->identity;
        $idUser = Yii::$app->user->id;
        $user = $this->findUserModel($idUser);
        if ($identity && $idUser && $user && $user->doctor)
        {
            if(PermissionDoctor::canDoctorPermisiion($user->doctor->id, $id)){
                $searchModel = new ScheduletSearch([
                    'doctor_id' => $id,
                    'start_at' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'),
                ]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('/doctor/view', [
                    'patients' => Patient::getAllPatientsByDoctor($searchModel->doctor_id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * action to edit comments
     * @param integer $id
     * @return save comment and redirect to home page
     */
    public function actionComment($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        } else {
            return $this->renderAjax('/doctor/_comment', [
                'model' => $model
            ]);
        }
    }

    /**
     * action to edit doctor permissions
     * @param integer $id
     * @return redirect to home page
     */
    public function actionPermissionDoctor($id)
    {
        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            PermissionDoctor::changeDoctorPermission($post["Doctor"]['permissions'], $id);
        }
        return $this->redirect(['/']);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionCancelVisit($id)
    {
        if(Yii::$app->request->isPost){
            $model = $this->findModel($id);
            $model->visit = 0;
            $model->save();
            return $this->redirect(['/']);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
           if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'doctors' => Doctor::getAllDoctorsAsArray(),
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUserModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
