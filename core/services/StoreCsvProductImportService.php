<?php

namespace app\core\services;

use app\models\store\StoreImport;
use Yii;

class StoreCsvProductImportService implements StoreFileProductImportInterface
{
    public function import(StoreImport  $storeImport): void
    {
        $file = Yii::getAlias('@webroot' . DIRECTORY_SEPARATOR . StoreImport::FILE_DIR . DIRECTORY_SEPARATOR . $storeImport->file);
        $csvArray = array_map('str_getcsv', file($file));

        var_dump($csvArray);exit;
    }
}