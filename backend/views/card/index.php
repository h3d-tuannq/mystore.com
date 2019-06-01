<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Cards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Html::tag('i','',['class'=>'fa fa-plus']).' Thêm thẻ mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'slug',
                'label' => 'Mã thẻ',
                'options' => ['style' => 'width: 10%'],
            ],
            [
                'attribute' => 'card_type',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->cardType ? $model->cardType->name : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\CardType::find()->active()->all(), 'id', 'name'),
            ],
            'name',
            //'description',
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
            [
                'attribute' => 'bonus_price',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    if($model->retail_price){
                        return \Yii::$app->formatter->asCurrency($model->retail_price, 'VND');
                    }
                    return \Yii::$app->formatter->asCurrency(0, 'VND');
                },
            ],
            [
                'attribute' => 'raw_price',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    if($model->retail_price){
                        return \Yii::$app->formatter->asCurrency($model->retail_price, 'VND');
                    }
                    return \Yii::$app->formatter->asCurrency(0, 'VND');
                },
            ],
            'rate_employee:percent',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn','options' => ['style' => 'width: 66px'],],
        ],
    ]); ?>

</div>
