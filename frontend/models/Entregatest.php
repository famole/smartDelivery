<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "entrega".
 *
 * @property integer $ent_id
 * @property integer $ped_id
 * @property integer $z_id
 * @property integer $ent_pendefinir
 * @property integer $te_id
 * @property integer $est_id
 * @property string $ent_obs
 * @property string $ent_fecha
 * @property integer $dir_id
 * @property string $ent_errorDesc
 */
class Entregatest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entrega';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ent_id', 'ped_id', 'est_id'], 'required'],
            [['ent_id', 'ped_id', 'z_id', 'ent_pendefinir', 'te_id', 'est_id', 'dir_id'], 'integer'],
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
            'ent_id' => 'Ent ID',
            'ped_id' => 'Ped ID',
            'z_id' => 'Z ID',
            'ent_pendefinir' => 'Ent Pendefinir',
            'te_id' => 'Te ID',
            'est_id' => 'Est ID',
            'ent_obs' => 'Ent Obs',
            'ent_fecha' => 'Ent Fecha',
            'dir_id' => 'Dir ID',
            'ent_errorDesc' => 'Ent Error Desc',
        ];
    }
}
