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


    public function init()
    {
        parent::init();
        //$this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['oboom/gallery/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@vendor/johnproza/yii2-gallery/messages',
//            'fileMap' => [
//                'oboom/users/validation' => 'validation.php',
//                'modules/users/form' => 'form.php',
//            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('oboom/gallery/' . $category, $message, $params, $language);
    }
}
