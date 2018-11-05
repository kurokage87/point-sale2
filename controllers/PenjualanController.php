<?php

namespace app\controllers;

use Yii;
use app\models\Penjualan;
use app\models\searchModel\PenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class PenjualanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Penjualan models.
     * @return mixed
     */
    
    public function actionIndex()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionLabaRugi()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('laba-rugi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penjualan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Penjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penjualan();
        $modelDetailJuals = [];
        $model->user_id = \Yii::$app->user->identity->id;
       
        $formDetails = \Yii::$app->request->post('DetailJual', []);
        
        foreach ($formDetails as $i => $formDetail) {
            $modelDetailJual = new \app\models\DetailJual(['scenario' => \app\models\DetailJual::SCENARIO_BATCH_UPDATE]);
            $modelDetailJual->setAttributes($formDetail);
            $modelDetailJuals[] = $modelDetailJual;
        }
        
        if (\Yii::$app->request->post('addRow') == 'true'){
            $model->load(\Yii::$app->request->post());
            
            $modelDetailJuals[] = new \app\models\DetailJual(['scenario' => \app\models\DetailJual::SCENARIO_BATCH_UPDATE]);
            return $this->render('create', [
                'model' => $model,
                'modelDetailJuals' => $modelDetailJuals
            ]);
        }
        
        if ($model->load(\Yii::$app->request->post())){
            if (\yii\base\Model::validateMultiple($modelDetailJuals) && $model->validate()){
                $model->save();
                foreach ($modelDetailJuals as $modelDetailJual) {
                    $modelDetailJual->penjualan_id = $model->id;
                    $modelDetailJual->save();
                    
                }
                return $this->redirect(['checkout', 'id' => $model->id]);
            }
        }
        
//        if ($model->load(Yii::$app->request->post('addRow')) == 'true') {
//            $model
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
        
        return $this->render('create', [
            'model' => $model,
            'modelDetailJuals' => $modelDetailJuals
        ]);
    }
    
    public function actionCheckout($id){
        $model = $this->findModel($id);
        
        $totalBelanja = \app\models\DetailJual::find()->where(['penjualan_id' => $model->id])->all();
        $jumlah_qty = 0;
        $jumlah_harga = 0;
        $total = 0;
        foreach ($totalBelanja as $tot) {
            $jumlah_qty +=$tot->qty;
            $jumlah_total = $tot->qty * $tot->barang->harga_jual;
            $total +=$jumlah_total;
        }
        $model->total_jual = $total;
//        \yii\helpers\VarDumper::dump($jumlah_harga);die;
//        $model->kembalian = $model->jumlah_uang - $model->total_jual;
        $nilai = Penjualan::find()->max('id');         
        $model->no_faktur = "MHKT". date('dmY').sprintf("%05s", $nilai+1);
        if ($model->load(\Yii::$app->request->post()) && $model->save()){
            $model->kembalian = $model->jumlah_uang - $model->total_jual;
            if ($model->load(\Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('checkout_form',[
            'model' => $model,
        ]);
    }
    
    public function actionCetakStruk($id){
        // get your HTML raw content without any layouts or scripts
    $content = $this->renderPartial('cetak-struk',[
            'model' => $this->findModel($id),
        ]);
        
        $pdf = new Pdf([
        'mode' => Pdf::MODE_BLANK,
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Bukti Pembayaran'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>[''], 
            'SetFooter'=>[''],
            ]
        ]);
        return $pdf->render();
    }


        /**
     * Updates an existing Penjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDetailJuals = $model->detailJuals;
        
        $formDetails = \Yii::$app->request->post('DetailJual', []);
        
        foreach ($formDetails as $i => $formDetail) {
            if (isset($formDetail['id']) && isset($formDetail['updateType']) && $formDetail['updateType'] != \app\models\DetailJual::UPDATE_TYPE_CREATE){
            $modelDetailJual = \app\models\DetailJual::findOne(['id' => $formDetail['id'], 'penjualan_id' => $model->id]);
            $modelDetailJual->setScenario(\app\models\DetailJual::SCENARIO_BATCH_UPDATE);
            $modelDetailJual->setAttributes($formDetail);
            $modelDetailJuals[$i] = $modelDetailJual;
            }else{
                $modelDetailJual = new \app\models\DetailJual(['scenario' => \app\models\DetailJual::SCENARIO_BATCH_UPDATE]);
                $modelDetailJual->setAttributes($formDetail);
                $modelDetailJuals[] = $modelDetailJual;
            }
        }
        
        if (\Yii::$app->request->post('addRow') == 'true'){
            $modelDetailJuals[] = new \app\models\DetailJual(['scenario' => \app\models\DetailJual::SCENARIO_BATCH_UPDATE]);
            return $this->render('update',[
                'model' => $model,
                'modelDetailJuals' => $modelDetailJuals
            ]);
        }
        
        if ($model->load(\Yii::$app->request->post())){
            if (\yii\base\Model::validateMultiple($modelDetailJuals) && $model->validate()){
                $model->save();
                foreach ($modelDetailJuals as $modelDetailJual) {
                    if ($modelDetailJual->updateType == \app\models\DetailJual::UPDATE_TYPE_DELETE) {
                        $modelDetailJual->delete();
                    }else{
                        $modelDetailJual->penjualan_id = $model->id;
                        $modelDetailJual->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }

        return $this->render('update', [
            'model' => $model,
            'modelDetailJuals' => $modelDetailJuals
        ]);
    }

    /**
     * Deletes an existing Penjualan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Penjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    protected function findModelBarang($id){
        if ($model = \app\models\Barang::findOne($id) != null){
            return $model;
        }
        
        throw new NotFoundHttpException(\Yii::t('app','The request page does not exist'));
    }
}
