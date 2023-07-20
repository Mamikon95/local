<?php

namespace app\core\services;

use app\models\store\StoreImport;

interface StoreFileProductImportInterface
{
    public function import(StoreImport  $storeImport): void;
}