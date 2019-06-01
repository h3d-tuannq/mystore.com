<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap\ActiveForm */
?>
<div class="product-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <h3>Thông tin cơ bản</h3>
                    <?php echo $form->field($model, 'product_type_id',
                        ['template' => '{label}<div class="input-group">
                {input}
                '.Html::a(Html::tag('i','',['class'=>'fa fa-plus']),
                                ['product-type/create'],
                                ['class'=>'input-group-addon btn btn-success','target'=>'_blank']).'
              </div>'])->dropDownList(\yii\helpers\ArrayHelper::map(
                        $product_types,
                        'id',
                        'name'
                    ), ['prompt' => '']) ?>
                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <?php echo $form->field($model, 'product_unit_id')->dropDownList(\yii\helpers\ArrayHelper::map(
	                    \common\models\ProductUnit::find()->all(),
	                    'id',
	                    'name'
                    ), ['prompt' => '']) ?>

                    <?php echo $form->field($model, 'quantity')->textInput() ?>


                    <?php echo $form->field($model, 'status')->dropDownList(\common\models\Common::statuses()) ?>

                    <?php echo $form->field($model, 'product_date')->widget(
                        \trntv\yii\datetime\DateTimeWidget::class,
                        [
                            'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
                        ]
                    ) ?>
                    <?php echo $form->field($model, 'product_time_use')->textInput() ?>

                    <?php echo $form->field($model, 'is_notification')->checkbox() ?>

                    <?php echo $form->field($model, 'limit_quantity')->textInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-body">
                    <h3>Sản phẩm dùng cho dịch vụ</h3>
                    <?php echo $form->field($model, 'input_price')->textInput() ?>

                    <?php echo $form->field($model, 'retail_price')->textInput() ?>

                    <?php echo $form->field($model, 'rate_employee')->textInput(['maxlength' => true]) ?>

                    <?php echo $form->field($model, 'discount_money')->textInput() ?>
                    <?php echo $form->field($model, 'specification')->textInput() ?>
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
