<?php

namespace app\models\searchModel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Penjualan;

/**
 * PenjualanSearch represents the model behind the search form of `app\models\Penjualan`.
 */
class PenjualanSearch extends Penjualan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['no_faktur', 'tgl_jual', 'keterangan'], 'safe'],
            [['total_jual', 'jumlah_uang', 'kembalian'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Penjualan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tgl_jual' => $this->tgl_jual,
            'total_jual' => $this->total_jual,
            'jumlah_uang' => $this->jumlah_uang,
            'kembalian' => $this->kembalian,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'no_faktur', $this->no_faktur])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
