<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Retur;
/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\Retur */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Returs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retur-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if(Yii::$app->user->identity->level == app\models\User::karyawan) :?>
        <?= Html::a(Yii::t('app', 'Create Retur'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?php if(Yii::$app->user->identity->level == \app\models\User::karyawan):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'tgl_retur',
            'barang.nama_barang',
            'qty',
            'subtotal',
            //'keterangan:ntext',
            [
                'label' => 'Status',
                'value' =>function($data){
                    if($data->status == app\models\Retur::retur_baru):
                        return 'Request Retur Barang';
                    elseif($data->status == app\models\Retur::diproses):
                        return 'Sedang Diproses';
                    elseif($data->status == Retur::dikirim):
                        return 'Sedang Dikirim';
                    elseif($data->status == Retur::selesai):
                        return 'Selesai';
                    endif;
                }
            ],
        ],
    ]); ?>
    <?php elseif(Yii::$app->user->identity->level == \app\models\User::supplier):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'tgl_retur',
            'barang.nama_barang',
            'qty',
            'subtotal',
            //'keterangan:ntext',
            [
                'label' => 'Status',
                'value' =>function($data){
                    if($data->status == app\models\Retur::retur_baru):
                        return 'Request Retur Barang';
                    elseif($data->status == app\models\Retur::diproses):
                        return 'Sedang Diproses';
                    elseif($data->status == Retur::dikirim):
                        return 'Sedang Dikirim';
                    elseif($data->status == Retur::selesai):
                        return 'Selesai';
                    endif;
                }
            ],
            [
                'label' => 'Action',
                'format' => 'html',
                'value' => function($data){
                if($data->status == Retur::diproses):
                return Html::a('View', ['view', 'id' => $data->id], ['class' => 'btn btn-info btn-xs']) . ' ' .
                                    Html::a('Update', ['update', 'id' => $data->id], ['class' => 'btn btn-primary btn-xs']);
                else:
                    return Html::a('Proses', ['proses', 'id' => $data->id], ['class' => 'btn btn-success btn-xs']) . ' ' .
                                    Html::a('View', ['view', 'id' => $data->id], ['class' => 'btn btn-info btn-xs']) . ' ' .
                                    Html::a('Update', ['update','id' => $data->id], ['class' => 'btn btn-primary btn-xs']);
                endif;
                }
            ],

//            ['class' => 'yii\grid\ActionColumn',
//                'template' => '{view} {update}'],
        ],
    ]); ?>
    <?php else:?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'tgl_retur',
            'barang.nama_barang',
            'qty',
            'subtotal',
            //'keterangan:ntext',
            [
                'label' => 'Status',
                'value' =>function($data){
                    if($data->status == app\models\Retur::retur_baru):
                        return 'Request Retur Barang';
                    elseif($data->status == app\models\Retur::diproses):
                        return 'Sedang Diproses';
                    elseif($data->status == Retur::dikirim):
                        return 'Sedang Dikirim';
                    elseif($data->status == Retur::selesai):
                        return 'Selesai';
                    endif;
                }
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
    <?php endif;?>
</div>
