<?php

namespace app\core\services\assembler;

use app\core\forms\StoreUploadForm;
use app\core\services\assembler\dto\StoreImportDto;

class StoreImportAssembler
{
    public function assemble(StoreUploadForm $form): StoreImportDto
    {
        $dto = new StoreImportDto();
        $dto->setStoreId($form->storeId);
        $dto->setFile($form->file);

        return $dto;
    }
}