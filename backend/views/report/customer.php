<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReportCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Doanh thu theo khách hàng');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?php echo $this->render('_search_customer', ['model' => $searchModel]); ?>
            </div>
            <div class="pull-right">
                <?= Html::button('Xuất báo cáo<i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['export-customer','from'=>$searchModel->from,'to'=>$searchModel->to,'code'=>$searchModel->customer_code]),
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
                'attribute' => 'customer_code',
                'options' => ['style' => 'width: 20%'],
            ],
            'customer_name',
            //'year',
            // 'quarter',
            // 'month',
            // 'week',
            'report_date',
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
