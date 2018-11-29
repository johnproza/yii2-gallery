<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:07
 */

namespace oboom\gallery\widgets;

use Yii;
use oboom\gallery\models\Gallery;
use yii\base\Widget;
use yii\helpers\Html;

class GalleryWidgets extends Widget
{
    /*
     *      @template -> path to your template | default 'menu' | yii2-gallery/widgets/views/index.php
     *      @data -> values from DataBase
     *      @type -> prefix of upload data (field "type" into DataBase)
     *
     *      @widgetType -> how to show widget
     *                      show => show image
     *                      add => show upload form
     */
    public  $template = 'index';
    public  $model = null;
    public  $type=null;
    public  $params=null;
    private $data;

    public function init(){
        parent::init();
        //$this->registerTranslations();
        if ($this->model!==null && $this->type!==null){
//            if(!$this->data =Gallery::getData($this->model->id, $this->type)){
//                $this->data = new Gallery();
//            }
            $this->data =Gallery::getData($this->model->id, $this->type);

        }
        else {
            //$this->data= new Gallery();
            throw new \ErrorException('model is required attribute');
        }
    }


    public function initParams(){
        if($this->params['type']!=null){
            switch ($this->params['type']) {
                case 'showSingle':
                    $this->template="showSingle";
                    break;
                case 'showMultiple':
                    $this->template="showMultiple";
                    break;
                case 'addMultiple':
                    $this->template="addMultiple";
                    break;
                case 'addSingle':
                    $this->template="addSingle";
                    break;
            }
        }

        else {
            $this->template='showSingle';
        }
    }

    public function run(){
        $this->initParams();

        return $this->render($this->template,
                            ['data'=>$this->data,'className'=>$this->params['className']]
                            );

    }

    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['widgets/menu/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@vendor/johnproza/yii2-gallery/messages',
            'fileMap' => [
                'messages' => 'gallery.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('message/' . $category, $message, $params, $language);
    }

}