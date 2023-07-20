<?php

namespace app\models\store;

use Yii;

/**
 * This is the model class for table "store_product".
 *
 * @property int $id
 * @property int|null $store_id
 * @property string $upc
 * @property string $title
 * @property float $price
 *
 * @property Store $store
 */
class StoreProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id'], 'integer'],
            [['upc', 'title', 'price'], 'required'],
            [['price'], 'number'],
            [['upc'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 64],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::class, 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'upc' => 'Upc',
            'title' => 'Title',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Store]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }
}
