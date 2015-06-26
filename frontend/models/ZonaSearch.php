<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\zona;

/**
 * ZonaSearch represents the model behind the search form about `frontend\models\zona`.
 */
class ZonaSearch extends zona
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['z_id'], 'integer'],
            [['z_nombre', 'z_zona', 'z_wkt'], 'safe'],
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
        $query = zona::find();

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
            'z_id' => $this->z_id,
        ]);

        $query->andFilterWhere(['like', 'z_nombre', $this->z_nombre])
            ->andFilterWhere(['like', 'z_zona', $this->z_zona])
            ->andFilterWhere(['like', 'z_wkt', $this->z_wkt]);

        return $dataProvider;
    }
}
