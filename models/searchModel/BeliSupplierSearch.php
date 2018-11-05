<?php

namespace app\models\searchModel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BeliSupplier;

/**
 * BeliSupplierSearch represents the model behind the search form of `app\models\BeliSupplier`.
 */
class BeliSupplierSearch extends BeliSupplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id'], 'integer'],
            [['no_faktur', 'tgl_beli', 'kode_pembelian'], 'safe'],
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
        $query = BeliSupplier::find();

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
            'tgl_beli' => $this->tgl_beli,
            'supplier_id' => $this->supplier_id,
        ]);

        $query->andFilterWhere(['like', 'no_faktur', $this->no_faktur])
            ->andFilterWhere(['like', 'kode_pembelian', $this->kode_pembelian]);

        return $dataProvider;
    }
}
