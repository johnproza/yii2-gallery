<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 28.11.2018
 * Time: 0:44
 */
namespace oboom\gallery\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use oboom\gallery\models\Gallery;



class AttachGallery extends Behavior
{
    public $thumbPathUpload = '@web/uploads/';
    public $mainPathUpload = '@web/uploads/';
    public $mode ='single';
    public $quality =100;
    public $inputName = 'User[avator]';
    public $type = null;

    public function init()
    {
        if ($this->quality > 100) {
            $this->quality = 100;
        } elseif ($this->quality < 0) {
            $this->quality = 0;
        }

        //var_dump($this->mainPathUpload);
    }

    public function events()
    {
        return [
            //ActiveRecord::EVENT_BEFORE_UPDATE => 'setImages',
            ActiveRecord::EVENT_BEFORE_INSERT => 'setImages',
            //ActiveRecord::EVENT_BEFORE_DELETE => 'removeImages',
        ];
    }

    public function getInputName()
    {
        return $this->inputName;
    }

    public function getGalleryMode()
    {
        return $this->mode;
    }

    public function setGalleryPath()
    {
        return $this->mode;
    }


    public function setImages($event){
        $images = UploadedFile::getInstancesByName($this->getInputName());

        var_dump($images);
    }

}

