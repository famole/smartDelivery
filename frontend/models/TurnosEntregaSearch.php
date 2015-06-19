<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\TurnosEntrega;

/**
 * TurnosEntregaSearch represents the model behind the search form about `frontend\models\TurnosEntrega`.
 */
class TurnosEntregaSearch extends TurnosEntrega
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_id'], 'integer'],
            [['te_nombre', 'te_horainicio', 'te_horafin'], 'safe'],
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
        $query = TurnosEntrega::find();

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
            'te_id' => $this->te_id,
            'te_horainicio' => $this->te_horainicio,
            'te_horafin' => $this->te_horafin,
        ]);

        $query->andFilterWhere(['like', 'te_nombre', $this->te_nombre]);

        return $dataProvider;
    }
}
