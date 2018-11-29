<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 13:20
 */

namespace oboom\gallery;
use yii\web\AssetBundle;

class BaseAssetsBundle extends AssetBundle
{
    public $sourcePath = '@vendor/johnproza/yii2-gallery/assets';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/script.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}