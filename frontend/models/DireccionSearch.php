<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Direccion;

/**
 * DireccionSearch represents the model behind the search form about `frontend\models\Direccion`.
 */
class DireccionSearch extends Direccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dir_id'], 'integer'],
            [['dir_direccion', 'dir_lat', 'dir_lon'], 'safe'],
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
        $query = Direccion::find();

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
            'dir_id' => $this->dir_id,
        ]);

        $query->andFilterWhere(['like', 'dir_direccion', $this->dir_direccion])
            ->andFilterWhere(['like', 'dir_lat', $this->dir_lat])
            ->andFilterWhere(['like', 'dir_lon', $this->dir_lon]);
                

        return $dataProvider;
    }
}
