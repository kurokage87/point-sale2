<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DetailJual */

$this->title = Yii::t('app', 'Create Detail Jual');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Detail Juals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-jual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
