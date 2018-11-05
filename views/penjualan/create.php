<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */

$this->title = Yii::t('app', 'Create Penjualan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penjualans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelDetailJuals' => $modelDetailJuals,
    ]) ?>

</div>
