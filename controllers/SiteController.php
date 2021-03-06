<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\DetailBeliSupplier;
use app\models\Retur;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'daftar-user'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'daftar-user'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     *
     * @return string
     */
    public function actionIndex()
    {
//        $searchModel = new \app\models\searchModel\DetailJual();
//        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider = new \yii\data\ActiveDataProvider([
		'query' => (new \yii\db\Query())->select('SUM(d.qty) barang, b.nama_barang')->from('detail_jual d')->join('inner join', 'barang b', 'd.barang_id = b.id')->groupBy('barang_id'),
	    'pagination' => false
	]);
        
        $beli_kirim = DetailBeliSupplier::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id])->andWhere(['status' => DetailBeliSupplier::dikirim])->count();
        $beli_selesai = DetailBeliSupplier::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id])->andWhere(['status' => DetailBeliSupplier::selesai])->count();
        $retur_kirim = Retur::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id])->andWhere(['status' => Retur::dikirim])->count();
        $retur_selesai = Retur::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id])->andWhere(['status' => Retur::selesai])->count();
        return $this->render('index',[
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'beli_kirim' => $beli_kirim,
            'beli_selesai' => $beli_selesai,
            'retur_kirim' => $retur_kirim,
            'retur_selesai' => $retur_selesai
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionSignup() {
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
        ]);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionTambahUser(){
    
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($user = $model->signup()){
                return $this->redirect(['daftar-user']);
            }
        }
        
        return $this->render('tambahUser',[
            'model' => $model
        ]);
    }
    
    public function actionDaftarUser()
    {
        $searchModel = new \app\models\searchModel\ListUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('list-user',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
