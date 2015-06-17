<?php

namespace app\models;

use Yii;
use frontend\controllers\NumeradoresController;


/**
 * This is the model class for table "estados".
 *
 * @property integer $est_id
 * @property string $est_nom
 *
 * @property Reparto[] $repartos
 */
class Estados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['est_nom'], 'required'],
            [['est_id'], 'integer'],
            [['est_nom'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'est_id' => Yii::t('app', 'Codigo'),
            'est_nom' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartos()
    {
        return $this->hasMany(Reparto::className(), ['est_id' => 'est_id']);
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('EST');
            $this->est_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `estados` (`est_id`, `est_nom`) VALUES ("."'".$this->est_id."',"."'".$this->est_nom."')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }

}
