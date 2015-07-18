<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Vehiculo;

/**
 * VehiculoSearch represents the model behind the search form about `app\models\Vehiculo`.
 */
class VehiculoSearch extends Vehiculo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ve_id', 've_movil', 'tv_id', 've_entregaslimite'], 'integer'],
            [['ve_matricula', 've_seguro'], 'safe'],
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
        $query = Vehiculo::find();

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
            've_id' => $this->ve_id,
            've_movil' => $this->ve_movil,
            'tv_id' => $this->tv_id,
            've_entregaslimite' => $this->ve_entregaslimite,
        ]);

        $query->andFilterWhere(['like', 've_matricula', $this->ve_matricula])
            ->andFilterWhere(['like', 've_seguro', $this->ve_seguro]);

        return $dataProvider;
    }
}
