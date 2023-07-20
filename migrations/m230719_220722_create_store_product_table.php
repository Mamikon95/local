<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%store_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%store}}`
 */
class m230719_220722_create_store_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%store_product}}', [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer(),
            'upc' => $this->string(32)->notNull(),
            'title' => $this->string(64)->notNull(),
            'price' => $this->float()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-store_product-upc}}',
            '{{%store_product}}',
            'upc'
        );

        // creates index for column `store_id`
        $this->createIndex(
            '{{%idx-store_product-store_id}}',
            '{{%store_product}}',
            'store_id'
        );

        // add foreign key for table `{{%store}}`
        $this->addForeignKey(
            '{{%fk-store_product-store_id}}',
            '{{%store_product}}',
            'store_id',
            '{{%store}}',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%store}}`
        $this->dropForeignKey(
            '{{%fk-store_product-store_id}}',
            '{{%store_product}}'
        );

        // drops index for column `store_id`
        $this->dropIndex(
            '{{%idx-store_product-store_id}}',
            '{{%store_product}}'
        );

        $this->dropIndex(
            '{{%idx-store_product-upc}}',
            '{{%store_product}}'
        );

        $this->dropTable('{{%store_product}}');
    }
}
