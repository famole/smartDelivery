<?php

namespace frontend\models;

use Yii;
use frontend\controllers\NumeradoresController;

/**
 * This is the model class for table "reparto".
 *
 * @property integer $rep_id
 * @property integer $ve_id
 * @property string $rep_fhini
 * @property string $rep_fhfin
 * @property integer $est_id
 * @property string $est_observacion
 * @property string $rep_fecha
 *
 * @property Estados $est
 * @property Vehiculo $ve
 * @property Repartoentrega[] $repartoentregas
 * @property Entrega[] $ents
 * @property Repartopersonal[] $repartopersonals
 * @property Personal[] $pers
 */
class Reparto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reparto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 've_id'], 'required'],
            [['rep_id', 've_id', 'est_id'], 'integer'],
            [['rep_fhini', 'rep_fhfin', 'rep_fecha'], 'safe'],
            [['est_observacion'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => Yii::t('app', 'Codigo'),
            've_id' => Yii::t('app', 'Vehiculo'),
            'rep_fhini' => Yii::t('app', 'Comienzo'),
            'rep_fhfin' => Yii::t('app', 'Fin'),
            'est_id' => Yii::t('app', 'Estado'),
            'est_observacion' => Yii::t('app', 'Observacion'),
            'rep_fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEst()
    {
        return $this->hasOne(Estados::className(), ['est_id' => 'est_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVe()
    {
        return $this->hasOne(Vehiculo::className(), ['ve_id' => 've_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartoentregas()
    {
        return $this->hasMany(Repartoentrega::className(), ['rep_id' => 'rep_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnts()
    {
        return $this->hasMany(Entrega::className(), ['ent_id' => 'ent_id'])->viaTable('repartoentrega', ['rep_id' => 'rep_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartopersonals()
    {
        return $this->hasMany(Repartopersonal::className(), ['rep_id' => 'rep_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPers()
    {
        return $this->hasMany(Personal::className(), ['per_id' => 'per_id'])->viaTable('repartopersonal', ['rep_id' => 'rep_id']);
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        $ret = array();
        if ($this->getIsNewRecord()) {
            try{
                $numerador = new NumeradoresController('REP');
                $this->rep_id = $numerador->getNumerador();
                $this-> rep_fhini = 'NULL';
                $this->rep_fhfin = 'NULL';
                $connection = static::getDb();
                $sql="INSERT INTO reparto (rep_id, ve_id,rep_fhini,rep_fhfin,est_id,est_observacion,rep_fecha) "
                        ."VALUES('".$this->rep_id."','".$this->ve_id."',".$this->rep_fhini.",".$this->rep_fhfin.",'".$this->est_id."','".$this->est_observacion."','".$this->rep_fecha."')";
                $command=$connection->createCommand($sql);
                $rows = $command->execute();
                if ($rows > 0){
                    $ret["rep_id"] = $this->rep_id;
                    $ret["rows"] = $rows;
                    $ret["error"] = 0;
                    $ret["msg"] = 'Ok';
                    
                    return $ret;
                    
                }else{
                    $ret["rows"] = $rows;
                    $ret["rep_id"]   = -1;
                    $ret["error"] = 1;
                    $ret["msg"] = 'Error creando el reparto';
                    return $ret;
                }          
                
            }catch(Exception $e){
                $ret["rows"] = -1;
                $ret["rep_id"]   = -1;
                $ret["error"] = 1;
                $ret["msg"] = 'Error creando el reparto';
                return $ret;
            }
            
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
            
}
    
    
}
