<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id
 * @property int $order_id
 * @property int $object_id
 * @property string $object_type
 * @property int $quantity
 * @property int $unit_money
 * @property int $total_money
 * @property int $employee_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property Order $order
 */
class OrderDetail extends base\OrderDetail
{
    const TYPE_PRODUCT = 'product';
    const TYPE_SERVICE = 'service';
    const TYPE_CARD = 'card';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'object_id', 'quantity', 'unit_money', 'total_money', 'employee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['object_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\OrderDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderDetailQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'object_id']);
    }

    public function getCard()
    {
        return $this->hasOne(Card::class, ['id' => 'object_id']);
    }

    public function isProduct()
    {
        return 'product' == $this->object_type;
    }

    public function isService()
    {
        return 'service' == $this->object_type;
    }

    public function isCard()
    {
        return 'card' == $this->object_type;
    }

}
