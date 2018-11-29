<?php

namespace oboom\gallery\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $thumb_path
 * @property string $path
 * @property int $is_main
 * @property string $alt
 * @property string $title
 * @property int $sort
 * @property int $assign_id
 * @property string $type
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $upload;

    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_main', 'sort', 'assign_id'], 'integer'],
            [['type'], 'required'],
            [['thumb_path', 'path'], 'string', 'max' => 200],
            [['alt', 'title'], 'string', 'max' => 120],
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb_path' => 'Thumb Path',
            'path' => 'Big Path',
            'is_main' => 'Is Main',
            'alt' => 'Alt',
            'title' => 'Title',
            'sort' => 'Sort',
            'assign_id' => 'Assign ID',
            'type' => 'Type ID',
        ];
    }

    static function getData($id,$type){
        return Gallery::find()->where(['assign_id'=>$id,'type'=>$type])->limit(1)->one();
    }

    static function remove($id,$type){
        return Gallery::deleteAll(['assign_id' =>$id, 'type'=>$type]);
    }
}
