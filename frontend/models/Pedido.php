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
 * @property integer $ped_proc
 * @property string $ped_dep
 * @property integer $ped_error
 * @property string $ped_errordesc
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
            [['ped_observaciones'], 'string', 'max' => 1000],
            [['ped_dep'], 'string', 'max' => 100],
            [['ped_errordesc'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ped_id' => Yii::t('app', 'Codigo'),
            'cli_id' => Yii::t('app', 'Cliente Id'),
            'ped_fechahora' => Yii::t('app', 'Fecha'),
            'ped_direccion' => Yii::t('app', 'Dirección'),
            'ped_observaciones' => Yii::t('app', 'Observaciones'),
            'ped_ultproc' => Yii::t('app', 'Ped Ultproc'),
            'ped_dep' => Yii::t('app', 'Departamento'),
            'ped_error' => Yii::t('app', 'Error en Pedido'),
            'ped_errordesc' => Yii::t('app', 'Descripcion Error')
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
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('PED');
            $this->per_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `pedido` (`ped_id`, `cli_id`, `ped_fechahora`, `ped_direccion`, `ped_observaciones`, `ped_ultproc`, `ped_error`, `ped_errordesc`) "
                    . "VALUES ("."'".$this->ped_id."',"
                    ."'".$this->cli_id."',"
                    ."'".$this->ped_fechahora."',"
                    ."'".$this->ped_direccion."',"
                    ."'".$this->ped_observaciones."',"
                    ."'".$this->ped_ultproc."',"
                    ."'".$this->ped_dep."',"
                    ."'".$this->ped_error."',"
                    ."'".$this->ped_errordesc."')";
            $command=$connection->createCommand($sql);
            $rows = $command->execute();
            return $rows > 0;
           
        } else {
            $this->ped_error = 0;
            $this->ped_errordesc = '';
            $auxDate = strtotime($this->ped_fechahora);
            $this->ped_fechahora = date('Y-m-d', $auxDate);
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
    

}
