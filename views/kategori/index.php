<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kategoris');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
     <div class="row">
        <div class="col-md-12">
        <p>
            <?= Html::a('Create Kategori', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="text-right">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
           
            <br />
        </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

//            'id',
            'nama_kategori',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
