<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Service Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-type-index">

    <?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'slug',
        [
            'attribute' => 'product_type',
            'label' => 'Kiểu',
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
            'attribute' => 'product_unit',
            'label' => 'Đơn vị',
        ],
        'quantity',
        'input_price',
        'retail_price',
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
        'columns' => $gridColumns,
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
                Html::a('<i class="fa fa-plus"></i>',
                    ['create'],
                    [
                        'type' => 'button',
                        'title' => Yii::t('backend', 'Thêm sản phẩm'),
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
            '{toggleData}'
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
            'type' => GridView::TYPE_PRIMARY
        ],
    ]);
    ?>

</div>
