<?php

namespace app\models\store;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property StoreImport[] $storeImports
 * @property StoreProduct[] $storeProducts
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[StoreImports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStoreImports()
    {
        return $this->hasMany(StoreImport::class, ['store_id' => 'id']);
    }

    /**
     * Gets query for [[StoreProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStoreProducts()
    {
        return $this->hasMany(StoreProduct::class, ['store_id' => 'id']);
    }
}
