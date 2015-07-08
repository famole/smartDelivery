<?php

namespace app\models;

use Yii;
use frontend\controllers\NumeradoresController;

/**
 * This is the model class for table "personalcat".
 *
 * @property integer $pc_id
 * @property string $pc_desc
 *
 * @property Personal[] $personals
 */
class Personalcat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personalcat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pc_desc'], 'required'],
            [['pc_id'], 'integer'],
            [['pc_desc'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pc_id' => Yii::t('app', 'Codigo'),
            'pc_desc' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::className(), ['pc_id' => 'pc_id']);
    }
    
     public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $numerador = new NumeradoresController('PCA');
            $this->pc_id = $numerador->getNumerador();
            $connection = static::getDb();
            $sql="INSERT INTO `personalcat` (`pc_id`, `pc_desc`) VALUES ("."'".$this->pc_id."',"."'".$this->pc_desc."')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
