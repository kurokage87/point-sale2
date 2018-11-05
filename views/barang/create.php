<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = Yii::t('app', 'Create Barang');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Barangs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
