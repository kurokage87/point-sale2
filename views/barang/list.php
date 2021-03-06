<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Barangs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
<?= Html::a(Yii::t('app', 'Create Barang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger', 'heading' => 'List Barang'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
//            'id',
            'nama_barang',
//            'barang_satuan',
//            'harga_modal',
//            'harga_jual',
            //'min_stock',
            //'tgl_input',
            //'tgl_last_update',
            //'kategori_id',
            //'user_id',
            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
