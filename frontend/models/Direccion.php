<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Direccion".
 *
 * @property integer $dir_id
 * @property string $dir_direccion
 * @property string $dir_latlong
 *
 * @property Clientedireccion[] $clientedireccions
 */
class Direccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Direccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dir_id'], 'required'],
            [['dir_id'], 'integer'],
            [['dir_latlong'], 'string'],
            [['dir_direccion'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dir_id' => Yii::t('app', 'Codigo'),
            'dir_direccion' => Yii::t('app', 'Direccion'),
            'dir_latlong' => Yii::t('app', 'Coordenadas'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientedireccions()
    {
        return $this->hasMany(Clientedireccion::className(), ['dir_id' => 'dir_id']);
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('DIR');
            $this->dir_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `direccion` (`dir_id`, `dir_direccion`, `dir_latlong`) VALUES ("."'".$this->dir_id."',"."'".$this->dir_direccion."','".$this->dir_latlong ."')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
