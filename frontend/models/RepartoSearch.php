<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Reparto;

/**
 * RepartoSearch represents the model behind the search form about `frontend\models\Reparto`.
 */
class RepartoSearch extends Reparto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 've_id', 'est_id'], 'integer'],
            [['rep_fhini', 'rep_fhfin', 'est_observacion', 'rep_fecha'], 'safe'],
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
        $query = Reparto::find();

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
            'rep_id' => $this->rep_id,
            've_id' => $this->ve_id,
            'rep_fhini' => $this->rep_fhini,
            'rep_fhfin' => $this->rep_fhfin,
            'est_id' => $this->est_id,
            'rep_fecha' => $this->rep_fecha,
        ]);

        $query->andFilterWhere(['like', 'est_observacion', $this->est_observacion]);

        return $dataProvider;
    }
}
