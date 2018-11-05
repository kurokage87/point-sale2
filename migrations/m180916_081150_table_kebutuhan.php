<?php

use yii\db\Migration;

/**
 * Class m180916_081150_table_kebutuhan
 */
class m180916_081150_table_kebutuhan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('kategori', [
            'id' => $this->primaryKey(),
            'nama_kategori' => $this->string()
        ]);
        
        $this->createTable('barang', [
            'id' => $this->primaryKey(),
            'nama_barang' => $this->string(),
            'barang_satuan' => $this->string(5),
            'harga_modal' => $this->string(100),
            'harga_jual' => $this->string(100),
            'stock' => $this->string(),
            'min_stock' => $this->string(),
            'tgl_input' => $this->timestamp(),
            'tgl_last_update' => $this->dateTime(),
            'kategori_id' => $this->integer(),
            'user_id' => $this->integer()
        ]);
        
        $this->addForeignKey('fk-kategori_id-barang-kategori-id', 'barang', 'kategori_id', 'kategori', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-user_id-barang-user-id', 'barang', 'user_id', 'user', 'id', 'cascade', 'cascade');
        
        $this->createTable('penjualan', [
            'id' => $this->primaryKey(),
            'no_faktur' => $this->string(),
            'tgl_jual' => $this->timestamp(),
            'total_jual' => $this->double(),
            'jumlah_uang' => $this->double(),
            'kembalian' => $this->double(),
            'user_id' => $this->integer(),
            'keterangan' => $this->text(),
        ]);
        
        $this->addForeignKey('fk-penjualan-user_id-user-id', 'penjualan', 'user_id', 'user', 'id', 'cascade', 'cascade');
        
        $this->createTable('detail_jual', [
            'id' => $this->primaryKey(),
            'penjualan_id' => $this->integer(),
            'barang_id' => $this->integer(),
            'qty' => $this->integer(),
            'total' => $this->double()
        ]);
        
        $this->addForeignKey('fk-detail_jual-penjualan_id-penjualan-id', 'detail_jual', 'penjualan_id', 'penjualan', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-detail_jual-barang_id-barang-id', 'detail_jual', 'barang_id', 'barang', 'id', 'cascade', 'cascade');
        
        $this->createTable('supplier', [
            'id' => $this->primaryKey(),
            'nama_supplier' => $this->string(),
            'alamat' => $this->text(),
            'no_telp' => $this->string(15),
            'user_id' => $this->integer()
        ]);
        
        $this->addForeignKey('fk-supplier-user_id-user-id', 'supplier', 'user_id', 'user', 'id', 'cascade', 'cascade');
        
        $this->createTable('beli_supplier', [
            'id' => $this->primaryKey(),
            'no_faktur' => $this->string(),
            'tgl_beli' => $this->date(),
            'supplier_id' => $this->integer(),
            'kode_pembelian' => $this->string()
        ]);
        
        $this->addForeignKey('fk-beli_supplier-supplier_id-supplier_id', 'beli_supplier', 'supplier_id', 'supplier', 'id', 'cascade', 'cascade');
        
        $this->createTable('detail_beli_supplier', [
            'id' => $this->primaryKey(),
            'no_faktur' => $this->string(),
            'barang_id' => $this->integer(),
            'jumlah' => $this->integer(),
        ]);
        
        $this->addForeignKey('fk-detail_beli_supplier-barang_id-barang-id', 'detail_beli_supplier', 'barang_id', 'barang', 'id', 'cascade', 'cascade');
        
        $this->createTable('retur', [
            'id' => $this->primaryKey(),
            'tgl_retur' => $this->timestamp(),
            'barang_id' => $this->integer(),
            'qty' => $this->integer(),
            'subtotal' => $this->double(),
            'keterangan' => $this->text()
        ]);
        
//        $this->createTable('barang_masuk', [
//            'id' => $this->primaryKey(),
//            'produk_id' => $this->integer(),
//            'jumlah_barnag_baru' => $this->string(100),
//            'tgl_kadaluarsa' => $this->date(),
//            'status_barang' => $this->smallInteger(),
//        ]);
//        
//        $this->createTable('mutasi_barang', [
//            'id' => $this->primaryKey(),
//            'produk_terjual' => $this->string(100),
//            'produk_dikembalikan' => $this->string(100)
//        ]);
//        
//        $this->createTable('penjualan', [
//            'id' => $this->primaryKey(),
//            'produk_id' => $this->integer(),
//            'tgl_beli' => $this->date(),
//            'jumlah' => $this->string(100),
//        ]);
//        
//        $this->createTable('produk', [
//            'id' => $this->primaryKey(),
//            'nama' => $this->string(),
//            'harga_jual' => $this->string(100),
//            'harga_satuan_modal' => $this->string(100),
//            'stok_awal' => $this->string(100),
//            'tgl_kadaluarsa' => $this->date(),
//            'kategori' => $this->string(100),
//            'user_id' => $this->integer(),
//        ]);
//        
//        $this->addForeignKey('fk-produk-user_id-user-id', 'produk', 'user_id', 'user', 'id', 'cascade', 'cascade');
//        $this->addForeignKey('fk-penjualan-produk_id-produk-id', 'penjualan', 'produk_id', 'produk', 'id', 'cascade', 'cascade');
//        $this->addForeignKey('fk-barang_masuk-produk_id-produk-id', 'barang_masuk', 'produk_id', 'produk', 'id', 'cascade', 'cascade');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropForeignKey('fk-produk-user_id-user-id', 'produk');
//        $this->dropForeignKey('fk-penjualan-produk_id-produk-id', 'penjualan');
//        $this->dropForeignKey('fk-barang_masuk-produk_id-produk-id', 'barang_masuk');
//        
//        $this->dropTable('produk');
//        $this->dropTable('barang_masuk');
//        $this->dropTable('mutasi_barang');
//        $this->dropTable('penjualan');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180916_081150_table_kebutuhan cannot be reverted.\n";

        return false;
    }
    */
}
