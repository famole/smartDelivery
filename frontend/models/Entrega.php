<?php

namespace frontend\models;
use frontend\controllers\NumeradoresController;
use yii\console\Exception;

use Yii;

/**
 * This is the model class for table "entrega".
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
 * @property string $ent_errorDesc
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
            [['ent_obs'], 'string', 'max' => 1000],
            [['ent_errorDesc'], 'string', 'max' => 200]
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
            'ent_errorDesc' => Yii::t('app', 'Error'),
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
            try{
                $numerador = new NumeradoresController('ENT');
                $this->ent_id = $numerador->getNumerador();
                $connection = static::getDb();
                $sql="INSERT INTO `entrega` (`ent_id`, `ped_id`,";
                $values = "VALUES ('".$this->ent_id."','"
                        .$this->ped_id."','";

                if ($this->z_id > 0){
                    $sql .= " `z_id`,";
                    $values .= $this->z_id."','";
                }

                $sql .= "`ent_pendefinir`,";
                $values .= $this->ent_pendefinir."','";

                if ($this->te_id > 0){
                    $sql .= "`te_id`,";
                    $values .= $this->te_id."','";
                }

                $sql .= "`est_id`, `ent_obs`, `ent_orden`, `ent_fecha`,"; 
                $values .= $this->est_id."','"
                        .$this->ent_obs."','"
                        .$this->ent_orden."','"
                        .$this->ent_fecha."','";
                        
                if($this->dir_id > 0){
                    $sql .= "`dir_id`,";
                    $values .= $this->dir_id."','";
                }        
                        
                $sql .= "`ent_errorDesc`) ";
                $values .= $this->ent_errorDesc."')";

                $sql .= $values;
                $command=$connection->createCommand($sql);
                $rows = $command->execute();
                return $rows > 0;
            }catch(Exception $e){
                return -1;
            }
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
    
    public function updateEntregaZona($zpoints){
        
        $connection = static::getDb();
        foreach($zpoints as $item){
            $sql="Update Entrega set z_id =".$item->z_id." where ent_id =".$item->ent_id ;
            $command=$connection->createCommand($sql);
            $rows = $command->execute();
        }
        
        
    }
}
