<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penjualans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no_faktur',
            'tgl_jual',
            'total_jual',
            'jumlah_uang',
            'kembalian',
            'user_id',
            'keterangan:ntext',
        ],
    ]) ?>
    
    <?php
    $listPembelian = \app\models\DetailJual::find()->where(['penjualan_id' => $model->id])->all();
    ?>
    
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider([
            'query' => $model->getDetailJuals(),
            'pagination' => false
        ]),
        'showPageSummary' => true,
        'columns' => [
            'barang.nama_barang',
            'qty',
            [
                'label' => 'Total',
                'pageSummary' => true,
                'value' => function($data){
                return $data->qty * $data->barang->harga_jual;
                }
            ]
        ]
    ])?>
    

</div>
