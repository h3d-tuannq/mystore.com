<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'service_type_id', ['template' => '{label}<div class="input-group">
                {input}
                ' . Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']),
                    ['service-type/create'],
                    ['class' => 'input-group-addon btn btn-success', 'target' => '_blank']) . '
              </div>'])->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\ServiceType::find()->all(),
                'id',
                'name'
            ), ['prompt' => '']) ?>


            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Tự động sinh ra theo tên nếu để trống') ?>

            <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?php echo $form->field($model, 'total_price')->textInput() ?>
            <?php echo $form->field($model, 'discount_of_employee')->textInput() ?>
            <?php echo $form->field($model, 'discount_money')->textInput() ?>

            <?php echo $form->field($model, 'retail_price')->textInput() ?>

            <?php echo $form->field($model, 'status')->checkbox() ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'thumbnail')->widget(
                \trntv\filekit\widget\Upload::class,
                [
                    'url' => ['/file/storage/upload'],
                    'maxFileSize' => 5000000, // 5 MiB
                ]);
            ?>

            <?php echo $form->field($model, 'number_serve')->textInput() ?>

            <?php echo $form->field($model, 'number_day')->textInput() ?>

            <?php echo $form->field($model, 'duration')->textInput() ?>
            <?php echo $form->field($model, 'on_time')->textInput() ?>

            <?php echo $form->field($model, 'remain_time')->textInput() ?>

            <?php echo $form->field($model, 'warranty')->textInput() ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
