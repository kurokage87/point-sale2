<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */

$this->title = 'No Faktur : '.$model->no_faktur;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penjualans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $detail = app\models\DetailBeliSupplier::find()->where(['beli_sup_id' => $model->id])->all();
//            \yii\helpers\VarDumper::dump($detail);die;
            $total = 0;
            foreach ($detail as $d) :
                $x = $d->barang;
            ?>
            <tr>
                <td><?= $x['nama_barang']?></td>
                <td><?= $d->jumlah?></td>
                <td><?= 'Rp.'. number_format($x['harga_modal'])?></td>
                <td><?= 'Rp.'. number_format($tot = $x['harga_modal'] * $d->jumlah)?></td>
            </tr>
            
            <?php 
            $total += $tot;
            endforeach;?>
            <tr>
                <td colspan="3" class="text-right">Total</td>
                <td><?= 'Rp. '. number_format($total)?></td>
            </tr>
        </tbody>
    </table>
    
    

</div>
