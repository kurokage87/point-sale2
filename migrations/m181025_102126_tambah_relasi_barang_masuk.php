<?php

use yii\db\Migration;

/**
 * Class m181025_102126_tambah_relasi_barang_masuk
 */
class m181025_102126_tambah_relasi_barang_masuk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('detail_beli_supplier', 'beli_sup_id', $this->integer());
        $this->addForeignKey('fk-detail_beli_supplier-beli_sup_id-beli_supplier-id', 'detail_beli_supplier', 'beli_sup_id', 'beli_supplier', 'id', 'cascade', 'cascade');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181025_102126_tambah_relasi_barang_masuk cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181025_102126_tambah_relasi_barang_masuk cannot be reverted.\n";

        return false;
    }
    */
}
