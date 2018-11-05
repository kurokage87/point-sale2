<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penjualan".
 *
 * @property int $id
 * @property string $no_faktur
 * @property string $tgl_jual
 * @property double $total_jual
 * @property double $jumlah_uang
 * @property double $kembalian
 * @property int $user_id
 * @property string $keterangan
 *
 * @property DetailJual[] $detailJuals
 * @property User $user
 */
class Penjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_jual'], 'safe'],
            [['total_jual', 'jumlah_uang', 'kembalian'], 'number'],
            [['user_id'], 'integer'],
            [['keterangan'], 'string'],
            [['no_faktur'], 'string', 'max' => 255],
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
            'no_faktur' => 'No Faktur',
            'tgl_jual' => 'Tgl Jual',
            'total_jual' => 'Total Jual',
            'jumlah_uang' => 'Jumlah Uang',
            'kembalian' => 'Kembalian',
            'user_id' => 'User ID',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailJuals()
    {
        return $this->hasMany(DetailJual::className(), ['penjualan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
