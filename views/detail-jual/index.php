<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\DetailJual */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Detail Juals');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-jual-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Detail Jual'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'label' => 'Nama Barang',
                'value' => 'barang.nama_barang'
            ],
            'penjualan.no_faktur',
            [
                'label' =>'Harga Modal',
                'value' => 'barang.harga_modal'
            ],
            [
                'label' =>'Harga Jual',
                'value' => 'barang.harga_jual'
            ],
            
            'qty',
//            'total',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
