<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Danh sách Làm dịch vụ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index" style="min-height: 1200px">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Thêm Làm dịch vụ', ['do-service'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'customer_name',
            [
                'attribute' => 'customer_id',
                'label' => 'Mã KH',
                'options' => ['style' => 'width: 20%'],
                'value' => function ($model) {
                    return $model->customer ? Html::a($model->customer->getFull(),
                        [
                            'customer/view', 'id' => $model->customer_id
                        ],
                        [
                            'title' => 'Xem chi tiết KH ' . $model->customer->slug
                        ]) : null;
                },
                'format' => 'raw',
                'filter' => \kartik\widgets\Select2::widget([
                    'name' => 'ActivitySearch[customer_id]',
                    'model' => $searchModel,
                    'value' => $searchModel->customer_id,
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->select(['*',' Concat(slug," - ",name) as full'])->all(), 'id', 'full'),
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'options' => ['placeholder' => 'Chọn khách hàng ...', 'prompt' => 'Tất cả'],
                ]),
                'filterInputOptions' => ['class' => 'form-control',
                    'id' => null,
                    'prompt' => 'Tất cả'],
            ],
//            [
//                'attribute' => 'customer_id',
//                //'options' => ['style' => 'width: 10%'],
//                'value' => function ($model) {
//                    return $model->customer ? Html::a($model->customer->name,
//                        [
//                            'customer/view', 'id' => $model->customer_id
//                        ],
//                        [
//                            'title' => 'Xem chi tiết KH ' . $model->customer->name
//                        ]) : null;
//                },
//                'format' => 'raw',
//                'filter' => \kartik\widgets\Select2::widget([
//                    'name' => 'ActivitySearch[customer_id]',
//                    'model' => $searchModel,
//                    'value' => $searchModel->customer_id,
//                    'pluginOptions' => [
//                        'allowClear' => true,
//                    ],
//                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->all(), 'id', 'name'),
//                    'options' => ['placeholder' => 'Chọn khách hàng ...', 'prompt' => 'Tất cả'],
//                ]),
//                'filterInputOptions' => ['class' => 'form-control',
//                    'id' => null,
//                    'prompt' => 'Tất cả'],
//            ],
            //'customer_id',
            //'service_id',
            [
                'attribute' => 'service_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->service ? $model->service->name : null;
                },
                'filter' => \kartik\widgets\Select2::widget([
                    'name' => 'ActivitySearch[service_id]',
                    'model' => $searchModel,
                    'value' => $searchModel->service_id,
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Service::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Chọn dịch vụ ...', 'prompt' => 'Tất cả'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
                'filterInputOptions' => ['class' => 'form-control',
                    'id' => null,
                    'prompt' => 'Tất cả'],
            ],
            [
                'attribute' => 'employee_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->employee ? $model->employee->name : null;
                },
                'filter' => \kartik\widgets\Select2::widget([
                    'name' => 'ActivitySearch[employee_id]',
                    'model' => $searchModel,
                    'value' => $searchModel->employee_id,
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'options' => ['placeholder' => 'Chọn nhân viên ...', 'prompt' => 'Tất cả'],
                ]),
                'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'Tất cả'],
            ],
            [
                'attribute' => 'discount',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    if (!$model->discount) {
                        $model->discount = 0;
                    }
                    return Yii::$app->formatter->asCurrency($model->discount, 'VND');
                },
                'format' => 'raw'
            ],
            'start_time:datetime',
            'end_time:datetime',
            'bed',
            // 'note',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 80px'],
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
