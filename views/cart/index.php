<?php

use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
$this->title = 'Masukan Daftar Belanja';
?>

<div class="penjualan-index">
    <p>Cari Produk</P>
            <?php $form = ActiveForm::begin([
                'action' => ['list'],
                'method' => 'get',
            ]); ?>

            <?=$form->field($searchModel, 'nama_barang')?>
    
    <div class="form-group">
        <?= Html::submitButton(('Search'), ['class' => 'btn btn-primary']) ?>
    </div>
            <?php ActiveForm::end(); ?>
    
    <?php
    if ($searchModel->nama_barang) {
        echo kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            [
                'label' => 'Nama Produk',
                'value' => function($data){
                    return $data->nama_barang.' ('.$data->user->username.')';
                }
            ],
//            'harga_modal',
            'harga_jual',
            'stock',
                    [
                        'label' => 'Action',
                        'format' => 'html',
                        'value' => function($data){
                            return Html::a('Tambah', ['cart/add-cart', 'id' => $data->id], ['class' => 'btn btn-success']);
                        }
                    ],
            //'min_stock',
            //'tgl_input',
            //'tgl_last_update',
            //'kategori_id',
            //'user_id',
        ],
    ]);
    }
    ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>Banyak</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($barang as $b) {
                ?>
                <tr>
                    <td><?=$b->nama_barang?></td>
                    <td><?= number_format($b->harga_jual)?></td>
                    <td>
                        <?= Html::a('-', ['cart/update-cart', 'id' => $b->getId(), 'quantity' => $b->getQuantity() - 1], ['class' => 'btn btn-xs btn-primary', 'disabled' => ($b->getQuantity() - 1) < 1]) ?>
                        <?=$b->getQuantity()?>
                        <?= Html::a('+', ['cart/update-cart', 'id' => $b->getId(), 'quantity' => $b->getQuantity() + 1], ['class' => 'btn btn-xs btn-primary'])?>
                    </td>
                    <td><?= number_format($b->getCost())?></td>
                </tr>
        <?php } ?>
                <tr>
                    <td colspan="3" class="text-right">Total</td>
                    <td><?= number_format($total)?></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><?= Html::a('checkout',['cart/checkout'],['class' => 'btn btn-primary'])?></td>
                </tr>
        </tbody>
    </table>
</div>

</div>
