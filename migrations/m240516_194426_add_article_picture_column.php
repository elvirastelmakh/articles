<?php

use yii\db\Migration;

/**
 * Class m240516_194426_add_article_picture_column
 */
class m240516_194426_add_article_picture_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('articles', 'picture');
        $this->addColumn('articles', 'picture', $this->binary());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles', 'picture');
        $this->addColumn('articles', 'picture', $this->string());
    }
}
