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
            [['rep_fhini', 'rep_fhfin'], 'safe'],
            [['est_observacion'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => Yii::t('app', 'Rep ID'),
            've_id' => Yii::t('app', 'Ve ID'),
            'rep_fhini' => Yii::t('app', 'Rep Fhini'),
            'rep_fhfin' => Yii::t('app', 'Rep Fhfin'),
            'est_id' => Yii::t('app', 'Est ID'),
            'est_observacion' => Yii::t('app', 'Est Observacion'),
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
        if ($this->getIsNewRecord()) {
            try{
                $numerador = new NumeradoresController('REP');
                $this->rep_id = $numerador->getNumerador();
                $this-> rep_fhini = 'NULL';
                $this->rep_fhfin = 'NULL';
                $connection = static::getDb();
                $sql="INSERT INTO reparto (rep_id, ve_id,rep_fhini,rep_fhfin,est_id,est_observacion) "
                        ."VALUES('".$this->rep_id."','".$this->ve_id."',".$this->rep_fhini.",".$this->rep_fhfin.",'".$this->est_id."','".$this->est_observacion."')";
                $command=$connection->createCommand($sql);
                $rows = $command->execute();
                if ($rows > 0){
                    return $this->rep_id;
                    
                }else{
                    return -1;
                }          
                
            }catch(Exception $e){
                return -1;
            }
            
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
            
}
}
