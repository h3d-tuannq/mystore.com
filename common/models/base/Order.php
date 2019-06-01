<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $code Mã Hóa đơn
 * @property int $customer_id
 * @property string $discount Chiết khấu cho khách hàng
 * @property string $rate_receptionist Phần trăm hoa hồng cho lễ tân
 * @property string $rate_receptionist_id ID của nhân viên lễ tân
 * @property string $rate_employee Phần trăm hoa hồng của nhân viên
 * @property int $rate_employee_id ID của nhân viên
 * @property int $raw_money Số tiền trước khi giảm giá
 * @property int $total_money
 * @property int $real_money Số tiền nhập kho
 * @property int $payment_type Hình thức thanh toán
 * @property string $voucher_code Mã voucher
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'rate_employee_id', 'raw_money', 'total_money', 'real_money', 'payment_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['discount', 'rate_receptionist', 'rate_receptionist_id', 'rate_employee'], 'number'],
            [['code', 'voucher_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'code' => Yii::t('common', 'Code'),
            'customer_id' => Yii::t('common', 'Customer ID'),
            'discount' => Yii::t('common', 'Discount'),
            'rate_receptionist' => Yii::t('common', 'Rate Receptionist'),
            'rate_receptionist_id' => Yii::t('common', 'Rate Receptionist ID'),
            'rate_employee' => Yii::t('common', 'Rate Employee'),
            'rate_employee_id' => Yii::t('common', 'Rate Employee ID'),
            'raw_money' => Yii::t('common', 'Raw Money'),
            'total_money' => Yii::t('common', 'Total Money'),
            'real_money' => Yii::t('common', 'Real Money'),
            'payment_type' => Yii::t('common', 'Payment Type'),
            'voucher_code' => Yii::t('common', 'Voucher Code'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\OrderQuery(get_called_class());
    }
}
