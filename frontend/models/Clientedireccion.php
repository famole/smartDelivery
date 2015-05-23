<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "clientedireccion".
 *
 * @property integer $cli_id
 * @property integer $dir_id
 *
 * @property Pedido $cli
 * @property Direccion $dir
 */
class Clientedireccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientedireccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cli_id', 'dir_id'], 'required'],
            [['cli_id', 'dir_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cli_id' => Yii::t('app', 'Cli ID'),
            'dir_id' => Yii::t('app', 'Dir ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCli()
    {
        return $this->hasOne(Pedido::className(), ['cli_id' => 'cli_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDir()
    {
        return $this->hasOne(Direccion::className(), ['dir_id' => 'dir_id']);
    }
}