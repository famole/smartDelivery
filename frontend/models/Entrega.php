<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Entrega".
 *
 * @property integer $ent_id
 * @property integer $ped_id
 * @property integer $z_id
 * @property boolean $ent_pendefinir
 * @property integer $te_id
 * @property integer $est_id
 * @property string $ent_obs
 * @property integer $ent_orden
 * @property string $ent_fecha
 * @property integer $dir_id
 */
class Entrega extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Entrega';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ent_id', 'ped_id', 'est_id'], 'required'],
            [['ent_id', 'ped_id', 'z_id', 'te_id', 'est_id', 'ent_orden', 'dir_id'], 'integer'],
            [['ent_pendefinir'], 'boolean'],
            [['ent_fecha'], 'safe'],
            [['ent_obs'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ent_id' => Yii::t('app', 'Codigo'),
            'ped_id' => Yii::t('app', 'Codigo Pedido'),
            'z_id' => Yii::t('app', 'Zona'),
            'ent_pendefinir' => Yii::t('app', 'Pendiente Definir'),
            'te_id' => Yii::t('app', 'Turno entrega'),
            'est_id' => Yii::t('app', 'Estado'),
            'ent_obs' => Yii::t('app', 'Observaciones'),
            'ent_orden' => Yii::t('app', 'Orden'),
            'ent_fecha' => Yii::t('app', 'Fecha'),
            'dir_id' => Yii::t('app', 'Direccion'),
        ];
    }

    /**
     * @inheritdoc
     * @return EntregaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntregaQuery(get_called_class());
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('ENT');
            $this->per_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `personal` (`ent_id`, `ped_id`, `z_id`, `ent_pendefinir`, `te_id`, `est_id`, `ent_obs`, `ent_orden`, `ent_fecha`, `dir_id`) "
                    . "VALUES ("."'".$this->per_id."',"
                    ."'".$this->ent_id."',"
                    ."'".$this->ped_id."',"
                    ."'".$this->z_id."',"
                    ."'".$this->ent_pendefinir."',"
                    ."'".$this->te_id."',"
                    ."'".$this->est_id."',"
                    ."'".$this->ent_obs."'," 
                    ."'".$this->ent_orden."',"
                    ."'".$this->ent_fecha."',"
                    ."'".$this->dir_id."',"
                    .")";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
