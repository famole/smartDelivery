<?php

namespace app\models;

use Yii;
use frontend\controllers\NumeradoresController;
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
            'tv_nombre' => Yii::t('app', 'Nombre Tipo Vehiculo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculos()
    {
        return $this->hasMany(Vehiculo::className(), ['tv_id' => 'tv_id']);
    }

    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('TV');
            $this->tv_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `tipovehiculo` (`tv_id`, `tv_nombre`) VALUES ("."'".$this->tv_id."',"."'".$this->tv_nombre."')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
   
}
