<?php

use yii\db\Migration;

/**
 * Handles the creation of table `authors`.
 */
class m240515_193156_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('authors', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(250)->notNull(),
            'birth_year' => $this->integer()->notNull(),
            'biography' => $this->text()->notNull()->defaultValue('')
        ]);
        $this->createIndex(
            'idx-authors-full_name-birth_year',
            'authors',
            ['full_name', 'birth_year'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('authors');
    }
}
