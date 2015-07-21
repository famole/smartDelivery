<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "DireccionReplacements".
 *
 * @property integer $dr_id
 * @property string $dr_str
 * @property string $dr_value
 * @property string $dr_type
 */
class DireccionReplacements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DireccionReplacements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dr_id'], 'required'],
            [['dr_id'], 'integer'],
            [['dr_str', 'dr_value'], 'string', 'max' => 50],
            [['dr_type'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dr_id' => Yii::t('app', 'Dr ID'),
            'dr_str' => Yii::t('app', 'Dr Str'),
            'dr_value' => Yii::t('app', 'Dr Value'),
            'dr_type' => Yii::t('app', 'Dr Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return DireccionReplacementsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DireccionReplacementsQuery(get_called_class());
    }
}
