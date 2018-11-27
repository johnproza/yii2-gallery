<?php

namespace oboom\gallery;

use Yii;
use yii\helpers\Inflector;


class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'default';
    public $controllerNamespace = 'oboom\gallery\controllers';
    public $mainLayout = '@oboom/gallery/views/layouts/main.php';

}
