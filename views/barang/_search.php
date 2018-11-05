<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searchModel\BarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama_barang') ?>

    <?= $form->field($model, 'barang_satuan') ?>

    <?= $form->field($model, 'harga_modal') ?>

    <?= $form->field($model, 'harga_jual') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'min_stock') ?>

    <?php // echo $form->field($model, 'tgl_input') ?>

    <?php // echo $form->field($model, 'tgl_last_update') ?>

    <?php // echo $form->field($model, 'kategori_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
