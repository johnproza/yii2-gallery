<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:21
 */

?>
<?if (!empty($data)):?>
    <img src = "<?=Yii::$app->params['webUrl']['front'].$data->thumb_path;?>"  <?= $className!=null ? "class=".$className : false ;?> />
<?endif;?>
