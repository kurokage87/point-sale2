<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "retur".
 *
 * @property int $id
 * @property string $tgl_retur
 * @property int $barang_id
 * @property int $qty
 * @property double $subtotal
 * @property string $keterangan
 * @property int $status
 *
 * @property Barang $barang
 */
class Retur extends \yii\db\ActiveRecord
{
    const retur_baru = 1;
    const diproses = 2;
    const dikirim = 3;
    const selesai = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'retur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_retur'], 'safe'],
            [['barang_id', 'qty', 'status'], 'integer'],
            [['subtotal'], 'number'],
            [['keterangan'], 'string'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['barang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tgl_retur' => 'Tgl Retur',
            'barang_id' => 'Barang ID',
            'qty' => 'Qty',
            'subtotal' => 'Subtotal',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id' => 'barang_id']);
    }
}
