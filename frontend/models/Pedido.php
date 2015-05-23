<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property integer $ped_id
 * @property integer $cli_id
 * @property string $ped_fechahora
 * @property string $ped_direccion
 * @property string $ped_observaciones
 * @property string $ped_ultproc
 *
 * @property Clientedireccion $clientedireccion
 * @property Entrega[] $entregas
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ped_id', 'cli_id'], 'required'],
            [['ped_id', 'cli_id'], 'integer'],
            [['ped_fechahora', 'ped_ultproc'], 'safe'],
            [['ped_direccion'], 'string', 'max' => 500],
            [['ped_observaciones'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ped_id' => Yii::t('app', 'ID'),
            'cli_id' => Yii::t('app', 'Cliente ID'),
            'ped_fechahora' => Yii::t('app', 'Fecha'),
            'ped_direccion' => Yii::t('app', 'Dirección'),
            'ped_observaciones' => Yii::t('app', 'Observaciones'),
            'ped_ultproc' => Yii::t('app', 'Ped Ultproc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientedireccion()
    {
        return $this->hasOne(Clientedireccion::className(), ['cli_id' => 'cli_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntregas()
    {
        return $this->hasMany(Entrega::className(), ['ped_id' => 'ped_id']);
    }
}
