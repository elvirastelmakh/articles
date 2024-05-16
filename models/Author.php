<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    /**
     * Table name.
     * @var string
     */
    static $_table = 'authors';

    public static function tableName()
    {
        return self::$_table;
    }

    public function safeAttributes()
    {
        return ['full_name', 'birth_year', 'biography'];
    }
}
