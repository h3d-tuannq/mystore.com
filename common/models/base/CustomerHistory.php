<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer_history".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $object_id
 * @property string $object_type Sản phẩm, dịch vụ, thẻ nạp
 * @property int $quantity Số lần sử dụng
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $data
 * @property int $amount
 * @property int $sub
 * @property int $remain
 * @property int $order_id
 */
class CustomerHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'object_id', 'quantity', 'status','updated_at','created_at', 'created_by', 'updated_by', 'amount', 'sub', 'remain', 'order_id'], 'integer'],
            [['data'], 'string'],
            [['object_type'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'customer_id' => Yii::t('common', 'Customer ID'),
            'object_id' => Yii::t('common', 'Object ID'),
            'object_type' => Yii::t('common', 'Object Type'),
            'quantity' => Yii::t('common', 'Quantity'),
            'note' => Yii::t('common', 'Note'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'data' => Yii::t('common', 'Data'),
            'amount' => Yii::t('common', 'Amount'),
            'sub' => Yii::t('common', 'Sub'),
            'remain' => Yii::t('common', 'Remain'),
            'order_id' => Yii::t('common', 'Order ID'),
            'started_date' => Yii::t('common', 'Ngày'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CustomerHistoryQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(\common\models\Service::class, ['id' => 'object_id']);
    }

    public function getDetails()
    {
        return $this->hasMany(CustomerHistoryDetail::class, ['history_id' => 'id']);
    }
}
