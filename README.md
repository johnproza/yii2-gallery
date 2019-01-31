Images Gallery
==============
Images Gallery with react fronend

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist johnproza/yii2-gallery "*"
```

or add

```
"johnproza/yii2-gallery": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Before using you must prepare database
```php
php yii migrate --migrationPath=@vendor/johnproza/yii2-gallery/migrations 
```

Module setup
------------

Insert into your config file
```php
'modules' => [
    'news' => [
        'class' => 'oboom\gallery\Module',
    ],
]
```

Model usage
------------

Insert into your model file (like behaviors)
```php
public function behaviors()
{
    return [
        [
            'class' => 'oboom\gallery\behaviors\AttachGallery',
            'mainPathUpload'=>Yii::$app->params['uploadPath'].'/uploads',
            'mode'=>'multiple', // mode of upload ("single" or "multiple")
            'type' => 'news', // type of gallery (may be have a different string value)
            'thumbSize'=>[ 
                'x'=>600, 
                'y'=>480
            ] // size of thumbSize
        ],
    ];
}
```

Params / path setup
------------

insert into your params-local.php file params for correct work

```php
return [
    ......
    'uploadPath' => '/server/path/to/frontend/web',
    'webUrl' => [
        'back' => 'http://admin.yourwebsite.com',
        'front' => 'http://yourwebsite.com',
    ]
];
```

Widget usage
------------

Insert into your view file
```php
use oboom\gallery\widgets\GalleryWidgets;
.....
.....
GalleryWidgets::widget([
    'model'=>$items, // model 
    'type'=>'news', // type of gallery (may be have a different string value)
    'max'=>5, //max upload files
    'params'=>[
        'type'=>'single', // mode of upload ("single" or "multiple")
        'className'=>'avator-img' // css classname for custom stylization
    ],
])
```