<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 28.11.2018
 * Time: 0:44
 */
namespace oboom\gallery\behaviors;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\base\Security;
use oboom\gallery\models\Gallery;



class AttachGallery extends Behavior
{
    public $thumb = true;
    public $mainPathUpload = 'frontend/web/uploads/';
    public $mode ='single';
    public $quality =100;
    public $inputName = 'Gallery[upload]';
    public $type = null;

    public function init()
    {
        if ($this->quality > 100) {
            $this->quality = 100;
        } elseif ($this->quality < 0) {
            $this->quality = 0;
        }

    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'updateImages',
            ActiveRecord::EVENT_AFTER_INSERT => 'setImages',
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeImages',
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

    private function saveDB($path,$thumbPath,$owner){
        $image = new Gallery();
        $image->path = $path;
        $image->thumb_path = $thumbPath;
        $image->assign_id = $owner;
        $image->type = $this->type;
        return $image->save() ? true : false;
    }



    public function uploadImage($data,$id=null,$type=null){
        if(!is_null($id) && !is_null($type)){
            if($this->checkFolder($this->mainPathUpload,$id,$type, $this->thumb)){

                $name = Yii::$app->security->generateRandomString(12);
                $path = $this->getPath().$name.'.'.$data[0]->extension;

                $dbPath = $this->getWebPath().$name.'.'.$data[0]->extension;
                $dbThumbPath = null;


                if($this->thumb){
                    $thumbPath = $this->getPath().'thumb/'.$name.'.'.$data[0]->extension;
                    $dbThumbPath =$this->getWebPath().'thumb/'.$name.'.'.$data[0]->extension;

                    Image::resize($data[0]->tempName,300,300)
                        ->save($thumbPath); //['jpeg_quality' => 75]
                }

                Image::resize($data[0]->tempName,1280,800)
                        ->save($path); //['png_compression_level' => 1-9]

                $this->saveDB($dbPath,$dbThumbPath,$id);
            }

            else {
                throw new \ErrorException('type and id are required attribute');
            }
        }
    }

    public function checkFolder($path,$id, $type, $thumb=true){
        if(!is_dir($path.'/'.$type.'/'.$id)){
            FileHelper::createDirectory($path.'/'.$type.'/'.$id);
            var_dump(FileHelper::createDirectory($path.'/'.$type.'/'.$id));

            $thumb==true ?  FileHelper::createDirectory($path.'/'.$type.'/'.$id.'/thumb') : null;
            return true;
        }
        else {
            FileHelper::createDirectory($path.'/'.$type.'/'.$id);
            //var_dump(is_dir($path.'/'.$type.'/'.$id), $path,$id,$type );
        }

        return true;
    }

    public function getPath(){
        return $this->mainPathUpload.'/'.$this->type.'/'.$this->owner->id.'/';
    }

    public function getWebPath(){
        return explode('web',$this->mainPathUpload)[1].'/'.$this->type.'/'.$this->owner->id.'/';
    }


    public function removeFolder($path){
        FileHelper::removeDirectory($path);
    }





    public function uploadArrayImages($data,$id=null,$type=null){

    }

    public function setImages($event){
        $images = UploadedFile::getInstancesByName($this->getInputName());
        if (!$images) return false;
        if($this->mode==='single' && !is_null($this->mainPathUpload)){
            $this->uploadImage($images,$this->owner->id, $this->type);
        }
        else {
            $this->uploadArrayImages($images,$this->owner->id, $this->type);
        }
    }

    public function updateImages ($event) {
        $images = UploadedFile::getInstancesByName($this->getInputName());
        if (!$images) return false;

        if(!is_null($this->owner->id) && !is_null($this->type)) {
            Gallery::deleteAll(['assign_id'=>$this->owner->id,'type'=>$this->type]);
        }

        //var_dump($images, $this->owner->id, $this->type);

        $this->uploadImage($images,$this->owner->id, $this->type);
    }

    public function removeImages($event) {
        if (!is_null($this->owner->id) && !is_null($this->type)){
            if(Gallery::remove($this->owner->id,$this->type)){
                $this->removeFolder($this->getPath());
            }
        }
    }

}

