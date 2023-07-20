<?php

namespace app\models\store;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "store_import".
 *
 * @property int $id
 * @property int|null $store_id
 * @property string|null $file
 * @property string|null $type
 * @property int|null $import_count
 * @property int|null $error_count
 * @property int|null $status
 * @property int|null $created_at
 *
 * @property Store $store
 */
class StoreImport extends ActiveRecord
{
    const FILE_DIR = 'files';

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store_import';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'import_count', 'error_count', 'created_at', 'status'], 'integer'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::class, 'targetAttribute' => ['store_id' => 'id']],
            [['file', 'type'], 'string']
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
            'status' => 'Status',
            'file' => 'File',
            'type' => 'Type',
            'import_count' => 'Import Count',
            'error_count' => 'Error Count',
            'created_at' => 'Created At',
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
