<?php

namespace frontend\models;
use frontend\controllers\NumeradoresController;
use common\models\User;

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
            [['per_nom', 'per_priape', 'pc_id'], 'required'],
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
            'per_id' => Yii::t('app', 'Codigo'),
            'user_id' => Yii::t('app', 'User Id'),
            'per_nom' => Yii::t('app', 'Nombre'),
            'per_priape' => Yii::t('app', 'Apellido'),
            'per_segape' => Yii::t('app', 'Segundo apellido'),
            'per_tel' => Yii::t('app', 'Telefono'),
            'pc_id' => Yii::t('app', 'Categoria'),
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
    
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $user = new User();
            $user->username = $this->per_nom;
            $user->setPassword($this->per_priape);
            $user->usertype = $this->pc->pc_desc;
            $user->generateAuthKey();
            if ($user->save()) {
                $numerador = new NumeradoresController('PER');
                $this->per_id = $numerador->getNumerador();
                $connection = static::getDb();
                $sql="INSERT INTO `personal` (`per_id`, `user_id`, `per_nom`, `per_priape`, `per_segape`, `per_tel`, `pc_id`) "
                        . "VALUES ("."'".$this->per_id."',"
                        ."'".$user->id."',"
                        ."'".$this->per_nom."',"
                        ."'".$this->per_priape."',"
                        ."'".$this->per_segape."',"
                        ."'".$this->per_tel."',"
                        ."'".$this->pc_id."')";
                $command=$connection->createCommand($sql);
                $command->execute();
            }
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
        
    }
    
    public function getAvailablePersonalByDate($date){
        $connection = static::getDb();
        $transaction = $connection->beginTransaction();
        $sql= "SELECT p.per_id, 
            p.per_nom,
            p.per_priape,
            p.per_tel ,
            rp.rep_id
            FROM repartopersonal rp 
            RIGHT JOIN personal p ON p.per_id = rp.per_id 
            WHERE rp.rep_id NOT IN (
            SELECT DISTINCT(re.rep_id) 
            FROM repartoentrega re, entrega e 
            WHERE e.ent_fecha = '".$date."' AND e.ent_id = re.ent_id) OR rp.rep_id IS NULL";
        $command=$connection->createCommand($sql);
        $dataReader = $command->query();
        $items = (array) null;
        foreach($dataReader as $item){
            Yii::Error($item['per_nom']);
            $item = array(
                    "per_id" => $item['per_id'],
                    "per_nom" => $item['per_nom'],
                    "per_priape" => $item['per_priape'],
                    "per_tel" => $item['per_tel'],
                      
            );
            array_push($items, $item);
        }
        return $items;
        
    }
}
