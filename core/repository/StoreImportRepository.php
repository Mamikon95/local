<?php

namespace app\core\repository;

use app\models\store\StoreImport;

class StoreImportRepository
{
    /**
     * @param array $ids
     * @return StoreImport[]
     */
    public function getByIds(array $ids): array
    {
        return StoreImport::find()
            ->andWhere(['id' => $ids])
            ->orderBy('id desc')
            ->all();
    }
}