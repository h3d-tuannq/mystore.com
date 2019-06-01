<?php
use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#service" data-toggle="tab" aria-expanded="true">Các Dịch vụ đã làm</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="service">
            <!-- Post -->
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->render('_search_service', ['model' => $searchModel,'employee_id'=>$model->id]); ?>
                    <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            //'customer_name',
//                            [
//                                'attribute' => 'customer_id',
//                                'label' => 'Mã KH',
//                                'options' => ['style' => 'width: 20%'],
//                                'value' => function ($model) {
//                                    return $model->customer ? Html::a($model->customer->getFull(),
//                                        [
//                                            'customer/view', 'id' => $model->customer_id
//                                        ],
//                                        [
//                                            'title' => 'Xem chi tiết KH ' . $model->customer->slug
//                                        ]) : null;
//                                },
//                                'format' => 'raw',
//                                'filter' => \kartik\widgets\Select2::widget([
//                                    'name' => 'ActivitySearch[customer_id]',
//                                    'model' => $searchModel,
//                                    'value' => $searchModel->customer_id,
//                                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->select(['*',' Concat(slug," - ",name) as full'])->all(), 'id', 'full'),
//                                    'pluginOptions' => [
//                                        'allowClear' => true,
//                                    ],
//                                    'options' => ['placeholder' => 'Chọn khách hàng ...', 'prompt' => 'Tất cả'],
//                                ]),
//                                'filterInputOptions' => ['class' => 'form-control',
//                                    'id' => null,
//                                    'prompt' => 'Tất cả'],
//                            ],
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
//                            [
//                                'attribute' => 'employee_id',
//                                //'options' => ['style' => 'width: 10%'],
//                                'value' => function ($model) {
//                                    return $model->employee ? $model->employee->name : null;
//                                },
//                                'filter' => \kartik\widgets\Select2::widget([
//                                    'name' => 'ActivitySearch[employee_id]',
//                                    'model' => $searchModel,
//                                    'value' => $searchModel->employee_id,
//                                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
//                                    'pluginOptions' => [
//                                        'allowClear' => true,
//                                    ],
//                                    'options' => ['placeholder' => 'Chọn nhân viên ...', 'prompt' => 'Tất cả'],
//                                ]),
//                                'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'Tất cả'],
//                            ],
                                                        [
                                'attribute' => 'count_time',
                                'label' => 'Số lần',
                            ],
                            [
                                'attribute' => 'total_money',
                                'label' => 'Tổng tiền',
                                //'options' => ['style' => 'width: 10%'],
                                'value' => function ($model) {
                                    if (!$model->total_money) {
                                        $model->total_money = 0;
                                    }
                                    return Yii::$app->formatter->asCurrency($model->total_money, 'VND');
                                },
                                'format' => 'raw'
                            ],
                            //'start_time:datetime',
                            //'end_time:datetime',

//                            [
//                                'class' => 'yii\grid\ActionColumn',
//                                'options' => ['style' => 'width: 80px'],
//                                'template' => '{view}',
//                                'buttons'=>[
//                                    'view' => function ($url, $model) {
//                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/activity/view','id'=>$model->id], [
//                                            'title' => Yii::t('app', 'Xem Làm dịch vụ'),
//                                        ]);
//                                    },
//                                ]
//                            ],
                        ],
                    ]); ?>

                </div>
            </div>
            <!-- /.post -->
        </div>

        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>

