<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%store_import}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%store}}`
 */
class m230719_221929_create_store_import_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%store_import}}', [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer(),
            'file' => $this->string(32),
            'import_count' => $this->integer()->defaultValue(0),
            'error_count' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->integer(),
        ]);

        // creates index for column `store_id`
        $this->createIndex(
            '{{%idx-store_import-store_id}}',
            '{{%store_import}}',
            'store_id'
        );

        // add foreign key for table `{{%store}}`
        $this->addForeignKey(
            '{{%fk-store_import-store_id}}',
            '{{%store_import}}',
            'store_id',
            '{{%store}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%store}}`
        $this->dropForeignKey(
            '{{%fk-store_import-store_id}}',
            '{{%store_import}}'
        );

        // drops index for column `store_id`
        $this->dropIndex(
            '{{%idx-store_import-store_id}}',
            '{{%store_import}}'
        );

        $this->dropTable('{{%store_import}}');
    }
}
