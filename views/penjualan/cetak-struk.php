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
            $detail = \app\models\DetailJual::find()->all();
            $total = 0;
            foreach ($detail as $d) :
            ?>
            <tr>
                <td><?= $d->barang->nama_barang?></td>
                <td><?= $d->qty?></td>
                <td><?= 'Rp.'. number_format($d->barang->harga_jual)?></td>
                <td><?= 'Rp.'. number_format($tot = $d->barang->harga_jual * $d->qty)?></td>
            </tr>
            
            <?php 
            $total += $tot;
            endforeach;?>
            <tr>
                <td colspan="3" class="text-right">Total</td>
                <td><?= 'Rp. '. number_format($total)?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Uang Bayar</td>
                <td><?='Rp. '. number_format($model->jumlah_uang)?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Uang Kembali</td>
                <td><?= 'Rp. '. number_format($model->jumlah_uang - $total)?></td>
            </tr>
        </tbody>
    </table>
    
    

</div>
