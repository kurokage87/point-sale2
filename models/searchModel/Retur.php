<?php

namespace app\models\searchModel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Retur as ReturModel;

/**
 * Retur represents the model behind the search form of `app\models\Retur`.
 */
class Retur extends ReturModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'qty', 'status'], 'integer'],
            [['tgl_retur', 'keterangan'], 'safe'],
            [['subtotal'], 'number'],
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
        if (Yii::$app->controller->action->id == 'list'){
            if(\Yii::$app->user->identity->level == \app\models\User::supplier):
                $query = ReturModel::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id])->andWhere(['status' => Retur::retur_baru]);
            elseif(\Yii::$app->user->identity->level == \app\models\User::pimpinan):
                $query = ReturModel::find()->joinWith('barang')->where(['status' => Retur::selesai]);
            else:
                $query = ReturModel::find();
            endif;
        }elseif (Yii::$app->controller->action->id == 'proses') {
            $query = ReturModel::find()->joinWith('barang')->where(['barang.user_id' => \Yii::$app->user->identity->id]);
        } else {
            $query = ReturModel::find();
        }

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
            'tgl_retur' => $this->tgl_retur,
            'barang_id' => $this->barang_id,
            'qty' => $this->qty,
            'subtotal' => $this->subtotal,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
