<?php

namespace frontend\models;

use frontend\controllers\NumeradoresController;
use yii\console\Exception;

use Yii;

/**
 * This is the model class for table "direccion".
 *
 * @property integer $dir_id
 * @property string $dir_direccion
 * @property string $dir_latlong
 * @property string $dir_latstr
 * @property string $dir_longstr
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
            [['dir_direccion'], 'string', 'max' => 500],
            [['dir_latstr'], 'string', 'max' => 100],
            [['dir_longstr'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dir_id' => 'Codigo',
            'dir_direccion' => 'Direccion',
            'dir_latlong' => 'Point',
            'dir_latstr' => 'Latitud',
            'dir_longstr' => 'Longitud',
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
            try{
                $numerador = new NumeradoresController('DIR');
                $this->dir_id = $numerador->getNumerador();
                $connection = static::getDb();
                $sql="INSERT INTO `direccion` (`dir_id`, `dir_direccion`, `dir_latlong`, `dir_latstr`, `dir_longstr` ) VALUES ("."'".$this->dir_id."',"."'".$this->dir_direccion."','".$this->dir_latlong ."','".$this->dir_latstr ."','".$this->dir_longstr ."')";
                $command=$connection->createCommand($sql);
                $rows = $command->execute();
                if ($rows > 0) return $this->dir_id;
                return -1;
            }catch(Exception $e){
                return -1;
            }
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
