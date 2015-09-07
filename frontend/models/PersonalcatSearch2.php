<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Personalcat;

/**
 * PersonalcatSearch2 represents the model behind the search form about `frontend\models\Personalcat`.
 */
class PersonalcatSearch2 extends Personalcat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pc_id'], 'integer'],
            [['pc_desc'], 'safe'],
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
        $query = Personalcat::find();

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
            'pc_id' => $this->pc_id,
        ]);

        $query->andFilterWhere(['like', 'pc_desc', $this->pc_desc]);

        return $dataProvider;
    }
}
