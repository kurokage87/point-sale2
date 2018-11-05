<?php
namespace models\searchModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ListUser;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\searchModel;

/**
 * Description of ListUserSearch
 *
 * @author kurokage
 */
class ListUserSearch extends \app\models\ListUser{
    public function rules(){
        return [
            [['id', 'level'], 'integer'],
            [['username'], 'safe'],
            
        ];
    }
    
    public function search($params){
        $query = \app\models\ListUser::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query
        ]);
        
        $this->load($params);
        
        if ($this->validate()){
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
        ]);
        
        $query->filterWhere([
            'like', 'username', $this->username
        ]);
        
        return $dataProvider;
    }
}
