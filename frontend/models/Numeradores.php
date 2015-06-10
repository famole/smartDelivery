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
}
