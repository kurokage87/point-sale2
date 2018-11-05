<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Barangs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Barang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger', 'heading' => 'List Barang'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
//            'id',
              'nama_barang',
//            'barang_satuan',
//            'harga_modal',
//            'harga_jual',
            [
                'label' => 'Total Stok Barang',
                'value' => function($data) {
                    $detailBeli = app\models\DetailBeliSupplier::find()->where(['barang_id' => $data->id])->all();
                    $totalBeli = 0;
                    foreach ($detailBeli as $d) {
                        $totalBeli += $d->jumlah;
                    }
                    return $data->stock + $totalBeli;
                }
            ],
            [
                'label' => 'Stock Masuk Terbaru',
                'value' => function($model) {
                    $detailBeli = app\models\DetailBeliSupplier::find()->where(['barang_id' => $model->id])->andWhere(['status' => app\models\DetailBeliSupplier::selesai])->orderBy('id desc')->limit(1)->all();
                    foreach ($detailBeli as $d) {
                        return $d->jumlah == NULL ? 0 : $d->jumlah;
                    }
                }
            ],
            [
                'label' => 'Total Terjual',
                'value' => function($data) {
                    $jual = app\models\DetailJual::find()->where(['barang_id' => $data->id])->all();
                    $sum = 0;
                    foreach ($jual as $key => $j) {
                        $sum += $j->qty;
                    }
                    return $sum;
                }
            ],
            [
                'label' => 'Total Retur',
                'value' => function($data) {
                    $retur = \app\models\Retur::find()->where(['barang_id' => $data->id])->andWhere(['status' => \app\models\Retur::selesai])->all();
                    $totRet = 0;
                    foreach ($retur as $r) {
                        $totRet += $r->qty;
                    }
                    return $totRet;
                }
            ],
            [
                'label' => 'Sisa Barang',
                'value' => function($data) {
                    $jual = app\models\DetailJual::find()->where(['barang_id' => $data->id])->all();
                    $beli = app\models\DetailBeliSupplier::find()->where(['barang_id' => $data->id])->all();
                    $retur = \app\models\Retur::find()->where(['barang_id' => $data->id])->andWhere(['status' => \app\models\Retur::selesai])->all();

                    $suRet = 0;
                    $sumJual = 0;
                    $sumBeli = 0;
                    foreach ($jual as $key => $j) {
                        $sumJual += $j->qty;
                    }
                    foreach ($beli as $b) {
                        $sumBeli += $b->jumlah;
                    }
                    foreach ($retur as $r) {
                        $suRet += $r->qty;
                    }

                    $total = ((($data->stock + $sumBeli) - $sumJual) - $suRet);
                    if ($total < $data->min_stock) {
                        return 'Silahkan Update Stock Terbaru';
                    } else {
                        return $total;
                    }
                }
            ],
            //'min_stock',
            //'tgl_input',
            //'tgl_last_update',
            //'kategori_id',
            //'user_id',
            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
