<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Thêm khách hàng', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Nhập từ excel <i class="fa fa-upload"></i>',
            [
                'value' => \yii\helpers\Url::to(['customer/import']),
                'title' => 'Nhập từ excel',
                'class' => 'showModalButton btn btn-primary',
                'data-title' => 'Tải lên và nhập dữ liệu danh sách khách hàng từ excel',
            ]); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             [
                'attribute' => 'customer_type_id',
                //'options' => ['style' => 'width: 10%'],
                'value' => function ($model){
                    return $model->customerType ? $model->customerType->name : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\base\CustomerType::find()->all(), 'id', 'name'),
            ],
            'slug',
            'name',
            'birth_of_date:date',
            'phone',
            [
                'attribute' => 'address',
                'value' => function ($model) {
                    return $model->address? : '';
                }
            ],
            [
                'attribute' => 'remain_money',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->remain_money ?: 0, 'VND');
                }
            ],
            [
                'attribute' => 'account_money',
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->account_money ?: 0, 'VND');
                }
            ],
            //'source',
//            [
//                'attribute' => 'is_notification_birthday',
//                'value' => function ($model) {
//                    return $model->is_notification_birthday? 'Cho phép thông báo': 'Không thông báo';
//                }
//            ],
            // 'is_notification_service',
            // 'status',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'created_at:relativeTime',
            'updated_at:relativeTime',
            // 'created_by',
            // 'updated_by',
            [
                'label' => 'Thông báo',
                'value' => function ($model) {
                    $result = $model->is_notification_birthday ? '<p>Sinh nhật</p>' : '';
                    $result .= $model->is_notification_service ? '<p>Dịch vụ</p>' : '';
                    return $result;
                },
                'format'=>'html'
            ],

            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 96px'],
            ],
        ],
    ]); ?>

</div>
