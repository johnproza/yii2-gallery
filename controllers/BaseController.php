<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 12:59
 */

namespace oboom\gallery\controllers;
use oboom\gallery\models\Gallery;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;


class BaseController extends Controller
{

//    public function behaviors()
//    {
////        return [
////
////            'verbs' => [
////                'class' => VerbFilter::class,
////                'actions' => [
////                    'index' => ['post'],
////                    'delete' => ['post', 'delete'],
////                ],
////            ],
////        ];
//    }

    public function actionIndex($id=null,$type=null){


    }

    public function actionData($id=null,$type=null){

        if(Yii::$app->request->isPost && !Yii::$app->user->getIsGuest()){
            var_dump($id,$type);
        }

        $data = Gallery::getAllData($id,$type);
        if($data){
            return $this->asJson([
                'status' => true,
                'data' => $data,
                'id'=>$id,
                'type'=>$type

            ]);
        }

        else {
            return $this->asJson([
                'status' => false,
                'message' => 'No data'
            ]);
        }

    }



}

