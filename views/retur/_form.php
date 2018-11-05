<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Retur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="retur-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group field-retur-barang_id">
        <label class="control-label" for="retur-barang_id">Nama Barang</label>
        <select id="retur-barang_id" class="form-control" name="Retur[barang_id]">
            <?php
            $barang = app\models\Barang::find()->all();
            foreach ($barang as $b) :
            ?>
            <option value="<?=$b->id?>"><?=$b->nama_barang.' - '.$b->user->username?></option>
            <?php endforeach;?>
        </select>

        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'keterangan')->label('alasan retur')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
