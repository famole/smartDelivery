<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repartopersonal".
 *
 * @property integer $rep_id
 * @property integer $per_id
 *
 * @property Personal $per
 * @property Reparto $rep
 */
class RepartoPersonal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repartopersonal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'per_id'], 'required'],
            [['rep_id', 'per_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => Yii::t('app', 'Rep ID'),
            'per_id' => Yii::t('app', 'Per ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPer()
    {
        return $this->hasOne(Personal::className(), ['per_id' => 'per_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRep()
    {
        return $this->hasOne(Reparto::className(), ['rep_id' => 'rep_id']);
    }
}
