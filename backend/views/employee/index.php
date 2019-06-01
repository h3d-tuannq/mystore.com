<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Employees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('<i class="fa fa-plus"></i> Thêm nhân viên', ['create'], ['class' => 'btn btn-success']) ?>
        <?php //echo Html::a('Nhập từ excel <i class="fa fa-upload"></i>', ['import'], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::button('Nhập từ excel <i class="fa fa-upload"></i>',
            [
                'value' => \yii\helpers\Url::to(['employee/import']),
                'title' => 'Nhập từ excel',
                'class' => 'showModalButton btn btn-primary',
                'data-title' => 'Tải lên và nhập dữ liệu danh sách nhân viên từ excel',
            ]); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'slug',
                'options' => ['style' => 'width: 10%'],
            ],

            [
                'attribute' => 'employee_type_id',
                'options' => ['style' => 'width: 66px'],
                'value' => function ($model) {
                    return $model->employeeType ? $model->employeeType->name : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\base\EmployeeType::find()->all(), 'id', 'name'),
            ],
            'name',
            'birth_of_date:date',
            'phone',
            //'identify',
             [
                'attribute' => 'salary',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->salary?:0, 'VND');
                },
            ],

            // 'rate_revenue',
            // 'rate_overtime',
            // 'status',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn','options' => ['style' => 'width: 66px'],],
        ],
    ]); ?>

</div>
