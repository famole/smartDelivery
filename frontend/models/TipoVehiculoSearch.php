<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\TipoVehiculo;

/**
 * TipoVehiculoSearch represents the model behind the search form about `frontend\models\TipoVehiculo`.
 */
class TipoVehiculoSearch extends TipoVehiculo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tv_id'], 'integer'],
            [['tv_nombre'], 'safe'],
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
        $query = TipoVehiculo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tv_id' => $this->tv_id,
        ]);

        $query->andFilterWhere(['like', 'tv_nombre', $this->tv_nombre]);

        return $dataProvider;
    }
}
