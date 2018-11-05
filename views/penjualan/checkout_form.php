<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kategori */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kategori-form">

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider([
            'query' => $model->getDetailJuals(),
            'pagination' => false
        ]),
        'showPageSummary' => true,
        'panel' => ['type' => 'success', 'heading' => 'Total belaja'],
        'columns' => [
            'barang.nama_barang',
            'barang.harga_jual',
            'qty',
            [
                'label' => 'Total Belanja',
                'value' => function($data){
                    return $data->barang->harga_jual * $data->qty;
                },
                'pageSummary' => true
            ]  
        ]
    ])?>
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_faktur')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>
    
    <?= $form->field($model, 'total_jual')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>
    
    <?= $form->field($model, 'jumlah_uang')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Bayar'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Tambah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
