<?php

namespace app\models\searchModel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Barang;

/**
 * BarangSearch represents the model behind the search form of `app\models\Barang`.
 */
class BarangSearch extends Barang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kategori_id', 'user_id'], 'integer'],
            [['nama_barang', 'barang_satuan', 'harga_modal', 'harga_jual', 'stock', 'min_stock', 'tgl_input', 'tgl_last_update'], 'safe'],
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
        if (Yii::$app->controller->action->id == 'list-barang'):
        $query = Barang::find()->where(['user_id' => Yii::$app->user->identity->id]);
        else:
            $query = Barang::find();
        endif;

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
            'tgl_input' => $this->tgl_input,
            'tgl_last_update' => $this->tgl_last_update,
            'kategori_id' => $this->kategori_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'nama_barang', $this->nama_barang])
            ->andFilterWhere(['like', 'barang_satuan', $this->barang_satuan])
            ->andFilterWhere(['like', 'harga_modal', $this->harga_modal])
            ->andFilterWhere(['like', 'harga_jual', $this->harga_jual])
            ->andFilterWhere(['like', 'stock', $this->stock])
            ->andFilterWhere(['like', 'min_stock', $this->min_stock]);

        return $dataProvider;
    }
}
