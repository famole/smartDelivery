<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Personal;

/**
 * PersonalSearch represents the model behind the search form about `frontend\models\Personal`.
 */
class PersonalSearch extends Personal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['per_id', 'user_id', 'per_tel', 'pc_id'], 'integer'],
            [['per_nom', 'per_priape', 'per_segape'], 'safe'],
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
        $query = Personal::find();

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
            'per_id' => $this->per_id,
            'user_id' => $this->user_id,
            'per_tel' => $this->per_tel,
            'pc_id' => $this->pc_id,
        ]);

        $query->andFilterWhere(['like', 'per_nom', $this->per_nom])
            ->andFilterWhere(['like', 'per_priape', $this->per_priape])
            ->andFilterWhere(['like', 'per_segape', $this->per_segape]);

        return $dataProvider;
    }
}
