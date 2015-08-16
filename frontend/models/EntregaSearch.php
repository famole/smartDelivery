<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Entrega;

/**
 * EntregaSearch represents the model behind the search form about `frontend\models\Entrega`.
 */
class EntregaSearch extends Entrega
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ent_id', 'ped_id', 'z_id', 'ent_pendefinir', 'te_id', 'est_id', 'dir_id'], 'integer'],
            [['ent_obs', 'ent_fecha', 'ent_errorDesc'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Entrega::find();
//        $query->joinWith('estados');
//        $query->joinWith('zona');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
//        $dataProvider->sort->attributes['estado'] = [
//            'asc' => ['estados.est_nom' => SORT_ASC],
//            'desc' => ['estados.est_nom' => SORT_DESC],
//        ];
//        
//        $dataProvider->sort->attributes['zona'] = [
//            'asc' => ['zona.z_nombre' => SORT_ASC],
//            'desc' => ['zona.z_nombre' => SORT_DESC],
//        ];
//        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ent_id' => $this->ent_id,
            'ped_id' => $this->ped_id,
            'z_id' => $this->z_id,
            'ent_pendefinir' => $this->ent_pendefinir,
            'te_id' => $this->te_id,
            'est_id' => $this->est_id,
            'ent_fecha' => $this->ent_fecha,
            'dir_id' => $this->dir_id,
            
        ]);
        
        $query->andFilterWhere(['like', 'ent_obs', $this->ent_obs])
            ->andFilterWhere(['like', 'ent_errorDesc', $this->ent_errorDesc]);
        
        $dataProvider->pagination->pageSize = 15;
        
        return $dataProvider;
    }
}