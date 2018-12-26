<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use oboom\gallery\BaseAssetsBundle;
use kartik\file\FileInput;

BaseAssetsBundle::register($this);
?>
<div class="tabContent row">


    <div class="col-lg-12" id="gallery">
        <ul class="list" id="galleryList">
            <?if (!empty($model)):?>
                <li>
                    <img src="<?=Yii::$app->params['webUrl']['front'].$model->thumb_path?>">
                </li>
            <?endif;?>
        </ul>
    </div>
    <div class="col-lg-12 col-md-12">

            <div class="custom-file" id="gallery">
<!--                --><?//= FileInput::widget([
//                     //model'=>$model,
//
//                    'name' => 'Gallery[upload]',
//                    'attribute' => 'upload',
//                    'pluginOptions' => [
//                        'showUpload' => false,
//                        'browseLabel' => '',
//                        'removeLabel' => '',
//
//                        'browseClass' => 'btn btn-primary btn-block',
//                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
//                        'browseLabel' =>  'Выбрать фото',
//
//                        'mainClass' => 'input-group-md',
//                        'initialPreview'=>[
//                            Yii::$app->params['webUrl']['front'].$model->thumb_path ? Yii::$app->params['webUrl']['front'].$model->thumb_path : false ,
//                        ],
//                        'options' => ['accept' => 'image/*'],
//                        'initialPreviewAsData'=>true,
//
//
//                    ]
//                    ]);?>
                <?= HTML::fileInput('Gallery[upload]',null,['class'=>'custom-file-input','id'=>'upload']);?>
                <label class="custom-file-label" for="upload">
                    <span id="uploadText">Выбрать файл</span>
                </label>
            </div>
        <div class="input-group"></div>

    </div>
</div>





