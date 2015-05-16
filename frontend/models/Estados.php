<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estados".
 *
 * @property integer $est_id
 * @property string $est_nom
 *
 * @property Reparto[] $repartos
 */
class Estados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['est_id', 'est_nom'], 'required'],
            [['est_id'], 'integer'],
            [['est_nom'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'est_id' => Yii::t('app', 'Est ID'),
            'est_nom' => Yii::t('app', 'Est Nom'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartos()
    {
        return $this->hasMany(Reparto::className(), ['est_id' => 'est_id']);
    }
}
