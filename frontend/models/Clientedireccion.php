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
            'cli_id' => Yii::t('app', 'Codigo Cliente'),
            'dir_id' => Yii::t('app', 'Codigo Direccion'),
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
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('CDI');
            $this->dir_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `clientedireccion` (`cli_id`, `dir_id`) VALUES ("."'".$this->cli_id."','".$this->dir_id."')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
