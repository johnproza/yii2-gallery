<?php

namespace oboom\gallery\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $thumb_path
 * @property string $big_path
 * @property int $is_main
 * @property string $alt
 * @property string $title
 * @property int $sort
 * @property int $assign_id
 * @property string $type_id
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
            [['type_id'], 'required'],
            [['thumb_path', 'big_path'], 'string', 'max' => 60],
            [['alt', 'title'], 'string', 'max' => 120],
            [['type_id'], 'string', 'max' => 45],
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
            'big_path' => 'Big Path',
            'is_main' => 'Is Main',
            'alt' => 'Alt',
            'title' => 'Title',
            'sort' => 'Sort',
            'assign_id' => 'Assign ID',
            'type_id' => 'Type ID',
        ];
    }
}
