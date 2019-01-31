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
</div>





