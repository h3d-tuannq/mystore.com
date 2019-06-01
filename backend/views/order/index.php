<?php

use yii\helpers\Html;
use yii\grid\GridView;
use trntv\yii\datetime\DateTimeWidget;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">



    <p>
        <?php echo Html::a('Tạo hóa đơn', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
        <?php echo Html::a('Hóa đơn trả nợ', ['pay'], ['class' => 'btn btn-sm btn-primary']) ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>
    <?php //echo Html::button('Tạo hóa đơn',
//        [
//            'value' => \yii\helpers\Url::to(['order/create']),
//            'title' => 'Tạo hóa đơn',
//            'data-title' => 'Tạo hóa đơn',
//            'class' => 'showModalButton btn btn-success'
//        ]);
    ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'code',
                'options' => ['style' => 'width: 96px'],
                'value' => function ($model) {
                    return Html::a($model->code,
                        [
                            'view','id'=>$model->id
                        ],
                        [
                            'title'=>'Xem chi tiết HĐ '.$model->code
                        ]);
                },
                'format'=>'raw',
            ],
            [
                'attribute' => 'customer_id',
                'label' => 'Mã KH',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->customer ? Html::a($model->customer->slug,
                        [
                            'customer/view', 'id' => $model->customer_id
                        ],
                        [
                            'title' => 'Xem chi tiết KH ' . $model->customer->slug
                        ]) : null;
                },
                'format' => 'raw',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->all(), 'id', 'slug'),
                'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'Tất cả'],
            ],
            [
                'attribute' => 'customer_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->customer ? Html::a($model->customer->name,
                        [
                            'customer/view','id'=>$model->customer_id
                        ],
                        [
                            'title'=>'Xem chi tiết KH '.$model->customer->name
                        ]) : null;
                },
                'format'=>'raw',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->all(), 'id', 'name'),
                'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'Tất cả'],
            ],

            [
                'attribute' => 'discount',
                'options' => ['style' => 'width: 96px'],
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
            //'order_date:datetime',
            [
                'attribute' => 'order_date',
                'format' => 'datetime',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'order_date',
                    'phpDatetimeFormat' => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],

//            [
//                'attribute' => 'order_date',
//                'format' => 'datetime',
//                'filter' => \trntv\yii\datetime\DateTimeWidget::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'order_date',
//                    'phpDatetimeFormat' => 'dd.MM.yyyy',
//                    'momentDatetimeFormat' => 'DD.MM.YYYY',
//                    'clientEvents' => [
//                        //'dp.change' => new \yii\web\JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
//                    ],
//                ])
//            ],
            //'created_at:datetime',
            [
                'attribute' => 'created_by',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->author->username;
                },
                'format'=>'raw',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => 'Tất cả'],
            ],
            // 'updated_by',

            [
                'attribute' => 'total_money',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->total_money, 'VND');
                }
            ],
            'updated_at:relativeTime',
            //'status',

            ['class' => 'yii\grid\ActionColumn','options' => ['style' => 'width: 66px'],],
        ],
    ]); ?>

</div>
