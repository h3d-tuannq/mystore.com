<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Doanh thu theo sản phẩm');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?php echo $this->render('_search_product', ['model' => $searchModel]); ?>
            </div>
            <div class="pull-right">
                <?= Html::button('Xuất báo cáo<i class="fa fa-download"></i>',
                    [
                        'value' => \yii\helpers\Url::to(['export-product','from'=>$searchModel->from,'to'=>$searchModel->to,'code'=>$searchModel->product_code]),
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
			    'attribute' => 'product_code',
			    'options' => ['style' => 'width: 20%'],
		    ],
		    'product_name',
		    //'year',
		    // 'quarter',
		    // 'month',
		    // 'week',
		     'report_date',
		     'quantity_sell',
		     'quantity_use',
		     'quantity',
		     'unit',
            [
                'attribute' => 'revenue',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->revenue, 'VND');
                },
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
