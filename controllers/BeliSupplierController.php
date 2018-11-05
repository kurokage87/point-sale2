<?php

namespace app\controllers;

use Yii;
use app\models\BeliSupplier;
use app\models\searchModel\BeliSupplierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DetailBeliSupplier;
use yii\base\Model;
use kartik\mpdf\Pdf;

/**
 * BeliSupplierController implements the CRUD actions for BeliSupplier model.
 */
class BeliSupplierController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all BeliSupplier models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BeliSupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionHalamanSupplier(){
        $searchModel = new BeliSupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionProsesSupplier($id){
        $model = $this->findModel($id);
        $model->status = BeliSupplier::di_proses_supplier;
        $model->save();
        return $this->redirect('halaman-supplier');
        
    }

    /**
     * Displays a single BeliSupplier model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
    
    public function actionSelesai($id) {
        $model = DetailBeliSupplier::findOne($id);
        $model->status = DetailBeliSupplier::selesai;
        $model->save();
        
        return $this->redirect(['view','id' => $model->beli_sup_id]);
    }

    /**
     * Creates a new BeliSupplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BeliSupplier();
        $model->tgl_beli = date('Y-m-d');
        $model->status = BeliSupplier::order;
        $modelDetailBelis = [];
        $supplier = \app\models\Supplier::find()->where(['user_id' => \Yii::$app->user->identity->id])->one();
        if ($supplier == null)
        {
            \Yii::$app->session->getFlash('Silahkan Isi Formulir Profil Supplier');
            return $this->redirect(['supplier/create']);
        }else{
            $model->supplier_id = $supplier->id;
        }
        
        $faktur = BeliSupplier::find()->max('id');
        $model->no_faktur = "MHKTSUP".date('dmY'). sprintf("%05s", $faktur+1);
        $model->kode_pembelian = "KDBELI".sprintf("%05s", $faktur+1);
        $formDetails = \Yii::$app->request->post('DetailBeliSupplier', []);

        foreach ($formDetails as $formDetail) {
            $modelDetail = new DetailBeliSupplier(['scenario' => DetailBeliSupplier::SCENARIO_BATCH_UPDATE]);
            $modelDetail->setAttributes($formDetail);
            $modelDetailBelis[] = $modelDetail;
        }

        if (\Yii::$app->request->post('addRow') == 'true') {
            $model->load(\Yii::$app->request->post());
            $modelDetailBelis[] = new DetailBeliSupplier(['scenario' => DetailBeliSupplier::SCENARIO_BATCH_UPDATE]);
            return $this->render('create', [
                        'model' => $model,
                        'modelDetailBelis' => $modelDetailBelis
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Model::validateMultiple($modelDetailBelis) && $model->validate()) {
                $model->save();
                foreach ($modelDetailBelis as $modelDetail) {
                    $modelDetail->beli_sup_id = $model->id;
                    $modelDetail->status = DetailBeliSupplier::order;
                    $modelDetail->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelDetailBelis' => $modelDetailBelis
        ]);
    }
    
    public function actionCetakStruk($id){
        // get your HTML raw content without any layouts or scripts
        $model = $this->findModel($id);
        $faktur = BeliSupplier::find()->max('id');
//        $model->no_faktur = "MHKTSUP".date('dmY'). sprintf("%05s", $faktur+1);
        
    $content = $this->renderPartial('cetak-struk',[
            'model' => $model,
        ]);
        
        $pdf = new Pdf([
        'mode' => Pdf::MODE_BLANK,
        'format' => Pdf::FORMAT_A4,
        'filename' => "MHKTSUP".date('dmY'). sprintf("%05s", $faktur+1),
        // portrait orientation
        'orientation' => Pdf::ORIENT_LANDSCAPE, 
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
            'SetHeader'=>[date('d-M-Y')], 
            'SetFooter'=>['ini footernya'],
            ]
        ]);
        return $pdf->render();
    }

    /**
     * Updates an existing BeliSupplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $modelDetailBelis = $model->detailBeliSuppliers;

        $formDetails = \Yii::$app->request->post('DetailBeliSupplier', []);
        foreach ($formDetails as $i => $formDetail) {
            if (isset($formDetail['id']) && isset($formDetail['updateType']) && $formDetail['updateType'] != DetailBeliSupplier::UPDATE_TYPE_CREATE) {
                $modelDetail = DetailBeliSupplier::findOne(['id' => $formDetail['id'], 'beli_sup_id' => $model->id]);
                $modelDetail->setScenario(DetailBeliSupplier::SCENARIO_BATCH_UPDATE);
                $modelDetail->setAttributes($formDetail);
                $modelDetailBelis[$i] = $modelDetail;
            } else {
                $modelDetail = new DetailBeliSupplier(['scenario' => DetailBeliSupplier::SCENARIO_BATCH_UPDATE]);
                $modelDetail->setAttributes($formDetail);
                $modelDetailBelis[] = $modelDetail;
            }
        }

        if (\Yii::$app->request->post('addRow') == 'true') {
            $modelDetailBelis[] = new DetailBeliSupplier(['scenario' => DetailBeliSupplier::SCENARIO_BATCH_UPDATE]);
            return $this->render('update', [
                        'model' => $model,
                        'modelDetailBelis' => $modelDetailBelis
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Model::validateMultiple($modelDetailBelis) && $model->validate()) {
                $model->save();
                foreach ($modelDetailBelis as $modelDetail) {
                    if ($modelDetail->updateType == DetailBeliSupplier::UPDATE_TYPE_DELETE) {
                        $modelDetail->delete();
                    } else {
                        $modelDetail->beli_sup_id = $model->id;
                        $modelDetail->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelDetailBelis' => $modelDetailBelis
        ]);
    }

    /**
     * Deletes an existing BeliSupplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BeliSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BeliSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BeliSupplier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
