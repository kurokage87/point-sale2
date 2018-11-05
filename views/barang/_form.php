<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_barang')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'kategori_id')->label('Kategori Produk')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Kategori::find()->all(), 'id', 'nama_kategori'),[
        'prompt' => 'Pilih Kategori Peoduk'
    ]) ?>

    <?= $form->field($model, 'barang_satuan')->textInput(['maxlength' => true, 'placeholder' => 'Contoh : Kg']) ?>

    <?= $form->field($model, 'harga_modal')->textInput(['maxlength' => true, 'placeholder' => 'Harga Modal']) ?>

    <?= $form->field($model, 'harga_jual')->textInput(['maxlength' => true, 'placeholder' => 'Harga Jual']) ?>

    <?= $form->field($model, 'stock')->textInput(['maxlength' => true, 'placeholder' => 'Stok Sekarang']) ?>

    <?= $form->field($model, 'min_stock')->textInput(['maxlength' => true,'type' => 'number', 'placeholder' => 'minimal stock']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
