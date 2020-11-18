<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\LessonPlan;
use app\models\Schedule;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class LessonPlanController extends BaseController
{

    public function actionIndex()
    {
        $strainer1 = $_GET['gruppa'];
        $strainer2 = $_GET['user'];
        if ($strainer1!=""&&$strainer1!=null&&$strainer2!=""&&$strainer2!=null){
            return new ActiveDataProvider(['query' => LessonPlan::find()->where(['gruppa_id' => $strainer1,'user_id' => $strainer2])]);
        }
        else{
            return new ActiveDataProvider(['query' => LessonPlan::find()]);
        }
    }

    public function actionCreate()
    {
        $lessonplan = new LessonPlan();
        return $this->saveModel($lessonplan);
    }

    public function actionUpdate($id)
    {
        $lessonplan = $this->findModel($id);
        return $this->saveModel($lessonplan);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }
    public function actionDelete($id)
    {
        if (!Schedule::find()->where(['lesson_plan_id' => $id])->exists()){
            $lessonplan = $this->findModel($id)->delete();
            if ($lessonplan==1){
                return "message: Deleted lesson plan №$id";
            }
        }
        else{
            return "message: Schedule exists, cannot delete.";
        }
    }
    public function saveModel($lessonplan)
    {
        if ($lessonplan->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',
            Url::toRoute(['view', 'id' => $lessonplan->getPrimaryKey()], true));
        } 
        elseif (!$lessonplan->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($lessonplan->getErrors()));
        }  
        return $lessonplan;
    }
    public function findModel($id)
    {
        $lessonplan = LessonPlan::findOne($id);
        if ($lessonplan === null) {
            throw new NotFoundHttpException("Lesson Plan with ID $id not found");
        }
        return $lessonplan;
    }
    
}
