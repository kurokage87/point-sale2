<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = $model->nama_barang;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Barangs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama_barang',
            'barang_satuan',
            'harga_modal',
            'harga_jual',
            'stock',
            'min_stock',
            'tgl_input',
            'tgl_last_update',
            'kategori_id',
            'user_id',
        ],
    ]) ?>

</div>
