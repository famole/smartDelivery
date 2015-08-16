<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\pedido;

/**
 * PedidoSearch represents the model behind the search form about `frontend\models\pedido`.
 */
class PedidoSearch extends pedido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ped_id', 'cli_id'], 'integer'],
            [['ped_fechahora', 'ped_direccion', 'ped_observaciones', 'ped_ultproc'], 'safe'],
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
        $query = pedido::find();

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
            'ped_id' => $this->ped_id,
            'cli_id' => $this->cli_id,
            'ped_fechahora' => $this->ped_fechahora,
            'ped_ultproc' => $this->ped_ultproc,
        ]);

        $query->andFilterWhere(['like', 'ped_direccion', $this->ped_direccion])
            ->andFilterWhere(['like', 'ped_observaciones', $this->ped_observaciones]);
        
        $dataProvider->pagination->pageSize = 15;
        
        return $dataProvider;
    }
}
