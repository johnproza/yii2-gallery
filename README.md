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

Insert into your view file for upload images
```php
use oboom\gallery\widgets\GalleryWidgets;
.....
.....
<?= GalleryWidgets::widget([
    'model'=>$items, // model 
    'type'=>'news', // type of gallery (may be have a different string value)
    'max'=>5, //max upload files
    'params'=>[
        'aspectRatio'=>[16,9],
        'type'=>'single', // mode of upload ("single" or "multiple")
        'className'=>'avator-img' // css classname for custom stylization
    ],
]); ?>
```

Insert into your view file for output images
```php
use oboom\gallery\widgets\GalleryWidgets;
.....
.....
<?= GalleryWidgets::widget([
    'model'=>$item['item'], // model
    'type'=>'news', // type of gallery (may be have a different string value)
    'show_main'=>true, // if you want to show main image for model
    'params'=>[
        'type'=>'showSingle', // if you want to show one image
        'className'=>'image'
    ],
]); ?>
```

Insert into your view file for output images into your custom view
```php
use oboom\gallery\widgets\GalleryWidgets;
.....
.....
<?= GalleryWidgets::widget([
    'model'=>$item['item'], // model
    'type'=>'news', // type of gallery (may be have a different string value)
    'template'=>"@app/themes/base/views/dev/gallery", // path to your view
    'show_main'=>true, // if you want to show main image for model
    'params'=>[
        'type'=>'data', // if you want to show all images
        'className'=>'image'
    ],
]); ?>

...
custom view

<?if (!empty($data)):?>
    <ul>
        <?foreach ($data as $item) :?>
            <li>
                <a href="<?=Yii::$app->params['webUrl']['front'].$item->path;?>">
                    <img src = "<?=Yii::$app->params['webUrl']['front'].$item->thumb_path;?>"  <?= $className!=null ? "class=".$className : false ;?> />
                </a>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>

```
