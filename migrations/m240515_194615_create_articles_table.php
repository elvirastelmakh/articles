<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m240515_194615_create_articles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'title' => $this->string(250)->notNull(),
            'picture' => $this->string(300),
            'announcement' => $this->text()->defaultValue(''),
            'text' => $this->text()->defaultValue(''),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-articles-author',
            'articles',
            'author_id'
        );

        $this->addForeignKey(
            'fk-articles-author',
            'articles',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('articles');
    }
}
