<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this       yii\web\View
 * @var $model      common\models\Article
 * @var $categories common\models\ArticleCategory[]
 */

?>
<?php \yii\widgets\Pjax::begin() ?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
]) ?>

<?php echo $form->field($model, 'attachment')->widget(
    Upload::class,
    [
        'url' => ['/file/storage/upload'],
        'sortable' => true,
        'maxFileSize' => 10000000, // 10 MiB
        'maxNumberOfFiles' => 1,
    ]);
?>

<div class="form-group">
    <?php echo Html::submitButton('Nhập dữ liệu',
        ['class' => 'btn btn-success']) ?>

</div>

<?php ActiveForm::end() ?>

<?php \yii\widgets\Pjax::end() ?>
<?php echo Html::a('Download file mẫu',['template/product-unit.xls'], ['target'=>'_blank','class' => 'btn btn-primary']) ?>
