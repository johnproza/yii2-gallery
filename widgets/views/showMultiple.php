<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:21
 */

?>
<?if (!empty($data)):?>
    <ul>
        <?foreach ($data as $item) :?>
           <li><img src = "<?=Yii::$app->params['webUrl']['front'].$item->thumb_path;?>"  <?= $className!=null ? "class=".$className : false ;?> /></li>
        <?endforeach;?>
    </ul>
<?endif;?>

