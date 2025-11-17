<?php
namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;


class Book extends ActiveRecord
{
    public static function tableName() {
        return 'book';
    }


    public function rules() {
        return [
            [['title','author'],'required'],
            [['description'],'string'],
            [['published_at'],'date','format'=>'php:Y-m-d'],
            [['title','author'],'string','max'=>255],
        ];
    }


    public function behaviors() {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
            ],
        ];
    }


    public function getCreator() {
        return $this->hasOne(User::class, ['id'=>'created_by']);
    }
}