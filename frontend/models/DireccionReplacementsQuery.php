<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[DireccionReplacements]].
 *
 * @see DireccionReplacements
 */
class DireccionReplacementsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return DireccionReplacements[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DireccionReplacements|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}