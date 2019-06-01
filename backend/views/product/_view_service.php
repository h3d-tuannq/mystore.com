<?php
use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#service" data-toggle="tab" aria-expanded="true">Các Dịch vụ sử dụng</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="service">
            <!-- Post -->
            <div class="row">
                <div class="col-md-12">

                    <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'options' => ['style' => 'width: 10%'], 'class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Số lượng',
                                'attribute' => 'amount',
                            ],
                            [
                                'label' => 'Giá',
                                'attribute' => 'money',
                            ],
                            [
                                'label' => 'Tổng tiền',
                                'options' => ['style' => 'width: 10%'],
                                'value' => function ($model) {
                                    return $model->amount * $model->money;
                                },
                            ],
                            [
                                'label' => 'Mã dịch vụ',
                                'attribute' => 'service_id',
                                'options' => ['style' => 'width: 10%'],
                                'value' => function ($model) {
                                    if ($model->service) {
                                        return $model->service->slug;
                                    }
                                    return '';
                                },
                            ],

                            [
                                'attribute' => 'service_id',
                                'label' => 'Tên dịch vụ',
                                'options' => ['style' => 'width: 30%'],
                                'value' => function ($model) {
                                    if ($model->service) {
                                        return $model->service->name;
                                    }
                                    return '';
                                },
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'options' => ['style' => 'width: 66px'],
                                'template' => '{view} {delete}',
                                'buttons'=>[
                                    'view' => function ($url, $model) {
                                        if ($model->service) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/service/view','id'=>$model->service_id], [
                                                'title' => Yii::t('app', 'Xem dịch vụ'),
                                            ]);
                                        }
                                    },
                                    'delete' => function ($url, $model) {
                                        if (!$model->service) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/service/view','id'=>$model->service_id], [
                                                'title' => Yii::t('app', 'Xem dịch vụ'),
                                            ]);
                                        }
                                    },
                                ]
                            ],
                        ],
                    ]); ?>

                </div>
                <div class="col-md-12 text-center">
                    <?php echo \yii\widgets\LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination']
                    ]) ?>
                </div>

                <?php //\yii\widgets\Pjax::end() ?>
            </div>
            <!-- /.post -->
        </div>

        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>

