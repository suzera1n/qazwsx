<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "special".
 *
 * @property int $classroom_id
 * @property string $name
 * @property int $classroom_id
 * @property int $active
 *
 * @property Gruppa[] $gruppas
 * @property Otdel $classroom
 */
class Classroom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classroom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['classroom_id'], 'required'],
            [['classroom_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['classroom_id'], 'unique', 'targetClass' => Classroom::className(), 'message' => 'Класс успешно добавлен'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'classroom_id' => 'Classroom ID',
            'name' => 'Name',
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
        return $this->hasMany(Gruppa::className(), ['classroom_id' => 'classroom_id']);
    }

    /**
     * Gets query for [[Otdel]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\OtdelQuery
     */
    public function getOtdel()
    {
        return $this->hasOne(Otdel::className(), ['classroom_id' => 'classroom_id']);
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
            'classroom_id' => function () { return $this->classroom_id;},
            'name' => function () { return $this->name;},
            'active' => function () { return $this->active;},
        ]);
    }

    public function loadAndSave($bodyParams)
    {
        $classroom = ($this->isNewRecord) ? new Special() :
        Classroom::findOne($this->classroom_id);
        if ($classroom->load($bodyParams, '') && $classroom->save()) {
            if ($this->isNewRecord) {
                $this->classroom_id = $classroom->classroom_id;
            }
            if ($this->load($bodyParams, '') && $this->save()) {
                return true;
            }
        }
        return false;
    }
}
