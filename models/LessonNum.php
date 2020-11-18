<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lesson_num".
 *
 * @property int $lesson_num_id
 * @property string $name
 * @property string $time_lesson
 *
 * @property Schedule[] $schedules
 */
class LessonNum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lesson_num';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_lesson'], 'required'],
            [['time_lesson'], 'safe'],
            [['name'], 'string', 'max' => 10],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lesson_num_id' => 'Lesson Num ID',
            'name' => 'Name',
            'time_lesson' => 'Time Lesson',
        ];
    }

    /**
     * Gets query for [[Schedules]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\ScheduleQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['lesson_num_id' => 'lesson_num_id']);
    }
    public function fields()
    {
        $fields = parent::fields();
        return array_merge($fields, [
            'lesson_num_id' => function () { return $this->lesson_num_id;},
            'time_lesson' => function () { return $this->time_lesson;},
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\UserQuery(get_called_class());
    }
}
