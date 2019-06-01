<?php

use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\ProductSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => ['run-report'],
        'method' => 'post',
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'year')->dropDownList(['2019' => '2019', '2018' => '2018'],
                ['placeholder' => 'Chọn  ...', 'prompt' => 'Năm']) ?>
            <?php echo $form->field($model, 'month')->dropDownList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            ], ['placeholder' => 'Chọn  ...', 'prompt' => 'Tháng']) ?>
            <?php echo $form->field($model, 'day')->dropDownList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20',
                '21' => '21',
                '22' => '22',
                '23' => '23',
                '24' => '24',
                '25' => '25',
                '26' => '26',
                '27' => '27',
                '28' => '28',
                '29' => '29',
                '30' => '30',
                '31' => '31',
            ], ['placeholder' => 'Chọn  ...', 'prompt' => 'Ngày']) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('backend', 'Tạo báo cáo'), ['class' => 'btn btn-primary']) ?>
                <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <br/>


    <?php ActiveForm::end(); ?>

    <p class="text-info">
        Ghi chú:
         <ul>
            <li>Khi chọn đầy đủ ngày tháng năm thì sẽ tạo báo cáo cho ngày đó</li>
            <li>Khi chọn tháng năm thì sẽ tạo báo cáo cho tất cả các ngày trong tháng đó</li>
        </ul>
    </p>
    <br/>
    <br/>
    <p>
        <?php echo Html::a('<i class="fa fa-arrow-left"></i> Doanh thu', ['index'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
