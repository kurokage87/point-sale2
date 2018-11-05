<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\BeliSupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Beli Suppliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beli-supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Beli Supplier'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $ctrl = Yii::$app->controller->action->id;
    if ($ctrl == 'halaman-supplier' && Yii::$app->user->identity->level == app\models\User::supplier){
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'no_faktur',
            'tgl_beli',
            'supplier_id',
            'kode_pembelian',
            [
                'label' => 'Action',
                'format' => 'html',
                'value' => function($data){
                    return Html::a('Proses', ['proses-supplier', 'id' => $data->id], ['class' => 'btn btn-success']);
                }
            ]
            
        ],
    ]);
    }else{
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'no_faktur',
            'tgl_beli',
            'supplier_id',
            'kode_pembelian',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]);
    }
    ?>
</div>
