<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProdukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ListUser-index">

    <h1><?= Html::encode($this->title) ?></h1>
     <div class="row">
        <div class="col-md-12">
            <p>
                <?= Html::a('Create User', ['tambah-user'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="text-right">
                <?php echo $this->render('search/usersearch', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    
    <?php
        echo GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
            'panel' => ['type' => 'warning', 'heading' => 'List User'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'password_hash',
            'email',
//            'level',
           ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]);
 
     ?>
</div>
