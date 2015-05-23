<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ClienteDireccion;

/**
 * CliDirSearch represents the model behind the search form about `frontend\models\ClienteDireccion`.
 */
class CliDirSearch extends ClienteDireccion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cli_id', 'dir_id'], 'integer'],
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
        $query = ClienteDireccion::find();

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
            'cli_id' => $this->cli_id,
            'dir_id' => $this->dir_id,
        ]);

        return $dataProvider;
    }
}
