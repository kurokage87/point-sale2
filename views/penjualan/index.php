<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\PenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Penjualans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if(Yii::$app->user->identity->level == \app\models\User::karyawan):?>
        <?= Html::a(Yii::t('app', 'Create Penjualan'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif;?>
    </p>

    <?php
    if (Yii::$app->user->identity->level == app\models\User::karyawan){
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger', 'heading' => 'list penjualan'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'no_faktur',
            'tgl_jual',
            'total_jual',
            'jumlah_uang',
            //'kembalian',
            //'user_id',
            //'keterangan:ntext',
            ['class' => 'kartik\grid\ActionColumn',
                'template' => '{view}'],
        ],
    ]);
    }else{
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger', 'heading' => 'list penjualan'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'no_faktur',
            'tgl_jual',
            'total_jual',
            'jumlah_uang',
            //'kembalian',
            //'user_id',
            //'keterangan:ntext',

//            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]);
    }
    ?>
</div>
