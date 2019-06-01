<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer_history_detail".
 *
 * @property int $id
 * @property int $history_id
 * @property int $customer_id
 * @property int $object_id
 * @property int $object_type
 * @property int $used_at Ngày sử dụng
 * @property int $amount Số lượng
 * @property int $price Giá
 * @property int $total_price Giá
 * @property string $type Kiểu dùng
 * @property string $note Ghi chú
 * @property string $data Lưu json cần thiết
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CustomerHistoryDetail extends \yii\db\ActiveRecord
{
    const SERVICE_IN_COMBO = 1;
    const PRODUCT = 2;
    const SERVER_IN_CARD = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_history_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['history_id', 'customer_id', 'object_id', 'object_type', 'used_at', 'amount', 'price', 'total_price', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['note', 'data'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'history_id' => Yii::t('common', 'History ID'),
            'customer_id' => Yii::t('common', 'Customer ID'),
            'object_id' => Yii::t('common', 'Object ID'),
            'object_type' => Yii::t('common', 'Object Type'),
            'used_at' => Yii::t('common', 'Used At'),
            'amount' => Yii::t('common', 'Amount'),
            'price' => Yii::t('common', 'Price'),
            'total_price' => Yii::t('common', 'Total Price'),
            'type' => Yii::t('common', 'Type'),
            'note' => Yii::t('common', 'Note'),
            'data' => Yii::t('common', 'Data'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerHistoryDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CustomerHistoryDetailQuery(get_called_class());
    }
}
