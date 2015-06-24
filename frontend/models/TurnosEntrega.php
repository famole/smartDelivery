<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "turnosentrega".
 *
 * @property integer $te_id
 * @property string $te_nombre
 * @property string $te_horainicio
 * @property string $te_horafin
 *
 * @property Entrega[] $entregas
 */
class TurnosEntrega extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'turnosentrega';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['te_id', 'te_nombre', 'te_horainicio', 'te_horafin'], 'required'],
            [['te_id'], 'integer'],
            [['te_horainicio', 'te_horafin'], 'safe'],
            [['te_nombre'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'te_id' => Yii::t('app', 'Te ID'),
            'te_nombre' => Yii::t('app', 'Te Nombre'),
            'te_horainicio' => Yii::t('app', 'Te Horainicio'),
            'te_horafin' => Yii::t('app', 'Te Horafin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntregas()
    {
        return $this->hasMany(Entrega::className(), ['te_id' => 'te_id']);
    }
}
