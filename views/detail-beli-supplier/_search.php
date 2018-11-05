<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searchModel\DetailBeliSupplierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detail-beli-supplier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no_faktur') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?= $form->field($model, 'beli_sup_id') ?>

    <?php // echo $form->field($model, 'tgl_kadaluarsa') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
