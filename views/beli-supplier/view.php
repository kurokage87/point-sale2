<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\BeliSupplier;

/* @var $this yii\web\View */
/* @var $model app\models\BeliSupplier */

$this->title = 'Pembelian Ke ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Beli Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beli-supplier-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
        <?php if (Yii::$app->user->identity->level == app\models\User::karyawan): ?>
            <?= Html::a(Yii::t('app', 'Cetak'), ['cetak-struk', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php else : ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
    <?= Html::a(Yii::t('app', 'Cetak'), ['cetak-struk', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'no_faktur',
            'tgl_beli',
            'supplier.nama_supplier',
            'kode_pembelian',
            [
                'label' => 'Status Pemesanan',
                'format' => 'html',
                'value' => function($data) {
                    if ($data->status == BeliSupplier::order) {
                        return 'Baru Di Pesan';
                    } elseif ($data->status == BeliSupplier::di_proses_supplier) {
                        return 'Di Proses Supplier';
                    } elseif ($data->status == BeliSupplier::ditolak) {
                        return 'Pesanan Di Tolak';
                    } elseif ($data->status == BeliSupplier::dikirim) {
                        return 'Pesanan Sedang Dikirim ';
                    } else {
                        return 'Pesanan Selesai';
                    }
                }
            ],
        ],
    ])
    ?>

    <?=
    kartik\grid\GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider([
            'query' => $model->getDetailBeliSuppliers(),
            'pagination' => false
                ]),
        'showPageSummary' => true,
        'columns' => [
            [
                'label' => 'Nama Barang',
                'value' => function($data) {
                    return $data->barang->nama_barang;
                }
            ],
            [
                'label' => 'Harga Modal',
                'value' => function($data) {
                    return number_format($data->barang->harga_modal);
                }
            ],
            [
                'label' => 'Jumlah Barang',
                'value' => function($data) {
                    return $data->jumlah;
                }
            ],
            [
                'label' => 'Total Harga',
                'pageSummary' => true,
                'value' => function($data) {
                    $sum = $data->barang->harga_modal * $data->jumlah;
                    return $sum;
                },
            ],
            [
                'label' => 'Status Pesanan',
                'format' => 'html',
                'value' => function($data) {
                    if ($data->status == app\models\DetailBeliSupplier::order):
                        return 'Pesanan Baru';
                    elseif ($data->status == app\models\DetailBeliSupplier::di_proses_supplier):
                        return 'Sedang Di Proses';
                    elseif ($data->status == app\models\DetailBeliSupplier::ditolak):
                        return 'Barang Kosong';
                    elseif ($data->status == app\models\DetailBeliSupplier::dikirim):
                        return 'Barang sedang Di Kirim <br>' . Html::a('Selesai', ['selesai', 'id' => $data->id], ['class' => 'btn btn-success']);
                    elseif ($data->status == app\models\DetailBeliSupplier::selesai):
                        return 'Selesai';
                    endif;
                }
            ],
        ]
    ])
    ?>

</div>
