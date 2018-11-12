<?php

namespace app\models\searchModel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetailBeliSupplier;

/**
 * DetailBeliSupplierSearch represents the model behind the search form of `app\models\DetailBeliSupplier`.
 */
class DetailBeliSupplierSearch extends DetailBeliSupplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'jumlah', 'beli_sup_id', 'status'], 'integer'],
            [['no_faktur', 'tgl_kadaluarsa'], 'safe'],
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
        $barang = \app\models\Barang::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        $ctrl = Yii::$app->controller->action->id;
        if ($ctrl == 'index'):
            if(\Yii::$app->user->identity->level == \app\models\User::supplier):
            $query = DetailBeliSupplier::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id])->andWhere(['status' => DetailBeliSupplier::setujui_owner])->orderBy('id desc');
            elseif(\Yii::$app->user->identity->level == \app\models\User::pimpinan):
                $query = DetailBeliSupplier::find()->joinWith('barang')->andWhere(['status' => DetailBeliSupplier::order])->orderBy('id desc');
            else:
                $query = DetailBeliSupplier::find()->joinWith('barang')->orderBy('id desc');
            endif;
        elseif($ctrl == 'proses'):
            $query = DetailBeliSupplier::find()->where(['barang_id' => $barang->id]);
        elseif($ctrl == 'persetujuan-owner'):
             $query = DetailBeliSupplier::find()->joinWith('barang')->andWhere(['status' => DetailBeliSupplier::order])->orderBy('id desc');
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
            'barang_id' => $this->barang_id,
            'jumlah' => $this->jumlah,
            'beli_sup_id' => $this->beli_sup_id,
            'tgl_kadaluarsa' => $this->tgl_kadaluarsa,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_faktur', $this->no_faktur]);

        return $dataProvider;
    }
}
