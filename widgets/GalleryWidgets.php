<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:07
 */

namespace oboom\gallery\widgets;
use oboom\gallery\models\Gallery;
use yii\base\Widget;
use yii\helpers\Html;

class GalleryWidgets extends Widget
{
    /*
     *      $template -> path to your template | default 'menu' | yii2-menu/widgets/views/menu.php
     *      $data -> values from DataBase
     *      $type -> base css style type of menu (horizontal-menu | vertical-menu)
     *      $menuId -> id value menu table from DataBase (table 'menu')
     *      $className -> personal user css styles for customize menu
     */
    public  $template = 'index';
    public  $model = null;
    public  $type=null;
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

    public function run(){

            return $this->render($this->template,
                    ['data'=>$this->data]);


    }

}