<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReportCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Doanh thu theo nhân viên');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?php echo $this->render('_search_employee', ['model' => $searchModel]); ?>
            </div>
            <div class="pull-right">
                <?= Html::button('Xuất báo cáo<i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['export-employee','from'=>$searchModel->from,'to'=>$searchModel->to,'code'=>$searchModel->employee_code]),
                        'title' => '\'Xuất báo cáo',
                        'class' => 'showModalButton btn btn-success',
                        'data-title' => 'Tải báo cáo',
                    ]); ?>
            </div>
        </div>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'employee_code',
                'options' => ['style' => 'width: 20%'],
            ],
            'employee_name',
            //'year',
            // 'quarter',
            // 'month',
            // 'week',
            'report_date',
            //'revenue_order',
            [
                'attribute' => 'revenue_order',
                'value' => function ($model) {
                    return Html::a($model->revenue_order,['order/index','OrderSearch[order_date]'=> $model->report_date]);
                },
                'format'=> 'raw'
            ],
            //'revenue_order_quantity',
            [
                'attribute' => 'revenue_order_quantity',
                'value' => function ($model) {
                    return Html::a($model->revenue_order_quantity,['order/index','OrderSearch[order_date]'=> $model->report_date]);
                },
                'format'=> 'raw'
            ],
            'revenue_activity',
            'revenue_activity_quantity',
            [
                'attribute' => 'revenue',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->revenue, 'VND');
                },
//                'footer' => \Yii::$app->formatter
//                    ->asCurrency(\common\models\base\ReportRevenue::getTotal(
//                        $dataProvider->models,
//                        'revenue'),
//                        'VND'),
            ],
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
             'updated_at:relativeTime',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
