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
        'css/style.css',
        //'css/cropper.min.css',
        'css/jcrop.css',
    ];
    public $js = [
        'js/jcrop.js',
        //'js/cropper.min.js',
        'js/script.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\CanvasBlobAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}