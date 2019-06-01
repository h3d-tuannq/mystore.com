<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <h3>Thông tin cơ bản</h3>

                        <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?php echo $form->field($model, 'slug')
                                        ->textInput(['maxlength' => true])->hint('Mã sẽ tự sinh theo tên nếu để trống.') ?>

                        <?php echo $form->field($model, 'birth_of_date')->widget(
                            \trntv\yii\datetime\DateTimeWidget::class,
                            [
                                'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
                            ]
                        ) ?>
                        <?php echo $form->field($model, 'customer_type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\base\CustomerType::find()->all(),'id','name')) ?>
                        <?php echo $form->field($model, 'account_money')->textInput() ?>
                        <?php echo $form->field($model, 'remain_money')->textInput() ?>


                        <?php echo $form->field($model, 'status')->dropDownList(\common\models\Common::statuses()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-body">
                    <h3>Thông tin thêm</h3>
                        <?php echo $form->field($model, 'source')->textInput() ?>
                        <?php echo $form->field($model, 'email')->textInput() ?>
                        <?php echo $form->field($model, 'phone')->textInput() ?>
                        <?php echo $form->field($model, 'identify')->textInput() ?>
                        <?php echo $form->field($model, 'address')->textarea() ?>
                    <?php echo $form->field($model, 'is_notification_birthday')->checkbox() ?>
                    <?php echo $form->field($model, 'is_notification_service')->checkbox() ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-body">
                    <?php echo $form->field($model, 'thumbnail')->widget(
                        \trntv\filekit\widget\Upload::class,
                        [
                            'url' => ['/file/storage/upload'],
                            'maxFileSize' => 5000000, // 5 MiB
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
