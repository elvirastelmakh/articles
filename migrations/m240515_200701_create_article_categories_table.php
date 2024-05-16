<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_categories`.
 */
class m240515_200701_create_article_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_categories', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);
        $this->createIndex(
            'idx-article_categories-article_category',
            'article_categories',
            ['article_id', 'category_id'],
            true
        );
        $this->addForeignKey(
            'fk-article_categories-article',
            'article_categories',
            'article_id',
            'articles',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-article_categories-category',
            'article_categories',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_categories');
    }
}
