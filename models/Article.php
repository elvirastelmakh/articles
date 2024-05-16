<?php

namespace app\models;

use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    /**
     * Table name.
     * @var string
     */
    static $_table = 'articles';

    public static function tableName()
    {
        return self::$_table;
    }

    public function safeAttributes()
    {
        return ['title', 'picture', 'announcement', 'text', 'author_id'];
    }

    public function fields()
    {
        $fields = parent::fields();
        
        $fields['picture'] = function() {
            return base64_encode($this->picture);
        };
        unset($fields['author_id']);

        return $fields;
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('article_categories', ['article_id' => 'id']);
    }

    public function extraFields()
    {
        return ['author', 'categories'];
    }        
        
}
