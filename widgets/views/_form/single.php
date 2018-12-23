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

            <div class="custom-file">
                <?= HTML::fileInput('Gallery[upload]',null,['class'=>'custom-file-input','id'=>'upload']);?>
                <label class="custom-file-label" for="upload"><i class="icon ion-md-cloud-upload iconBase"></i>Выбрать файл</label>
            </div>
        <div class="input-group"></div>

    </div>
</div>





