<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('<i class="fa fa-plus"></i> Thêm sản phẩm', ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::a('<i class="fa fa-upload"></i> Nhập từ excel', ['import'], ['class' => 'btn btn-primary']) ?>
        &nbsp;&nbsp;
        <?php //echo Html::button('Nhập từ excel <i class="fa fa-upload"></i>',
//	        [
//		        'value' => \yii\helpers\Url::to(['product/import']),
//		        'title' => 'Nhập từ excel',
//		        'class' => 'showModalButton btn btn-primary',
//		        'data-title' => 'Tải lên và nhập dữ liệu sản phẩm từ excel',
//	        ]); ?>
        &nbsp;&nbsp;
        <?= Html::button('Xuất báo cáo Tồn kho <i class="fa fa-download"></i>',
            [
                'value' => \yii\helpers\Url::to(['product/export']),
                'title' => 'Nhập từ excel',
                'class' => 'showModalButton btn btn-primary',
                'data-title' => 'Tải báo cáo Tồn kho',
            ]); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'slug',
                'options' => ['style' => 'width: 48px'],
            ],
            [
                'attribute' => 'product_type',
                'label' => 'Kiểu',
            ],
//            [
//                'attribute' => 'product_type_id',
//                'options' => ['style' => 'width: 10%'],
//                'value' => function ($model) {
//                    return $model->productType ? $model->productType->name : null;
//                },
//                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ProductType::find()->active()->all(), 'id', 'name'),
//            ],
            [
                'attribute' => 'name',
                'options' => ['style' => 'width: 25%'],
            ],
            //'description:ntext',
            //'product_type_id',

            //'product_unit_id',
            [
                'attribute' => 'quantity',
                'options' => ['style' => 'width: 48px'],
            ],
            [
                'attribute' => 'product_unit',
                'label' => 'Đơn vị',
            ],
            [
                'attribute' => 'input_price',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->input_price ?: 0, 'VND');
                },
                'visible' => Yii::$app->user->can('administrator'),
            ],
            [
                'attribute' => 'retail_price',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->retail_price ?: 0, 'VND');
                }
            ],
            // 'rate_employee',
            // 'status',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            //'created_at:relativeTime',
            'updated_at:relativeTime',
            // 'created_by',
            // 'updated_by',
            // 'product_date',
            // 'product_time_use:datetime',
            // 'is_notification',
            [
                'attribute' => 'is_notification',
                'label' => 'Thông báo',
                'value' => function ($model) {
                    return $model->is_notification? 'Đã bật' : 'Đã tắt';
                },
                'format'=>'html'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 66px'],
                'template' => '{view} {update} {delete}',
//                'buttons' => [
//                    'login' => function ($url) {
//                        return Html::a(
//                            '<i class="fa fa-sign-in" aria-hidden="true"></i>',
//                            $url,
//                            [
//                                'title' => Yii::t('backend', 'Login')
//                            ]
//                        );
//                    },
//                ],
                'visibleButtons' => [
                    'view' => Yii::$app->user->can('administrator'),
                    'update' => Yii::$app->user->can('administrator'),
                    'delete' => Yii::$app->user->can('administrator')
                ]

            ],
        ],
    ]); ?>

</div>
