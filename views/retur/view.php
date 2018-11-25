<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Retur */

$this->title = 'Retur No ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Returs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retur-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->identity->level == \app\models\User::supplier): 
            if($model->status == app\models\Retur::diproses):?>
        <?= Html::a(Yii::t('app', 'Dikirim'), ['kirim', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
        <?php else :?>
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
        <?php endif; ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tgl_retur',
            'barang.nama_barang',
            'qty',
            'subtotal',
            'keterangan:ntext',
            [
                'label' => 'Status Retur',
                'value' => function($data) {
                    if ($data->status == app\models\Retur::retur_baru) {
                        return 'Request Retur Barang';
                    } elseif ($data->status == \app\models\Retur::diproses) {
                        return 'Di Proses Supplier';
                    } elseif ($data->status == \app\models\Retur::dikirim) {
                        return 'Barang Dikirim';
                    } else {
                        return 'Selesai';
                    }
                }
            ],
        ],
    ])
    ?>

</div>
