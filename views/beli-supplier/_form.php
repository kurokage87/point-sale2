<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DetailBeliSupplier;
/* @var $this yii\web\View */
/* @var $model app\models\BeliSupplier */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("
    $('.delete-button').click(function() {
        var detail = $(this).closest('.beli-detail');
        var updateType = detail.find('.update-type');
        if (updateType.val() === " . json_encode(DetailBeliSupplier::UPDATE_TYPE_UPDATE) . ") {
            //marking the row for deletion
            updateType.val(" . json_encode(DetailBeliSupplier::UPDATE_TYPE_DELETE) . ");
            detail.hide();
        } else {
            //if the row is a new row, delete the row
            detail.remove();
        }

    });
");
$ctrl = Yii::$app->controller->action->id;
?>

<div class="beli-supplier-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ($model->status == \app\models\BeliSupplier::di_proses_supplier) :?>    
    
    <?= $form->field($model, 'status')->dropDownList([
 \app\models\BeliSupplier::ditolak => 'Di Tolak',
 \app\models\BeliSupplier::dikirim => 'Di Kirim',
    ]) ?>
    
    <?php else : ?>
    <?= $form->field($model, 'no_faktur')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
    
    <?= $form->field($model, 'kode_pembelian')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
    
     <?php foreach ($modelDetailBelis as $i => $modelDetail) : ?>
        <div class="row beli-detail beli-detail-<?= $i ?>">
                <?= Html::activeHiddenInput($modelDetail, "[$i]id") ?>
                <?= Html::activeHiddenInput($modelDetail, "[$i]updateType", ['class' => 'update-type']) ?>
            
                <div class="col-md-5">
                    <?= $form->field($modelDetail, "[$i]barang_id")->label('Nama Barang')->dropDownList(yii\helpers\ArrayHelper::map(app\models\Barang::find()->all(), 'id', 'nama_barang', 'user.username'),[
                    'prompt' => 'Silahkan Pilih'
                ])
                ?>
                </div>
                <div class="col-md-5">
                <?= $form->field($modelDetail, "[$i]jumlah")?>
                </div>
                <div class="col-md-2">
                 <?= Html::button('x', ['class' => 'delete-button btn btn-danger btn-md', 'data-target' => "beli-detail-$i"]) ?>
                </div>
            </div>
    <?php endforeach;
          endif;
    ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Tambah Pesanan', ['name' => 'addRow', 'value' => 'true', 'class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
