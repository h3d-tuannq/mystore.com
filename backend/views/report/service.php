<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReportServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Doanh thu theo dịch vụ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?php echo $this->render('_search_service', ['model' => $searchModel]); ?>
            </div>
            <div class="pull-right">
                <?= Html::button('Xuất báo cáo<i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['export-service','from'=>$searchModel->from,'to'=>$searchModel->to,'code'=>$searchModel->service_code]),
                        'title' => '\'Xuất báo cáo',
                        'class' => 'showModalButton btn btn-success',
                        'data-title' => 'Tải báo cáo',
                    ]); ?>
            </div>
        </div>
    </div>
    <br/>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Mã dịch vụ',
                'attribute' => 'service_code',
                'options' => ['style' => 'width: 20%'],
            ],
            [
                'label' => 'Tên dịch vụ',
                'attribute' => 'service_name',
                'options' => ['style' => 'width: 25%'],
            ],
            //'year',
            // 'quarter',
            // 'month',
            // 'week',
            'report_date',
            'sell',
            [
                'attribute' => 'revenue',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->revenue, 'VND');
                },
            ],
            'use',
            [
                'attribute' => 'spend',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->spend, 'VND');
                },
            ],
            [
                'attribute' => 'proceed',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->proceed, 'VND');
                },
            ],
            [
                'attribute' => 'interest',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->interest, 'VND');
                },
            ],

            'quantity',
            //'unit',

            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            'employee_service',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
