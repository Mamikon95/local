<?php

use yii\db\Migration;

/**
 * Class m230720_053103_fill_store_table
 */
class m230720_053103_fill_store_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('store', ['title'], [
            ['Aliexpress'],
            ['Amazon'],
            ['Alibaba']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230720_053103_fill_store_table cannot be reverted.\n";

        return false;
    }
}
