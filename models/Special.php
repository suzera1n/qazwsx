<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "special".
 *
 * @property int $special_id
 * @property string $name
 * @property int $special_id
 * @property int $active
 *
 * @property Gruppa[] $gruppas
 * @property Otdel $special
 */
class Special extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'special';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['special_id'], 'required'],
            [['special_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['special_id'], 'exist', 'skipOnError' => true, 'targetClass' => Special::className(), 'targetAttribute' => ['special_id' => 'special_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'special_id' => 'Special ID',
            'name' => 'Name',
            'otdel_id' => 'Otdel ID',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Gruppas]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\GruppaQuery
     */
    public function getGruppas()
    {
        return $this->hasMany(Gruppa::className(), ['special_id' => 'special_id']);
    }

    /**
     * Gets query for [[Otdel]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\OtdelQuery
     */
    public function getOtdel()
    {
        return $this->hasOne(Otdel::className(), ['otdel_id' => 'otdel_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\UserQuery(get_called_class());
    }
    
    public function fields()
    {
        $fields = parent::fields();
        return array_merge($fields, [
            'special_id' => function () { return $this->special_id;},
            'otdelName' => function () { return $this->otdel->name;},
            'active' => function () { return $this->active;},
        ]);
    }

    public function loadAndSave($bodyParams)
    {
        $special = ($this->isNewRecord) ? new Special() :
        Special::findOne($this->special_id);
        if ($special->load($bodyParams, '') && $special->save()) {
            if ($this->isNewRecord) {
                $this->special_id = $special->special_id;
            }
            if ($this->load($bodyParams, '') && $this->save()) {
                return true;
            }
        }
        return false;
    }
}
