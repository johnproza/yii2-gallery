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


    public function actionData($id=null,$type=null){

        if(!Yii::$app->user->isGuest && Yii::$app->request->isGet){
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

    public function actionMain($id=null){

        if(!Yii::$app->user->getIsGuest() && Yii::$app->request->isGet){
            $data = Gallery::findOne($id);
            $allData = Gallery::find()->where(['assign_id'=>$data->assign_id, 'type'=>$data->type])->all();
            foreach ($allData as $item) {
                $item->is_main = 0;
                $item->save();
            }

            $data->is_main = 1;

            if($data->save()){
                return $this->asJson([
                    'status' => true,
                    'data' => $allData,
                    'message'=>"Данные обновлены",

                ]);
            }

            else {
                return $this->asJson([
                    'status' => false,
                    'message' => 'нет прав на просмотр'
                ]);
            }
        }

        else {
            return $this->asJson([
                'status' => false,
                'message' => 'нет прав на просмотр'
            ]);
        }

    }

    public function actionRemove($id=null){

        if(!Yii::$app->user->getIsGuest() && Yii::$app->request->isGet){
            $data = Gallery::findOne($id);
            //var_dump();
            unlink(!is_null(Yii::$app->params['uploadPath']) ? Yii::$app->params['uploadPath'].$data->thumb_path : Yii::$app->system->getValue('uploadPath').$data->thumb_path);
            unlink(!is_null(Yii::$app->params['uploadPath']) ? Yii::$app->params['uploadPath'].$data->path : Yii::$app->system->getValue('uploadPath').$data->path);

            if($data->delete()){
                return $this->asJson([
                    'status' => true,
                    'message'=>"Фото удалено",
                ]);
            }

            else {
                return $this->asJson([
                    'status' => false,
                    'message' => 'нет прав на просмотр'
                ]);
            }
        }

        else {
            return $this->asJson([
                'status' => false,
                'message' => 'нет прав на просмотр'
            ]);
        }

    }

    public function actionMeta($id=null,$alt=null, $title=null){

        if(!Yii::$app->user->getIsGuest() && Yii::$app->request->isGet){
            $data = Gallery::findOne($id);

            $data->alt =$alt;
            $data->title=$title;
            if($data->save()){
                return $this->asJson([
                    'status' => true,
                    'message'=>"Данные обновлены",
                ]);
            }
        }

        else {
            return $this->asJson([
                'status' => false,
                'message' => 'нет прав на просмотр'
            ]);
        }

    }

}

