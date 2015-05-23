<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "personal".
 *
 * @property integer $per_id
 * @property integer $user_id
 * @property string $per_nom
 * @property string $per_priape
 * @property string $per_segape
 * @property integer $per_tel
 * @property integer $pc_id
 *
 * @property Personalcat $pc
 * @property Repartopersonal[] $repartopersonals
 * @property Reparto[] $reps
 */
class Personal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['per_id', 'user_id', 'per_nom', 'per_priape', 'pc_id'], 'required'],
            [['per_id', 'user_id', 'per_tel', 'pc_id'], 'integer'],
            [['per_nom', 'per_priape', 'per_segape'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'per_id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'per_nom' => Yii::t('app', 'Nombre'),
            'per_priape' => Yii::t('app', 'Primer apellido'),
            'per_segape' => Yii::t('app', 'Segundo apellido'),
            'per_tel' => Yii::t('app', 'Telefono'),
            'pc_id' => Yii::t('app', 'Pc ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPc()
    {
        return $this->hasOne(Personalcat::className(), ['pc_id' => 'pc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartopersonals()
    {
        return $this->hasMany(Repartopersonal::className(), ['per_id' => 'per_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReps()
    {
        return $this->hasMany(Reparto::className(), ['rep_id' => 'rep_id'])->viaTable('repartopersonal', ['per_id' => 'per_id']);
    }
}