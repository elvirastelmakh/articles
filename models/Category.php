<?php

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    /**
     * Table name.
     * @var string
     */
    static $_table = 'categories';

    public static function tableName()
    {
        return self::$_table;
    }

    public function safeAttributes()
    {
        return ['parent_id', 'title', 'description', 'parent'];
    }

    public function fields()
    {
        $fields = parent::fields();

        return $fields;
    }
    public function extraFields()
    {
        return ['parent'];
    }
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }
}
