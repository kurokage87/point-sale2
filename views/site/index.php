<?php

/* @var $this yii\web\View */
use sjaakp\gcharts\BarChart;
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php if(Yii::$app->user->identity->level == app\models\User::Admin || Yii::$app->user->identity->level == app\models\User::pimpinan || Yii::$app->user->identity->level == app\models\User::karyawan): ?>
<?= BarChart::widget([
    'height' => '400px',
    'dataProvider' => $dataProvider,
    'columns' => [
        'nama_barang:string',
        'barang'
    ],
    'options' => [
        'title' => 'Penjualan'    
        ],
]) ?>
<?php else:?>
    <div class="row">
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red-active">
            <div class="inner">
              <h3><?= $beli_kirim?></h3>

              <p>Barang dalam pengiriman</p>
            </div>
            <div class="icon">
              <i class="fa fa-send"></i>
            </div>
<!--            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>-->
          </div>
        </div>
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red-active">
            <div class="inner">
              <h3><?= $beli_selesai?></h3>

              <p>Barang diterima toko</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-square"></i>
            </div>
<!--            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>-->
          </div>
        </div>
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red-active">
            <div class="inner">
              <h3><?= $retur_kirim?></h3>

              <p>Barang retur dikirim</p>
            </div>
            <div class="icon">
              <i class="fa fa-send-o"></i>
            </div>
<!--            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>-->
          </div>
        </div>
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red-active">
            <div class="inner">
              <h3><?= $retur_selesai?></h3>

              <p>Barang retur diterima toko</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-square-o"></i>
            </div>
<!--            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>-->
          </div>
        </div>
    </div>
<?php endif; ?>
</div>
