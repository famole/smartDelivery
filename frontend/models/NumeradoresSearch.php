<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\numeradores;

/**
 * NumeradoresSearch represents the model behind the search form about `frontend\models\numeradores`.
 */
class NumeradoresSearch extends numeradores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_id'], 'safe'],
            [['num_num'], 'integer'],
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
        $query = numeradores::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'num_num' => $this->num_num,
        ]);

        $query->andFilterWhere(['like', 'num_id', $this->num_id]);

        return $dataProvider;
    }
}
