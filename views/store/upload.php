<?php

use app\core\forms\StoreUploadForm;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $storeList */
/** @var StoreUploadForm $modelForm */

$this->registerJsFile('/js/fileUpload.js', ['depends' => [JqueryAsset::class]]);
?>

<div id="file-upload">
    <?php $form = ActiveForm::begin(['id' => 'file-upload-form', 'validateOnSubmit' => false, 'options' => ['enctype' => 'multipart/form-data']])?>
        <?=$form->field($modelForm, 'storeId')->dropDownList($storeList)?>

        <?=$form->field($modelForm, 'file')->fileInput(['accept' => '.csv'])?>

        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    <?php ActiveForm::end();?>
</div>