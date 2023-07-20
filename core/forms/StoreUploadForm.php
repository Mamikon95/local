<?php
namespace app\core\forms;

use app\core\services\assembler\dto\StoreImportDto;
use app\core\services\assembler\StoreImportAssembler;
use app\core\services\StoreImportService;
use app\models\store\Store;
use yii\base\Model;

class StoreUploadForm extends Model
{
    public $storeId;

    public $file;

    private StoreImportAssembler $storeImportAssembler;

    public function __construct(
        StoreImportAssembler $storeImportAssembler,
        $config = []
    )
    {
        $this->storeImportAssembler = $storeImportAssembler;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['storeId'], 'integer'],
            [['storeId'], 'required'],
            [['storeId'], 'exist', 'targetClass' => Store::class, 'targetAttribute' => 'id'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => StoreImportService::CSV_EXT, 'checkExtensionByMimeType' => false, 'maxSize' => 5 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'storeId' => 'Store',
            'file' => 'File'
        ];
    }

    public function getDto(): StoreImportDto
    {
        return $this->storeImportAssembler->assemble($this);
    }
}