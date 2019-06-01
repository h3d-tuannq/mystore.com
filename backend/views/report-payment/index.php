<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ReportPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Báo cáo phương thức thanh toán');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-payment-index">


    <div class="row">
        <div class="col-md-12">
            <div class="pull-left col-md-9">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="pull-right col-md-3">
                <?= Html::button('Xuất báo cáo <i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['export','from'=>$searchModel->from,
                            'to'=>$searchModel->to,
                            'payment_id'=>$searchModel->payment_id]),
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
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'report_date',
            //'payment_id',
            'payment_name',
            //'year',
            //'quarter',
            // 'month',
            // 'week',
            [
                'attribute' => 'revenue',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->revenue, 'VND');
                },
                'footer' => \Yii::$app->formatter
                    ->asCurrency(\common\models\base\ReportPayment::getTotal(
                        $dataProvider->models,
                        'revenue'),
                        'VND'),
            ],
            // 'status',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
