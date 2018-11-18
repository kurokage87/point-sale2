<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DetailBeliSupplier */

$this->title = 'Pesanan No '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Detail Beli Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-beli-supplier-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->identity->level == \app\models\User::Admin):?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php else:
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        endif;
?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'No Faktur',
                'value' => $model->beliSup->no_faktur
            ],
            'barang.nama_barang',
            'jumlah',
            [
                'label' => 'Harga Satuan',
                'value' => function($model){
                return 'Rp. '.number_format($model->barang->harga_modal);
                }
            ],
            [
               'label' => 'Total Harga Beli',
                'value' => function($data){
                    $jml = $data->jumlah;
                    $hbeli = $data->barang->harga_modal;
                    $tot = $jml * $hbeli;
                    return 'Rp. '. number_format($tot);
                }
                
            ],
//            'beli_sup_id',
            [
                'label' => 'Tanggal Kadaluarsa',
                'value' => function($data){
                   if ($data->tgl_kadaluarsa == NULL):
                       return 'Sedang Proses';
                   else:
                       return $data->tgl_kadaluarsa;
                   endif;
                }
            ],
            [
                'label' => 'Status Pesanan',
                'value' => function($data){
                    if ($data->status == app\models\DetailBeliSupplier::order):
                        return 'Pesanan Baru';
                    elseif($data->status == app\models\DetailBeliSupplier::di_proses_supplier):
                        return 'Sedang Di Proses';
                    elseif($data->status == app\models\DetailBeliSupplier::ditolak):
                        return 'Barang Kosong';
                    elseif($data->status == app\models\DetailBeliSupplier::dikirim):
                        return 'Barang sedang Di Kirim';
                    elseif($data->status == app\models\DetailBeliSupplier::selesai):
                        return 'Selesai';
                    elseif($data->status == app\models\DetailBeliSupplier::setujui_owner):
                        return 'Disetujui Owner';
                    elseif($data->status== app\models\DetailBeliSupplier::tolak_owner):
                        return 'Ditolak Owner';
                    endif;
                }
            ],
        ],
    ]) ?>

</div>
