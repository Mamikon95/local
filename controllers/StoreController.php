<?php

namespace app\controllers;

use app\core\forms\StoreUploadForm;
use app\core\repository\StoreRepository;
use app\core\services\StoreImportService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class StoreController extends Controller
{
    // Other controller code

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'uploadFile' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionUpload()
    {
        $form = Yii::$container->get(StoreUploadForm::class);
        $storeRepository = Yii::$container->get(StoreRepository::class);

        return $this->render('upload', [
            'modelForm' => $form,
            'storeList' => ArrayHelper::map($storeRepository->getAll(), 'id', 'title')
        ]);
    }

    public function actionUploadFile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $form = Yii::$container->get(StoreUploadForm::class);
        $storeImportService = Yii::$container->get(StoreImportService::class);

        if($form->load(Yii::$app->request->post())) {
            $form->file = UploadedFile::getInstance($form, 'file');

            if($form->validate()) {
                try {
                    $importId = $storeImportService->add($form->getDto());
                } catch (\Exception $e) {
                    return ['success' => false, 'message' => $e->getMessage()];
                }

                return ['success' => true, 'message' => $importId];
            } else {
                return ['success' => false, 'message' => 'validation error'];
            }
        }

        return ['success' => 'false', 'message' => 'file not uploaded'];
    }
}
