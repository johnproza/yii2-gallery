<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use oboom\gallery\BaseAssetsBundle;
use kartik\file\FileInput;

BaseAssetsBundle::register($this);
?>
<div class="tabContent row">
    <div class="col-lg-12" id="gallery" data-id="<?=$modelId?>"
         data-type="<?=$modelType?>"
         data-max="<?=$max?>"
         data-host="<?=Yii::$app->params['webUrl']['front']?>">

    </div>
<!--    <div class="list col-lg-12" id="galleryList">-->
<!--        --><?//if (!empty($data)):?>
<!--            <div class="itemGallery">-->
<!--                <img src="--><?//=Yii::$app->params['webUrl']['front'].$data->thumb_path?><!--">-->
<!--            </div>-->
<!--        --><?//endif;?>
<!--    </div>-->
</div>





