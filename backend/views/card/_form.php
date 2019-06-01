<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Card */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'card_type',['template' => '{label}<div class="input-group">
                {input}
                '.Html::a(Html::tag('i','',['class'=>'fa fa-plus']),
                    ['card-type/create'],
                    ['class'=>'input-group-addon btn btn-success','target'=>'_blank']).'
              </div>'])->dropDownList(\yii\helpers\ArrayHelper::map(
                $card_types,
                'id',
                'name'
            ), ['prompt' => '']) ?>
            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Tự động sinh ra theo tên nếu để trống') ?>

            <?= $form->field($model, 'retail_price',['template' => '{label}<div class="input-group">
                {input}
                <span class="input-group-addon">VNĐ</span>
              </div>']
                ) ?>

            <?= $form->field($model, 'bonus_price',['template' => '{label}<div class="input-group">
                {input}
                <span class="input-group-addon">VNĐ</span>
              </div>']
            ) ?>


            <?= $form->field($model, 'raw_price',['template' => '{label}<div class="input-group">
                {input}
                <span class="input-group-addon">VNĐ</span>
              </div>']
            ) ?>
        </div>
        <div class="col-md-6">

            <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'rate_employee',['template' => '{label}<div class="input-group">
                {input}
                <span class="input-group-addon">%</span>
              </div>']
            ) ?>

            <?php echo $form->field($model, 'discount_money')->textInput() ?>

            <?php echo $form->field($model, 'status')->dropDownList(\common\models\Common::statuses()) ?>
        </div>

    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>



<!--    --><?php //echo $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?php //echo $form->field($model, 'updated_at')->textInput() ?>
<!---->
<!--    --><?php //echo $form->field($model, 'created_by')->textInput() ?>
<!---->
<!--    --><?php //echo $form->field($model, 'updated_by')->textInput() ?>


    <?php ActiveForm::end(); ?>

</div>
