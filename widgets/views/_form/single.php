<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use oboom\gallery\BaseAssetsBundle;
BaseAssetsBundle::register($this);
?>
<div class="tabContent row">


    <div class="col-lg-12" id="gallery">
        <?if (!empty($model)):?>
            <div class="col-lg-2 col-md-3 col-sm-4 imgItem">
                <img src="<?=Yii::$app->params['webUrl']['front'].$model->thumb_path?>">
                <div class="imgBar"></div>
            </div>
        <?endif;?>
    </div>
    <div class="col-lg-12 col-md-12">
        <?= HTML::fileInput('Gallery[upload]');?>
    </div>
</div>





