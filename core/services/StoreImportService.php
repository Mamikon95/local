<?php

namespace app\core\services;

use app\core\repository\StoreImportRepository;
use app\core\services\assembler\dto\StoreImportDto;
use app\models\store\StoreImport;
use Yii;

class StoreImportService
{
    const CSV_EXT = 'csv';

    private array $importToProcessIds = [];
    private array $inProcessStoreIds = [];

    private StoreImportRepository  $storeImportRepository;

    public function __construct(
        StoreImportRepository  $storeImportRepository
    )
    {
        $this->storeImportRepository = $storeImportRepository;
    }

    public function add(StoreImportDto $storeImportDto): ?int
    {
        $fileName = uniqid(true) . '.' . $storeImportDto->getFile()->getExtension();
        $file = $this->getDir() . '/' . $fileName;

        $transaction = Yii::$app->db->beginTransaction();
        $storeImportModel = new StoreImport();
        $storeImportDto->getFile()->saveAs($file);

        if(file_exists($file)) {
            $storeImportModel->store_id = $storeImportDto->getStoreId();
            $storeImportModel->file = $fileName;
            $storeImportModel->type = $storeImportDto->getFile()->extension;

            if($storeImportModel->save()) {
                $transaction->commit();
            } else {
                unlink($file);
                $transaction->rollBack();

                throw new \Exception('Error save file');
            }
        } else {
            throw new \Exception('Error upload file');
        }

        return $storeImportModel->id;
    }

    public function import(): void
    {
        if($this->importToProcessIds) {
            $storeImportModels = $this->storeImportRepository->getByIds($this->importToProcessIds);

            if($storeImportModels) {
                $currentImportModel = null;

                do {
                    foreach($storeImportModels as $storeImport) {
                        if(!in_array($storeImport->store_id, $this->inProcessStoreIds)) {
                            $currentImportModel = $storeImport;
                        }
                    }
                } while(!$currentImportModel);

                $this->inProcessStoreIds[] = $currentImportModel->store_id;

                $importClass = $this->getFileImportObject($currentImportModel->type);

                $importClass->import($currentImportModel);
            }
        }
    }

    public function getDir(): string
    {
        return Yii::getAlias('@webroot' . DIRECTORY_SEPARATOR . StoreImport::FILE_DIR);
    }

    public function getFileImportObject($type): StoreFileProductImportInterface
    {
        return Yii::$container->get($this->ImportClassesMap()[$type]);
    }

    public function ImportClassesMap(): array
    {
        return [
            self::CSV_EXT => StoreCsvProductImportService::class
        ];
    }

    /**
     * @param int $id
     */
    public function addImportToProcessId(int $id): void
    {
        $this->importToProcessIds[] = $id;
    }

    /**
     * @return array
     */
    public function getImportToProcessIds(): array
    {
        return $this->importToProcessIds;
    }
}