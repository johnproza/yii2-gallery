<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:21
 */

//use yii\helpers\Url;
//use oboom\menu\FrontAssetsBundle;

//FrontAssetsBundle::register($this);
?>
<?if (!empty($data)):?>
    <img src = "<?=Yii::$app->params['webUrl']['front'].$data->thumb_path;?>"  <?= $className!=null ? "class=".$className : false ;?> />
<?endif;?>
