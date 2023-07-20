<?php

namespace app\core\repository;

use app\models\store\Store;

class StoreRepository
{
    public function getAll(): array
    {
        return Store::find()->all();
    }
}