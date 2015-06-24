<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "numeradores".
 *
 * @property string $num_id
 * @property integer $num_num
 */
class Numeradores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'numeradores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_id', 'num_num'], 'required'],
            [['num_num'], 'integer'],
            [['num_id'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'num_id' => Yii::t('app', 'Id'),
            'num_num' => Yii::t('app', 'Numerador'),
        ];
    }
    
     public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $connection = static::getDb();
            $sql="INSERT INTO `numeradores` (`num_id`, `num_num`) VALUES ("."'".$this->num_id."',"."'".$this->num_num."')";
            $command=$connection->createCommand($sql);
            $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }
}
