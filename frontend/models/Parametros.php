<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "parametros".
 *
 * @property string $parm_id
 * @property integer $parm_num
 * @property string $parm_text
 */
class Parametros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parm_id'], 'required'],
            [['parm_num'], 'integer'],
            [['parm_id'], 'string', 'max' => 30],
            [['parm_text'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parm_id' => Yii::t('app', 'Id'),
            'parm_num' => Yii::t('app', 'Numero'),
            'parm_text' => Yii::t('app', 'Texto'),
        ];
    }
}
