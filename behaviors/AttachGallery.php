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
    public $inputName = 'storage';
    public $type = null;
    public $thumbSize = [
        'x'=>300,
        'y'=>300
    ];

    public function init()
    {

        if ($this->quality > 100) {
            $this->quality = 75;
        } elseif ($this->quality < 0) {
            $this->quality = 75;
        }

    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setImages',
            //ActiveRecord::EVENT_BEFORE_UPDATE => 'updateImages',
            //ActiveRecord::EVENT_BEFORE_INSERT => 'setImages',
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



//    public function uploadImage($data,$id=null,$type=null){
//        if(!is_null($id) && !is_null($type)){
//            if($this->checkFolder($this->mainPathUpload,$id,$type, $this->thumb)){
//
//                $name = Yii::$app->security->generateRandomString(12);
//                $path = $this->getPath().$name.'.'.$data[0]->extension;
//
//                $dbPath = $this->getWebPath().$name.'.'.$data[0]->extension;
//                $dbThumbPath = null;
//
//
//                if($this->thumb){
//                    $thumbPath = $this->getPath().'thumb/'.$name.'.'.$data[0]->extension;
//                    $dbThumbPath =$this->getWebPath().'thumb/'.$name.'.'.$data[0]->extension;
//                    //var_dump($dbThumbPath.'jpg');
//                    Image::crop($data[0]->tempName,$this->thumbSize['x'],$this->thumbSize['y'])
//                        ->save($thumbPath); //['jpeg_quality' => 75]
//                }
//
//                Image::resize($data[0]->tempName,1280)
//                        ->save($path); //['png_compression_level' => 1-9]
//
//                $this->saveDB($dbPath,$dbThumbPath,$id);
//            }
//
//            else {
//                throw new \ErrorException('type and id are required attribute');
//            }
//        }
//    }

    public function uploadImage($data){
        if(!is_null($this->owner->id) && !is_null($this->type)){
            if($this->checkFolder($this->mainPathUpload,$this->owner->id,$this->type, $this->thumb)){

                $name = Yii::$app->security->generateRandomString(12);
                $path = $this->getPath().$name.'.jpg';
                $dbPath = $this->getWebPath().$name.'.jpg';

                $dbThumbPath = null;
                //upload files for temp directory
                $tempName = $name.'.jpg';
                file_put_contents($this->getTempPath().$tempName, $data);

                if($this->thumb){
                    $thumbPath = $this->getPath().'thumb/'.$name.'.jpg';
                    $dbThumbPath =$this->getWebPath().'thumb/'.$name.'.jpg';
                    Image::thumbnail($this->getTempPath().$tempName,450,null)
                        ->save($thumbPath,['jpeg_quality' => 75]); //['jpeg_quality' => 75]
                }

                Image::thumbnail($this->getTempPath().$tempName,1024,null)
                        ->save($path,['jpeg_quality' => 75]); //['png_compression_level' => 1-9]

                $this->saveDB($dbPath,$dbThumbPath,$this->owner->id);
            }

            else {
                throw new \ErrorException('type and id are required attribute');
            }
        }
    }

    public function checkFolder($path,$id, $type, $thumb=true){
        if(!is_dir($path.'/'.$type.'/'.$id)){
            FileHelper::createDirectory($path.'/'.$type.'/'.$id);
            $thumb==true ?  FileHelper::createDirectory($path.'/'.$type.'/'.$id.'/thumb') : null;
            return true;
        }
        return true;
    }

    public function getPath(){
        return $this->mainPathUpload.'/'.$this->type.'/'.$this->owner->id.'/';
    }

    public function getTempPath(){
        if(!is_dir($this->mainPathUpload.'/_temp/'.Yii::$app->user->getId())){
            FileHelper::createDirectory($this->mainPathUpload.'/_temp/'.Yii::$app->user->getId());
        }
        return $this->mainPathUpload.'/_temp/'.Yii::$app->user->getId().'/';
    }

    public function getWebPath(){
        return '/uploads/'.$this->type.'/'.$this->owner->id.'/';
    }

    public function removeFolder($path){
        FileHelper::removeDirectory($path);
    }

    public function getBase64Data($array){
        $data = [];
        if(count($array)==1){
            $data[] = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $array[0]));
        }
        elseif (count($array)>1){
            foreach ($array as $item){
                $data[] = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item));
            }
        }

        return $data;
    }



    public function uploadArrayImages($data){
        foreach ($data as $item){
            $this->uploadImage($item,$this->owner->id, $this->type);
        }
    }

    public function setImages($event){
        $item = Yii::$app->request->post($this->inputName);
        if(empty($item)){
            return false;
        }
        $decode_data = $this->getBase64Data($item);
        if($this->mode==='single' && !is_null($this->mainPathUpload)){
            $this->uploadImage($decode_data);
        }
        else {
            $this->uploadArrayImages($decode_data);
            //return false;
        }
    }

    public function updateImages ($event) {
        $item = Yii::$app->request->post($this->inputName);
        if(empty($item)){
            return false;
        }
        $decode_data = $this->getBase64Data($item);
        if($this->mode==='single' && !is_null($this->mainPathUpload)){
            if(!is_null($this->owner->id) && !is_null($this->type)) {
                Gallery::deleteAll(['assign_id'=>$this->owner->id,'type'=>$this->type]);
                $this->uploadImage($decode_data);
            }
        }
        else {
            if(!is_null($this->owner->id) && !is_null($this->type)) {
                Gallery::deleteAll(['assign_id'=>$this->owner->id,'type'=>$this->type]);
                $this->uploadArrayImages($decode_data);
            }
        }





        $this->uploadImage($decode_data,$this->owner->id, $this->type);
    }

    public function removeImages($event) {
        if (!is_null($this->owner->id) && !is_null($this->type)){
            if(Gallery::remove($this->owner->id,$this->type)){
                $this->removeFolder($this->getPath());
            }
        }
    }

}

