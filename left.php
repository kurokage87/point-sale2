<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->isGuest ? "Guest" : Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?php
        $count = app\models\Retur::find()->where(['status' => app\models\Retur::retur_baru])->count();
        $proc_retur = app\models\Retur::find()->where(['status' => app\models\Retur::diproses])->count();
        $accept_ret = app\models\Retur::find()->where(['status' => app\models\Retur::dikirim])->count();
        $belibaru = app\models\DetailBeliSupplier::find()->where(['status' => app\models\DetailBeliSupplier::order])->count();
        $supreq = app\models\DetailBeliSupplier::find()->where(['status' => app\models\DetailBeliSupplier::setujui_owner])->count();
        $proc_sup = app\models\DetailBeliSupplier::find()->where(['status' => app\models\DetailBeliSupplier::di_proses_supplier])->count();
        $terima_sup = app\models\DetailBeliSupplier::find()->where(['status' => app\models\DetailBeliSupplier::dikirim])->count();
        if (Yii::$app->user->identity->level == app\models\User::Admin) {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                        'items' => [
                            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                            ['label' => 'User Management', 'icon' => 'circle-o', 'url' => ['/site/daftar-user']],
                            ['label' => 'Barang', 'icon' => 'circle-o', 'url' => ['/barang']],
                            ['label' => 'Kategori', 'icon' => 'circle-o', 'url' => ['/kategori']],
                            ['label' => 'Barang Masuk', 'icon' => 'circle-o', 'url' => ['/beli-supplier']],
                            ['label' => 'Penjualan', 'icon' => 'circle-o', 'url' => ['/penjualan']],
                            [
                                'label' => 'Form Request Mutasi',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Form Barang Rusak', 'icon' => 'circle-o', 'url' => ['mutasi-barang/create']],
                                    ['label' => 'Request Pergantian Barang', 'icon' => 'circle-o', 'url' => ['mutasi-barang/index']]
                                ]
                            ],
                        ],
                    ]
            );
        } elseif (Yii::$app->user->identity->level == app\models\User::supplier) {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                        'items' => [
                            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                            ['label' => 'Barang', 'icon' => 'circle-o', 'url' => ['/barang/list-barang']],
                            ['label' => 'Pemesanan', 'icon' => 'circle-o', 'items' => [
                                    ['label' => 'Pesanan Barang Baru ('.$supreq.')', 'icon' => 'circle-o', 'url' => ['/detail-beli-supplier']],
                                    ['label' => 'History Pemesanan', 'icon' => 'circle-o', 'url' => ['/detail-beli-supplier/proses']],
                                    ['label' => 'List Proses Pemesanan ('.$proc_sup.')', 'icon' => 'circle-o', 'url' => ['detail-beli-supplier/proses-selesai']],
                                ]],
                            ['label' => 'Retur Barang', 'icon' => 'circle-o', 'items' => [
                                    ['label' => 'List Retur Barang ('.$count.')', 'icon' => 'circle-o', 'url' => ['/retur/list']],
                                    ['label' => 'Proses Retur Barang ('.$proc_retur .')', 'icon' => 'circle-o', 'url' => ['retur/list-proses']],
                                    ['label' => 'Status Retur Barang', 'icon' => 'circle-o', 'url' => ['retur/track']],
                                ]],
                        ],
                    ]
            );
        } elseif (Yii::$app->user->identity->level == app\models\User::pimpinan) {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                        'items' => [
                            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                            ['label' => 'User Management', 'icon' => 'circle-o', 'url' => ['/site/daftar-user']],
                            ['label' => 'Barang', 'icon' => 'circle-o', 'url' => ['/barang']],
                            ['label' => 'Kategori', 'icon' => 'circle-o', 'url' => ['/kategori']],
//                    ['label' => 'Barang Masuk', 'icon' => 'circle-o', 'url' => ['/beli-supplier']],
                            ['label' => 'Pembelian Barang', 'icon' => 'circle-o', 'items' => [
                                    ['label' => 'History Pembelian Barang', 'icon' => 'circle-o', 'url' => ['/detail-beli-supplier/status-pesan']],
                                    ['label' => 'List Request Beli Barang ('.$belibaru.')', 'icon' => 'circle-o', 'url' => ['/detail-beli-supplier/persetujuan-owner']],
                                ]],
                            ['label' => 'Penjualan', 'icon' => 'circle-o', 'url' => ['/penjualan']],
                            ['label' => 'Laba Rugi', 'icon' => 'circle-o', 'url' => ['/barang/laba-rugi']],
                            ['label' => 'List Retur', 'icon' => 'circle-o', 'url' => ['/retur/list']]
                        ],
                    ]
            );
        } elseif (Yii::$app->user->identity->level == app\models\User::karyawan) {
            echo dmstr\widgets\Menu::widget(
                    [
                        'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                        'items' => [
                            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                            ['label' => 'Penjualan', 'icon' => 'circle-o', 'url' => ['/penjualan']],
                            ['label' => 'Pembelian Barang', 'icon' => 'circle-o', 'items' => [
                                    ['label' => 'Order Supplier', 'icon' => 'circle-o', 'url' => ['/beli-supplier/create']],
                                    ['label' => 'History Pembelian Barang', 'icon' => 'circle-o', 'url' => ['/detail-beli-supplier/status-pesan']],
                                    ['label' => 'List Barang Masuk ('.$terima_sup.')', 'icon' => 'circle-o', 'url' => ['/detail-beli-supplier/terima-karyawan']],
                                ]],
                            ['label' => 'Retur Barang', 'icon' => 'circle-o', 'items' => [
                                    ['label' => 'Retur ('.$accept_ret.')', 'icon' => 'circle-o', 'url' => ['/retur']],
//                                    ['label' => 'Status Retur Barang', 'icon' => 'circle-o', 'url' => ['retur/track']],
                                ]]
                        ],
                    ]
            );
        }
        ?>

    </section>

</aside>
