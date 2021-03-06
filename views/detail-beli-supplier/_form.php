<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\DetailBeliSupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detail-beli-supplier-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if(Yii::$app->user->identity->level == \app\models\User::supplier) :?>
    <?= $form->field($model, 'status')->dropDownList([
        app\models\DetailBeliSupplier::ditolak => 'Di Tolak',
        app\models\DetailBeliSupplier::dikirim => 'Di Terima',
    ]) ?>
    <?php if($model->status == app\models\DetailBeliSupplier::di_proses_supplier):
      echo $form->field($model, 'tgl_kadaluarsa')->widget(
    DatePicker::className(), [
         'inline' => false, 
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
]);  
    endif;
?>
    <?php
    else : ?>
        <?= $form->field($model, 'status')->dropDownList([
        app\models\DetailBeliSupplier::setujui_owner => 'Disetujui Owner',
        app\models\DetailBeliSupplier::tolak_owner => 'Ditolak Owner',
    ]) ?>
    <?php endif;
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
