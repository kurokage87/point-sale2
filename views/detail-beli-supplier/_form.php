<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetailBeliSupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detail-beli-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList([
 app\models\DetailBeliSupplier::ditolak => 'Di Tolak',
 app\models\DetailBeliSupplier::dikirim => 'Di Terima',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
