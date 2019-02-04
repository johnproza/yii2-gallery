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
    public  $template = 'upload';
    public  $model = null;
    public  $max = 10;
    public  $type=null;
    public  $params=[
        'type'=>'single',
        'className'=>'foto',
        'aspectRatio'=>[1,1]
    ];
    private $data;

    public function init(){
        parent::init();
        if ($this->model!==null && $this->type!==null){
            $this->data =Gallery::getData($this->model->id, $this->type);
        }
        else {
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
                case 'single':
                    $this->template="upload";
                    break;
                case 'multiple':
                    $this->template="upload";
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
                            [   'data'=>$this->data,
                                'modelType'=>$this->type,
                                'aspectRatio'=>$this->params['aspectRatio'],
                                'modelId'=>$this->model->id,
                                'mode'=>$this->params['type'],
                                'max'=>$this->max,
                                'className'=>$this->params['className']]
                            );

    }

}