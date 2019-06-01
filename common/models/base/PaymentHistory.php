<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payment_history".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $before_money
 * @property int $change_money
 * @property int $current_money
 * @property string $reason
 * @property int $type Kiểu trừ hoặc cộng cho KH, 1 là cộng, 2 trừ
 * @property int $object_id
 * @property string $object_type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class PaymentHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_history';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'before_money', 'change_money', 'current_money', 'type', 'object_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['reason', 'object_type'], 'string', 'max' => 255],
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
            'before_money' => Yii::t('common', 'Before Money'),
            'change_money' => Yii::t('common', 'Change Money'),
            'current_money' => Yii::t('common', 'Current Money'),
            'reason' => Yii::t('common', 'Reason'),
            'type' => Yii::t('common', 'Type'),
            'object_id' => Yii::t('common', 'Object ID'),
            'object_type' => Yii::t('common', 'Object Type'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\PaymentHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\PaymentHistoryQuery(get_called_class());
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCustomer()
	{
		return $this->hasOne(Customer::class, ['id' => 'customer_id']);
	}
}
