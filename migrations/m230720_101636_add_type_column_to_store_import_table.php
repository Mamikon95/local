<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%store_import}}`.
 */
class m230720_101636_add_type_column_to_store_import_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%store_import}}', 'type', $this->string(12)->after('file'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%store_import}}', 'type');
    }
}
