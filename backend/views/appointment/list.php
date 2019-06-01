<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Lịch hẹn');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Html::tag('i','',['class'=>'fa fa-plus']).' Thêm lịch hẹn', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'customer_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->customer ? Html::a($model->customer->name,
                        [
                            'customer/view','id'=>$model->customer_id
                        ],
                        [
                            'title'=>'Xem chi tiết KH '.$model->customer->name
                        ]) : null;
                },
                'format'=>'raw'
                //'filter' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
            ],
            //'customer_id',
            //'service_id',
            [
                'attribute' => 'service_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->service ? $model->service->name : null;
                },
                //'filter' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'employee_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->employee ? $model->employee->name : null;
                },
                //'filter' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
            ],
            // 'status',
             'appointment_time:datetime',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
