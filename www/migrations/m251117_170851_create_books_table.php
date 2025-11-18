<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m251117_170851_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'description' => $this->text(),
            'published_at' => $this->date(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);


        $this->addForeignKey(
            'fk_book_user',
            'book',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_book_user', 'book');
        $this->dropTable('book');
    }
}
