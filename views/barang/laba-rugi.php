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
        <?php // Html::a(Yii::t('app', 'Create Barang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'exportConfig' => [
            GridView::PDF => [
                'label' => ('Export'),
//        'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => ('Report-Pembelian-' . date("D, d-M-Y")),
                'alertMsg' => ('The PDF export file will be generated for download.'),
                'options' => ['title' => ('Portable Document Format')],
                'mime' => 'application/pdf',
                'config' => [
                    'mode' => 'c',
                    'format' => 'A4-L',
                    'destination' => 'D',
                    'marginTop' => 20,
                    'marginBottom' => 20,
                    'cssInline' => '.kv-wrap{padding:20px;}' .
                    '.kv-align-center{text-align:center;}' .
                    '.kv-align-left{text-align:left;}' .
                    '.kv-align-right{text-align:right;}' .
                    '.kv-align-top{vertical-align:top!important;}' .
                    '.kv-align-bottom{vertical-align:bottom!important;}' .
                    '.kv-align-middle{vertical-align:middle!important;}' .
                    '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                    '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                    '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
//            'options' => [
//                'title' => $title,
//                'subject' => Yii::t('kvgrid', 'PDF export generated by kartik-v/yii2-grid extension'),
//                'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf')
//            ],
                    'contentBefore' => ' <table class="table-responsive">
        <tbody>
            <tr>
                <td style="padding: 1%;text-align: center;vertical-align: middle;width: 80px;height: 60px">
                    <img src="images/logo.jpg" height="100px" width="150px" />
                </td>
                <td style="vertical-align: top;padding-left: 5%;padding: 2%;">
                    <h1>Kripik Balado Mahkota</h1>
                    <p>
                        Alamat : Jl. Raya Padang Bukittinggi KM 19, Muaro Kasang, Batang Anai, Padang Pariaman, Sumatera Barat 25586<br>
                        No telp : 0751-483846 <br>
                        Email : cv_mahkota@yahoo.co.id<br>
                        Instagram : @kripikbaladomahkotas
                    </p>
                </td>
            </tr>
        </tbody>
    </table>',
                    'contentAfter' => '<table class="table-responsive">
        <tbody>
            <tr>
                <td style="padding: 1%;text-align: center;vertical-align: middle;width: 80px;height: 60px">
                    Paraf Pemilik<p><br/><img src="images/ttdee.png" height="100px" width="150px" /></p>
                   
                </td>
            </tr>
        </tbody>
    </table>'
                ]
            ]
        ],
//        'filterModel' => $searchModel,
        'panel' => ['type' => 'danger', 'heading' => 'List Barang'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
//            'id',
            'nama_barang',
//            'barang_satuan',
            'harga_modal',
            'harga_jual',
            [
                'label' => 'Laba (Keuntungan)',
                'value' => function($data) {
                    return $data->harga_jual - $data->harga_modal;
                }
            ],
            [
                'label' => 'Total Terjual',
                'value' => function($data) {
                    $jual = app\models\DetailJual::find()->where(['barang_id' => $data->id])->all();
                    $sum = 0;
                    foreach ($jual as $key => $j) {
                        $sum += $j->qty;
                    }
                    return $sum;
                }
            ],
            [
                'label' => 'Total Laba',
                'value' => function($data) {
                    $jual = app\models\DetailJual::find()->where(['barang_id' => $data->id])->all();
                    $sum = 0;
                    foreach ($jual as $key => $j) {
                        $sum += $j->qty;
                    }

                    return ($data->harga_jual - $data->harga_modal) * $sum;
                }
            ],
        //'min_stock',
        //'tgl_input',
        //'tgl_last_update',
        //'kategori_id',
        //'user_id',
//            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]);
    ?>
<?php Pjax::end(); ?>
</div>
