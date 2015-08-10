<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repartoentrega".
 *
 * @property integer $rep_id
 * @property integer $ent_id
 * @property string $re_fhentregado
 * @property integer $re_orden
 *
 * @property Entrega $ent
 * @property Reparto $rep
 */
class RepartoEntrega extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repartoentrega';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'ent_id'], 'required'],
            [['rep_id', 'ent_id', 're_orden'], 'integer'],
            [['re_fhentregado'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => Yii::t('app', 'Rep ID'),
            'ent_id' => Yii::t('app', 'Ent ID'),
            're_fhentregado' => Yii::t('app', 'Re Fhentregado'),
            're_orden' => Yii::t('app', 'Re Orden'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnt()
    {
        return $this->hasOne(Entrega::className(), ['ent_id' => 'ent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRep()
    {
        return $this->hasOne(Reparto::className(), ['rep_id' => 'rep_id']);
    }
}
