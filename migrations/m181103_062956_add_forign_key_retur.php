<?php

use yii\db\Migration;

/**
 * Class m181103_062956_add_forign_key_retur
 */
class m181103_062956_add_forign_key_retur extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-retur-barang_id-barang-id', 'retur', 'barang_id', 'barang', 'id', 'cascade', 'cascade');
    }   

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181103_062956_add_forign_key_retur cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181103_062956_add_forign_key_retur cannot be reverted.\n";

        return false;
    }
    */
}
