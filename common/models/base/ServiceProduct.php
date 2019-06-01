<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "service_product".
 *
 * @property int $id
 * @property int $service_id
 * @property int $product_id Hình thức thanh toán
 * @property string $amount
 * @property string $unit Đơn vị
 * @property int $money Tiền theo số lượng
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ServiceProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'product_id', 'money', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['unit'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'product_id' => 'Product ID',
            'amount' => 'Amount',
            'unit' => 'Unit',
            'money' => 'Money',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ServiceProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ServiceProductQuery(get_called_class());
    }
}
