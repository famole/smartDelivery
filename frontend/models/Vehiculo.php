<?php

namespace app\models;

use Yii;
use frontend\controllers\NumeradoresController;

/**
 * This is the model class for table "vehiculo".
 *
 * @property integer $ve_id
 * @property string $ve_matricula
 * @property string $ve_seguro
 * @property integer $ve_movil
 * @property integer $tv_id
 * @property integer $ve_entregaslimite
 * @property integer $ve_estado
 *
 * @property Reparto[] $repartos
 * @property Tipovehiculo $tv
 */
class Vehiculo extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
            
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
            [['tv_id'], 'required'],
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
            've_id' => Yii::t('app', 'Codigo'),
            've_matricula' => Yii::t('app', 'Matricula'),
            've_seguro' => Yii::t('app', 'Seguro'),
            've_movil' => Yii::t('app', 'Movil'),
            'tv_id' => Yii::t('app', 'Tipo de Vehiculo'),
            've_entregaslimite' => Yii::t('app', 'Entregas Limite'),
            've_estado' => Yii::t('app', 'Estado'),
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
    public function getTipoVehiculo()
    {
        return $this->hasOne(Tipovehiculo::className(), ['tv_id' => 'tv_id']);
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('VEH');
            $this->ve_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `vehiculo` (`ve_id`, `ve_matricula`, `ve_seguro`, `ve_movil`, `tv_id`, `ve_entregaslimite`,`ve_estado` ) VALUES ("."'".
                    $this->ve_id."',"."'".
                    $this->ve_matricula."','".
                    $this->ve_seguro."','".
                    $this->ve_movil."','".
                    $this->tv_id."','".
                    $this->ve_entregaslimite.
                    $this->ve_estado . "')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
    
}
