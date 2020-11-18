<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\Day;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class DayController extends BaseController
{

    public function actionIndex()
    {
        return new ActiveDataProvider(['query' => Day::find()]);
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
        $day = Day::findOne($id);
        if ($day === null) {
            throw new NotFoundHttpException("Day with ID $id not found");
        }
        return $day;
    }
   
}
