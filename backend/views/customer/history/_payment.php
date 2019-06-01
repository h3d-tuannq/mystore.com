<?php

use yii\helpers\Html;


$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => \common\models\base\PaymentHistory::find()->where(['customer_id'=>$model->id]),
]);

?>

<div class="row">
    <?php //\yii\widgets\Pjax::begin() ?>
    <div class="col-md-12">

        <?php if ($dataProvider->count > 0): ?>
            <?php echo \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'customer_id',
                        'options' => ['style' => 'width: 10%'],
                        'value' => function ($model) {
                            return $model->customer ? $model->customer->name : null;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Customer::find()->active()->all(), 'id', 'name'),
                    ],

                    'created_at:datetime',

//                    [
//                        'attribute' => 'before_money',
//                        'value' => function ($model) {
//                            return \Yii::$app->formatter->asCurrency($model->change_money, 'VND');
//                        }
//                    ],
	                [
		                'attribute' => 'change_money',
		                'value' => function ($model) {
                            if($model->type == 1){
                                $sign = ' + ';
                            }else{
	                            $sign = ' - ';
                            }
			                return $sign . \Yii::$app->formatter->asCurrency($model->change_money, 'VND');
		                }
	                ],
//                    [
//                        'attribute' => 'current_history',
//                        'value' => function ($model) {
//                            return \Yii::$app->formatter->asCurrency($model->change_money, 'VND');
//                        }
//                    ],
                    //'status',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'options' => ['style' => 'width: 10%'],
                        'template' => '{view} {update}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-view'),
                                ]);
                            },

                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-update'),
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = \yii\helpers\Url::to(['payment-history/view','id'=>$model->id]);
                                return $url;
                            }

                            if ($action === 'update') {
                                $url = \yii\helpers\Url::to(['payment-history/update','id'=>$model->id]);
                                return $url;
                            }
                        }
                    ],
                ],
            ]); ?>
        <?php else: ?>
            <?php echo Yii::t('backend', 'Chưa có lịch sử') ?>
        <?php endif; ?>
    </div>
    <div class="col-md-12 text-center">
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>

    <?php //\yii\widgets\Pjax::end() ?>
</div>



