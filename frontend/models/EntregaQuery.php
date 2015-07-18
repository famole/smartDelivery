<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Entrega]].
 *
 * @see Entrega
 */
class EntregaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/
    
    /**
     * @inheritdoc
     * @return Entrega[]|array
     */
    public function all($db = null )
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Entrega|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}