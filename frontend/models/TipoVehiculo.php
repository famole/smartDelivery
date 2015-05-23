<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipovehiculo".
 *
 * @property integer $tv_id
 * @property string $tv_nombre
 *
 * @property Vehiculo[] $vehiculos
 */
class TipoVehiculo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipovehiculo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tv_id'], 'required'],
            [['tv_id'], 'integer'],
            [['tv_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tv_id' => Yii::t('app', 'Codigo'),
            'tv_nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculos()
    {
        return $this->hasMany(Vehiculo::className(), ['tv_id' => 'tv_id']);
    }

}
