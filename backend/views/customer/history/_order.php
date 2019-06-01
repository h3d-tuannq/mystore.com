<?php

use yii\helpers\Html;

?>

<div class="row">
    <?php //\yii\widgets\Pjax::begin() ?>
    <div class="col-md-12">

        <?php if ($oDataProvider->count > 0): ?>
            <?php echo \yii\grid\GridView::widget([
                'dataProvider' => $oDataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'code',
                    [
                        'attribute' => 'customer_id',
                        'options' => ['style' => 'width: 10%'],
                        'value' => function ($model) {
                            return $model->customer ? $model->customer->name : null;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->active()->all(), 'id', 'name'),
                    ],

                    [
                        'attribute' => 'discount',
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asPercent($model->discount / 100, 0);
                        }
                    ],
                    //'rate_receptionist',
                    // 'rate_receptionist_id',
                    // 'rate_employee',
                    // 'rate_employee_id',
                    // 'raw_money',
                    // 'real_money',
                    // 'payment_type',
                    // 'voucher_code',
                    'order_date:datetime',
                    //'created_at:datetime',
                    // 'updated_at',
//                    [
//                        'attribute' => 'created_by',
//                        'options' => ['style' => 'width: 10%'],
//                        'value' => function ($model) {
//                            return $model->author->username;
//                        },
//                    ],
                    // 'updated_by',

                    [
                        'attribute' => 'total_money',
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asCurrency($model->total_money, 'VND');
                        }
                    ],
                    //'status',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'options' => ['style' => 'width: 10%'],
                        'template' => '{view} {update}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-view'),
                                ]);
                            },

                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-update'),
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = \yii\helpers\Url::to(['order/view','id'=>$model->id]);
                                return $url;
                            }

                            if ($action === 'update') {
                                $url = \yii\helpers\Url::to(['order/update','id'=>$model->id]);
                                return $url;
                            }
                        }
                    ],
                ],
            ]); ?>
        <?php else: ?>
            <?php echo Yii::t('backend', 'Chưa có hóa đơn nào') ?>
        <?php endif; ?>
    </div>
    <div class="col-md-12 text-center">
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $oDataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>

    <?php //\yii\widgets\Pjax::end() ?>
</div>



