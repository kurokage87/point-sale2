<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail_beli_supplier".
 *
 * @property int $id
 * @property string $no_faktur
 * @property int $barang_id
 * @property int $jumlah
 * @property int $beli_sup_id
 * @property string $tgl_kadaluarsa
 * @property integer $status Description
 *
 * @property Barang $barang
 * @property BeliSupplier $beliSup
 */
class DetailBeliSupplier extends \yii\db\ActiveRecord
{
    const order = 1;
    const setujui_owner=6;
    const tolak_owner=7;
    const di_proses_supplier = 2;
    const dikirim = 3;
    const ditolak = 4;
    const selesai = 5;
    const UPDATE_TYPE_CREATE = 'create';
    const UPDATE_TYPE_UPDATE = 'update';
    const UPDATE_TYPE_DELETE = 'delete';
    
    const SCENARIO_BATCH_UPDATE = 'batchUpdate';
    
    private $_updateType;
    
    public function getUpdateType(){
        if (empty($this->_updateType)){
            if ($this->isNewRecord){
                $this->_updateType = self::UPDATE_TYPE_CREATE;
            }else{
                $this->_updateType = self::UPDATE_TYPE_UPDATE;
            }
        }
        
        return $this->_updateType;
    }
    
    public function setUpdateType($value){
        $this->_updateType = $value;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail_beli_supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_kadaluarsa','status'],'safe'],
            ['updateType', 'required', 'on' => self::SCENARIO_BATCH_UPDATE],
            ['updateType', 
                'in',
                'range' => [self::UPDATE_TYPE_CREATE, self::UPDATE_TYPE_UPDATE, self::UPDATE_TYPE_DELETE],
                'on' => self::SCENARIO_BATCH_UPDATE],
            ['beli_sup_id','required', 'except' => self::SCENARIO_BATCH_UPDATE],
            [['barang_id', 'jumlah', 'beli_sup_id'], 'integer'],
            [['no_faktur'], 'string', 'max' => 255],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['barang_id' => 'id']],
            [['beli_sup_id'], 'exist', 'skipOnError' => true, 'targetClass' => BeliSupplier::className(), 'targetAttribute' => ['beli_sup_id' => 'id']],
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
            'barang_id' => 'Barang ID',
            'jumlah' => 'Jumlah',
            'beli_sup_id' => 'Beli Sup ID',
            'tgl_kadaluarsa' => 'Tanggal Kadaluarsa',
            'status' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['id' => 'barang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeliSup()
    {
        return $this->hasOne(BeliSupplier::className(), ['id' => 'beli_sup_id']);
    }
}
