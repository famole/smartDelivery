<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zona".
 *
 * @property integer $z_id
 * @property string $z_nombre
 * @property string $z_zona
 * @property string $z_wkt
 *
 * @property Entrega[] $entregas
 */
class Zona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['z_id', 'z_nombre'], 'required'],
            [['z_id'], 'integer'],
            [['z_zona', 'z_wkt'], 'string'],
            [['z_nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'z_id' => Yii::t('app', 'ID'),
            'z_nombre' => Yii::t('app', 'Nombre'),
            'z_zona' => Yii::t('app', 'Zona'),
            'z_wkt' => Yii::t('app', 'Wkt'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntregas()
    {
        return $this->hasMany(Entrega::className(), ['z_id' => 'z_id']);
    }
     public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
//           $dsn = 'mysql:host=localhost;dbname=smartdelivery';
//           $username = 'root';
//           $password = 'root';
//           $connection=new CDbConnection($dsn,$username,$password);
           $connection = static::getDb();
           $sql="INSERT INTO `zona` (`z_id`, `z_nombre`, `z_zona`,`z_wkt`) VALUES ("."'".$this->z_id."',"."'".$this->z_nombre."',"."GeomFromText('".  $this->z_zona."'),'".$this->z_zona."')";
           $command=$connection->createCommand($sql);
           $command->execute();
           
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
}
    }
  
}
