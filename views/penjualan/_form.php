<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use app\models\Penjualan;
use app\models\DetailJual;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(""
        . "$('.delete-button').click(function(){"
        . "var detail = $(this).closest('.detail-jual');"
        . "var updateType = detail.find('.update-type');"
        . "if(updateType.val() ===" . json_encode(DetailJual::UPDATE_TYPE_UPDATE) . "){"
        . "updateType.val(" . json_encode(DetailJual::UPDATE_TYPE_DELETE) . ");"
        . "detail.hide();"
        . "}else{"
        . "detail.remove();"
        . "}"
        . "})");
?>

<div class="penjualan-form">

    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => false
    ]);
    ?>

    <?php //  $form->field($model, 'no_faktur')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>

    <?php
    if (Yii::$app->controller->action->id == 'update'){ ?>
        <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
    <?php }else{
     echo Html::activeHiddenInput($model, 'keterangan');
    }
    ?>

<!--    <h2>Daftar Belanjaan</h2>-->

        <?php foreach ($modelDetailJuals as $i => $modelDetailJual) : ?>
        <div class="row detail-jual-<?= $i['id'] ?>">

                <?= yii\bootstrap\Html::activeHiddenInput($modelDetailJual, "[$i]id") ?>
                <?= Html::activeHiddenInput($modelDetailJual, "[$i]updateType", ['class' => 'update-type']) ?>
            <div class="col-md-5">
                <?= $form->field($modelDetailJual, "[$i]barang_id")->label('Nama Barang')->dropDownList(yii\helpers\ArrayHelper::map(app\models\Barang::find()->all(), 'id', 'nama_barang'),[
                    'prompt' => 'Silahkan Pilih'
                ])
                ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($modelDetailJual, "[$i]qty") ?>
            </div>

            <div class="col-md-2">
            <?= Html::button('x', ['class' => 'delete-button btn btn-danger', 'data-target' => "detail-jual-$i"]) ?>
            </div>
        </div>
<?php endforeach; ?>
    <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Bayar'), ['class' => 'btn btn-success']) ?>
    <?= Html::submitButton('Tambah Belanjaan', ['name' => 'addRow', 'value' => 'true', 'class' => 'btn btn-info']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
