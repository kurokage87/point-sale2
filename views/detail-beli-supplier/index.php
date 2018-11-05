<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\DetailBeliSupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List Pesanan');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-beli-supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //  Html::a(Yii::t('app', 'Create Detail Beli Supplier'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    if (Yii::$app->user->identity->id == app\models\User::supplier) :
        echo GridView::widget([
            'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
            'panel' => ['type' => 'danger', 'heading' => 'List Pesanan Permintaan Barang'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
//            'id',
                [
                    'label' => 'No Faktur',
                    'value' => function($data) {
                        return $data->beliSup->no_faktur;
                    }
                ],
                [
                    'label' => 'Nama Barang',
                    'attribute' => 'barang_id',
                    'value' => 'barang.nama_barang'
                ],
                'jumlah',
//            'beli_sup_id',
                //'tgl_kadaluarsa',
                [
                    'label' => 'Status',
                    'value' => function($data){
                    if ($data->status == app\models\DetailBeliSupplier::order):
                        return 'Pesanan Baru';
                    elseif ($data->status == app\models\DetailBeliSupplier::di_proses_supplier):
                        return 'Sedang Di Proses';
                    elseif ($data->status == app\models\DetailBeliSupplier::ditolak):
                        return 'Barang Kosong';
                    elseif ($data->status == app\models\DetailBeliSupplier::dikirim):
                        return 'Barang sedang Di Kirim';
                    elseif ($data->status == app\models\DetailBeliSupplier::selesai):
                        return 'Selesai';
                    endif;
                }
                ],
                [
                    'label' => 'Action',
                    'format' => 'html',
                    'value' => function($data) {
                        if ($data->status == app\models\DetailBeliSupplier::order){
                            return  Html::a('Proses', ['proses-supplier', 'id' => $data->id], ['class' => 'btn btn-success btn-xs']).'<br>'.
                                    Html::a('View', ['view', 'id' => $data->id], ['class' => 'btn btn-primary btn-xs']).'<br>'.
                                    Html::a('Update', ['update', 'id' => $data->id], ['class' => 'btn btn-info btn-xs']);
                        }else{
                            return  Html::a('View', ['view', 'id' => $data->id], ['class' => 'btn btn-primary btn-xs']).'<br>'.
                                    Html::a('Update', ['update', 'id' => $data->id], ['class' => 'btn btn-info btn-xs']);
                        }
                    }
                ],
            ],
        ]);
    else :
        echo GridView::widget([
            'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
            'panel' => ['type' => 'danger', 'heading' => 'List Pesanan Permintaan Barang'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
//            'id',
                [
                    'label' => 'No Faktur',
                    'value' => function($data) {
                        return $data->beliSup->no_faktur;
                    }
                ],
                [
                    'label' => 'Nama Barang',
                    'attribute' => 'barang_id',
                    'value' => 'barang.nama_barang'
                ],
                'jumlah',
//            'beli_sup_id',
                //'tgl_kadaluarsa',
                [
                    'label' => 'Status',
                    'value' => function($data){
                    if ($data->status == app\models\DetailBeliSupplier::order):
                        return 'Pesanan Baru';
                    elseif ($data->status == app\models\DetailBeliSupplier::di_proses_supplier):
                        return 'Sedang Di Proses';
                    elseif ($data->status == app\models\DetailBeliSupplier::ditolak):
                        return 'Barang Kosong';
                    elseif ($data->status == app\models\DetailBeliSupplier::dikirim):
                        return 'Barang sedang Di Kirim';
                    elseif ($data->status == app\models\DetailBeliSupplier::selesai):
                        return 'Selesai';
                    endif;
                }
                ],
//                ['class' => 'kartik\grid\ActionColumn'],
            ],
        ]);
    endif;
    ?>
</div>
