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
        return ['parent_id', 'title', 'description'];
    }
}
