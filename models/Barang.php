<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barang".
 *
 * @property int $id
 * @property string $nama_barang
 * @property string $barang_satuan
 * @property integer $harga_modal
 * @property integer $harga_jual
 * @property string $stock
 * @property string $min_stock
 * @property string $tgl_input
 * @property string $tgl_last_update
 * @property int $kategori_id
 * @property int $user_id
 *
 * @property Kategori $kategori
 * @property User $user
 * @property DetailBeliSupplier[] $detailBeliSuppliers
 * @property DetailJual[] $detailJuals
 */
class Barang extends \yii\db\ActiveRecord implements \hscstudio\cart\ItemInterface
{
    use \hscstudio\cart\ItemTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_input', 'tgl_last_update'], 'safe'],
            [['kategori_id', 'user_id','harga_modal', 'harga_jual'], 'integer'],
            [['nama_barang', 'stock', 'min_stock'], 'string', 'max' => 255],
            [['barang_satuan'], 'string', 'max' => 5],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kategori::className(), 'targetAttribute' => ['kategori_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_barang' => 'Nama Barang',
            'barang_satuan' => 'Barang Satuan',
            'harga_modal' => 'Harga Modal',
            'harga_jual' => 'Harga Jual',
            'stock' => 'Stock',
            'min_stock' => 'Min Stock',
            'tgl_input' => 'Tgl Input',
            'tgl_last_update' => 'Tgl Last Update',
            'kategori_id' => 'Kategori ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(Kategori::className(), ['id' => 'kategori_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailBeliSuppliers()
    {
        return $this->hasMany(DetailBeliSupplier::className(), ['barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailJuals()
    {
        return $this->hasMany(DetailJual::className(), ['barang_id' => 'id']);
    }

    public function getId(){
        return $this->id;
    }

    public function getPrice(){
        return $this->harga_jual;
    }

}
