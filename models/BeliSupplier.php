<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beli_supplier".
 *
 * @property int $id
 * @property string $no_faktur
 * @property string $tgl_beli
 * @property int $supplier_id
 * @property string $kode_pembelian
 * @property string $status
 *
 * @property Supplier $supplier
 * @property DetailBeliSupplier[] $detailBeliSuppliers
 */
class BeliSupplier extends \yii\db\ActiveRecord
{
    const order = 1;
    const di_proses_supplier = 2;
    const dikirim = 3;
    const ditolak = 4;
    const selesai = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beli_supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_beli'], 'safe'],
            [['supplier_id','status'], 'integer'],
            [['no_faktur', 'kode_pembelian'], 'string', 'max' => 255],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_faktur' => 'No Faktur',
            'tgl_beli' => 'Tgl Beli',
            'supplier_id' => 'Nama Karyawan',
            'kode_pembelian' => 'Kode Pembelian',
            'status' => 'Status Barang'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailBeliSuppliers()
    {
        return $this->hasMany(DetailBeliSupplier::className(), ['beli_sup_id' => 'id']);
    }
}
