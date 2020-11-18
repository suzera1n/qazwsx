<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\LessonNum;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class LessonNumController extends BaseController
{

    public function actionIndex()
    {
        return new ActiveDataProvider(['query' => LessonNum::find()]);
    }

    /*public function actionCreate()
    {
        $day = new Gender();
        return $this->saveModel($day);
    }

    public function actionUpdate($id)
    {
        $day = $this->findModel($id);
        return $this->saveModel($day);
    }*/

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /*public function saveModel($day)
    {
        if ($day->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',
            Url::toRoute(['view', 'id' => $day->getPrimaryKey()], true));
        } 
        elseif (!$day->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($day->getErrors()));
        }  
        return $day;
    }*/
    public function findModel($id)
    {
        $lessonnum = LessonNum::findOne($id);
        if ($lessonnum === null) {
            throw new NotFoundHttpException("LessonNum with ID $id not found");
        }
        return $lessonnum;
    }
   
}
