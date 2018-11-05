<?php

namespace app\controllers;
use Yii;
class CartController extends \yii\web\Controller
{
    public function actionAddCart($id){
        $barang = \app\models\Barang::findOne($id);
        if ($barang){
            Yii::$app->cart->create($barang);
            $this->redirect(['cart/list']);
        }
    }
    
    public function actionList(){
        $searchModel = new \app\models\searchModel\BarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $cart = Yii::$app->cart;
        $barang = $cart->getItems();
        $total = $cart->getCost();
        return $this->render('index',[
            'barang' => $barang,
            'total' => $total,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionDeleteCart($id){
        $barang = \app\models\Barang::findOne($id);
        if ($barang){
            Yii::$app->cart->delete($barang);
            $this->redirect(['cart/list']);
        }
    }
    
    public function actionUpdateCart($id, $quantity){
        $barang = \app\models\Barang::findOne($id);
        if ($barang) {
            Yii::$app->cart->update($barang, $quantity);
            $this->redirect(['cart/list']);
        }
    }
    
    public function actionCheckout(){
        Yii::$app->cart->checkOut(false);
        $this->redirect(['cart/list']);
    }

}
