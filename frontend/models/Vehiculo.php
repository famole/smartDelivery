<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehiculo".
 *
 * @property integer $ve_id
 * @property string $ve_matricula
 * @property string $ve_seguro
 * @property integer $ve_movil
 * @property integer $tv_id
 * @property integer $ve_entregaslimite
 *
 * @property Reparto[] $repartos
 * @property Tipovehiculo $tv
 */
class Vehiculo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehiculo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ve_id', 'tv_id'], 'required'],
            [['ve_id', 've_movil', 'tv_id', 've_entregaslimite'], 'integer'],
            [['ve_matricula'], 'string', 'max' => 50],
            [['ve_seguro'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            've_id' => Yii::t('app', 'Ve ID'),
            've_matricula' => Yii::t('app', 'Ve Matricula'),
            've_seguro' => Yii::t('app', 'Ve Seguro'),
            've_movil' => Yii::t('app', 'Ve Movil'),
            'tv_id' => Yii::t('app', 'Tv ID'),
            've_entregaslimite' => Yii::t('app', 'Ve Entregaslimite'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartos()
    {
        return $this->hasMany(Reparto::className(), ['ve_id' => 've_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTv()
    {
        return $this->hasOne(Tipovehiculo::className(), ['tv_id' => 'tv_id']);
    }
}
