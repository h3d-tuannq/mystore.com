<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Services');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'slug',
            //'pageSummary' => 'Tổng trang',
            'vAlign' => 'middle',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
            'editableOptions' => ['header' => 'Name', 'size' => 'md']
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'vAlign' => 'middle',
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
            'editableOptions' => [
                'header' => ' Tên',
                'size' => 'md',
                'formOptions' => ['action' => ['editName']]]
        ],
//	    [
//		    'attribute'=>'color',
//		    'value'=>function ($model, $key, $index, $widget) {
//			    return "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" .
//			           $model->color . '</code>';
//		    },
//		    'filterType'=>GridView::FILTER_COLOR,
//		    'vAlign'=>'middle',
//		    'format'=>'raw',
//		    'width'=>'150px',
//		    'noWrap'=>true
//	    ],
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'status',
            //'vAlign' => 'middle',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            //'dropdown' => true,
            //'vAlign' => 'middle',
//            'urlCreator' => function ($action, $model, $key, $index) {
//                return '#';
//            },
            'viewOptions' => ['title' => 'Xem', 'data-toggle' => 'tooltip'],
            'updateOptions' => ['title' => 'Cập nhật', 'data-toggle' => 'tooltip'],
            'deleteOptions' => ['title' => 'Xóa', 'data-toggle' => 'tooltip'],
        ],
        ['class' => 'kartik\grid\CheckboxColumn']
    ];
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'slug',
                'options' => ['style' => 'width: 10%'],
            ],
            [
                'attribute' => 'service_type_id',
                'options' => ['style' => 'width: 66px'],
                'value' => function ($model) {
                    return $model->serviceType ? $model->serviceType->name : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ServiceType::find()->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'name',
                'options' => ['style' => 'width: 30%'],
            ],
            //'description:ntext',
            //'service_type_id',

            // 'status',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'discount_of_employee',
            // 'number_product',
            // 'number_serve',
            // 'number_day',
            // 'on_time',
            // 'remain_time:datetime',
            // 'warranty',
            // 'total_price',
            [
                'attribute' => 'duration',
                'options' => ['style' => 'width: 5%'],
                'value' => function ($model) {
                    if ($model->duration) {
                        return "$model->duration p";
                    }
                    return '0 phút';
                }
            ],
            [
                'attribute' => 'total_price',
                'options' => ['style' => 'width: 8%'],
                'value' => function ($model) {
                    if($model->total_price){
                        return \Yii::$app->formatter->asCurrency($model->total_price, 'VND');
                    }
                    return \Yii::$app->formatter->asCurrency(0, 'VND');
                },
                'visible' => Yii::$app->user->can('administrator'),
            ],
            [
                'attribute' => 'retail_price',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    if($model->retail_price){
                        return \Yii::$app->formatter->asCurrency($model->retail_price, 'VND');
                    }
                    return \Yii::$app->formatter->asCurrency(0, 'VND');
                },
            ],
            'created_at:relativeTime',
            'updated_at:relativeTime',
            [
                'class' => 'kartik\grid\EnumColumn',
                'attribute' => 'status',
                 'enum' => [
                     '1' => '<span class="text-success">Hoạt động</span>',
                     '0' => '<span class="text-muted">Khóa</span>',
                     '-1' => '<span class="text-danger">Đã xóa</span>',
                 ],
                 'filter' => [  // will override the grid column filter
                     '1'  => 'Hoạt động',
                     '0'  => 'Khóa',
                     '-1' => 'Đã xóa',
                 ],
                'loadEnumAsFilter' => 1,
                'format'=>'raw'
            ],
            [
            'class' => 'kartik\grid\ActionColumn',
            //'dropdown' => true,
            //'vAlign' => 'middle',
//            'urlCreator' => function ($action, $model, $key, $index) {
//                return '#';
//            },
            'viewOptions' => ['title' => 'Xem', 'data-toggle' => 'tooltip'],
            'updateOptions' => ['title' => 'Cập nhật', 'data-toggle' => 'tooltip'],
            'deleteOptions' => ['title' => 'Xóa', 'data-toggle' => 'tooltip'],
            ],
            ['class' => 'kartik\grid\CheckboxColumn']
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
//        'beforeHeader' => [
//            [
//                'columns' => [
//                    ['content' => 'Header Before 1', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
//                    ['content' => 'Header Before 2', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
//                    ['content' => 'Header Before 3', 'options' => ['colspan' => 3, 'class' => 'text-center warning']],
//                ],
//                'options' => ['class' => 'skip-export'] // remove this row from export
//            ]
//        ],
        'toolbar' => [
            ['content' =>
                Html::a('<i class="fa fa-plus"></i> Thêm dịch vụ',
                    ['create'],
                    [
                        'type' => 'button',
                        'title' => Yii::t('backend', 'Thêm loại dịch vụ'),
                        'class' => 'btn btn-success',
                        'onclick' => ''
                    ])
                . ' ' .
                Html::a('<i class="fa fa-repeat"></i>',
                    ['index'],
                    [
                        'data-pjax' => 0,
                        'class' => 'btn btn-default',
                        'title' => Yii::t('backend', 'Làm mới')])
            ],

            '{export}',
            ['content' =>
                Html::button('Xuất dữ liệu  <i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['service/export']),
                        'title' => 'Xuất excel',
                        'class' => 'showModalButton btn btn-primary',
                        'data-title' => 'Tải dữ liệu',
                    ])
            ],
            '{toggleData}',
            ['content' =>
                Html::a('<i class="fa fa-trash"></i>',
                    ['recycle'],
                    [
                        'type' => 'button',
                        'title' => Yii::t('backend', 'Thùng rác'),
                        'class' => 'btn btn-default',
                        'onclick' => ''
                    ])
            ],
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        //'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_INFO
        ],
    ]);
    ?>


</div>
