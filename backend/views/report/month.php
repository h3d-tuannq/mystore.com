<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReportProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Báo cáo doanh thu theo tháng');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-product-index">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?php echo $this->render('_search_month', ['model' => $searchModel]); ?>
            </div>
            <div class="pull-right">
                <?= Html::button('Xuất báo cáo<i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['export-month']),
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
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'year',
            //'quarter',
            'month',
            //'week',
            //'report_date',
            [
                'attribute' => 'revenue',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->revenue, 'VND');
                },
                'footer' => \Yii::$app->formatter
                    ->asCurrency(\common\models\base\ReportRevenue::getTotal(
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
