<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lesson_plan".
 *
 * @property int $lesson_plan_id
 * @property int $lessonplan_id
 * @property int $subject_id
 * @property int $user_id
 *
 * @property Subject $subject
 * @property Teacher $user
 * @property Gruppa $lessonplan
 * @property Schedule[] $schedules
 */
class LessonPlan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lesson_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gruppa_id', 'subject_id', 'user_id'], 'required'],
            [['gruppa_id', 'subject_id', 'user_id'], 'integer'],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'subject_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['gruppa_id', 'user_id'], 'filter', 'targetClass' => LessonPlan::className(),'targetAttribute' => ['lesson_plan_id' => 'lesson_plan_id']],
            [['lesson_plan_id'], 'unique', 'targetClass' => LessonPlan::className(), 'message' => 'Предмет успешно добавлен'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lesson_plan_id' => 'Lesson Plan ID',
            'gruppa_id' => 'Gruppa ID',
            'subject_id' => 'Subject ID',
            'user_id' => 'User ID',
        ];
    }


    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\SubjectQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['subject_id' => 'subject_id']);
    }

    public function getGruppa()
    {
        return $this->hasOne(Gruppa::className(), ['gruppa_id' => 'gruppa_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\TeacherQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Schedules]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\ScheduleQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['lesson_plan_id' => 'lesson_plan_id']);
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
            'lesson_plan_id' => function () { return $this->lesson_plan_id;},
            'gruppa' => function () { return $this->gruppa->name;},
            'subject' => function () { return $this->subject->name;},
            'lastname' => function () { return $this->user->lastname;},
            'firstname' => function () { return $this->user->firstname;},
            'patronymic' => function () { return $this->user->patronymic;},
        ]);
    }

    public function loadAndSave($bodyParams)
    {
        $lessonplan = ($this->isNewRecord) ? new LessonPlan() :
        LessonPlan::findOne($this->lesson_plan_id);
        if ($lessonplan->load($bodyParams, '') && $lessonplan->save()) {
            if ($this->isNewRecord) {
                $this->lesson_plan_id = $lessonplan->lesson_plan_id;
            }
            if ($this->load($bodyParams, '') && $this->save()) {
                return true;
            }
        }
        return false;
    }
}
