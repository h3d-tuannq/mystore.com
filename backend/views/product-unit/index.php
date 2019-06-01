<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đơn vị sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-unit-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Thêm đơn vị', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::button('Nhập từ excel <i class="fa fa-upload"></i>',
            [
                'value' => \yii\helpers\Url::to(['product-unit/import']),
                'title' => 'Nhập từ excel',
                'class' => 'showModalButton btn btn-primary',
                'data-title' => 'Tải lên và nhập dữ liệu Đơn vị sản phẩm từ excel',
            ]); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'slug',
            'name',
            'description',
            'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
