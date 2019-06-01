<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "service_product".
 *
 * @property int $id
 * @property int $service_id
 * @property int $product_id Hình thức thanh toán
 * @property string $amount Số lượng
 * @property int $unit Đơn vị
 * @property int $money Tiền theo số lượng
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ServiceProduct extends base\ServiceProduct
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'sortBehavior' => [
                'class' => 'demi\sort\SortBehavior',
                'sortConfig' => [
                    'sortAttribute' => 'sort',
                    'condition' => function ($query, $model) {
                        /* @var $query \yii\db\Query */
                        /* @var $model self */
                        $query->andWhere(['service_id' => $model->service_id]);
                    },
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ServiceProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ServiceProductQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
